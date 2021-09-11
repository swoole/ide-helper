<?php

declare(strict_types=1);

namespace Swoole;

class Atomic
{
    public function __construct($value = null)
    {
    }

    /**
     * @param mixed|null $add_value
     * @return mixed
     */
    public function add($add_value = null)
    {
    }

    /**
     * @param mixed|null $sub_value
     * @return mixed
     */
    public function sub($sub_value = null)
    {
    }

    /**
     * @return mixed
     */
    public function get()
    {
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function set($value)
    {
    }

    /**
     * @param mixed|null $timeout
     * @return mixed
     */
    public function wait($timeout = null)
    {
    }

    /**
     * @param mixed|null $count
     * @return mixed
     */
    public function wakeup($count = null)
    {
    }

    /**
     * @param mixed $cmp_value
     * @param mixed $new_value
     * @return mixed
     */
    public function cmpset($cmp_value, $new_value)
    {
    }
}
