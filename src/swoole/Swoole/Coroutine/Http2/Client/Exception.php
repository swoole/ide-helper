<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http2\Client;

/**
 * Thrown by \Swoole\Coroutine\Http2\Client on invalid usage, e.g. connecting with an empty host, sending on a client
 * that is not connected, or exceeding the allowed number of concurrent streams.
 *
 * @see \Swoole\Coroutine\Http2\Client
 * @alias This class has an alias of "\Co\Http2\Client\Exception" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http2\Client\Exception
 */
class Exception extends \Swoole\Exception
{
}
