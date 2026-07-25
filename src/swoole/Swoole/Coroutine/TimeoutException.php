<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * The exception thrown inside a coroutine when the execution time limit set through method
 * \Swoole\Coroutine::setTimeLimit() is exceeded.
 *
 * Catching it gives the coroutine a chance to release whatever it holds (open files, database connections, and so on)
 * before it stops, e.g.,
 *
 * ```php
 * Swoole\Coroutine\run(function () {
 *     try {
 *         Swoole\Coroutine::setTimeLimit(1.0);
 *         while (true) {
 *             Swoole\Coroutine::sleep(0.1);
 *         }
 *     } catch (Swoole\Coroutine\TimeoutException $e) {
 *         echo "time limit exceeded; releasing resources here\n";
 *     }
 * });
 * ```
 *
 * @see \Swoole\Coroutine::setTimeLimit()
 * @since 6.2.0
 */
final class TimeoutException extends \Exception
{
}
