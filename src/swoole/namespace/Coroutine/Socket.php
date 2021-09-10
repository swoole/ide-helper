<?php

namespace Swoole\Coroutine;

class Socket
{

    public $fd = -1;

    public $domain = 0;

    public $type = 0;

    public $protocol = 0;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct($domain, $type, $protocol = null)
    {
    }

    /**
     * @return mixed
     */
    public function bind($address, $port = null)
    {
    }

    /**
     * @return mixed
     */
    public function listen($backlog = null)
    {
    }

    /**
     * @return mixed
     */
    public function accept($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function connect($host, $port = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function checkLiveness()
    {
    }

    /**
     * @return mixed
     */
    public function peek($length = null)
    {
    }

    /**
     * @return mixed
     */
    public function recv($length = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recvAll($length = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recvLine($length = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recvWithBuffer($length = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recvPacket($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function send($data, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function readVector($io_vector, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function readVectorAll($io_vector, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function writeVector($io_vector, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function writeVectorAll($io_vector, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendFile($filename, $offset = null, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendAll($data, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recvfrom(&$peername, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendto($addr, $port, $data)
    {
    }

    /**
     * @return mixed
     */
    public function getOption($level, $opt_name)
    {
    }

    /**
     * @return mixed
     */
    public function setProtocol(array $settings)
    {
    }

    /**
     * @return mixed
     */
    public function setOption($level, $opt_name, $opt_value)
    {
    }

    /**
     * @return mixed
     */
    public function sslHandshake()
    {
    }

    /**
     * @return mixed
     */
    public function shutdown($how = null)
    {
    }

    /**
     * @return mixed
     */
    public function cancel($event = null)
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
    public function getpeername()
    {
    }

    /**
     * @return mixed
     */
    public function getsockname()
    {
    }


}
