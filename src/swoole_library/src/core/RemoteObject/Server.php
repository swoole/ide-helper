<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\RemoteObject;

use Swoole\Atomic\Long;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server as HttpServer;
use Swoole\RemoteObject;

class Server
{
    public const DEFAULT_PORT = 9567;

    private HttpServer $server;

    private array $objects = [];

    private array $allowedClasses = [];

    private array $allowedFunctions = [];

    private Long $nextObjectId;

    private string $apiKey = '';

    public function __construct(string $host = '127.0.0.1', int $port = self::DEFAULT_PORT, array $options = [])
    {
        // By default, thread mode is used, and when viewed with ps, only one process will be displayed.
        $server_mode = $options['server_mode'] ?? SWOOLE_THREAD;
        $socket_type = $options['socket_type'] ?? SWOOLE_SOCK_TCP;
        $server      = new HttpServer($host, $port, $server_mode, $socket_type);
        unset($options['server_mode'], $options['socket_type']);

        if (isset($options['allowed_classes'])) {
            if (!is_array($options['allowed_classes'])) {
                throw new Exception('allowed_classes must be an array');
            }
            $this->allowedClasses = array_flip($options['allowed_classes']);
            unset($options['allowed_classes']);
        }

        if (isset($options['allowed_functions'])) {
            if (!is_array($options['allowed_functions'])) {
                throw new Exception('allowed_functions must be an array');
            }
            $this->allowedFunctions = array_flip($options['allowed_functions']);
            unset($options['allowed_functions']);
        }

        if (isset($options['api_key'])) {
            $this->apiKey = $options['api_key'];
            unset($options['api_key']);
        }

        if ($options) {
            $server->set($options);
        }
        $server->on('request', [$this, 'onRequest']);
        $server->on('start', [$this, 'onStart']);
        $this->server       = $server;
        $this->nextObjectId = new Long(1);
    }

    public function start(): bool
    {
        return $this->server->start();
    }

    public function onStart(): void
    {
        echo "The remote-object server is started at http://{$this->server->host}:{$this->server->port}\n";
    }

    public function onRequest(Request $request, Response $response): void
    {
        $ctx = new Context($request, $response);
        if ($this->apiKey and $this->apiKey !== $request->header['x-api-key']) {
            $response->status(403);
            $ctx->end(['code' => -3, 'msg' => 'invalid api key']);
            return;
        }
        try {
            $method = $ctx->getHandler();
            if (method_exists($this, $method)) {
                $this->{$method}($ctx);
            } else {
                $ctx->end(['code' => -1, 'msg' => 'invalid request']);
            }
        } catch (\Throwable $e) {
            $ctx->end(['code' => -2, 'exception' => [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'class'   => get_class($e),
            ]]);
        }
    }

    private function addObject($object): int
    {
        // The spl_object_id/spl_object_hash cannot be used,
        // as the IDs they generate will be reused after the objects are destroyed.
        $object_id                 = $this->nextObjectId->add();
        $this->objects[$object_id] = $object;
        return $object_id;
    }

    private function marshal(Context $ctx, mixed $data): mixed
    {
        if (is_object($data) or is_resource($data)) {
            $object_id = $this->addObject($data);
            return RemoteObject::marshal($object_id, $ctx->getCoroutineId(), $ctx->getClientId());
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->marshal($ctx, $value);
            }
        }
        return $data;
    }

    private function unmarshal($data): mixed
    {
        if (is_object($data) and $data instanceof RemoteObject) {
            return $this->objects[$data->getObjectId()];
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->unmarshal($value);
            }
            return $data;
        }
        return $data;
    }

    /**
     * @throws Exception
     */
    private function _new(Context $ctx): void
    {
        $class = trim($ctx->getParam('class'), '\ ');
        if (count($this->allowedClasses) > 0 and !isset($this->allowedClasses[$class])) {
            throw new Exception("class[{$class}] not allowed");
        }
        $class = '\\' . $class;
        $args  = $ctx->getDataParam('args');
        foreach ($args as $key => $value) {
            $args[$key] = $this->unmarshal($value);
        }
        $obj       = new $class(...$args);
        $object_id = $this->addObject($obj);
        $ctx->end(['code' => 0, 'object' => $object_id]);
    }

    private function _call_function(Context $ctx): void
    {
        $fn = trim($ctx->getParam('function'), '\ ');
        if (count($this->allowedFunctions) > 0 and !isset($this->allowedFunctions[$fn])) {
            throw new Exception("function[{$fn}] not allowed");
        }
        $args = $ctx->getDataParam('args');
        foreach ($args as $key => $value) {
            $args[$key] = $this->unmarshal($value);
        }
        $fn = '\\' . $fn;
        if (!function_exists($fn)) {
            throw new Exception("function[{$fn}] not found");
        }
        $result = $fn(...$args);
        $ctx->end(['code' => 0, 'result' => $this->marshal($ctx, $result)]);
    }

    /**
     * @throws Exception
     */
    private function _call_method(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $method = $ctx->getParam('method');
        $args   = $ctx->getDataParam('args');
        foreach ($args as $key => $value) {
            $args[$key] = $this->unmarshal($value);
        }
        $obj = $this->objects[$object_id];
        if (!method_exists($obj, $method)) {
            $class = get_class($obj);
            throw new Exception("method[{$class}::{$method}] not found");
        }
        $result = $obj->{$method}(...$args);
        $ctx->end(['code' => 0, 'result' => $this->marshal($ctx, $result)]);
    }

    /**
     * @throws Exception
     */
    private function _read_property(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $property  = $ctx->getParam('property');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj    = $this->objects[$object_id];
        $result = $obj->{$property};
        $ctx->end(['code' => 0, 'property' => $this->marshal($ctx, $result)]);
    }

    /**
     * @throws Exception
     */
    private function _write_property(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $property  = $ctx->getParam('property');
        $value     = $ctx->getDataParam('value');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj              = $this->objects[$object_id];
        $obj->{$property} = $this->unmarshal($value);
        $ctx->end(['code' => 0]);
    }

    private function _ping(Context $ctx): void
    {
        $ctx->end(['code' => 0]);
    }

    /**
     * @throws Exception
     */
    private function _destroy(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        unset($this->objects[$object_id]);
        $ctx->end(['code' => 0]);
    }

    private function _to_string(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj = $this->objects[$object_id];
        $ctx->end(['code' => 0, 'value' => (string) $obj]);
    }

    private function _offset_get(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $offset    = $ctx->getParam('offset');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj    = $this->objects[$object_id];
        $result = $obj->{$offset};
        $ctx->end(['code' => 0, 'value' => $this->marshal($ctx, $result)]);
    }

    private function _offset_set(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $offset    = $ctx->getParam('offset');
        $value     = $ctx->getDataParam('value');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj            = $this->objects[$object_id];
        $obj->{$offset} = $this->unmarshal($value);
        $ctx->end(['code' => 0]);
    }

    private function _offset_unset(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $offset    = $ctx->getParam('offset');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj = $this->objects[$object_id];
        unset($obj->{$offset});
        $ctx->end(['code' => 0]);
    }

    private function _offset_exists(Context $ctx): void
    {
        $object_id = $ctx->getParam('object');
        $offset    = $ctx->getParam('offset');
        if (!isset($this->objects[$object_id])) {
            throw new Exception("object[#{$object_id}] not found");
        }
        $obj    = $this->objects[$object_id];
        $result = isset($obj->{$offset});
        $ctx->end(['code' => 0, 'value' => $this->marshal($ctx, $result)]);
    }
}
