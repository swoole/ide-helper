<?php

namespace Swoole;

class Client
{

    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 64;

    public const MSG_WAITALL = 256;

    public const SHUT_RDWR = 2;

    public const SHUT_RD = 0;

    public const SHUT_WR = 1;

    public $errCode = 0;

    public $sock = -1;

    public $reuse = false;

    public $reuseCount = 0;

    public $type = 0;

    public $id;

    public $setting;

    public function __construct($type, $async = null, $id = null)
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
    public function recv($size = null, $flag = null)
    {
    }

    /**
     * @return mixed
     */
    public function send($data, $flag = null)
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
    public function sendto($ip, $port, $data)
    {
    }

    /**
     * @return mixed
     */
    public function shutdown($how)
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
    public function close($force = null)
    {
    }

    /**
     * @return mixed
     */
    public function getSocket()
    {
    }


}
