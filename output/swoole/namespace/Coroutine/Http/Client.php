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

    public $setting = null;

    public $requestMethod = null;

    public $requestHeaders = null;

    public $requestBody = null;

    public $uploadFiles = null;

    public $downloadFile = null;

    public $downloadOffset = 0;

    public $statusCode = 0;

    public $headers = null;

    public $set_cookie_headers = null;

    public $cookies = null;

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
    public function upgrade($path)
    {
    }

    /**
     * @return mixed
     */
    public function push($data, $opcode = null, $finish = null)
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
