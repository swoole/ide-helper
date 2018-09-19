<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class Client
{
    const MSG_OOB = 1;
    const MSG_PEEK = 2;
    const MSG_DONTWAIT = 128;
    const MSG_WAITALL = 64;
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

    /**
     * @param $type [required]
     * @param $async [optional]
     * @return mixed
     */
    public function __construct($type, $async=null){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $settings [required]
     * @return mixed
     */
    public function set(array $settings){}

    /**
     * @param $host [required]
     * @param $port [optional]
     * @param $timeout [optional]
     * @param $sock_flag [optional]
     * @return mixed
     */
    public function connect(string $host, int $port=null, float $timeout=null, $sock_flag=null){}

    /**
     * @param $size [optional]
     * @param $flag [optional]
     * @return mixed
     */
    public function recv(int $size=null, $flag=null){}

    /**
     * @param $data [required]
     * @param $flag [optional]
     * @return mixed
     */
    public function send($data, $flag=null){}

    /**
     * @param $dst_socket [required]
     * @return mixed
     */
    public function pipe($dst_socket){}

    /**
     * @param $filename [required]
     * @param $offset [optional]
     * @param $length [optional]
     * @return mixed
     */
    public function sendfile(string $filename, int $offset=null, int $length=null){}

    /**
     * @param $ip [required]
     * @param $port [required]
     * @param $data [required]
     * @return mixed
     */
    public function sendto($ip, int $port, $data){}

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
     * @param $how [required]
     * @return mixed
     */
    public function shutdown($how){}

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
     * @param $force [optional]
     * @return mixed
     */
    public function close($force=null){}

    /**
     * @param $event_name [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public function on(string $event_name, $callback){}

    /**
     * @return mixed
     */
    public function getSocket(){}


}
