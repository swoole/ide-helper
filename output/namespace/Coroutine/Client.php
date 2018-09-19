<?php
namespace Swoole\Coroutine;

/**
 * @since 4.2.1
 */
class Client
{
    const MSG_OOB = 1;
    const MSG_PEEK = 2;
    const MSG_DONTWAIT = 128;
    const MSG_WAITALL = 64;

    public $errCode;
    public $sock;
    public $type;
    public $setting;
    public $connected;

    /**
     * @param $type [required]
     * @return mixed
     */
    public function __construct($type){}

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
     * @return mixed
     */
    public function connect(string $host, int $port=null, float $timeout=null){}

    /**
     * @param $timeout [optional]
     * @return mixed
     */
    public function recv(float $timeout=null){}

    /**
     * @param $length [optional]
     * @return mixed
     */
    public function peek(int $length=null){}

    /**
     * @param $data [required]
     * @return mixed
     */
    public function send($data){}

    /**
     * @param $filename [required]
     * @param $offset [optional]
     * @param $length [optional]
     * @return mixed
     */
    public function sendfile(string $filename, int $offset=null, int $length=null){}

    /**
     * @param $address [required]
     * @param $port [required]
     * @param $data [required]
     * @return mixed
     */
    public function sendto($address, int $port, $data){}

    /**
     * @param $length [required]
     * @param $address [required]
     * @param $port [optional]
     * @return mixed
     */
    public function recvfrom(int $length, $address, int $port=null){}

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
    public function getSocket(){}


}
