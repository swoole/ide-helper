<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\ArrayList.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
 */
final class ArrayList implements \ArrayAccess, \Countable
{
    public int $id = 0;

    public function __construct(?array $array = null)
    {
    }

    /**
     * @see \ArrayAccess::offsetGet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * {@inheritDoc}
     */
    public function offsetGet(mixed $key): mixed
    {
    }

    /**
     * @see \ArrayAccess::offsetExists()
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * {@inheritDoc}
     */
    public function offsetExists(mixed $key): bool
    {
    }

    /**
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
    }

    /**
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $key): void
    {
    }

    public function find(mixed $value): int
    {
    }

    public function incr(mixed $key, mixed $value = 1): mixed
    {
    }

    public function decr(mixed $key, mixed $value = 1): mixed
    {
    }

    public function clean(): void
    {
    }

    /**
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    public function toArray(): array
    {
    }

    /**
     * Sort the list in ascending order, without maintaining index association.
     *
     * @since 6.0.1
     */
    public function sort(): void
    {
    }
}
