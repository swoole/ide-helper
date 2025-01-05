<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * A synchronization mechanism that allows multiple threads to wait at a barrier point until the specified number of
 * threads has reached the barrier.
 *
 * Once the required number of threads has arrived, all threads are released simultaneously.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
 */
final class Barrier
{
    /**
     * Initializes a new barrier with a specified thread count.
     *
     * @param int $count The number of threads required to meet at the barrier before they can proceed.
     *                   This value must be greater than 0.
     */
    public function __construct(int $count)
    {
    }

    /**
     * Blocks the current thread until the specified number of threads (provided in the constructor)
     * have invoked this method.
     *
     * Once all threads have called this method, the barrier is lifted, and all waiting threads proceed.
     */
    public function wait(): void
    {
    }
}
