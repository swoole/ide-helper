<?php
namespace Swoole\Coroutine;

/**
 * @since 4.0.1
 */
class Client
{
    const MSG_OOB = 1;
    const MSG_PEEK = 2;
    const MSG_DONTWAIT = 64;
    const MSG_WAITALL = 256;

    public $errCode;
    public $sock;
    public $reuse;
    public $reuseCount;
    public $type;
    public $id;
    public $setting;
    public $connected;

    /**
     * @param $type[required]
     * @return mixed
     */
    public function __construct($type){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $settings[required]
     * @return mixed
     */
    public function set($settings){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $timeout[optional]
     * @return mixed
     */
    public function connect($host, $port=null, $timeout=null){}

    /**
     * @param $timeout[optional]
     * @return mixed
     */
    public function recv($timeout=null){}

    /**
     * @param $length[optional]
     * @return mixed
     */
    public function peek($length=null){}

    /**
     * @param $data[required]
     * @param $flag[optional]
     * @return mixed
     */
    public function send($data, $flag=null){}

    /**
     * @param $filename[required]
     * @param $offset[optional]
     * @param $length[optional]
     * @return mixed
     */
    public function sendfile($filename, $offset=null, $length=null){}

    /**
     * @param $ip[required]
     * @param $port[required]
     * @param $data[required]
     * @return mixed
     */
    public function sendto($ip, $port, $data){}

    /**
     * @return mixed
     */
    public function enableSSL(){}

    /**
     * @return mixed
     */
    public function getPeerCert(){}

    /**
     * @return mixed
     */
    public function verifyPeerCert(){}

    /**
     * @return mixed
     */
    public function isConnected(){}

    /**
     * @return mixed
     */
    public function getsockname(){}

    /**
     * @return mixed
     */
    public function getpeername(){}

    /**
     * @return mixed
     */
    public function close(){}

    /**
     * @return mixed
     */
    public function __sleep(){}

    /**
     * @return mixed
     */
    public function __wakeup(){}

    /**
     * @return mixed
     */
    public function getSocket(){}


}
