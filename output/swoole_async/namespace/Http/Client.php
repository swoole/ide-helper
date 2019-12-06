<?php

namespace Swoole\Http;

class Client
{

    public $type = 0;

    public $errCode = 0;

    public $errMsg = '';

    public $statusCode = 0;

    public $host = null;

    public $port = 0;

    public $ssl = false;

    public $requestMethod = null;

    public $requestHeaders = null;

    public $requestBody = null;

    public $uploadFiles = null;

    public $set_cookie_headers = null;

    public $downloadFile = null;

    public $headers = null;

    public $cookies = null;

    public $body = null;

    public $onConnect = null;

    public $onError = null;

    public $onMessage = null;

    public $onClose = null;

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
    public function execute($path, $callback)
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
    public function get($path, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function post($path, $data, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function upgrade($path, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function download($path, $file, $callback, $offset = null)
    {
    }

    /**
     * @return mixed
     */
    public function isConnected()
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }

    /**
     * @return mixed
     */
    public function on($event_name, $callback)
    {
    }


}
