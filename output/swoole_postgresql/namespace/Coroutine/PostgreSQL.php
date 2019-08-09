<?php

namespace Swoole\Coroutine;

class PostgreSQL
{

    public $error = null;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function connect($conninfo)
    {
    }

    /**
     * @return mixed
     */
    public function query($query = null)
    {
    }

    /**
     * @return mixed
     */
    public function prepare($stmtname, $query)
    {
    }

    /**
     * @return mixed
     */
    public function execute($stmtname, $pv_param_arr)
    {
    }

    /**
     * @return mixed
     */
    public function fetchAll($result = null, $result_type = null)
    {
    }

    /**
     * @return mixed
     */
    public function affectedRows($result = null)
    {
    }

    /**
     * @return mixed
     */
    public function numRows($result = null)
    {
    }

    /**
     * @return mixed
     */
    public function metaData($table_name)
    {
    }

    /**
     * @return mixed
     */
    public function fetchObject($result, $row = null, $class_name = null, $l = null, $ctor_params = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetchAssoc($result, $row = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetchArray($result, $row = null, $result_type = null)
    {
    }

    /**
     * @return mixed
     */
    public function fetchRow($result, $row = null, $result_type = null)
    {
    }

    public function __destruct()
    {
    }


}
