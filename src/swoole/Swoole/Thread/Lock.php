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
    public const RWLOCK = SWOOLE_RWLOCK;

    public const MUTEX = SWOOLE_MUTEX;

    public const SPINLOCK = SWOOLE_SPINLOCK;

    public int $errCode = 0;

    public function __construct(int $type = self::MUTEX)
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
