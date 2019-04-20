<?php

namespace Swoole\Http;

class Response
{

    public $fd = 0;

    public $header = null;

    public $cookie = null;

    public $trailer = null;

    /**
     * @return mixed
     */
    public function initHeader()
    {
    }

    /**
     * @return mixed
     */
    public function cookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
    }

    /**
     * @return mixed
     */
    public function rawcookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null)
    {
    }

    /**
     * @return mixed
     */
    public function status($http_code, $reason = null)
    {
    }

    /**
     * @return mixed
     */
    public function header($key, $value, $ucwords = null)
    {
    }

    /**
     * @return mixed
     */
    public function trailer($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function ping()
    {
    }

    /**
     * @return mixed
     */
    public function write($content)
    {
    }

    /**
     * @return mixed
     */
    public function end($content = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendfile($filename, $offset = null, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public function redirect($location, $http_code = null)
    {
    }

    /**
     * @return mixed
     */
    public function detach()
    {
    }

    /**
     * @return mixed
     */
    public static function create($fd)
    {
    }

    public function __destruct()
    {
    }


}
