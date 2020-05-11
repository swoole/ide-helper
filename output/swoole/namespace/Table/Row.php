<?php

namespace Swoole\Table;

class Row implements \ArrayAccess
{

    public $key;

    public $value;

    /**
     * @return mixed
     */
    public function offsetExists($offset)
    {
    }

    /**
     * @return mixed
     */
    public function offsetGet($offset)
    {
    }

    /**
     * @return mixed
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * @return mixed
     */
    public function offsetUnset($offset)
    {
    }

    public function __destruct()
    {
    }


}
