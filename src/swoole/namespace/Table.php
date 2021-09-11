<?php

declare(strict_types=1);

namespace Swoole;

class Table implements \Iterator, \ArrayAccess, \Countable
{
    public const TYPE_INT = 1;

    public const TYPE_STRING = 3;

    public const TYPE_FLOAT = 2;

    public $size;

    public $memorySize;

    public function __construct($table_size, $conflict_proportion = null)
    {
    }

    /**
     * @param mixed $name
     * @param mixed $type
     * @param mixed|null $size
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
     * @param mixed $key
     * @return mixed
     */
    public function set($key, array $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $field
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
     * @param mixed $key
     * @return mixed
     */
    public function del($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function delete($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function exists($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function exist($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $column
     * @param mixed|null $incrby
     * @return mixed
     */
    public function incr($key, $column, $incrby = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $column
     * @param mixed|null $decrby
     * @return mixed
     */
    public function decr($key, $column, $decrby = null)
    {
    }

    /**
     * @return mixed
     */
    public function getSize()
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
    public function rewind()
    {
    }

    /**
     * @return mixed
     */
    public function valid()
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
     * Whether or not an offset exists.
     *
     * @param mixed $offset an offset to check for
     * @return bool returns true on success or false on failure
     *              {@inheritDoc}
     * @see \ArrayAccess
     * @see https://www.php.net/manual/en/class.arrayaccess.php
     */
    public function offsetExists($offset)
    {
    }

    /**
     * Returns the value at specified offset.
     *
     * @param mixed $offset the offset to retrieve
     * @return mixed can return all value types
     *               {@inheritDoc}
     * @see \ArrayAccess
     * @see https://www.php.net/manual/en/class.arrayaccess.php
     */
    public function offsetGet($offset)
    {
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param mixed $offset the offset to assign the value to
     * @param mixed $value the value to set
     *                     {@inheritDoc}
     * @see \ArrayAccess
     * @see https://www.php.net/manual/en/class.arrayaccess.php
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * Unsets an offset.
     *
     * @param mixed $offset the offset to unset
     *                      {@inheritDoc}
     * @see \ArrayAccess
     * @see https://www.php.net/manual/en/class.arrayaccess.php
     */
    public function offsetUnset($offset)
    {
    }
}
