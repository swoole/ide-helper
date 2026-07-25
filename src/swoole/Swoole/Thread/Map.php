<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\Map.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @since 6.0.0
 */
final class Map implements \ArrayAccess, \Countable
{
    /**
     * Constructor. It can only be called once per object; calling it a second time throws an \Error.
     *
     * @param array|null $array Optional initial key-value pairs of the map.
     */
    public function __construct(?array $array = null)
    {
    }

    /**
     * Get the value stored under the given key, i.e., what reading `$map[$key]` returns.
     *
     * @param mixed $key Key of the entry (a string or an integer).
     * @return mixed The value stored under the given key, or NULL when the key doesn't exist.
     * @see \ArrayAccess::offsetGet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * {@inheritDoc}
     */
    public function offsetGet(mixed $key): mixed
    {
    }

    /**
     * Check if the given key exists in the map, i.e., what `isset($map[$key])` returns.
     *
     * @param mixed $key Key to check for (a string or an integer).
     * @return bool TRUE if the key exists; otherwise FALSE.
     * @see \ArrayAccess::offsetExists()
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * {@inheritDoc}
     */
    public function offsetExists(mixed $key): bool
    {
    }

    /**
     * Store a value under the given key, i.e., what writing `$map[$key] = $value` does. Any value already stored
     * under the same key is replaced.
     *
     * @param mixed $key Key of the entry (a string or an integer).
     * @param mixed $value The value to store.
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
    }

    /**
     * Remove the entry stored under the given key, i.e., what `unset($map[$key])` does. Nothing happens when the
     * key doesn't exist.
     *
     * @param mixed $key Key of the entry to remove (a string or an integer).
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $key): void
    {
    }

    /**
     * Find the key of the first entry equal to the given value.
     *
     * @param mixed $value The value to search for.
     * @return mixed Key of the first matching entry (a string or an integer), or NULL when no entry matches.
     */
    public function find(mixed $value): mixed
    {
    }

    /**
     * Get the number of entries in the map, i.e., what `count($map)` returns.
     *
     * @return int Number of entries in the map.
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    /**
     * Atomically increase the numeric value stored under the given key.
     *
     * When the key doesn't exist yet, a new entry is created with $value as its initial value.
     *
     * @param mixed $key Key of the entry to update (a string or an integer).
     * @param mixed $value The amount to add. The default value is 1.
     * @return mixed The new value of the entry (an integer, or a float when the stored value is a float).
     */
    public function incr(mixed $key, mixed $value = 1): mixed
    {
    }

    /**
     * Atomically decrease the numeric value stored under the given key.
     *
     * When the key doesn't exist yet, a new entry is created with the negated amount (-$value) as its initial
     * value.
     *
     * @param mixed $key Key of the entry to update (a string or an integer).
     * @param mixed $value The amount to subtract. The default value is 1.
     * @return mixed The new value of the entry (an integer, or a float when the stored value is a float).
     */
    public function decr(mixed $key, mixed $value = 1): mixed
    {
    }

    /**
     * Add a new entry to the map, only if the key doesn't exist yet.
     *
     * @param mixed $key Key of the new entry (a string or an integer).
     * @param mixed $value Value of the new entry.
     * @return bool TRUE if the entry was added; FALSE if the key already exists (the map is left unchanged).
     * @see \Swoole\Thread\Map::update()
     */
    public function add(mixed $key, mixed $value): bool
    {
    }

    /**
     * Update an existing entry of the map, only if the key already exists.
     *
     * @param mixed $key Key of the entry to update (a string or an integer).
     * @param mixed $value The new value of the entry.
     * @return bool TRUE if the entry was updated; FALSE if the key doesn't exist (the map is left unchanged).
     * @see \Swoole\Thread\Map::add()
     */
    public function update(mixed $key, mixed $value): bool
    {
    }

    /**
     * Remove all entries from the map.
     */
    public function clean(): void
    {
    }

    /**
     * Get all keys of the map.
     *
     * @return array All keys of the map, as a list.
     */
    public function keys(): array
    {
    }

    /**
     * Get all values of the map.
     *
     * @return array All values of the map, as a list (without the original keys).
     */
    public function values(): array
    {
    }

    /**
     * Get all entries of the map as a plain (non-shared) PHP array.
     *
     * @return array All key-value pairs of the map.
     */
    public function toArray(): array
    {
    }

    /**
     * Sort the map in ascending order.
     *
     * @since 6.0.1
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function sort(): void
    {
        $array = $this->toArray();
        asort($array);
        $this->__construct($array);
    }
}
