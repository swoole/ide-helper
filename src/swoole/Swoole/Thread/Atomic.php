<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\Atomic.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * This class is a thread-safe version of the \Swoole\Atomic class. For more information, see the documentation for the
 * \Swoole\Atomic class.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @since 6.0.0
 * @see \Swoole\Atomic Use this instead when PHP is compiled without Zend Thread Safety (ZTS) enabled.
 * @see \Swoole\Thread\Atomic\Long Use this instead to store the value using signed 64-bit integers instead of unsigned 32-bit integers.
 */
final class Atomic
{
    /**
     * Constructor. It can only be called once per object; calling it a second time throws an \Error.
     *
     * @param int $value The initial value of the counter. The default value is 0. It shouldn't be a negative number.
     */
    public function __construct(int $value = 0)
    {
    }

    /**
     * Atomically adds a value to the counter.
     *
     * @param int $add_value The value to be added to the counter. The default value is 1. It shouldn't be a negative number.
     * @return int The new value of the counter.
     */
    public function add(int $add_value = 1): int
    {
    }

    /**
     * Atomically subtracts a value from the counter.
     *
     * @param int $sub_value The value to be subtracted from the counter. The default value is 1. It shouldn't be a negative number.
     * @return int The new value of the counter.
     */
    public function sub(int $sub_value = 1): int
    {
    }

    /**
     * Get the current value of the counter.
     *
     * @return int The current value of the counter.
     */
    public function get(): int
    {
    }

    /**
     * Set the value of the counter.
     *
     * @param int $value The new value of the counter. It shouldn't be a negative number.
     */
    public function set(int $value): void
    {
    }

    /**
     * Block the current thread until it's woken up by another thread or the timeout expires.
     *
     * Before using this method, the counter must be either 0 or 1, otherwise the behavior is undefined.
     *   - When the counter is 0, the current thread will be put into a blocking state.
     *   - When the counter is 1, it means the thread doesn't need to wait; the method resets the counter back to 0
     *     (consuming the pending wake-up signal) and returns true immediately.
     *
     * WARNING: This method blocks the whole thread, not just the current coroutine.
     *
     * @param float $timeout The timeout in seconds.
     *                       > 0: The thread will be woken up after the specified number of seconds (or by another thread).
     *                       <= 0: No timeout. The thread will resume execution only when woken up by another thread.
     * @return bool Returns true if there was no need to wait, or if the thread was woken up by another thread and
     *              managed to consume the wake-up signal; returns false if the timeout expired, or if another thread
     *              consumed the wake-up signal first.
     * @see \Swoole\Thread\Atomic::wakeup()
     */
    public function wait(float $timeout = 1.0): bool
    {
    }

    /**
     * Wake up one or more threads that are blocked by method \Swoole\Thread\Atomic::wait().
     *
     * Before using this method, the counter must be either 0 or 1, otherwise the behavior is undefined.
     *   - When the counter is 0, there may be threads blocked; the method sets the counter to 1 and wakes up (up to
     *     $count of) them. It returns true whether or not any thread was actually blocked.
     *   - When the counter is 1, it means an earlier wake-up signal hasn't been consumed yet; the method does nothing
     *     and returns true immediately.
     *
     * There is no guarantee about which threads are awoken.
     *
     * @param int $count The number of threads to wake up.
     * @return bool Returns true in practice, whether or not any thread was actually woken up; it returns false only
     *              when the underlying wake-up operation fails at the operating system level.
     * @see \Swoole\Thread\Atomic::wait()
     */
    public function wakeup(int $count = 1): bool
    {
    }

    /**
     * Atomically compare and set the value of the counter.
     *
     * For example, assuming current value of the counter is 10,
     *   - $atomic->cmpset(11, 20); // This will not change the value of the counter.
     *   - $atomic->cmpset(10, 20); // This will set the value to 20.
     *
     * @param int $cmp_value The value to be compared with the current value of the counter.
     * @param int $new_value The new value of the counter. It shouldn't be a negative number.
     * @return bool True if the value of the counter was changed, false otherwise.
     */
    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
