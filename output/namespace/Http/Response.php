<?php

namespace Swoole\Http;

class Response
{

    public $fd = 0;

    public $socket = null;

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
    public function setCookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null)
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
    public function setStatusCode($http_code, $reason = null)
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
    public function setHeader($key, $value, $ucwords = null)
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

    /**
     * @return mixed
     */
    public function upgrade()
    {
    }

    /**
     * @return mixed
     */
    public function push()
    {
    }

    /**
     * @return mixed
     */
    public function recv()
    {
    }

    public function __destruct()
    {
    }


}
