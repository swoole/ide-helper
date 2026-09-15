<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Reports the failure to hand a stream or socket over from one thread to another.
 *
 * Objects of this class are never created in PHP code. When a stream or socket that was shared between threads (e.g.,
 * stored in a \Swoole\Thread\Map, a \Swoole\Thread\ArrayList, or a \Swoole\Thread\Queue) can't be re-created in the
 * thread reading it back, an object of this class is handed back in its place, with property $code telling why.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @see \Swoole\Thread\Map
 * @see \Swoole\Thread\ArrayList
 * @see \Swoole\Thread\Queue
 * @since 6.0.0
 */
class Error
{
    /**
     * Error code of the operating system call that failed while re-creating the shared stream or socket. Default is 0.
     *
     * @readonly
     */
    public int $code = 0;
}
