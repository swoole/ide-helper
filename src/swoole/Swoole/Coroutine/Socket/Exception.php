<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Socket;

/**
 * Thrown by \Swoole\Coroutine\Socket on invalid usage, e.g., when a Socket object cannot be created (an invalid
 * domain/type/protocol combination, or a failing socket system call), or when invalid items are passed to methods
 * readVector(), readVectorAll(), writeVector(), or writeVectorAll().
 *
 * @see \Swoole\Coroutine\Socket
 * @alias This class has an alias of "\Co\Socket\Exception" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Socket\Exception
 */
class Exception extends \Swoole\Exception
{
}
