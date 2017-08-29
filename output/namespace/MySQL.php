<?php
namespace Swoole;

/**
 * @since 2.0.8
 */
class MySQL
{


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
     * @param $callback[required]
     * @return mixed
     */
    public function connect($server_config, $callback){}

    /**
     * @param $callback[required]
     * @return mixed
     */
    public function begin($callback){}

    /**
     * @param $callback[required]
     * @return mixed
     */
    public function commit($callback){}

    /**
     * @param $callback[required]
     * @return mixed
     */
    public function rollback($callback){}

    /**
     * @param $string[required]
     * @param $flags[optional]
     * @return mixed
     */
    public function escape($string, $flags=null){}

    /**
     * @param $sql[required]
     * @param $callback[required]
     * @return mixed
     */
    public function query($sql, $callback){}

    /**
     * @return mixed
     */
    public function close(){}

    /**
     * @param $event_name[required]
     * @param $callback[required]
     * @return mixed
     */
    public function on($event_name, $callback){}


}
