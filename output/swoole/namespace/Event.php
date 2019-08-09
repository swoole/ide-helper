<?php

namespace Swoole;

class Event
{

    /**
     * @return mixed
     */
    public static function add($fd, ?callable $read_callback, ?callable $write_callback = null, $events = null)
    {
    }

    /**
     * @return mixed
     */
    public static function del($fd)
    {
    }

    /**
     * @return mixed
     */
    public static function set($fd, ?callable $read_callback = null, ?callable $write_callback = null, $events = null)
    {
    }

    /**
     * @return mixed
     */
    public static function isset($fd, $events = null)
    {
    }

    /**
     * @return mixed
     */
    public static function dispatch()
    {
    }

    /**
     * @return mixed
     */
    public static function defer(callable $callback)
    {
    }

    /**
     * @return mixed
     */
    public static function cycle(?callable $callback, $before = null)
    {
    }

    /**
     * @return mixed
     */
    public static function write($fd, $data)
    {
    }

    /**
     * @return mixed
     */
    public static function wait()
    {
    }

    /**
     * @return mixed
     */
    public static function rshutdown()
    {
    }

    /**
     * @return mixed
     */
    public static function exit()
    {
    }


}
