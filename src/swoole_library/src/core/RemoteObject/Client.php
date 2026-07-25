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

use Swoole\Coroutine;
use Swoole\Coroutine\Http\Client as HttpClient;
use Swoole\RemoteObject;

class Client
{
    private static array $clients = [];

    private HttpClient $client;

    private string $id;

    private int $ownerCoroutineId;

    public function __construct(string $host = '127.0.0.1', int $port = Server::DEFAULT_PORT, array $options = [])
    {
        $this->id               = $this->genUuid();
        $this->client           = new HttpClient($host, $port);
        $this->ownerCoroutineId = Coroutine::getCid();

        $headers = [
            'client-id'    => $this->id,
            'coroutine-id' => $this->ownerCoroutineId,
        ];
        if (isset($options['api_key'])) {
            $headers['x-api-key'] = $options['api_key'];
        }
        $this->client->setHeaders($headers);
        self::$clients[$this->id] = $this;
    }

    public function create(string $class, mixed ...$args): RemoteObject
    {
        return RemoteObject::create($this, $class, $args);
    }

    public function call(string $fn, mixed ...$args): mixed
    {
        return RemoteObject::call($this, $fn, $args);
    }

    /**
     * @throws Exception
     */
    public static function getInstance(string $clientId): ?static
    {
        if (empty($clientId)) {
            throw new Exception('RemoteObject is not bound to a client');
        }
        if (!isset(self::$clients[$clientId])) {
            return null;
        }
        return self::$clients[$clientId];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function execute(string $path, array $array)
    {
        $rs = $this->client->post($path, $array);
        if (!$rs) {
            throw new Exception($this->client->errMsg);
        }
        $result = unserialize($this->client->body);
        if ($result['code'] != 0) {
            $ex = $result['exception'];
            throw new Exception('Server Error: ' . $ex['message'], $ex['code']);
        }
        return $result;
    }

    public function ping(): bool
    {
        try {
            $this->execute('/ping', []);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function genUuid(): string
    {
        $data    = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0F | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3F | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
