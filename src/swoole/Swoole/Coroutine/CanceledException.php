<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * The exception thrown inside a coroutine that is cancelled through method \Swoole\Coroutine::cancel($cid, true).
 *
 * Catching it gives the coroutine a chance to release whatever it holds (open files, database connections, and so on)
 * before it stops, e.g.,
 *
 * ```php
 * $cid = Swoole\Coroutine::create(function () {
 *     try {
 *         while (true) {
 *             Swoole\Coroutine::sleep(0.1);
 *         }
 *     } catch (Swoole\Coroutine\CanceledException $e) {
 *         echo "cancelled; releasing resources here\n";
 *     }
 * });
 * Swoole\Coroutine::sleep(0.3);
 * Swoole\Coroutine::cancel($cid, true);
 * ```
 *
 * Note that this exception is thrown only when the second argument of method \Swoole\Coroutine::cancel() is TRUE. A
 * plain \Swoole\Coroutine::cancel($cid) call cancels the coroutine without throwing anything.
 *
 * @see \Swoole\Coroutine::cancel()
 * @since 6.1.0
 */
final class CanceledException extends \Exception
{
}
