<?php

declare(strict_types=1);

namespace Swoole\Http2;

/**
 * An HTTP/2 request.
 *
 * Objects of this class describe an HTTP/2 request to be sent out through method
 * \Swoole\Coroutine\Http2\Client::send(): create an object, set its public properties, and pass it to that method.
 * The class has no methods, and Swoole never creates objects of this class itself.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Coroutine\Http2\Client::send()
 */
class Request
{
    /**
     * Request path (with an optional query string), used as the ":path" pseudo-header of the request.
     */
    public string $path = '/';

    /**
     * Request method (e.g., "GET" or "POST"), used as the ":method" pseudo-header of the request.
     */
    public string $method = 'GET';

    /**
     * Request headers, as an array of header names (lowercase) mapping to values. NULL until assigned.
     */
    public ?array $headers = null;

    /**
     * Cookies to send with the request, as an array of cookie names mapping to values. NULL until assigned.
     */
    public ?array $cookies = null;

    /**
     * Request body.
     *
     * It can be either a string (sent as is) or an array of form fields; an array is sent URL-encoded, with request
     * header "content-type" set to "application/x-www-form-urlencoded" automatically. When left empty and property
     * $pipeline is FALSE, the request is sent without a body.
     */
    public string|array $data = '';

    /**
     * When TRUE, the request is sent in streaming (pipeline) mode: the request is not marked as finished after
     * method \Swoole\Coroutine\Http2\Client::send() returns, so more body data can be written to the stream with
     * method \Swoole\Coroutine\Http2\Client::write().
     *
     * @see \Swoole\Coroutine\Http2\Client::write()
     */
    public bool $pipeline = false;

    /**
     * When TRUE, a pipelined (streamed) request is read piece by piece with
     * \Swoole\Coroutine\Http2\Client::read() instead of being buffered until the whole response ends.
     *
     * @since 5.1.0
     * @see \Swoole\Coroutine\Http2\Client::read()
     */
    public bool $usePipelineRead = false;
}
