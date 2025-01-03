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

    public function offsetGet(mixed $key): mixed
    {
    }

    public function offsetExists(mixed $key): bool
    {
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
    }

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

    public function count(): int
    {
    }

    public function toArray(): array
    {
    }
}
