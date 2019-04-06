<?php

namespace Swoole\Process;

class Pool
{

    public $master_pid = -1;

    public function __construct($worker_num, $ipc_type = null, $msgqueue_key = null)
    {
    }

    public function __destruct()
    {
    }

    public function on($event_name, callable $callback)
    {
    }

    public function getProcess()
    {
    }

    public function listen($host, $port = null, $backlog = null)
    {
    }

    public function write($data)
    {
    }

    public function start()
    {
    }

    public function shutdown()
    {
    }


}
