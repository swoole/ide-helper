<?php

declare(strict_types=1);

namespace Swoole\Connection;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Iterator implements \Iterator, \ArrayAccess, \Countable
{
    /**
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function __construct()
    {
        // NOTE: the actual error message won't be exactly the same as the one below.
        throw new \Error('Please use property \Swoole\Server::$connections instead.');
    }

    /**
     * @see \Iterator::rewind()
     * @see https://www.php.net/manual/en/iterator.rewind.php
     * {@inheritDoc}
     */
    public function rewind(): void
    {
    }

    /**
     * @see \Iterator::next()
     * @see https://www.php.net/manual/en/iterator.next.php
     * {@inheritDoc}
     */
    public function next(): void
    {
    }

    public function current(): mixed
    {
    }

    public function key(): mixed
    {
    }

    /**
     * @see \Iterator::valid()
     * @see https://www.php.net/manual/en/iterator.valid.php
     * {@inheritDoc}
     */
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

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet($fd, $value): void
    {
    }

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset($fd): void
    {
    }
}
