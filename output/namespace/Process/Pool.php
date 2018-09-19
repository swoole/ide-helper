<?php
namespace Swoole\Process;

/**
 * @since 4.2.1
 */
class Pool
{


    /**
     * @param $worker_num [required]
     * @param $ipc_type [optional]
     * @param $msgqueue_key [optional]
     * @return mixed
     */
    public function __construct(int $worker_num, $ipc_type=null, $msgqueue_key=null){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $event_name [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public function on(string $event_name, $callback){}

    /**
     * @return mixed
     */
    public function getProcess(){}

    /**
     * @param $host [required]
     * @param $port [optional]
     * @param $backlog [optional]
     * @return mixed
     */
    public function listen(string $host, int $port=null, $backlog=null){}

    /**
     * @param $data [required]
     * @return mixed
     */
    public function write($data){}

    /**
     * @return mixed
     */
    public function start(){}


}
