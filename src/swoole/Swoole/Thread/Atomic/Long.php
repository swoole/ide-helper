<?php

declare(strict_types=1);

namespace Swoole\Thread\Atomic;

/**
 * Class \Swoole\Thread\Atomic\Long.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
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
