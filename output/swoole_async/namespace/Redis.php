<?php

namespace Swoole;

class Redis
{

    const STATE_CONNECT = 0;

    const STATE_READY = 1;

    const STATE_WAIT_RESULT = 2;

    const STATE_SUBSCRIBE = 3;

    const STATE_CLOSED = 4;

    public $onConnect = null;

    public $onClose = null;

    public $onMessage = null;

    public $setting = null;

    public $host = null;

    public $port = null;

    public $sock = null;

    public $errCode = null;

    public $errMsg = null;

    public function __construct(?array $setting = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function on($event_name, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function connect($host, $port, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }

    /**
     * @return mixed
     */
    public function getState()
    {
    }

    /**
     * @return mixed
     */
    public function __call($command, $params)
    {
    }


}
