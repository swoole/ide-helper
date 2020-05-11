<?php

namespace Swoole\Http;

class Response
{

    public $fd = 0;

    public $socket;

    public $header;

    public $cookie;

    public $trailer;

    /**
     * @return mixed
     */
    public function initHeader()
    {
    }

    /**
     * @return mixed
     */
    public function cookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null, $samesite = null)
    {
    }

    /**
     * @return mixed
     */
    public function setCookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null, $samesite = null)
    {
    }

    /**
     * @return mixed
     */
    public function rawcookie($name, $value = null, $expires = null, $path = null, $domain = null, $secure = null, $httponly = null, $samesite = null)
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
    public static function create($server, $fd = null)
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
    public function push($data, $opcode = null, $flags = null)
    {
    }

    /**
     * @return mixed
     */
    public function recv()
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }

    public function __destruct()
    {
    }


}
