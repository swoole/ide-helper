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
 * Since Swoole 6.2.5, incoming requests are parsed more strictly and more completely:
 *   - When several requests arrive back to back on one connection (HTTP pipelining), every one of them is handled;
 *     before 6.2.5, the bytes following the first complete request were discarded.
 *   - A request body sent in chunks (header "Transfer-Encoding: chunked") may carry chunk extensions and trailer
 *     fields, as the HTTP specification allows; both are accepted and skipped, and trailer fields are not added to
 *     property \Swoole\Http\Request::$header. Before 6.2.5, a chunked request ending with trailer fields was never
 *     recognized as complete.
 *   - A request whose "Transfer-Encoding" header names anything other than "chunked" as the final encoding, or whose
 *     chunk sizes are malformed, is answered with a "400 Bad Request" response; a chunk bigger than setting
 *     "package_max_length" is answered with "413 Request Entity Too Large" right away, without reading it in.
 *   - The interim "100 Continue" response for requests carrying header "Expect: 100-continue" is sent exactly once,
 *     right after the request headers are received, and also for chunked bodies and for file uploads larger than
 *     "package_max_length" (which are streamed into temporary files); before 6.2.5, those two kinds of requests got no
 *     interim response.
 *   - A multipart request that tries to use the header name Swoole reserves internally for marking a file already
 *     saved to disk is rejected with a "400 Bad Request" response, so the paths in properties
 *     \Swoole\Http\Request::$files and \Swoole\Http\Request::$tmpfiles always point at files Swoole created itself.
 *   - Over HTTP/2, request headers that span several frames (a HEADERS frame followed by CONTINUATION frames) are
 *     accepted; before 6.2.5, CONTINUATION frames weren't supported, so such a request was never dispatched.
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
