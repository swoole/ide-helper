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
     * HTTP/2 error code of the stream (one of the SWOOLE_HTTP2_ERROR_* constant values). The property is declared for
     * backward compatibility but, as of Swoole 6.2.2, is never updated by Swoole; it always stays 0. When the server
     * terminates a stream with an RST_STREAM frame, the stream is discarded quietly and no response is handed back at
     * all.
     */
    public int $errCode = 0;

    /**
     * HTTP status code of the response (e.g., 200), taken from the ":status" pseudo-header sent by the server. It
     * stays 0 when no response headers have been received yet (e.g., on an individual piece of a streamed response
     * that carries body data only).
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
     * Response headers, as an array of header names (lowercase) mapping to values. NULL when no response headers have
     * been received for this response object (e.g., on an individual piece of a streamed response that carries body
     * data only).
     */
    public ?array $headers = null;

    /**
     * Raw values of the "set-cookie" response headers, in the order they were received. It's an empty array when the
     * response has headers but no "set-cookie" ones, and NULL when no response headers have been received for this
     * response object at all.
     */
    public ?array $set_cookie_headers = null;

    /**
     * Cookies parsed out of the "set-cookie" response headers, as an array of cookie names mapping to (URL-decoded)
     * values. It's an empty array when the response has headers but no "set-cookie" ones, and NULL when no response
     * headers have been received for this response object at all.
     */
    public ?array $cookies = null;

    /**
     * Response body. NULL when the response carries no body data (e.g., an individual piece of a streamed response
     * that only carries headers or trailers).
     */
    public ?string $data = null;
}
