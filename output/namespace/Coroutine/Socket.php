<?php
namespace Swoole\Coroutine;

/**
 * @since 4.2.1
 */
class Socket
{

    public $errCode;

    /**
     * @param $domain [required]
     * @param $type [required]
     * @param $protocol [required]
     * @return mixed
     */
    public function __construct($domain, $type, $protocol){}

    /**
     * @param $address [required]
     * @param $port [optional]
     * @return mixed
     */
    public function bind($address, int $port=null){}

    /**
     * @param $backlog [optional]
     * @return mixed
     */
    public function listen($backlog=null){}

    /**
     * @param $timeout [optional]
     * @return mixed
     */
    public function accept(float $timeout=null){}

    /**
     * @param $host [required]
     * @param $port [optional]
     * @param $timeout [optional]
     * @return mixed
     */
    public function connect(string $host, int $port=null, float $timeout=null){}

    /**
     * @param $timeout [optional]
     * @return mixed
     */
    public function recv(float $timeout=null){}

    /**
     * @param $data [required]
     * @param $timeout [optional]
     * @return mixed
     */
    public function send($data, float $timeout=null){}

    /**
     * @param $peername [required]
     * @param $timeout [optional]
     * @return mixed
     */
    public function recvfrom($peername, float $timeout=null){}

    /**
     * @param $addr [required]
     * @param $port [required]
     * @param $data [required]
     * @return mixed
     */
    public function sendto($addr, int $port, $data){}

    /**
     * @return mixed
     */
    public function getpeername(){}

    /**
     * @return mixed
     */
    public function getsockname(){}

    /**
     * @return mixed
     */
    public function getSocket(){}

    /**
     * @return mixed
     */
    public function close(){}


}
