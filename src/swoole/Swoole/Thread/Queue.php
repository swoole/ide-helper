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
    /**
     * Unblock only one of the waiting threads.
     *
     * This constant is used by method Queue::push() only.
     */
    public const NOTIFY_ONE = 1;

    /**
     * Unblock all threads currently waiting for this queue.
     *
     * This constant is used by method Queue::push() only.
     */
    public const NOTIFY_ALL = 2;

    /**
     * Push a value into the queue.
     *
     * @param mixed $value The value to push into the queue.
     * @param int $notify_which How to unblock threads that are waiting on the queue. Either Queue::NOTIFY_ONE,
     *                          Queue::NOTIFY_ALL, or 0 (not to notify anyone).
     */
    public function push(mixed $value, int $notify_which = 0): void
    {
    }

    /**
     * Pop a value from the queue.
     *
     * @param float $wait The maximum time, in seconds, to wait for a value to become available in the queue.
     *                    A value of 0 means to wait indefinitely.
     * @return mixed The value removed from the queue, or null if the wait time expires and no value is available.
     */
    public function pop(float $wait = 0): mixed
    {
    }

    /**
     * Clean the queue by removing all elements from it.
     */
    public function clean(): void
    {
    }

    /**
     * Count the number of elements in the queue.
     *
     * {@inheritDoc}
     * @return int The number of elements in the queue.
     */
    public function count(): int
    {
    }
}
