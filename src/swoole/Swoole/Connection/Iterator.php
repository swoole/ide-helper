<?php

declare(strict_types=1);

namespace Swoole\Connection;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Iterator implements \Iterator, \ArrayAccess, \Countable
{
    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function rewind(): void
    {
    }

    public function next(): void
    {
    }

    public function current(): mixed
    {
    }

    public function key(): mixed
    {
    }

    public function valid(): bool
    {
    }

    public function count(): int
    {
    }

    public function offsetExists($fd): bool
    {
    }

    /**
     * @param mixed $fd
     * @return mixed
     */
    public function offsetGet($fd)
    {
    }

    public function offsetSet($fd, $value): void
    {
    }

    public function offsetUnset($fd): void
    {
    }
}
