<?php

namespace Swoole;

class Process
{

    const IPC_NOWAIT = 256;

    const PIPE_MASTER = 1;

    const PIPE_WORKER = 2;

    const PIPE_READ = 3;

    const PIPE_WRITE = 4;

    public $pipe = null;

    public $callback = null;

    public $msgQueueId = null;

    public $msgQueueKey = null;

    public $pid = null;

    public $id = null;

    public function __construct(callable $callback, $redirect_stdin_and_stdout = null, $pipe_type = null, $enable_coroutine = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public static function wait($blocking = null)
    {
    }

    /**
     * @return mixed
     */
    public static function signal($signal_no, $callback)
    {
    }

    /**
     * @return mixed
     */
    public static function alarm($usec, $type = null)
    {
    }

    /**
     * @return mixed
     */
    public static function kill($pid, $signal_no = null)
    {
    }

    /**
     * @return mixed
     */
    public static function daemon($nochdir = null, $noclose = null)
    {
    }

    /**
     * @return mixed
     */
    public static function setaffinity(array $cpu_settings)
    {
    }

    /**
     * @return mixed
     */
    public function setTimeout($seconds)
    {
    }

    /**
     * @return mixed
     */
    public function setBlocking($blocking)
    {
    }

    /**
     * @return mixed
     */
    public function useQueue($key = null, $mode = null, $capacity = null)
    {
    }

    /**
     * @return mixed
     */
    public function statQueue()
    {
    }

    /**
     * @return mixed
     */
    public function freeQueue()
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
    public function write($data)
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
    public function read($size = null)
    {
    }

    /**
     * @return mixed
     */
    public function push($data)
    {
    }

    /**
     * @return mixed
     */
    public function pop($size = null)
    {
    }

    /**
     * @return mixed
     */
    public function exit($exit_code = null)
    {
    }

    /**
     * @return mixed
     */
    public function exec($exec_file, $args)
    {
    }

    /**
     * @return mixed
     */
    public function exportSocket()
    {
    }

    /**
     * @return mixed
     */
    public function name($process_name)
    {
    }


}
