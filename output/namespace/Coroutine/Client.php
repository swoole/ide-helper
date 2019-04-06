<?php

namespace Swoole\Coroutine;

class Client
{

    const MSG_OOB = 1;

    const MSG_PEEK = 2;

    const MSG_DONTWAIT = 128;

    const MSG_WAITALL = 64;

    public $errCode = 0;

    public $errMsg = '';

    public $sock = -1;

    public $type = 0;

    public $setting = null;

    public $connected = false;

    public function __construct($type)
    {
    }

    public function __destruct()
    {
    }

    public function set(array $settings)
    {
    }

    public function connect($host, $port = null, $timeout = null, $sock_flag = null)
    {
    }

    public function recv($timeout = null)
    {
    }

    public function peek($length = null)
    {
    }

    public function send($data)
    {
    }

    public function sendfile($filename, $offset = null, $length = null)
    {
    }

    public function sendto($address, $port, $data)
    {
    }

    public function recvfrom($length, &$address, &$port = null)
    {
    }

    public function isConnected()
    {
    }

    public function getsockname()
    {
    }

    public function getpeername()
    {
    }

    public function close()
    {
    }


}
