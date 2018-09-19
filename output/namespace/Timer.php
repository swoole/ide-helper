<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class Timer
{


    /**
     * @param $ms [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public static function tick(int $ms, $callback){}

    /**
     * @param $ms [required]
     * @param mixed $callback [required]
     * @param $param [optional]
     * @return mixed
     */
    public static function after(int $ms, $callback, $param=null){}

    /**
     * @param $timer_id [required]
     * @return mixed
     */
    public static function exists(int $timer_id){}

    /**
     * @param $timer_id [required]
     * @return mixed
     */
    public static function clear(int $timer_id){}


}
