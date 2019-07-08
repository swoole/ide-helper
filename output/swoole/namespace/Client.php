<?php

namespace Swoole;

class Client
{

    const MSG_OOB = 1;

    const MSG_PEEK = 2;

    const MSG_DONTWAIT = 64;

    const MSG_WAITALL = 256;

    const SHUT_RDWR = 2;

    const SHUT_RD = 0;

    const SHUT_WR = 1;

    public $errCode = 0;

    public $sock = -1;

    public $reuse = false;

    public $reuseCount = 0;

    public $type = 0;

    public $id = null;

    public $setting = null;

    private $onConnect = null;

    private $onError = null;

    private $onReceive = null;

    private $onClose = null;

    private $onBufferFull = null;

    private $onBufferEmpty = null;

    private $onSSLReady = null;

    public function __construct($type, $async = null)
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
    public function pipe($dst_socket)
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
    public function sleep()
    {
    }

    /**
     * @return mixed
     */
    public function wakeup()
    {
    }

    /**
     * @return mixed
     */
    public function pause()
    {
    }

    /**
     * @return mixed
     */
    public function resume()
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
    public function enableSSL(callable $callback = null)
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
    public function on($event_name, callable $callback)
    {
    }

    /**
     * @return mixed
     */
    public function getSocket()
    {
    }


}
