<?php

namespace Swoole;

class Table implements \Iterator, \ArrayAccess
{

    public const TYPE_INT = 1;

    public const TYPE_STRING = 3;

    public const TYPE_FLOAT = 2;

    public function __construct($table_size, $conflict_proportion = null)
    {
    }

    /**
     * @return mixed
     */
    public function column($name, $type, $size = null)
    {
    }

    /**
     * @return mixed
     */
    public function create()
    {
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
    }

    /**
     * @return mixed
     */
    public function set($key, array $value)
    {
    }

    /**
     * @return mixed
     */
    public function get($key, $field = null)
    {
    }

    /**
     * @return mixed
     */
    public function count()
    {
    }

    /**
     * @return mixed
     */
    public function del($key)
    {
    }

    /**
     * @return mixed
     */
    public function exists($key)
    {
    }

    /**
     * @return mixed
     */
    public function exist($key)
    {
    }

    /**
     * @return mixed
     */
    public function incr($key, $column, $incrby = null)
    {
    }

    /**
     * @return mixed
     */
    public function decr($key, $column, $decrby = null)
    {
    }

    /**
     * @return mixed
     */
    public function getMemorySize()
    {
    }

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

    /**
     * @return mixed
     */
    public function rewind()
    {
    }

    /**
     * @return mixed
     */
    public function next()
    {
    }

    /**
     * @return mixed
     */
    public function current()
    {
    }

    /**
     * @return mixed
     */
    public function key()
    {
    }

    /**
     * @return mixed
     */
    public function valid()
    {
    }


}
