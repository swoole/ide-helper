<?php

namespace Swoole\Coroutine;

class Socket
{

    public $fd = -1;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct($domain, $type, $protocol = null)
    {
    }

    public function bind($address, $port = null)
    {
    }

    public function listen($backlog = null)
    {
    }

    public function accept($timeout = null)
    {
    }

    public function connect($host, $port = null, $timeout = null)
    {
    }

    public function recv($length = null, $timeout = null)
    {
    }

    public function send($data, $timeout = null)
    {
    }

    public function recvAll($length = null, $timeout = null)
    {
    }

    public function sendAll($data, $timeout = null)
    {
    }

    public function recvfrom(&$peername, $timeout = null)
    {
    }

    public function sendto($addr, $port, $data)
    {
    }

    public function getOption($level, $opt_name)
    {
    }

    public function setOption($level, $opt_name, $opt_value)
    {
    }

    public function shutdown($how)
    {
    }

    public function close()
    {
    }

    public function getpeername()
    {
    }

    public function getsockname()
    {
    }

    public function getSocket()
    {
    }


}
