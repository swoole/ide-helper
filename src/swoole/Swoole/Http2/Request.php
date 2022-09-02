<?php

declare(strict_types=1);

namespace Swoole\Http2;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Request
{
    public $path = '/';

    public $method = 'GET';

    public $headers;

    public $cookies;

    public $data = '';

    public $pipeline = false;
}
