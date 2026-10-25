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
use Swoole\Coroutine\Channel;
use Swoole\Coroutine\Http\Client as HttpClient;
use Swoole\RemoteObject;

class Client
{
    /**
     * The live clients, keyed by client id.
     *
     * The references are weak on purpose. A RemoteObject holds a strong reference to the client it came
     * from, so a client stays reachable here for exactly as long as one of its remote objects is alive,
     * which is the lifetime RemoteObject::__destruct() needs to be able to send /destroy. A client nobody
     * else holds on to is freed right away instead of being pinned for the lifetime of the process.
     *
     * @var array<string, \WeakReference>
     */
    private static array $clients = [];

    private HttpClient $client;

    /**
     * Serializes the remote calls made through this client.
     *
     * The HTTP connection underneath can only be driven by one coroutine at a time: a second coroutine using
     * it while a request is in flight is a fatal "Socket has already been bound to another coroutine". A client
     * is routinely shared, though: by a service object handling concurrent requests, and by every remote object
     * it created, whose destructor sends a /destroy from whichever coroutine drops the last reference.
     */
    private Channel $lock;

    /**
     * The coroutine currently holding the lock, if any.
     */
    private int $lockOwner = -1;

    // Has a default value: __destruct() also runs on an instance built without the constructor.
    private string $id = '';

    private int $ownerCoroutineId;

    public function __construct(string $host = '127.0.0.1', int $port = Server::DEFAULT_PORT, array $options = [])
    {
        $this->id               = $this->genUuid();
        $this->client           = new HttpClient($host, $port);
        $this->lock             = new Channel(1);
        $this->ownerCoroutineId = Coroutine::getCid();

        $headers = [
            'client-id'    => $this->id,
            'coroutine-id' => $this->ownerCoroutineId,
        ];
        if (isset($options['api_key'])) {
            $headers['x-api-key'] = $options['api_key'];
        }
        $this->client->setHeaders($headers);

        // RemoteObject::__unserialize() looks the client up here by id to re-bind remote objects the server returns.
        self::$clients[$this->id] = \WeakReference::create($this);
    }

    public function __destruct()
    {
        // self::$clients only holds a weak reference, so its entry would outlive the client. Drop it here, but only
        // if it is this instance's own: one built without the constructor has no entry.
        if ((self::$clients[$this->id] ?? null)?->get() === $this) {
            unset(self::$clients[$this->id]);
        }
    }

    /**
     * A clone would share the id, the registry entry and the HTTP connection of the client it was made from.
     */
    private function __clone()
    {
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
        $client = (self::$clients[$clientId] ?? null)?->get();
        if ($client === null) {
            // Drop a dead reference if one is ever found.
            unset(self::$clients[$clientId]);
            return null;
        }
        return $client instanceof static ? $client : null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function execute(string $path, array $array)
    {
        $cid = Coroutine::getCid();
        // Outside a coroutine both sides are -1. The call goes on to the lock below, where Channel::push() ends it
        // with the fatal error "API must be called in the coroutine".
        if ($cid !== -1 && $this->lockOwner === $cid) {
            // Only reachable from a destructor the garbage collector runs in the middle of a call of this same
            // coroutine. Waiting would be waiting for itself.
            throw new Exception('The remote object client is already in use by the current coroutine');
        }
        if (!$this->lock->push(true)) {
            // The wait was cancelled (Coroutine::cancel()) or the channel closed; the lock was never acquired, so
            // this coroutine must not run its call alongside the holder, nor release the holder's lock in finally.
            throw new Exception('Cancelled while waiting for the remote object client', $this->lock->errCode);
        }
        $this->lockOwner = $cid;
        try {
            $rs = $this->client->post($path, $array);
            if (!$rs) {
                throw new Exception($this->client->errMsg);
            }
            // A body that does not unserialize is reported below, as an exception; the warning would only come first.
            $result = @unserialize($this->client->body);
        } finally {
            $this->lockOwner = -1;
            $this->lock->pop();
        }
        if (!is_array($result) || !array_key_exists('code', $result)) {
            throw new Exception('Malformed response from the remote object server');
        }
        if ($result['code'] != 0) {
            throw Exception::fromResponse($result);
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
