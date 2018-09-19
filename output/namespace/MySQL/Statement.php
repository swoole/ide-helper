<?php
namespace Co\Mysql;

/**
 * @since 4.0.1
 */
class Statement
{

    public $affected_rows;
    public $insert_id;
    public $error;
    public $errno;

    /**
     * @param $params[optional]
     * @param $timeout[optional]
     * @return mixed
     */
    public function execute($params=null, $timeout=null){}

    /**
     * @return mixed
     */
    public function fetch(){}

    /**
     * @return mixed
     */
    public function fetchAll(){}

    /**
     * @return mixed
     */
    public function nextResult(){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @return mixed
     */
    public function __sleep(){}

    /**
     * @return mixed
     */
    public function __wakeup(){}


}
