<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\Lock.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * This class is a thread-safe version of the \Swoole\Lock class. For more information, see the documentation for the
 * \Swoole\Lock class.
 *
 * @see \Swoole\Lock Use this instead when PHP is compiled without Zend Thread Safety (ZTS) enabled.
 * @since 6.0.0
 */
final class Lock
{
    public const RWLOCK = 1;

    public const MUTEX = 3;

    public const SPINLOCK = 5;

    public $errCode = 0;

    public function __construct(int $type = 3)
    {
    }

    public function __destruct()
    {
    }

    public function lock(): bool
    {
    }

    public function lockwait(float $timeout = 1): bool
    {
    }

    public function trylock(): bool
    {
    }

    public function lock_read(): bool
    {
    }

    public function trylock_read(): bool
    {
    }

    public function unlock(): bool
    {
    }
}
