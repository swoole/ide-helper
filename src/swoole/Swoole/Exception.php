<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The base exception class of Swoole.
 *
 * Almost every exception class defined by the Swoole extension (e.g., \Swoole\Client\Exception,
 * \Swoole\Coroutine\Socket\Exception, \Swoole\ExitException) extends this class. The only two that don't are
 * \Swoole\Coroutine\CanceledException and \Swoole\Coroutine\TimeoutException, which extend the built-in \Exception
 * class directly — so catching this class catches every exception thrown by Swoole except those two.
 *
 * Swoole also throws exceptions of this class directly for various runtime errors, e.g., a shared-memory
 * allocation failure in \Swoole\Atomic, an invalid lock type passed to \Swoole\Lock, or invalid parameters passed
 * to \Swoole\Process\Pool. The exception code carries the underlying error number (a Swoole error code or a C error
 * number), which can be turned into a human-readable message with function swoole_strerror().
 *
 * @see \Swoole\Coroutine\CanceledException
 * @see \Swoole\Coroutine\TimeoutException
 * @see \swoole_strerror()
 */
class Exception extends \Exception
{
}
