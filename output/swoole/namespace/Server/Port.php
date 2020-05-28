<?php

namespace Swoole\Server;

class Port
{

    private $onConnect;

    private $onReceive;

    private $onClose;

    private $onPacket;

    private $onBufferFull;

    private $onBufferEmpty;

    private $onRequest;

    private $onHandShake;

    private $onOpen;

    private $onMessage;

    public $host;

    public $port = 0;

    public $type = 0;

    public $sock = -1;

    public $setting;

    public $connections;

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
