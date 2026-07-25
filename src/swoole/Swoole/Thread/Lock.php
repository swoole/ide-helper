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
 * Since Swoole 6.1.0, this class exposes only three methods, __construct(), lock(), and unlock(), matching the
 * simplified \Swoole\Lock API. Methods lockwait(), trylock(), lock_read(), and trylock_read() were removed in that
 * release; see method \Swoole\Thread\Lock::lock() for how to express what each of them used to do.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Lock For inter-process locking when ZTS is not enabled.
 * @see \Swoole\Coroutine\Lock To use locks accross coroutines when ZTS is not enabled.
 * @see https://www.php.net/manual/en/function.flock.php The built-in PHP function that method \Swoole\Thread\Lock::lock() is modeled after.
 * @since 6.0.0
 */
final class Lock
{
    /**
     * Mutex lock.
     */
    public const MUTEX = SWOOLE_MUTEX;

    /**
     * Read-write lock.
     *
     * This constant is defined only when the platform provides read-write lock support.
     */
    public const RWLOCK = SWOOLE_RWLOCK;

    /**
     * Spin lock.
     *
     * This constant is defined only when the platform provides spinlock support.
     */
    public const SPINLOCK = SWOOLE_SPINLOCK;

    /**
     * The error code of the last operation. It is set to 0 if the last operation was successful.
     */
    public int $errCode = 0;

    /**
     * Construct a thread lock object.
     *
     * @param int $type Type of the lock. It must be one of the following constants:
     *                  - \Swoole\Thread\Lock::MUTEX
     *                  - \Swoole\Thread\Lock::RWLOCK
     *                  - \Swoole\Thread\Lock::SPINLOCK
     */
    public function __construct(int $type = self::MUTEX)
    {
    }

    /**
     * Acquire the lock.
     *
     * The signature of this method changed in Swoole 6.1.0:
     *   - before: public function lock(): bool
     *   - now:    public function lock(int $operation = LOCK_EX, float $timeout = -1): bool
     *
     * Parameter $operation is built from the same constants PHP's built-in flock() function uses:
     *   - LOCK_EX: an exclusive lock, meaning no other thread may hold the lock at the same time. This is the default.
     *   - LOCK_SH: a shared lock, meaning several threads may hold it at once. This only makes a difference for
     *     read-write locks (\Swoole\Thread\Lock::RWLOCK); other lock types treat it the same as LOCK_EX.
     *   - LOCK_NB: added to either of the above (e.g., LOCK_EX | LOCK_NB) to make the call return right away instead of
     *     waiting when the lock isn't available. Parameter $timeout is ignored in this case.
     *
     * The two new parameters cover everything the removed methods lockwait(), trylock(), lock_read(), and
     * trylock_read() used to do, e.g.,
     *
     * ```php
     * $lock = new Swoole\Thread\Lock();
     * $lock->lock();                     // Wait as long as needed (what lock() did before Swoole 6.1.0).
     * $lock->lock(LOCK_EX, 0.5);         // Give up after 0.5 seconds (what lockwait() used to do).
     * $lock->lock(LOCK_EX | LOCK_NB);    // Never wait; return immediately (what trylock() used to do).
     * $lock->lock(LOCK_SH);              // Wait for a shared lock (what lock_read() used to do).
     * $lock->lock(LOCK_SH | LOCK_NB);    // Try for a shared lock without waiting (what trylock_read() used to do).
     * ```
     *
     * @param int $operation What kind of lock to acquire, as described above.
     * @param float $timeout How long to wait for the lock, in seconds. Any value that is not greater than 0 (such as
     *                       the default -1) means wait as long as it takes.
     * @return bool TRUE when the lock was acquired, FALSE otherwise (the lock was held by another thread and either
     *              parameter $timeout expired or LOCK_NB was used).
     * @see \Swoole\Thread\Lock::unlock()
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public function lock(int $operation = LOCK_EX, float $timeout = -1): bool
    {
    }

    /**
     * Release the lock.
     *
     * @return bool TRUE on success, FALSE on failure.
     * @see \Swoole\Thread\Lock::lock()
     */
    public function unlock(): bool
    {
    }
}
