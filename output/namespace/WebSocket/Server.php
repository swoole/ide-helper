<?php
namespace Swoole\WebSocket;

/**
 * @since 4.2.1
 */
class Server extends \Swoole\Http\Server
{

    public $onConnect;
    public $onReceive;
    public $onClose;
    public $onPacket;
    public $onBufferFull;
    public $onBufferEmpty;
    public $onStart;
    public $onShutdown;
    public $onWorkerStart;
    public $onWorkerStop;
    public $onWorkerExit;
    public $onWorkerError;
    public $onTask;
    public $onFinish;
    public $onManagerStart;
    public $onManagerStop;
    public $onPipeMessage;
    public $connections;
    public $host;
    public $port;
    public $type;
    public $mode;
    public $ports;
    public $master_pid;
    public $manager_pid;
    public $worker_id;
    public $taskworker;
    public $worker_pid;
    public $onRequest;
    public $onHandshake;
    public $setting;

    /**
     * @param $event_name [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public function on(string $event_name, $callback){}

    /**
     * @param $fd [required]
     * @param $data [required]
     * @param $opcode [optional]
     * @param $finish [optional]
     * @return mixed
     */
    public function push(int $fd, $data, int $opcode=null, $finish=null){}

    /**
     * @param $fd [required]
     * @param $code [optional]
     * @param $reason [optional]
     * @return mixed
     */
    public function disconnect(int $fd, $code=null, string $reason=null){}

    /**
     * @param $fd [required]
     * @return mixed
     */
    public function exist(int $fd){}

    /**
     * @param $fd [required]
     * @return mixed
     */
    public function isEstablished(int $fd){}

    /**
     * @param $data [required]
     * @param $opcode [optional]
     * @param $finish [optional]
     * @param $mask [optional]
     * @return mixed
     */
    public static function pack($data, int $opcode=null, $finish=null, $mask=null){}

    /**
     * @param $data [required]
     * @return mixed
     */
    public static function unpack($data){}

    /**
     * @return mixed
     */
    public function start(){}

    /**
     * @param $host [required]
     * @param $port [optional]
     * @param $mode [optional]
     * @param $sock_type [optional]
     * @return mixed
     */
    public function __construct(string $host, int $port=null, $mode=null, $sock_type=null){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $host [required]
     * @param $port [required]
     * @param $sock_type [required]
     * @return mixed
     */
    public function listen(string $host, int $port, $sock_type){}

    /**
     * @param $host [required]
     * @param $port [required]
     * @param $sock_type [required]
     * @return mixed
     */
    public function addlistener(string $host, int $port, $sock_type){}

    /**
     * @param $settings [required]
     * @return mixed
     */
    public function set(array $settings){}

    /**
     * @param $fd [required]
     * @param $send_data [required]
     * @param $reactor_id [optional]
     * @return mixed
     */
    public function send(int $fd, string $send_data, int $reactor_id=null){}

    /**
     * @param $ip [required]
     * @param $port [required]
     * @param $send_data [required]
     * @param $server_socket [optional]
     * @return mixed
     */
    public function sendto($ip, int $port, string $send_data, $server_socket=null){}

    /**
     * @param $conn_fd [required]
     * @param $send_data [required]
     * @return mixed
     */
    public function sendwait(int $conn_fd, string $send_data){}

    /**
     * @param $fd [required]
     * @param $is_protected [optional]
     * @return mixed
     */
    public function protect(int $fd, bool $is_protected=null){}

    /**
     * @param $conn_fd [required]
     * @param $filename [required]
     * @param $offset [optional]
     * @param $length [optional]
     * @return mixed
     */
    public function sendfile(int $conn_fd, string $filename, int $offset=null, int $length=null){}

    /**
     * @param $fd [required]
     * @param $reset [optional]
     * @return mixed
     */
    public function close(int $fd, bool $reset=null){}

    /**
     * @param $fd [required]
     * @return mixed
     */
    public function confirm(int $fd){}

    /**
     * @param $fd [required]
     * @return mixed
     */
    public function pause(int $fd){}

    /**
     * @param $fd [required]
     * @return mixed
     */
    public function resume(int $fd){}

    /**
     * @param $data [required]
     * @param $worker_id [optional]
     * @param $finish_callback [optional]
     * @return mixed
     */
    public function task($data, int $worker_id=null, $finish_callback=null){}

    /**
     * @param $data [required]
     * @param $timeout [optional]
     * @param $worker_id [optional]
     * @return mixed
     */
    public function taskwait($data, float $timeout=null, int $worker_id=null){}

    /**
     * @param $tasks [required]
     * @param $timeout [optional]
     * @return mixed
     */
    public function taskWaitMulti($tasks, float $timeout=null){}

    /**
     * @param $tasks [required]
     * @param $timeout [optional]
     * @return mixed
     */
    public function taskCo($tasks, float $timeout=null){}

    /**
     * @param $data [required]
     * @return mixed
     */
    public function finish($data){}

    /**
     * @return mixed
     */
    public function reload(){}

    /**
     * @return mixed
     */
    public function shutdown(){}

    /**
     * @param $worker_id [optional]
     * @return mixed
     */
    public function stop(int $worker_id=null){}

    /**
     * @return mixed
     */
    public function getLastError(){}

    /**
     * @param $reactor_id [required]
     * @return mixed
     */
    public function heartbeat(int $reactor_id){}

    /**
     * @param $fd [required]
     * @param $reactor_id [optional]
     * @return mixed
     */
    public function connection_info(int $fd, int $reactor_id=null){}

    /**
     * @param $start_fd [required]
     * @param $find_count [optional]
     * @return mixed
     */
    public function connection_list(int $start_fd, int $find_count=null){}

    /**
     * @param $fd [required]
     * @param $reactor_id [optional]
     * @return mixed
     */
    public function getClientInfo(int $fd, int $reactor_id=null){}

    /**
     * @param $start_fd [required]
     * @param $find_count [optional]
     * @return mixed
     */
    public function getClientList(int $start_fd, int $find_count=null){}

    /**
     * @param $ms [required]
     * @param mixed $callback [required]
     * @param $param [optional]
     * @return mixed
     */
    public function after(int $ms, $callback, $param=null){}

    /**
     * @param $ms [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public function tick(int $ms, $callback){}

    /**
     * @param $timer_id [required]
     * @return mixed
     */
    public function clearTimer(int $timer_id){}

    /**
     * @param mixed $callback [required]
     * @return mixed
     */
    public function defer($callback){}

    /**
     * @param $message [required]
     * @param $dst_worker_id [required]
     * @return mixed
     */
    public function sendMessage(string $message, int $dst_worker_id){}

    /**
     * @param $process [required]
     * @return mixed
     */
    public function addProcess($process){}

    /**
     * @return mixed
     */
    public function stats(){}

    /**
     * @param $port [optional]
     * @return mixed
     */
    public function getSocket(int $port=null){}

    /**
     * @param $fd [required]
     * @param $uid [required]
     * @return mixed
     */
    public function bind(int $fd, int $uid){}


}
