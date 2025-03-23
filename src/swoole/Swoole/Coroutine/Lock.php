<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This Lock class provides a way to synchronize concurrent coroutines.
 *
 * @see \Swoole\Lock Use this instead when using locks accross processes.
 * @since 6.0.1
 */
class Lock
{
    /**
     * The error code of the last operation. It is set to 0 if the last operation was successful.
     */
    public int $errCode = 0;

    /**
     * @param bool $shared Use preserved shared memory of Swoole to create the lock or not.
     */
    public function __construct(bool $shared = false)
    {
    }

    /**
     * Lock the lock.
     *
     * If the lock is already acquired by another coroutine, this method will block until the lock is released.
     *
     * @return bool TRUE on success, FALSE on failure.
     * @see Lock::trylock()
     */
    public function lock(): bool
    {
    }

    /**
     * Lock the lock in a non-blocking way.
     *
     * This method returns immediately even if the lock is not acquired. Thus, the caller should check the return value
     * to see if the lock is acquired or not.
     *
     * @return bool TRUE on success, FALSE on failure.
     * @see Lock::lock()
     */
    public function trylock(): bool
    {
    }

    /**
     * Unlock the lock.
     *
     * @return bool TRUE on success, FALSE on failure.
     */
    public function unlock(): bool
    {
    }
}
