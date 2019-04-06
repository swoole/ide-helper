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

    public function set(array $settings)
    {
    }

    public function getDefer()
    {
    }

    public function setDefer($defer = null)
    {
    }

    public function setMethod($method)
    {
    }

    public function setHeaders(array $headers)
    {
    }

    public function setCookies(array $cookies)
    {
    }

    public function setData($data)
    {
    }

    public function execute($path)
    {
    }

    public function get($path)
    {
    }

    public function post($path, $data)
    {
    }

    public function download($path, $file, $offset = null)
    {
    }

    public function upgrade($path)
    {
    }

    public function addFile($path, $name, $type = null, $filename = null, $offset = null, $length = null)
    {
    }

    public function addData($path, $name, $type = null, $filename = null)
    {
    }

    public function recv($timeout = null)
    {
    }

    public function push($data, $opcode = null, $finish = null)
    {
    }

    public function close()
    {
    }


}
