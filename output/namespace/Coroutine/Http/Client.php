<?php
namespace Swoole\Coroutine\Http;

/**
 * @since 4.0.1
 */
class Client
{

    public $errCode;
    public $sock;
    public $reuse;
    public $reuseCount;
    public $type;
    public $setting;
    public $connected;
    public $statusCode;
    public $host;
    public $port;
    public $requestMethod;
    public $requestHeaders;
    public $requestBody;
    public $uploadFiles;
    public $headers;
    public $cookies;
    public $body;

    /**
     * @param $host[required]
     * @param $port[optional]
     * @param $ssl[optional]
     * @return mixed
     */
    public function __construct($host, $port=null, $ssl=null){}

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
     * @param $method[required]
     * @return mixed
     */
    public function setMethod($method){}

    /**
     * @param $headers[required]
     * @return mixed
     */
    public function setHeaders($headers){}

    /**
     * @param $cookies[required]
     * @return mixed
     */
    public function setCookies($cookies){}

    /**
     * @param $data[required]
     * @return mixed
     */
    public function setData($data){}

    /**
     * @param $path[required]
     * @return mixed
     */
    public function execute($path){}

    /**
     * @param $path[required]
     * @return mixed
     */
    public function get($path){}

    /**
     * @param $path[required]
     * @param $data[required]
     * @return mixed
     */
    public function post($path, $data){}

    /**
     * @param $path[required]
     * @param $file[required]
     * @param $offset[optional]
     * @return mixed
     */
    public function download($path, $file, $offset=null){}

    /**
     * @param $path[required]
     * @return mixed
     */
    public function upgrade($path){}

    /**
     * @param $path[required]
     * @param $name[required]
     * @param $type[optional]
     * @param $filename[optional]
     * @param $offset[optional]
     * @param $length[optional]
     * @return mixed
     */
    public function addFile($path, $name, $type=null, $filename=null, $offset=null, $length=null){}

    /**
     * @return mixed
     */
    public function isConnected(){}

    /**
     * @return mixed
     */
    public function close(){}

    /**
     * @param $defer[optional]
     * @return mixed
     */
    public function setDefer($defer=null){}

    /**
     * @return mixed
     */
    public function getDefer(){}

    /**
     * @param $timeout[optional]
     * @return mixed
     */
    public function recv($timeout=null){}

    /**
     * @param $data[required]
     * @param $opcode[optional]
     * @param $finish[optional]
     * @return mixed
     */
    public function push($data, $opcode=null, $finish=null){}

    /**
     * @return mixed
     */
    public function __sleep(){}

    /**
     * @return mixed
     */
    public function __wakeup(){}


}
