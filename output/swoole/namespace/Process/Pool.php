<?php

namespace Swoole\Process;

class Pool
{

    public $master_pid = -1;

    public $workers;

    public function __construct($worker_num, $ipc_type = null, $msgqueue_key = null, $enable_coroutine = null)
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
    public function getProcess($worker_id = null)
    {
    }

    /**
     * @return mixed
     */
    public function listen($host, $port = null, $backlog = null)
    {
    }

    /**
     * @return mixed
     */
    public function write($data)
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
