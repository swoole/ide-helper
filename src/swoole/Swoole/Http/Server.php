<?php

declare(strict_types=1);

namespace Swoole\Http;

/**
 * An HTTP server, built on top of class \Swoole\Server.
 *
 * This class adds no methods or properties of its own; what makes it different from \Swoole\Server is how it starts.
 * When the server starts, the HTTP protocol is turned on for the primary port automatically (HTTP/2 is turned on too
 * when setting "open_http2_protocol" is enabled), and incoming requests are parsed by Swoole and passed to the
 * "Request" event callback as a \Swoole\Http\Request object and a \Swoole\Http\Response object, e.g.,
 * ```php
 * $server = new \Swoole\Http\Server('127.0.0.1', 9501);
 * $server->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
 *     $response->end('Hello, World!');
 * });
 * $server->start();
 * ```
 *
 * A callback for the "Request" event must be registered before the server starts; otherwise starting the server fails
 * with a fatal error.
 *
 * @see \Swoole\Server
 * @see \Swoole\Http\Request
 * @see \Swoole\Http\Response
 * @see \Swoole\WebSocket\Server
 * @not-serializable Objects of this class cannot be serialized.
 */
class Server extends \Swoole\Server
{
}
