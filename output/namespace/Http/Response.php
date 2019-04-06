<?php

namespace Swoole\Http;

class Response
{

    public $fd = 0;

    public $header = null;

    public $cookie = null;

    public $trailer = null;

    public function initHeader()
    {
    }

    public function cookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
    }

    public function rawcookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
    }

    public function status($http_code, $reason = null)
    {
    }

    public function header($key, $value, $ucwords = null)
    {
    }

    public function trailer($key, $value, $ucwords = null)
    {
    }

    public function write($content)
    {
    }

    public function end($content = null)
    {
    }

    public function sendfile($filename, $offset = null, $length = null)
    {
    }

    public function redirect($location, $http_code = null)
    {
    }

    public function detach()
    {
    }

    public static function create($fd)
    {
    }

    public function __destruct()
    {
    }


}
