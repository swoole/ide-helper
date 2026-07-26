<?php

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * Class \Swoole\Thread\ArrayList.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @since 6.0.0
 */
final class ArrayList implements \ArrayAccess, \Countable
{
    /**
     * Although Swoole declares this property (as a read-only property), as of Swoole 6.2.2 it is never assigned
     * anywhere in the Swoole source code, so it always holds its default value of 0.
     *
     * @readonly
     */
    public int $id = 0;

    /**
     * Constructor. It can only be called once per object; calling it a second time throws an \Error.
     *
     * @param array|null $array Optional initial values of the list. It must be a "list"-style array (with
     *                          consecutive integer keys starting from 0), otherwise an \Error is thrown.
     */
    public function __construct(?array $array = null)
    {
    }

    /**
     * Get the element stored at the given index, i.e., what reading `$list[$key]` returns.
     *
     * @param mixed $key Index of the element. It must be an integer (or a value convertible to one).
     * @return mixed The element stored at the given index.
     * @throws \Swoole\Exception When the index is out of range.
     * @see \ArrayAccess::offsetGet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * {@inheritDoc}
     */
    public function offsetGet(mixed $key): mixed
    {
    }

    /**
     * Check if the given index exists in the list, i.e., what `isset($list[$key])` returns.
     *
     * @param mixed $key Index to check for. It must be an integer (or a value convertible to one).
     * @return bool TRUE if the index exists (i.e., it's between 0 and the size of the list minus one); otherwise
     *              FALSE.
     * @see \ArrayAccess::offsetExists()
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * {@inheritDoc}
     */
    public function offsetExists(mixed $key): bool
    {
    }

    /**
     * Store an element at the given index, i.e., what writing `$list[$key] = $value` (or `$list[] = $value`) does.
     *
     * @param mixed $key Index to store the element at. It must be an integer (or a value convertible to one) between
     *                   0 and the current size of the list; when it equals the size of the list (or NULL is given,
     *                   as in `$list[] = $value`), the element is appended to the end of the list.
     * @param mixed $value The element to store.
     * @throws \Swoole\Exception When the index is out of range (greater than the current size of the list).
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
    }

    /**
     * Remove the element at the given index, i.e., what `unset($list[$key])` does. The elements after it are shifted
     * down by one position, so the list stays a gapless, consecutively-indexed list.
     *
     * @param mixed $key Index of the element to remove. It must be an integer (or a value convertible to one).
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $key): void
    {
    }

    /**
     * Find the first element equal to the given value.
     *
     * @param mixed $value The value to search for.
     * @return int Index of the first matching element. Despite the declared return type, NULL is returned when no
     *             element matches.
     */
    public function find(mixed $value): int
    {
    }

    /**
     * Atomically increase the numeric value stored at the given index.
     *
     * When the index equals the current size of the list (or NULL is given as the index), a new element is appended
     * to the list with $value as its initial value.
     *
     * @param mixed $key Index of the element to update.
     * @param mixed $value The amount to add. The default value is 1.
     * @return mixed The new value of the element (an integer, or a float when the stored value is a float).
     * @throws \Swoole\Exception When the index is out of range.
     */
    public function incr(mixed $key, mixed $value = 1): mixed
    {
    }

    /**
     * Atomically decrease the numeric value stored at the given index.
     *
     * When the index equals the current size of the list (or NULL is given as the index), a new element is appended
     * to the list with the negated amount (-$value) as its initial value.
     *
     * @param mixed $key Index of the element to update.
     * @param mixed $value The amount to subtract. The default value is 1.
     * @return mixed The new value of the element (an integer, or a float when the stored value is a float).
     * @throws \Swoole\Exception When the index is out of range.
     */
    public function decr(mixed $key, mixed $value = 1): mixed
    {
    }

    /**
     * Remove all elements from the list.
     */
    public function clean(): void
    {
    }

    /**
     * Get the number of elements in the list, i.e., what `count($list)` returns.
     *
     * @return int Number of elements in the list.
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    /**
     * Get all elements of the list as a plain (non-shared) PHP array.
     *
     * @return array All elements of the list.
     */
    public function toArray(): array
    {
    }

    /**
     * Sort the list in ascending order, without maintaining index association.
     *
     * @since 6.0.1
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function sort(): void
    {
        $array = $this->toArray();
        sort($array);
        $this->__construct($array);
    }
}
