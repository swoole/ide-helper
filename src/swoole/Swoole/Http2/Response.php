<?php

declare(strict_types=1);

namespace Swoole\Http2;

/**
 * An HTTP/2 response.
 *
 * Objects of this class are created by Swoole and returned by methods \Swoole\Coroutine\Http2\Client::recv() and
 * \Swoole\Coroutine\Http2\Client::read(); they are not meant to be created directly in PHP code. The class has no
 * methods; all response information is exposed through its public properties.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Coroutine\Http2\Client::recv()
 * @see \Swoole\Coroutine\Http2\Client::read()
 */
class Response
{
    /**
     * ID of the HTTP/2 stream that the response belongs to. It matches the stream ID returned by the
     * \Swoole\Coroutine\Http2\Client::send() call that sent the corresponding request.
     *
     * @see \Swoole\Coroutine\Http2\Client::send()
     */
    public int $streamId = 0;

    /**
     * HTTP/2 error code of the stream (one of the SWOOLE_HTTP2_ERROR_* constant values), set when the server
     * terminates the stream with an RST_STREAM frame; it stays 0 for successfully completed responses.
     */
    public int $errCode = 0;

    /**
     * HTTP status code of the response (e.g., 200). It is set to -3 when the server terminates the stream with an
     * RST_STREAM frame instead of sending a complete response.
     */
    public int $statusCode = 0;

    /**
     * TRUE when the response is an incomplete piece of a streamed (pipelined) response and more pieces are still to
     * come; FALSE when the response is complete (the stream has ended).
     *
     * @see \Swoole\Coroutine\Http2\Client::read()
     */
    public bool $pipeline = false;

    /**
     * Response headers, as an array of header names (lowercase) mapping to values. NULL when the response carries
     * no headers.
     */
    public ?array $headers = null;

    /**
     * Raw values of the "set-cookie" response headers, in the order they were received. NULL when the response
     * carries no "set-cookie" headers.
     */
    public ?array $set_cookie_headers = null;

    /**
     * Cookies parsed out of the "set-cookie" response headers, as an array of cookie names mapping to (URL-decoded)
     * values. NULL when the response carries no "set-cookie" headers.
     */
    public ?array $cookies = null;

    /**
     * Response body. NULL when the response carries no body data (e.g., an individual piece of a streamed response
     * that only carries headers or trailers).
     */
    public ?string $data = null;
}
