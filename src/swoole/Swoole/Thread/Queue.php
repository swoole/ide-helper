<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\Queue.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
 */
final class Queue implements \Countable
{
    public const NOTIFY_ONE = 1;

    public const NOTIFY_ALL = 2;

    public function __construct()
    {
    }

    public function push(mixed $value, int $notify_which = 0): void
    {
    }

    public function pop(float $wait = 0): mixed
    {
    }

    public function clean(): void
    {
    }

    public function count(): int
    {
    }
}
