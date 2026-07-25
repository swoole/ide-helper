<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The Lock class provides a way to synchronize concurrent processes.
 *
 * In a multi-process environment, Lock objects should be created in the parent process so that child processes can
 * acquire the locks.
 *
 * It's not recommend to use locks in the event callback functions like onConnect(), onReceive() and so on. This could
 * cause memory leaks since memory usage could keep increasing as new requests keep coming in. In general, it's not
 * recommended to keep creating/destroying locks since this could cause memory leaks.
 *
 * This Lock class is not coroutine-friendly. It should not be used across different coroutines, especially when there
 * are coroutine switching between method calls to \Swoole\Lock::lock() and \Swoole\Lock::unlock(). For example, the
 * following example will cause deadlock:
 *
 *   Swoole\Coroutine\run(function () {
 *       $lock = new Swoole\Lock();
 *       for ($i = 0; $i < 2; $i++) {
 *           Swoole\Coroutine::create(function () use ($lock) {
 *               $lock->lock();
 *               Swoole\Coroutine::sleep(1);
 *               $lock->unlock();
 *           });
 *       }
 *   });
 *
 * If you think you need to use locks with coroutines, there are two options:
 * 1. use channels instead (before Swoole 6.0.1).
 * 2. use class \Swoole\Coroutine\Lock instead (since Swoole 6.0.1).
 *
 * Since Swoole 6.1.0, this class exposes only three methods, __construct(), lock(), and unlock(), and the way locks are
 * acquired now mirrors PHP's built-in flock() function: which kind of lock you want, and whether the call may block, are
 * both expressed through the $operation argument of method \Swoole\Lock::lock(). Methods lockwait(), trylock(),
 * lock_read(), and trylock_read() were removed in that release; see method \Swoole\Lock::lock() for how to express what
 * each of them used to do.
 *
 * @see \Swoole\Thread\Lock Use this instead when PHP is compiled with Zend Thread Safety (ZTS) enabled.
 * @see \Swoole\Coroutine\Lock Use this instead when using locks accross coroutines.
 * @see https://github.com/deminy/swoole-by-examples/blob/master/examples/csp/deadlocks/swoole-lock.php
 * @see https://www.php.net/manual/en/function.flock.php The built-in PHP function that method \Swoole\Lock::lock() is modeled after.
 * @not-serializable Objects of this class cannot be serialized.
 */
class Lock
{
    /**
     * Mutex lock.
     */
    public const MUTEX = SWOOLE_MUTEX;

    /**
     * Read-write lock.
     *
     * Supported only if read-write lock is included in the POSIX thread (pthread) libraries.
     */
    public const RWLOCK = SWOOLE_RWLOCK;

    /**
     * Spin lock.
     *
     * Supported only if the Spin Locks option is provided in the POSIX thread (pthread) libraries.
     */
    public const SPINLOCK = SWOOLE_SPINLOCK;

    /**
     * The error code of the last operation. It is set to 0 if the last operation was successful.
     */
    public int $errCode = 0;

    /**
     * Construct a Lock object.
     *
     * Before Swoole 4.5.3, the constructor accepts a second parameter $filename when the lock type is \Swoole\Lock::FILELOCK.
     * Parameter $filename specifies path to the file to be locked.
     *
     * @param int $type Type of the lock. It must be one of the following constants:
     *                  - \Swoole\Lock::MUTEX
     *                  - \Swoole\Lock::RWLOCK
     *                  - \Swoole\Lock::SPINLOCK
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
     *   - LOCK_EX: an exclusive lock, meaning no one else may hold the lock at the same time. This is the default.
     *   - LOCK_SH: a shared lock, meaning several holders may hold it at once. This only makes a difference for
     *     read-write locks (\Swoole\Lock::RWLOCK); other lock types treat it the same as LOCK_EX.
     *   - LOCK_NB: added to either of the above (e.g., LOCK_EX | LOCK_NB) to make the call return right away instead of
     *     waiting when the lock isn't available. Parameter $timeout is ignored in this case.
     *
     * The two new parameters cover everything the removed methods lockwait(), trylock(), lock_read(), and
     * trylock_read() used to do, e.g.,
     *
     * ```php
     * $lock = new Swoole\Lock();
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
     * @return bool TRUE when the lock was acquired, FALSE otherwise (the lock was held by someone else and either
     *              parameter $timeout expired or LOCK_NB was used).
     * @see \Swoole\Lock::unlock()
     * @see https://www.php.net/manual/en/function.flock.php
     */
    public function lock(int $operation = LOCK_EX, float $timeout = -1): bool
    {
    }

    /**
     * Release the lock.
     *
     * @return bool TRUE on success, FALSE on failure.
     * @see \Swoole\Lock::lock()
     */
    public function unlock(): bool
    {
    }
}
