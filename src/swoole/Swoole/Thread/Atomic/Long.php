<?php

declare(strict_types=1);

namespace Swoole\Thread\Atomic;

/**
 * Class \Swoole\Thread\Atomic\Long.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * This class is a thread-safe version of the \Swoole\Atomic\Long class. For more information, see the documentation for
 * the \Swoole\Atomic\Long class.
 *
 * @since 6.0.0
 * @see \Swoole\Atomic\Long Use this instead when PHP is compiled without Zend Thread Safety (ZTS) enabled.
 * @see \Swoole\Thread\Atomic Use this instead to store the value using unsigned 32-bit integers instead of signed 64-bit integers.
 */
final class Long
{
    public function __construct(int $value = 0)
    {
    }

    public function add(int $add_value = 1): int
    {
    }

    public function sub(int $sub_value = 1): int
    {
    }

    public function get(): int
    {
    }

    public function set(int $value): void
    {
    }

    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
