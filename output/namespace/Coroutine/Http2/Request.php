<?php
namespace Swoole\Coroutine\Http2;

/**
 * @since 4.0.2
 */
class Request
{

    public $path;
    public $method;
    public $headers;
    public $cookies;
    public $data;
    public $pipeline;
    public $files;


}
