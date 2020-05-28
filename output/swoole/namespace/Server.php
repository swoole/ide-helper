<?php

namespace Swoole;

class Server
{

    private $onStart;

    private $onShutdown;

    private $onWorkerStart;

    private $onWorkerStop;

    private $onWorkerExit;

    private $onWorkerError;

    private $onTask;

    private $onFinish;

    private $onManagerStart;

    private $onManagerStop;

    private $onPipeMessage;

    public $setting;

    public $connections;

    public $host = '';

    public $port = 0;

    public $type = 0;

    public $mode = 0;

    public $ports;

    public $master_pid = 0;

    public $manager_pid = 0;

    public $worker_id = -1;

    public $taskworker = false;

    public $worker_pid = 0;

    public function __construct($host, $port = null, $mode = null, $sock_type = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function listen($host, $port, $sock_type)
    {
    }

    /**
     * @return mixed
     */
    public function addlistener($host, $port, $sock_type)
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
    public function set(array $settings)
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
    public function send($fd, $send_data, $server_socket = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendto($ip, $port, $send_data, $server_socket = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendwait($conn_fd, $send_data)
    {
    }

    /**
     * @return mixed
     */
    public function exists($fd)
    {
    }

    /**
     * @return mixed
     */
    public function exist($fd)
    {
    }

    /**
     * @return mixed
     */
    public function protect($fd, $is_protected = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendfile($conn_fd, $filename, $offset = null, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public function close($fd, $reset = null)
    {
    }

    /**
     * @return mixed
     */
    public function confirm($fd)
    {
    }

    /**
     * @return mixed
     */
    public function pause($fd)
    {
    }

    /**
     * @return mixed
     */
    public function resume($fd)
    {
    }

    /**
     * @return mixed
     */
    public function task($data, $worker_id = null, ?callable $finish_callback = null)
    {
    }

    /**
     * @return mixed
     */
    public function taskwait($data, $timeout = null, $worker_id = null)
    {
    }

    /**
     * @return mixed
     */
    public function taskWaitMulti(array $tasks, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function taskCo(array $tasks, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function finish($data)
    {
    }

    /**
     * @return mixed
     */
    public function reload()
    {
    }

    /**
     * @return mixed
     */
    public function shutdown()
    {
    }

    /**
     * @return mixed
     */
    public function stop($worker_id = null)
    {
    }

    /**
     * @return mixed
     */
    public function getLastError()
    {
    }

    /**
     * @return mixed
     */
    public function heartbeat($reactor_id)
    {
    }

    /**
     * @return mixed
     */
    public function getClientInfo($fd, $reactor_id = null)
    {
    }

    /**
     * @return mixed
     */
    public function getClientList($start_fd, $find_count = null)
    {
    }

    /**
     * @return mixed
     */
    public function connection_info($fd, $reactor_id = null)
    {
    }

    /**
     * @return mixed
     */
    public function connection_list($start_fd, $find_count = null)
    {
    }

    /**
     * @return mixed
     */
    public function sendMessage($message, $dst_worker_id)
    {
    }

    /**
     * @return mixed
     */
    public function addProcess(\swoole_process $process)
    {
    }

    /**
     * @return mixed
     */
    public function stats()
    {
    }

    /**
     * @return mixed
     */
    public function getSocket($port = null)
    {
    }

    /**
     * @return mixed
     */
    public function bind($fd, $uid)
    {
    }


}
