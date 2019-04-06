<?php

namespace Swoole;

class Server
{

    private $onStart = null;

    private $onShutdown = null;

    private $onWorkerStart = null;

    private $onWorkerStop = null;

    private $onWorkerExit = null;

    private $onWorkerError = null;

    private $onTask = null;

    private $onFinish = null;

    private $onManagerStart = null;

    private $onManagerStop = null;

    private $onPipeMessage = null;

    public $setting = null;

    public $connections = null;

    public $host = '';

    public $port = 0;

    public $type = 0;

    public $mode = 0;

    public $ports = null;

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

    public function listen($host, $port, $sock_type)
    {
    }

    public function addlistener($host, $port, $sock_type)
    {
    }

    public function on($event_name, callable $callback)
    {
    }

    public function getCallback($event_name)
    {
    }

    public function set(array $settings)
    {
    }

    public function start()
    {
    }

    public function send($fd, $send_data, $server_socket = null)
    {
    }

    public function sendto($ip, $port, $send_data, $server_socket = null)
    {
    }

    public function sendwait($conn_fd, $send_data)
    {
    }

    public function exists($fd)
    {
    }

    public function exist($fd)
    {
    }

    public function protect($fd, $is_protected = null)
    {
    }

    public function sendfile($conn_fd, $filename, $offset = null, $length = null)
    {
    }

    public function close($fd, $reset = null)
    {
    }

    public function confirm($fd)
    {
    }

    public function pause($fd)
    {
    }

    public function resume($fd)
    {
    }

    public function task($data, $worker_id = null, ?callable $finish_callback = null)
    {
    }

    public function taskwait($data, $timeout = null, $worker_id = null)
    {
    }

    public function taskWaitMulti(array $tasks, $timeout = null)
    {
    }

    public function taskCo(array $tasks, $timeout = null)
    {
    }

    public function finish($data)
    {
    }

    public function reload()
    {
    }

    public function shutdown()
    {
    }

    public function stop($worker_id = null)
    {
    }

    public function getLastError()
    {
    }

    public function heartbeat($reactor_id)
    {
    }

    public function connection_info($fd, $reactor_id = null)
    {
    }

    public function connection_list($start_fd, $find_count = null)
    {
    }

    public function getClientInfo($fd, $reactor_id = null)
    {
    }

    public function getClientList($start_fd, $find_count = null)
    {
    }

    public function after($ms, callable $callback, $param = null)
    {
    }

    public function tick($ms, callable $callback)
    {
    }

    public function clearTimer($timer_id)
    {
    }

    public function defer(callable $callback)
    {
    }

    public function sendMessage($message, $dst_worker_id)
    {
    }

    public function addProcess(\swoole_process $process)
    {
    }

    public function stats()
    {
    }

    public function bind($fd, $uid)
    {
    }


}
