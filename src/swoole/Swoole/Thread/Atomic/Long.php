<?php

declare(strict_types=1);

namespace Swoole\Thread\Atomic;

/**
 * Class \Swoole\Thread\Atomic\Long.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * This class is a thread-safe version of the \Swoole\Atomic\Long class. For more information, see the documentation for
 * the \Swoole\Atomic\Long class.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @since 6.0.0
 * @see \Swoole\Atomic\Long Use this instead when PHP is compiled without Zend Thread Safety (ZTS) enabled.
 * @see \Swoole\Thread\Atomic Use this instead to store the value using unsigned 32-bit integers instead of signed 64-bit integers.
 */
final class Long
{
    /**
     * Constructor. It can only be called once per object; calling it a second time throws an \Error.
     *
     * @param int $value The initial value of the counter. The default value is 0.
     */
    public function __construct(int $value = 0)
    {
    }

    /**
     * Atomically adds a value to the counter.
     *
     * @param int $add_value The value to be added to the counter. The default value is 1.
     * @return int The new value of the counter.
     */
    public function add(int $add_value = 1): int
    {
    }

    /**
     * Atomically subtracts a value from the counter.
     *
     * @param int $sub_value The value to be subtracted from the counter. The default value is 1.
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
     * @param int $value The new value of the counter.
     */
    public function set(int $value): void
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
     * @param int $new_value The new value of the counter.
     * @return bool True if the value of the counter was changed, false otherwise.
     */
    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
