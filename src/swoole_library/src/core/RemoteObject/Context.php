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

use Swoole\Http\Request;
use Swoole\Http\Response;

class Context
{
    public string $clientId;

    public int $coroutineId;

    public Request $request;

    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->clientId    = $request->header['client-id'] ?? '';
        $this->coroutineId = intval($request->header['coroutine-id'] ?? 0);
        $this->request     = $request;
        $this->response    = $response;
    }

    public function end(array $data): void
    {
        $this->response->header('Content-Type', 'application/octet-stream');
        $this->response->end(serialize($data));
    }

    public function getHandler(): string
    {
        $path = $this->request->server['request_uri'];
        return str_replace('/', '_', $path);
    }

    public function getParam(string $name): string
    {
        if (!isset($this->request->post[$name])) {
            throw new Exception("param[{$name}] is empty");
        }
        return $this->request->post[$name];
    }

    public function getDataParam(string $name): mixed
    {
        return unserialize($this->getParam($name));
    }

    public function getCoroutineId(): int
    {
        $coroutine_id = $this->request->header['coroutine-id'] ?? '';
        if (!$coroutine_id) {
            throw new Exception('coroutine-id is empty');
        }
        return intval($coroutine_id);
    }

    public function getClientId(): string
    {
        $client_id = $this->request->header['client-id'] ?? '';
        if (!$client_id) {
            throw new Exception('client-id is empty');
        }
        return $client_id;
    }
}
