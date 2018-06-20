<?php
namespace Swoole\Http2;

/**
 * @since 4.0.1
 */
class Client extends \Swoole\Client
{
    const MSG_OOB = 1;
    const MSG_PEEK = 2;
    const MSG_DONTWAIT = 64;
    const MSG_WAITALL = 256;
    const SHUT_RDWR = 2;
    const SHUT_RD = 0;
    const SHUT_WR = 1;

    public $errCode;
    public $sock;
    public $reuse;
    public $reuseCount;
    public $type;
    public $id;
    public $setting;
    public $onConnect;
    public $onError;
    public $onReceive;
    public $onClose;
    public $onBufferFull;
    public $onBufferEmpty;
    public $onSSLReady;
    public $requestHeaders;
    public $cookies;

    /**
     * @return mixed
     */
    public function __construct(){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @return mixed
     */
    public function setHeaders(){}

    /**
     * @return mixed
     */
    public function setCookies(){}

    /**
     * @return mixed
     */
    public function get(){}

    /**
     * @return mixed
     */
    public function post(){}

    /**
     * @return mixed
     */
    public function onConnect(){}

    /**
     * @return mixed
     */
    public function onError(){}

    /**
     * @return mixed
     */
    public function onReceive(){}

    /**
     * @return mixed
     */
    public function onClose(){}

    /**
     * @return mixed
     */
    public function openStream(){}

    /**
     * @return mixed
     */
    public function push(){}

    /**
     * @return mixed
     */
    public function closeStream(){}

    /**
     * @param $settings[required]
     * @return mixed
     */
    public function set($settings){}

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $timeout[optional]
     * @param $sock_flag[optional]
     * @return mixed
     */
    public function connect($host, $port=null, $timeout=null, $sock_flag=null){}

    /**
     * @param $size[optional]
     * @param $flag[optional]
     * @return mixed
     */
    public function recv($size=null, $flag=null){}

    /**
     * @param $data[required]
     * @param $flag[optional]
     * @return mixed
     */
    public function send($data, $flag=null){}

    /**
     * @param $dst_socket[required]
     * @return mixed
     */
    public function pipe($dst_socket){}

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
    public function sleep(){}

    /**
     * @return mixed
     */
    public function wakeup(){}

    /**
     * @return mixed
     */
    public function pause(){}

    /**
     * @return mixed
     */
    public function resume(){}

    /**
     * @param $how[required]
     * @return mixed
     */
    public function shutdown($how){}

    /**
     * @param $callback[optional]
     * @return mixed
     */
    public function enableSSL($callback=null){}

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
     * @param $force[optional]
     * @return mixed
     */
    public function close($force=null){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     * @return mixed
     */
    public function on($event_name, $callback){}

    /**
     * @return mixed
     */
    public function getSocket(){}


}
