<?php

namespace Swoole;

class Timer
{
    /**
     * @param array $settings
     * @return void
     */
    public static function set(array $settings)
    {
    }

    /**
     * @param int $ms
     * @param callable $callback
     * @return int
     */
    public static function tick(int $ms, callable $callback, ...$params)
    {
    }

    /**
     * @param int $ms
     * @param callable $callback
     * @return int
     */
    public static function after(int $ms, callable $callback, ...$params)
    {
    }

    /**
     * @param int $timer_id
     * @return bool
     */
    public static function exists(int $timer_id)
    {
    }

    /**
     * @param int $timer_id
     * @return array
     */
    public static function info(int $timer_id)
    {
    }

    /**
     * @return array
     */
    public static function stats()
    {
    }

    /**
     * @return \Swoole\timer\Iterator
     */
    public static function list()
    {
    }

    /**
     * @param int $timer_id
     * @return bool
     */
    public static function clear(int $timer_id)
    {
    }

    /**
     * @return bool
     */
    public static function clearAll()
    {
    }
}
