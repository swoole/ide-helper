<?php

declare(strict_types=1);

namespace Swoole\Http2;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Request
{
    public string $path = '/';

    public string $method = 'GET';

    public array $headers;

    public array $cookies;

    public string $data = '';

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
