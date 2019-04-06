<?php

namespace Swoole\Coroutine\MySQL;

class Statement
{

    public $affected_rows = 0;

    public $insert_id = 0;

    public $error = '';

    public $errno = 0;

    public function execute($params = null, $timeout = null)
    {
    }

    public function fetch()
    {
    }

    public function fetchAll()
    {
    }

    public function nextResult()
    {
    }

    public function __destruct()
    {
    }


}
