<?php

namespace Swoole;

class Process
{

    public const IPC_NOWAIT = 256;

    public const PIPE_MASTER = 1;

    public const PIPE_WORKER = 2;

    public const PIPE_READ = 3;

    public const PIPE_WRITE = 4;

    public $pipe;

    public $msgQueueId;

    public $msgQueueKey;

    public $pid;

    public $id;

    private $callback;

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
    public static function daemon($nochdir = null, $noclose = null, $pipes = null)
    {
    }

    /**
     * @return mixed
     */
    public function setPriority($which, $priority)
    {
    }

    /**
     * @return mixed
     */
    public function getPriority($which)
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
