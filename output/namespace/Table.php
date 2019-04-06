<?php

namespace Swoole;

class Table implements \Iterator, \Traversable, \ArrayAccess, \Countable
{

    const TYPE_INT = 1;

    const TYPE_STRING = 7;

    const TYPE_FLOAT = 6;

    public function __construct($table_size, $conflict_proportion = null)
    {
    }

    public function column($name, $type, $size = null)
    {
    }

    public function create()
    {
    }

    public function destroy()
    {
    }

    public function set($key, array $value)
    {
    }

    public function get($key, $field = null)
    {
    }

    public function count()
    {
    }

    public function del($key)
    {
    }

    public function exists($key)
    {
    }

    public function exist($key)
    {
    }

    public function incr($key, $column, $incrby = null)
    {
    }

    public function decr($key, $column, $decrby = null)
    {
    }

    public function getMemorySize()
    {
    }

    public function offsetExists($offset)
    {
    }

    public function offsetGet($offset)
    {
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }

    public function rewind()
    {
    }

    public function next()
    {
    }

    public function current()
    {
    }

    public function key()
    {
    }

    public function valid()
    {
    }


}
