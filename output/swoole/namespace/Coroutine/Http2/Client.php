<?php

namespace Swoole\Coroutine\Http2;

class Client
{

    public $errCode = 0;

    public $errMsg = 0;

    public $sock = -1;

    public $type = 0;

    public $setting;

    public $connected = false;

    public $host;

    public $port = 0;

    public $ssl = false;

    public function __construct($host, $port = null, $ssl = null)
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
    public function connect()
    {
    }

    /**
     * @return mixed
     */
    public function stats($key = null)
    {
    }

    /**
     * @return mixed
     */
    public function isStreamExist($stream_id)
    {
    }

    /**
     * @return mixed
     */
    public function send($request)
    {
    }

    /**
     * @return mixed
     */
    public function write($stream_id, $data, $end_stream = null)
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
    public function goaway($error_code = null, $debug_data = null)
    {
    }

    /**
     * @return mixed
     */
    public function ping()
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }


}
