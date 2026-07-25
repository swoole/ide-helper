<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This Lock class provides a way to synchronize concurrent coroutines.
 *
 * Objects of this class can be used only inside a coroutine.
 *
 * Since Swoole 6.1.0, this class exposes only three methods, __construct(), lock(), and unlock(), matching the
 * simplified \Swoole\Lock API. Method trylock() was removed in that release; call lock(LOCK_EX | LOCK_NB) instead.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Lock Use this instead when using locks accross processes.
 * @see https://www.php.net/manual/en/function.flock.php The built-in PHP function that method \Swoole\Coroutine\Lock::lock() is modeled after.
 * @since 6.0.1
 */
class Lock
{
    /**
     * The error code of the last operation. It is set to 0 if the last operation was successful.
     */
    public int $errCode = 0;

    /**
     * Construct a coroutine lock object.
     *
     * @param bool $shared Use preserved shared memory of Swoole to create the lock or not.
     */
    public function __construct(bool $shared = false)
    {
    }

    /**
     * Acquire the lock.
     *
     * If the lock is already held by another coroutine, this method suspends the current coroutine until the lock is
     * released, unless LOCK_NB is passed.
     *
     * The signature of this method changed in Swoole 6.1.0:
     *   - before: public function lock(): bool
     *   - now:    public function lock(int $operation = LOCK_EX): bool
     *
     * Parameter $operation is built from the same constants PHP's built-in flock() function uses:
     *   - LOCK_EX: an exclusive lock, meaning no other coroutine may hold the lock at the same time. This is the
     *     default, and the only kind of lock this class supports.
     *   - LOCK_NB: added to the above (LOCK_EX | LOCK_NB) to make the call return right away instead of suspending the
     *     coroutine when the lock isn't available.
     *
     * Unlike method \Swoole\Lock::lock(), this method takes no timeout, since this class only supports exclusive locks
     * that are either waited on indefinitely or not waited on at all.
     *
     * The new parameter covers what the removed method trylock() used to do, e.g.,
     *
     * ```php
     * $lock = new Swoole\Coroutine\Lock();
     * $lock->lock();                     // Wait as long as needed (what lock() did before Swoole 6.1.0).
     * $lock->lock(LOCK_EX | LOCK_NB);    // Never wait; return immediately (what trylock() used to do).
     * ```
     *
     * When Swoole can't ask the operating system to signal it once the lock is released (which requires Linux io_uring
     * support), a waiting coroutine instead re-checks the lock periodically, doubling the pause between checks each
     * time. Prior to Swoole 6.1.7, this pause grew without limit, so under contention a coroutine could take
     * increasingly long to notice that the lock had been freed; since Swoole 6.1.7, the pause between checks is capped
     * at 0.1 second.
     *
     * @param int $operation What kind of lock to acquire, as described above.
     * @return bool TRUE when the lock was acquired, FALSE otherwise (the lock was held by another coroutine and LOCK_NB
     *              was used, or the method was called outside of a coroutine).
     * @see \Swoole\Coroutine\Lock::unlock()
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public function lock(int $operation = LOCK_EX): bool
    {
    }

    /**
     * Release the lock.
     *
     * @return bool TRUE on success, FALSE on failure (for example, when called outside of a coroutine).
     * @see \Swoole\Coroutine\Lock::lock()
     */
    public function unlock(): bool
    {
    }
}
