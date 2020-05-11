<?php

namespace Swoole\Coroutine\Http;

class Client
{

    public $errCode = 0;

    public $errMsg = '';

    public $connected = false;

    public $host = '';

    public $port = 0;

    public $ssl = false;

    public $setting;

    public $requestMethod;

    public $requestHeaders;

    public $requestBody;

    public $uploadFiles;

    public $downloadFile;

    public $downloadOffset = 0;

    public $statusCode = 0;

    public $headers;

    public $set_cookie_headers;

    public $cookies;

    public $body = '';

    public function __construct($host, $port = null, $ssl = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function set(array $settings)
    {
    }

    /**
     * @return mixed
     */
    public function getDefer()
    {
    }

    /**
     * @return mixed
     */
    public function setDefer($defer = null)
    {
    }

    /**
     * @return mixed
     */
    public function setMethod($method)
    {
    }

    /**
     * @return mixed
     */
    public function setHeaders(array $headers)
    {
    }

    /**
     * @return mixed
     */
    public function setBasicAuth($username, $password)
    {
    }

    /**
     * @return mixed
     */
    public function setCookies(array $cookies)
    {
    }

    /**
     * @return mixed
     */
    public function setData($data)
    {
    }

    /**
     * @return mixed
     */
    public function addFile($path, $name, $type = null, $filename = null, $offset = null, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public function addData($path, $name, $type = null, $filename = null)
    {
    }

    /**
     * @return mixed
     */
    public function execute($path)
    {
    }

    /**
     * @return mixed
     */
    public function getpeername()
    {
    }

    /**
     * @return mixed
     */
    public function getsockname()
    {
    }

    /**
     * @return mixed
     */
    public function get($path)
    {
    }

    /**
     * @return mixed
     */
    public function post($path, $data)
    {
    }

    /**
     * @return mixed
     */
    public function download($path, $file, $offset = null)
    {
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
    }

    /**
     * @return mixed
     */
    public function getHeaderOut()
    {
    }

    /**
     * @return mixed
     */
    public function getPeerCert()
    {
    }

    /**
     * @return mixed
     */
    public function upgrade($path)
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
    public function recv($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }


}
