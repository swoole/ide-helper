<?php

namespace Swoole\Coroutine\MySQL;

class Statement
{

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

    public function __destruct()
    {
    }


}
