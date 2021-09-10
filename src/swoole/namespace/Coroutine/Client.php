<?php

namespace Swoole\Coroutine;

class Client
{

    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 64;

    public const MSG_WAITALL = 256;

    public $errCode = 0;

    public $errMsg = '';

    public $fd = -1;

    private $socket;

    public $type = 1;

    public $setting;

    public $connected = false;

    public function __construct($type)
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
    public function connect($host, $port = null, $timeout = null, $sock_flag = null)
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
    public function peek($length = null)
    {
    }

    /**
     * @return mixed
     */
    public function send($data)
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
    public function sendto($address, $port, $data)
    {
    }

    /**
     * @return mixed
     */
    public function recvfrom($length, &$address, &$port = null)
    {
    }

    /**
     * @return mixed
     */
    public function enableSSL()
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
    public function verifyPeerCert()
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
    public function getsockname()
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
    public function close()
    {
    }

    /**
     * @return mixed
     */
    public function exportSocket()
    {
    }


}
