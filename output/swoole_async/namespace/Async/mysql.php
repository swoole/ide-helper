<?php

namespace Swoole;

class MySQL
{

    const STATE_QUERY = 0;

    const STATE_READ_START = 1;

    const STATE_READ_FIELD  = 2;

    const STATE_READ_ROW = 3;

    const STATE_READ_END = 5;

    const STATE_CLOSED = 6;

    public $serverInfo = null;

    public $sock = -1;

    public $connected = false;

    public $errno = 0;

    public $connect_errno = 0;

    public $error = null;

    public $connect_error = null;

    public $insert_id = null;

    public $affected_rows = null;

    public $onConnect = null;

    public $onClose = null;

    public function __construct()
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function connect(array $server_config, $callback)
    {
    }

    /**
     * @return mixed
     */
    public function begin($callback)
    {
    }

    /**
     * @return mixed
     */
    public function commit($callback)
    {
    }

    /**
     * @return mixed
     */
    public function rollback($callback)
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
    public function query($sql, $callback)
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
    public function getState()
    {
    }

    /**
     * @return mixed
     */
    public function on($event_name, $callback)
    {
    }


}
