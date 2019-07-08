<?php

namespace Swoole;

class Buffer
{

    public $capacity = 128;

    public $length = 0;

    public function __construct($size = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
    }

    /**
     * @return mixed
     */
    public function substr($offset, $length = null, $remove = null)
    {
    }

    /**
     * @return mixed
     */
    public function write($offset, $data)
    {
    }

    /**
     * @return mixed
     */
    public function read($offset, $length)
    {
    }

    /**
     * @return mixed
     */
    public function append($data)
    {
    }

    /**
     * @return mixed
     */
    public function expand($size)
    {
    }

    /**
     * @return mixed
     */
    public function recycle()
    {
    }

    /**
     * @return mixed
     */
    public function clear()
    {
    }


}
