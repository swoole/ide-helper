<?php

declare(strict_types=1);

/**
 * Alias classes and functions listed in this file are available only when directive "swoole.use_shortname" is not
 * explicitly turned off.
 *
 * PHP directive `swoole.use_shortname` can only be set in `php.ini` files.
 */
class_alias(Swoole\Coroutine::class, Co::class);
class_alias(Swoole\Coroutine\Channel::class, Chan::class);

class_alias(Swoole\Coroutine\Channel::class, Co\Channel::class);
class_alias(Swoole\Coroutine\Client::class, Co\Client::class);
class_alias(Swoole\Coroutine\Context::class, Co\Context::class);
class_alias(Swoole\Coroutine\Curl\Exception::class, Co\Curl\Exception::class);
class_alias(Swoole\Coroutine\Http2\Client::class, Co\Http2\Client::class);
class_alias(Swoole\Coroutine\Http2\Client\Exception::class, Co\Http2\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Client::class, Co\Http\Client::class);
class_alias(Swoole\Coroutine\Http\Client\Exception::class, Co\Http\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Server::class, Co\Http\Server::class);
class_alias(Swoole\Coroutine\Iterator::class, Co\Iterator::class);
class_alias(Swoole\Coroutine\PostgreSQL::class, Co\PostgreSQL::class);
class_alias(Swoole\Coroutine\Scheduler::class, Co\Scheduler::class);
class_alias(Swoole\Coroutine\Socket::class, Co\Socket::class);
class_alias(Swoole\Coroutine\Socket\Exception::class, Co\Socket\Exception::class);
class_alias(Swoole\Coroutine\System::class, Co\System::class);

// Following classes are deprecated since Swoole 5.0.0 and will be removed in the future.
class_alias(Swoole\Coroutine\MySQL::class, Co\MySQL::class);
class_alias(Swoole\Coroutine\MySQL\Exception::class, Co\MySQL\Exception::class);
class_alias(Swoole\Coroutine\MySQL\Statement::class, Co\MySQL\Statement::class);
class_alias(Swoole\Coroutine\Redis::class, Co\Redis::class);

/**
 * @alias This function is an alias of function swoole_coroutine_create(); it's available only when directive
 *        "swoole.use_shortname" is not explicitly turned off.
 * @see swoole_coroutine_create()
 */
function go(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns.
 *
 * @alias This function is an alias of function swoole_coroutine_defer(); it's available only when directive
 *        "swoole.use_shortname" is not explicitly turned off.
 * @see swoole_coroutine_defer()
 *
 * @example
 * <pre>
 * go(function () {      // The surrounding function of a coroutine.
 *   echo '1';
 *   defer(function () { // The callback function to be deferred.
 *     echo '3';
 *   });
 *   echo '2';
 * });
 * <pre>
 */
function defer(callable $callback): void
{
}
