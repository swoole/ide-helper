<?php

declare(strict_types=1);

/**
 * Alias classes and functions listed in this file are available only when directive "swoole.use_shortname" is not
 * explicitly turned off.
 *
 * PHP directive `swoole.use_shortname` can only be set in `php.ini` files.
 */
class_alias(Swoole\Coroutine::class, co::class);
class_alias(Swoole\Coroutine\Channel::class, chan::class);

class_alias(Swoole\Coroutine\Channel::class, Co\Channel::class);
class_alias(Swoole\Coroutine\Client::class, Co\Client::class);
class_alias(Swoole\Coroutine\Context::class, Co\Context::class);
// This alias exists only when Swoole is installed with option "--enable-swoole-curl" included.
class_alias(Swoole\Coroutine\Curl\Exception::class, Co\Coroutine\Curl\Exception::class);
class_alias(Swoole\Coroutine\Http2\Client::class, Co\Http2\Client::class);
class_alias(Swoole\Coroutine\Http2\Client\Exception::class, Co\Http2\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Client::class, Co\Http\Client::class);
class_alias(Swoole\Coroutine\Http\Client\Exception::class, Co\Http\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Server::class, Co\Http\Server::class);
class_alias(Swoole\Coroutine\Iterator::class, Co\Iterator::class);
class_alias(Swoole\Coroutine\Scheduler::class, Co\Scheduler::class);
class_alias(Swoole\Coroutine\Socket::class, Co\Socket::class);
class_alias(Swoole\Coroutine\Socket\Exception::class, Co\Socket\Exception::class);
class_alias(Swoole\Coroutine\System::class, Co\System::class);

/**
 * Create a coroutine.
 *
 * This function is available only when directive "swoole.use_shortname" is not explicitly turned off.
 *
 * @return int|false Returns the coroutine ID on success, or false on failure. Note that this method won't return
 *                   the coroutine ID back until the new coroutine yields its execution.
 * @alias This function has an alias function swoole_coroutine_create() and an alias method \Swoole\Coroutine::create().
 * @see swoole_coroutine_create()
 * @see \Swoole\Coroutine::create()
 */
function go(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns.
 *
 * This function is available only when directive "swoole.use_shortname" is not explicitly turned off. e.g.,
 * ```php
 * go(function () {      // The surrounding function of a coroutine.
 *   echo '1';
 *   defer(function () { // The callback function to be deferred.
 *     echo '3';
 *   });
 *   echo '2';
 * });
 * ```
 *
 * @alias This function is an alias of function swoole_coroutine_defer().
 * @see swoole_coroutine_defer()
 */
function defer(callable $callback): void
{
}

/**
 * Create a typed array: an array that rejects keys or values of the wrong type.
 *
 * This function is available only when directive "swoole.use_shortname" is not explicitly turned off, and Swoole is
 * installed with the "--enable-swoole-stdext" configuration option, e.g.,
 * ```php
 * $array = typed_array('<int, string>');
 * $array[1000] = 'hello'; // Fine.
 * $array[2000] = 2025;    // Throws a \TypeError, since 2025 is not a string.
 * ```
 *
 * @param string $typeDef The type definition, written between angle brackets. Give both a key type and a value type
 *                        separated by a comma (e.g., "<int, string>" for a map), or just a value type (e.g.,
 *                        "<string>") for a list. The key type must be "int" or "string"; the value type may also be a
 *                        class name, or a nested type definition such as "<int, <string>>".
 * @param array|null $initArray Values to fill the new typed array with. Each of them is type-checked as it goes in.
 * @return array The new typed array.
 * @throws \Error When the type definition is malformed or names a class that doesn't exist.
 * @throws \TypeError When one of the initial values doesn't match the type definition.
 * @alias This function is an alias of function swoole_typed_array().
 * @see swoole_typed_array()
 * @since 6.1.0
 */
function typed_array(string $typeDef, ?array $initArray = null): array
{
}
