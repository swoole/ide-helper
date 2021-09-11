<?php

declare(strict_types=1);

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
     * @param mixed $address
     * @param mixed|null $port
     * @return mixed
     */
    public function bind($address, $port = null)
    {
    }

    /**
     * @param mixed|null $backlog
     * @return mixed
     */
    public function listen($backlog = null)
    {
    }

    /**
     * @param mixed|null $timeout
     * @return mixed
     */
    public function accept($timeout = null)
    {
    }

    /**
     * @param mixed $host
     * @param mixed|null $port
     * @param mixed|null $timeout
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
     * @param mixed|null $length
     * @return mixed
     */
    public function peek($length = null)
    {
    }

    /**
     * @param mixed|null $length
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recv($length = null, $timeout = null)
    {
    }

    /**
     * @param mixed|null $length
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recvAll($length = null, $timeout = null)
    {
    }

    /**
     * @param mixed|null $length
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recvLine($length = null, $timeout = null)
    {
    }

    /**
     * @param mixed|null $length
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recvWithBuffer($length = null, $timeout = null)
    {
    }

    /**
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recvPacket($timeout = null)
    {
    }

    /**
     * @param mixed $data
     * @param mixed|null $timeout
     * @return mixed
     */
    public function send($data, $timeout = null)
    {
    }

    /**
     * @param mixed $io_vector
     * @param mixed|null $timeout
     * @return mixed
     */
    public function readVector($io_vector, $timeout = null)
    {
    }

    /**
     * @param mixed $io_vector
     * @param mixed|null $timeout
     * @return mixed
     */
    public function readVectorAll($io_vector, $timeout = null)
    {
    }

    /**
     * @param mixed $io_vector
     * @param mixed|null $timeout
     * @return mixed
     */
    public function writeVector($io_vector, $timeout = null)
    {
    }

    /**
     * @param mixed $io_vector
     * @param mixed|null $timeout
     * @return mixed
     */
    public function writeVectorAll($io_vector, $timeout = null)
    {
    }

    /**
     * @param mixed $filename
     * @param mixed|null $offset
     * @param mixed|null $length
     * @return mixed
     */
    public function sendFile($filename, $offset = null, $length = null)
    {
    }

    /**
     * @param mixed $data
     * @param mixed|null $timeout
     * @return mixed
     */
    public function sendAll($data, $timeout = null)
    {
    }

    /**
     * @param mixed $peername
     * @param mixed|null $timeout
     * @return mixed
     */
    public function recvfrom(&$peername, $timeout = null)
    {
    }

    /**
     * @param mixed $addr
     * @param mixed $port
     * @param mixed $data
     * @return mixed
     */
    public function sendto($addr, $port, $data)
    {
    }

    /**
     * @param mixed $level
     * @param mixed $opt_name
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
     * @param mixed $level
     * @param mixed $opt_name
     * @param mixed $opt_value
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
     * @param mixed|null $how
     * @return mixed
     */
    public function shutdown($how = null)
    {
    }

    /**
     * @param mixed|null $event
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
