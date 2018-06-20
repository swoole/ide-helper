<?php
namespace Swoole\Coroutine\Http2;

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
    public $host;
    public $port;

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
     * @return mixed
     */
    public function connect(){}

    /**
     * @param $request[required]
     * @return mixed
     */
    public function send($request){}

    /**
     * @return mixed
     */
    public function recv(){}

    /**
     * @param $stream_id[required]
     * @param $data[required]
     * @param $end_stream[optional]
     * @return mixed
     */
    public function write($stream_id, $data, $end_stream=null){}

    /**
     * @return mixed
     */
    public function close(){}


}
