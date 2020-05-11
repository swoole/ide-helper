<?php

namespace Swoole\Coroutine;

class MySQL
{

    public $serverInfo;

    public $sock = -1;

    public $connected = false;

    public $connect_errno = 0;

    public $connect_error = '';

    public $affected_rows = 0;

    public $insert_id = 0;

    public $error = '';

    public $errno = 0;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function getDefer()
    {
    }

    /**
     * @return mixed
     */
    public function setDefer($defer = null)
    {
    }

    /**
     * @return mixed
     */
    public function connect(array $server_config = null)
    {
    }

    /**
     * @return mixed
     */
    public function query($sql, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetch()
    {
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
    }

    /**
     * @return mixed
     */
    public function nextResult()
    {
    }

    /**
     * @return mixed
     */
    public function prepare($query, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recv()
    {
    }

    /**
     * @return mixed
     */
    public function begin($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function commit($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function rollback($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function escape($string, $flags = null)
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }


}
