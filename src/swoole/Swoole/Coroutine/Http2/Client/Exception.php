<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http2\Client;

/**
 * Thrown by \Swoole\Coroutine\Http2\Client. As of Swoole 6.2.2, there are two cases only: constructing the client with
 * an empty host (error code SWOOLE_ERROR_INVALID_PARAMS), and failing to send out buffered control frames while
 * another coroutine is writing to the same connection (error code SWOOLE_ERROR_HTTP2_SEND_CONTROL_FRAME_FAILED).
 *
 * Note that other kinds of misuse don't throw: sending on a client that isn't connected, or going over the allowed
 * number of concurrent streams, simply make the method fail with FALSE returned.
 *
 * @alias This class has an alias of "\Co\Http2\Client\Exception" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Swoole\Coroutine\Http2\Client
 * @see \Co\Http2\Client\Exception
 */
class Exception extends \Swoole\Exception
{
}
