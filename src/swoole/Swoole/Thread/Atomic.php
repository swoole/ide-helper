<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\Atomic.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
 */
final class Atomic
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

    public function wait(float $timeout = 1): bool
    {
    }

    public function wakeup(int $count = 1): bool
    {
    }

    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
