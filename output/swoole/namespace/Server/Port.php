<?php

namespace Swoole\Server;

class Port
{

    private $onConnect = null;

    private $onReceive = null;

    private $onClose = null;

    private $onPacket = null;

    private $onBufferFull = null;

    private $onBufferEmpty = null;

    private $onRequest = null;

    private $onHandShake = null;

    private $onOpen = null;

    private $onMessage = null;

    public $host = null;

    public $port = 0;

    public $type = 0;

    public $sock = -1;

    public $setting = null;

    public $connections = null;

    private function __construct()
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
    public function on($event_name, callable $callback)
    {
    }

    /**
     * @return mixed
     */
    public function getCallback($event_name)
    {
    }

    /**
     * @return mixed
     */
    public function getSocket()
    {
    }


}
