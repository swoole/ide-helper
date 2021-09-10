<?php

namespace Swoole\Coroutine\Http;

class Server
{

    public $fd = -1;

    public $host;

    public $port = -1;

    public $ssl = false;

    public $settings;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct($host, $port = null, $ssl = null, $reuse_port = null)
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
    public function handle($pattern, callable $callback)
    {
    }

    /**
     * @return mixed
     */
    private function onAccept()
    {
    }

    /**
     * @return mixed
     */
    public function start()
    {
    }

    /**
     * @return mixed
     */
    public function shutdown()
    {
    }


}
