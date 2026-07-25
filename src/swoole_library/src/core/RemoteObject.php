<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole;

use Swoole\RemoteObject\Client;
use Swoole\RemoteObject\Exception;

class RemoteObject implements \ArrayAccess, \Stringable, \Iterator, \Countable
{
    private int $objectId = 0;

    private int $coroutineId;

    private string $clientId;

    private ?Client $client = null;

    public function __construct($coroutineId, $clientId)
    {
        $this->coroutineId = $coroutineId;
        $this->clientId    = $clientId;
    }

    public function __destruct()
    {
        // On the server side, this object will also be constructed,
        // but it is only used for data storage and serialization.
        // No remote calls are executed during destruction.
        // If the objectId is 0, it indicates that the object may have been a temporary object created by a function call
        // and does not need to be destructed.
        if ($this->client and $this->objectId > 0) {
            try {
                $this->execute('/destroy', [
                    'object' => $this->objectId,
                ]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            }
        }
    }

    /**
     * @throws Exception
     */
    public function __call(string $method, array $args)
    {
        $rs = $this->execute('/call_method', [
            'object' => $this->objectId,
            'method' => $method,
            'args'   => serialize($args),
        ]);
        return $rs['result'];
    }

    /**
     * @throws Exception
     */
    public function __get(string $property)
    {
        $rs = $this->execute('/read_property', [
            'object'   => $this->objectId,
            'property' => $property,
        ]);
        return $rs['property'];
    }

    public function __set(string $property, mixed $value)
    {
        $this->execute('/write_property', [
            'object'   => $this->objectId,
            'property' => $property,
            'value'    => serialize($value),
        ]);
    }

    public function __unserialize(array $data): void
    {
        $this->objectId    = $data['objectId'];
        $this->coroutineId = $data['coroutineId'];
        $this->clientId    = $data['clientId'];
        $this->client      = Client::getInstance($this->clientId);
    }

    public function __serialize(): array
    {
        return [
            'objectId'    => $this->objectId,
            'coroutineId' => $this->coroutineId,
            'clientId'    => $this->clientId,
        ];
    }

    public function __toString(): string
    {
        $rs = $this->execute('/to_string', [
            'object' => $this->objectId,
        ]);
        return $rs['value'];
    }

    public function __invoke(...$args)
    {
        $rs = $this->execute('/call_method', [
            'object' => $this->objectId,
            'method' => '__invoke',
            'args'   => serialize($args),
        ]);
        return $rs['result'];
    }

    public static function call(Client $client, string $fn, array $args)
    {
        $object         = new self(Coroutine::getCid(), $client->getId());
        $object->client = $client;
        $rs             = $object->execute('/call_function', [
            'function' => $fn,
            'args'     => serialize($args),
        ]);
        return $rs['result'];
    }

    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @throws Exception
     */
    public static function create(Client $client, string $class, array $args): RemoteObject
    {
        $object         = new self(Coroutine::getCid(), $client->getId());
        $object->client = $client;
        $rs             = $object->execute('/new', [
            'class' => $class,
            'args'  => serialize($args),
        ]);
        $object->objectId = intval($rs['object']);
        return $object;
    }

    /**
     * This method is only used on the server side.
     */
    public static function marshal(int $objectId, int $ownerCoroutineId, string $clientId): RemoteObject
    {
        $object             = new self($ownerCoroutineId, $clientId);
        $object->objectId   = $objectId;
        return $object;
    }

    public function offsetGet(mixed $offset): mixed
    {
        $rs = $this->execute('/offset_get', [
            'object' => $this->objectId,
            'offset' => $offset,
        ]);
        return $rs['value'];
    }

    /**
     * @throws Exception
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->execute('/offset_set', [
            'object' => $this->objectId,
            'offset' => $offset,
            'value'  => serialize($value),
        ]);
    }

    /**
     * @throws Exception
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->execute('/offset_unset', [
            'object' => $this->objectId,
            'offset' => $offset,
        ]);
    }

    public function offsetExists(mixed $offset): bool
    {
        $rs = $this->execute('/offset_exists', [
            'object' => $this->objectId,
            'offset' => $offset,
        ]);
        return $rs['exists'];
    }

    public function current(): mixed
    {
        return $this->__call('current', []);
    }

    public function next(): void
    {
        $this->__call('next', []);
    }

    public function key(): mixed
    {
        return $this->__call('key', []);
    }

    public function valid(): bool
    {
        return $this->__call('valid', []);
    }

    public function rewind(): void
    {
        $this->__call('rewind', []);
    }

    public function count(): int
    {
        return $this->__call('count', []);
    }

    private function execute(string $path, array $params = []): array
    {
        if (!$this->client) {
            throw new Exception('This remote object is not bound to a client, and cannot initiate remote calls');
        }
        return $this->client->execute($path, $params);
    }
}
