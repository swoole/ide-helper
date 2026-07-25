<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The base exception class of Swoole.
 *
 * Every exception class defined by the Swoole extension (e.g., \Swoole\Client\Exception,
 * \Swoole\Coroutine\Socket\Exception) extends this class, so catching this class catches any exception thrown by
 * Swoole. Swoole also throws exceptions of this class directly for various runtime errors, e.g., a shared-memory
 * allocation failure in \Swoole\Atomic, an invalid lock type passed to \Swoole\Lock, or invalid parameters passed
 * to \Swoole\Process\Pool. The exception code carries the underlying error number (a Swoole error code or a C error
 * number), which can be turned into a human-readable message with function swoole_strerror().
 *
 * @see \swoole_strerror()
 */
class Exception extends \Exception
{
}
