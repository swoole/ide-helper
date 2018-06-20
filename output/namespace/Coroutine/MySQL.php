<?php
namespace Swoole\Coroutine;

/**
 * @since 4.0.1
 */
class MySQL
{

    private $serverInfo;
    public $sock;
    public $connected;
    public $connect_error;
    public $connect_errno;
    public $affected_rows;
    public $insert_id;
    public $error;
    public $errno;

    /**
     * @return mixed
     */
    public function __construct(){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $server_config[required]
     * @return mixed
     */
    public function connect($server_config){}

    /**
     * @param $sql[required]
     * @param $timeout[optional]
     * @return mixed
     */
    public function query($sql, $timeout=null){}

    /**
     * @return mixed
     */
    public function recv(){}

    /**
     * @param $string[required]
     * @param $flags[optional]
     * @return mixed
     */
    public function escape($string, $flags=null){}

    /**
     * @return mixed
     */
    public function begin(){}

    /**
     * @return mixed
     */
    public function commit(){}

    /**
     * @return mixed
     */
    public function rollback(){}

    /**
     * @param $query[required]
     * @return mixed
     */
    public function prepare($query){}

    /**
     * @param $defer[optional]
     * @return mixed
     */
    public function setDefer($defer=null){}

    /**
     * @return mixed
     */
    public function getDefer(){}

    /**
     * @return mixed
     */
    public function close(){}

    /**
     * @return mixed
     */
    public function __sleep(){}

    /**
     * @return mixed
     */
    public function __wakeup(){}


}
