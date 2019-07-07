<?php

namespace Swoole\Coroutine\MySQL;

class Statement
{

    public $id = 0;

    public $affected_rows = 0;

    public $insert_id = 0;

    public $error = '';

    public $errno = 0;

    /**
     * @return mixed
     */
    public function execute($params = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetch($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetchAll($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function nextResult($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function recv($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }


}
