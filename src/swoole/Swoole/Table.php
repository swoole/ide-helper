<?php

declare(strict_types=1);

namespace Swoole;

/**
 * History Changes:
 *
 * 1. In Swoole 5.0.0, class \Swoole\Table no longer implements interface \ArrayAccess. Following methods
 *    have been removed from Swoole 5.0.0:
 *    * \Swoole\Table::offsetExists()
 *    * \Swoole\Table::offsetGet()
 *    * \Swoole\Table::offsetSet()
 *    * \Swoole\Table::offsetUnset()
 *
 * @not-serializable Objects of this class cannot be serialized.
 */
class Table implements \Iterator, \Countable
{
    public const TYPE_INT = 1;

    public const TYPE_STRING = 3;

    public const TYPE_FLOAT = 2;

    public int $size;

    public int $memorySize;

    public function __construct(int $table_size, float $conflict_proportion = 0.2)
    {
    }

    public function column(string $name, int $type, int $size = 0): bool
    {
    }

    public function create(): bool
    {
    }

    /**
     * @return bool returns TRUE all the time
     */
    public function destroy(): bool
    {
    }

    public function set(string $key, array $value): bool
    {
    }

    public function get(string $key, ?string $field = null): mixed
    {
    }

    /**
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Table::delete().
     * @see \Swoole\Table::delete()
     */
    public function del(string $key): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Table::del().
     * @see \Swoole\Table::del()
     */
    public function delete(string $key): bool
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Table::exist().
     * @see \Swoole\Table::exist()
     */
    public function exists(string $key): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Table::exists().
     * @see \Swoole\Table::exists()
     */
    public function exist(string $key): bool
    {
    }

    public function incr(string $key, string $column, int|float $incrby = 1): int|float
    {
    }

    public function decr(string $key, string $column, int|float $incrby = 1): int|float
    {
    }

    public function getSize(): int
    {
    }

    public function getMemorySize(): int
    {
    }

    /**
     * @return array|false Return an array of stats information; Return FALSE when error happens.
     * @since 4.8.0
     */
    public function stats(): array|false
    {
    }

    /**
     * @see \Iterator::rewind()
     * @see https://www.php.net/manual/en/iterator.rewind.php
     * {@inheritDoc}
     */
    public function rewind(): void
    {
    }

    /**
     * @see \Iterator::valid()
     * @see https://www.php.net/manual/en/iterator.valid.php
     * {@inheritDoc}
     */
    public function valid(): bool
    {
    }

    /**
     * @see \Iterator::next()
     * @see https://www.php.net/manual/en/iterator.next.php
     * {@inheritDoc}
     */
    public function next(): void
    {
    }

    /**
     * @see \Iterator::current()
     * @see https://www.php.net/manual/en/iterator.current.php
     * {@inheritDoc}
     */
    public function current(): mixed
    {
    }

    /**
     * @see \Iterator::key()
     * @see https://www.php.net/manual/en/iterator.key.php
     * {@inheritDoc}
     */
    public function key(): mixed
    {
    }
}
