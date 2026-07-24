<?php

declare(strict_types=1);

namespace Swoole;

/**
 * Swoole Table is a fixed-size hash table (a key-value store) stored in shared memory.
 *   - Rows are stored in shared memory (allocated through mmap() when method \Swoole\Table::create() is called), thus
 *     a table is shared between the process creating it and all the child processes forked afterwards.
 *   - Memory used by a table is not limited by the PHP ini setting "memory_limit".
 *   - Every row has a spin lock in its header, but only the lock of the row sitting in a main slot is ever used: it
 *     guards that slot together with all the rows chained to it in its hash conflict list. Methods
 *     \Swoole\Table::set(), \Swoole\Table::get(), \Swoole\Table::del(), \Swoole\Table::delete(),
 *     \Swoole\Table::exists(), \Swoole\Table::exist(), \Swoole\Table::incr(), and \Swoole\Table::decr(), as well as
 *     the traversal methods \Swoole\Table::rewind() and \Swoole\Table::next(), take that lock automatically. i.e.,
 *     the table is not lock-free, but locking is fine-grained and handled internally, thus no manual locking is
 *     needed. Method \Swoole\Table::count() doesn't take it: it reads the atomic row counter directly. Methods
 *     \Swoole\Table::current(), \Swoole\Table::key(), and \Swoole\Table::valid() don't take it either: they read
 *     from the private copy of the row that \Swoole\Table::rewind() / \Swoole\Table::next() made.
 *   - Rows can be traversed using foreach (interface \Iterator), and counted using function \count() (interface
 *     \Countable).
 *   - Objects of this class can't be passed to a thread (\Swoole\Thread). A value passed to a thread is either one of
 *     the types Swoole transfers natively (scalars, arrays, sockets, and the \Swoole\Thread\* resource objects) or an
 *     object that gets serialized, and objects of this class are not serializable. To share data between threads, use
 *     \Swoole\Thread\Map, \Swoole\Thread\ArrayList, or \Swoole\Thread\Queue instead.
 *
 * Notes:
 *    - Don't delete rows while traversing a table. Deleting the row held in a main slot that has a hash conflict list
 *      moves the first row of that list into the main slot and frees the memory the moved row used to occupy, which
 *      in turn makes the traversal skip rows or return outdated data.
 *
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
 * @template TRow
 * @implements \Iterator<string, TRow>
 */
class Table implements \Iterator, \Countable
{
    /**
     * Column type for storing integers.
     *
     * @see \Swoole\Table::column()
     */
    public const TYPE_INT = 1;

    /**
     * Column type for storing floating-point numbers.
     *
     * @see \Swoole\Table::column()
     */
    public const TYPE_FLOAT = 2;

    /**
     * Column type for storing strings.
     *
     * @see \Swoole\Table::column()
     */
    public const TYPE_STRING = 3;

    /**
     * Maximum number of rows in the table.
     *
     * This property is NULL when the object is created; it is initialized when the table is created,
     * i.e., when method Table::create() is called successfully. Once initialized, this property never changes, even
     * after the table is destroyed (via method \Swoole\Table::destroy()).
     *
     * This property doesn't always contain the same value as the return value of method \Swoole\Table::getSize().
     * The two values are of the same only after the table is created but before it's destroyed. i.e., the two values
     * are of the same only between the calls of method \Swoole\Table::create() and method \Swoole\Table::destroy().
     *
     * @readonly
     * @see \Swoole\Table::create()
     * @see \Swoole\Table::getSize()
     */
    public ?int $size = null;

    /**
     * Memory allocated (in bytes) for the table.
     *
     * This property is NULL when the object is created; it is initialized when the table is created,
     * i.e., when method Table::create() is called successfully. Once initialized, this property never changes, even
     * after the table is destroyed (via method \Swoole\Table::destroy()).
     *
     * This property doesn't always contain the same value as the return value of method \Swoole\Table::getMemorySize().
     * The two values are of the same only after the table is created but before it's destroyed. i.e., the two values
     * are of the same only between the calls of method \Swoole\Table::create() and method \Swoole\Table::destroy().
     *
     * @readonly
     * @see \Swoole\Table::create()
     * @see \Swoole\Table::getMemorySize()
     */
    public ?int $memorySize = null;

    /**
     * A table is built on top of shared memory and can't be resized once created, thus its capacity has to be
     * determined before the table is created.
     *
     * Capacity:
     *   - Parameter $table_size is truncated to an unsigned 32-bit integer and then rounded up to the nearest power
     *     of 2 (e.g., 1000 is rounded up to 1024). The minimum value is 64, and the maximum value is 2147483648
     *     (2^31).
     *   - Besides the $table_size main slots, ($table_size * $conflict_proportion) extra slots are reserved to hold
     *     rows whose keys are hashed to occupied slots. Once these extra slots are used up, method
     *     \Swoole\Table::set() fails with warning "failed to set('...'), unable to allocate memory" and returns FALSE
     *     (methods \Swoole\Table::incr() and \Swoole\Table::decr() fail with warning "unable to allocate memory" in
     *     the same situation). When that happens, the table has to be recreated with a larger $table_size and/or a
     *     larger $conflict_proportion.
     *   - Because keys are not distributed evenly over the main slots, the extra slots start being consumed long
     *     before all the main slots are taken; with the default $conflict_proportion, a table normally can't hold as
     *     many as $table_size rows.
     *
     * Memory usage: the amount of shared memory allocated for a table (in bytes) is
     *
     *     rows     = $table_size * (1 + $conflict_proportion)
     *     row_size = size of the row header + total size of all the columns
     *                // the row header holds a spin lock, the PID of the process holding the lock, an "active" flag,
     *                // the key length, a pointer to the next row in the conflict list, and a fixed 64-byte key
     *                // buffer; see method \Swoole\Table::column() for how a column contributes to its total size
     *     memory   = rows * row_size                          // the rows themselves
     *                + $table_size * (size of a pointer)      // index of the main slots
     *                + size of the memory pool header + (rows - $table_size) * (size of a memory pool slice header)
     *
     * @param int $table_size Maximum number of rows in the table. The value is rounded up to the nearest power of 2,
     *                        with 64 as the minimum and 2147483648 as the maximum.
     * @param float $conflict_proportion Proportion of extra rows reserved for hash conflicts. Values smaller than 0.2
     *                                   are treated as 0.2, and values greater than 1.0 are treated as 1.0.
     * @throws \Error When the constructor is called more than once on the same object.
     * @throws \Swoole\Exception When failed to allocate memory for the table object.
     */
    public function __construct(int $table_size, float $conflict_proportion = 0.2)
    {
    }

    /**
     * Add a column in the table.
     *
     * This method must be called before method \Swoole\Table::create() is called; otherwise, a warning "unable to add
     * column after table has been created" is triggered and FALSE is returned.
     *
     * @param string $name Column name.
     * @param int $type Must be one of the following constants: Table::TYPE_INT, Table::TYPE_FLOAT, or
     *                  Table::TYPE_STRING; any other value triggers a warning "unknown column type" and FALSE is
     *                  returned. A column of type Table::TYPE_INT takes sizeof(long) bytes in a row (8 bytes on the
     *                  64-bit platforms Swoole targets, 4 bytes on 32-bit ones), and a column of type
     *                  Table::TYPE_FLOAT takes sizeof(double) bytes, i.e., 8 bytes.
     * @param int $size Maximum length of the string (in bytes).
     *                  - This parameter is ignored for other types.
     *                  - When specified for string types, it must be greater than 0; otherwise, a warning "the length
     *                  of string type values has to be more than zero" is triggered and FALSE is returned.
     *                  - The value is rounded up to a multiple of the size of an unsigned long (8 bytes on 64-bit
     *                  platforms), e.g., a column defined with a size of 5 can hold strings of up to 8 bytes.
     *                  - A string column takes the rounded up size plus 4 bytes in a row, the extra 4 bytes being
     *                  used to store the length of the string.
     * @return bool Returns TRUE on success, or FALSE on failure.
     * @see \Swoole\Table::create()
     */
    public function column(string $name, int $type, int $size = 0): bool
    {
    }

    /**
     * Allocate memory for the table and create it.
     *
     * A fatal run-time error "unable to allocate memory" will be triggered if failed to allocate memory for the
     * table, or if the table has been created already.
     *
     * After the table is created, memory usage can be retrieved via property \Swoole\Table::$memorySize.
     *
     * Notes on the order of the method calls:
     *   - Data access methods (\Swoole\Table::set(), \Swoole\Table::get(), \Swoole\Table::del(), etc.) can't be used
     *     before the table is created; using them triggers a fatal run-time error "table is not created or has been
     *     destroyed".
     *   - No column can be added (via method \Swoole\Table::column()) once the table is created.
     *   - A table is stored in the shared memory allocated by this method, thus this method must be called before any
     *     child process is forked; otherwise, the child processes access their own copies of the table instead of a
     *     shared one. When a table is used in a server, this method must be called before method
     *     \Swoole\Server::start() is called.
     *
     * @return bool Returns TRUE on success.
     * @see \Swoole\Table::column()
     * @see \Swoole\Table::$memorySize
     * @see \swoole_table() A helper method to easily initialize and create \Swoole\Table objects.
     */
    public function create(): bool
    {
    }

    /**
     * Destroy the table.
     *
     * It will free all memory allocated for the table, although the Table object itself still exists. After calling
     * this method, the Table object should not be used anymore.
     *
     * After the table is destroyed,
     *   - property $size and $memorySize still contain the same values of the table before it's destroyed (this
     *     method frees the shared memory and detaches the underlying table from the object, but it doesn't touch the
     *     two properties).
     *   - method \Swoole\Table::getSize() and \Swoole\Table::getMemorySize() return 0, method
     *     \Swoole\Table::count() returns 0, and method \Swoole\Table::stats() returns FALSE, since all of them fall
     *     back to these values once no table is attached to the object anymore.
     *
     * Calling this method on a table that hasn't been created yet triggers a fatal run-time error "table is not
     * created or has been destroyed". Calling it again on a destroyed table throws a \Swoole\Error with message
     * "must call constructor first", which is printed as a fatal error and terminates the process (i.e., it can't be
     * caught).
     *
     * @return bool returns TRUE all the time
     */
    public function destroy(): bool
    {
    }

    /**
     * Add a new row to the table, or update an existing one.
     *
     *   - Rows are identified by their keys: setting an existing key updates the row instead of adding a new one.
     *   - When a new row is added, columns missing from $value (or having a NULL value in it) are initialized to 0
     *     for numeric columns, and to an empty string for string columns. When an existing row is updated, only the
     *     columns present in $value are updated; elements of $value not matching any column name are ignored.
     *   - The maximum length of a key is 63 bytes. When a longer key is given, a warning "key[...] is too long" is
     *     triggered and only the first 63 bytes of the key are used.
     *   - A string value longer than the size of its column is truncated, and a warning "string value is too long" is
     *     triggered. Note that column sizes are rounded up to a multiple of 8 bytes: given a column defined as
     *     $table->column('str_value', Table::TYPE_STRING, 5), setting the value 'world 123456789' on it stores
     *     'world 12' (8 bytes), not 'world' (5 bytes).
     *   - This method returns FALSE with a warning "failed to set('...'), unable to allocate memory" when a new row
     *     has to be appended to a hash conflict list but the memory reserved for hash conflicts is used up (see the
     *     $conflict_proportion parameter of the constructor).
     *
     * Row level locking is in effect automatically when using this method, thus there is no need to use locks manually.
     * Same for method \Swoole\Table::get() and \Swoole\Table::del().
     *
     * @param string $key The key of the row. If the key already exists, the existing row will be updated.
     * @param array $value The value of the row. The keys of the array must be the same as the column names.
     * @return bool TRUE on success, FALSE on failure.
     * @see \Swoole\Table::__construct()
     */
    public function set(string $key, array $value): bool
    {
    }

    /**
     * Get a row from the table, or a single column of a row.
     *
     * Row level locking is in effect automatically when using this method, thus there is no need to use locks here
     * manually. Same for method \Swoole\Table::set() and \Swoole\Table::del().
     *
     * @param string $key The key of the row. Only the first 63 bytes of the key are used.
     * @param string|null $field The name of the column.
     * @return array|string|float|int|false The return value could be one of the following:
     *                                      - boolean false if the key doesn't exist, or if $field is given but
     *                                      doesn't match any column.
     *                                      - the value of the column (a string, float, or integer, depending on the
     *                                      type of the column) if $field is specified.
     *                                      - an array of all columns if $field is not specified.
     */
    public function get(string $key, ?string $field = null): array|string|float|int|false
    {
    }

    /**
     * Count the number of rows in the table.
     *
     * Although not part of the declared signature, the underlying implementation also accepts an optional mode
     * argument (e.g., $table->count(COUNT_RECURSIVE)): when constant COUNT_NORMAL (0, the default) is passed, the
     * number of rows is returned; any other value (e.g., constant COUNT_RECURSIVE) makes the method return the
     * number of rows multiplied by the number of columns, mimicking how PHP function \count() treats
     * two-dimensional arrays. Note that PHP function \count() always calls this method without arguments, i.e.,
     * \count($table, COUNT_RECURSIVE) still returns the number of rows only.
     *
     * @return int Number of rows currently stored in the table. If the table hasn't been created yet or has been
     *             destroyed, 0 is returned.
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    /**
     * Delete a row from the table.
     *
     * Row level locking is in effect automatically when using this method, thus there is no need to use locks here
     * manually. Same for method \Swoole\Table::set() and \Swoole\Table::get().
     *
     * Don't call this method while traversing the table: deleting the row held in a main slot that has a hash conflict
     * list moves the first row of that list into the main slot and frees the memory the moved row used to occupy,
     * which in turn makes the traversal skip rows or return outdated data.
     *
     * @param string $key The key of the row. Only the first 63 bytes of the key are used.
     * @return bool Returns TRUE on success, FALSE if the key doesn't exist.
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
     * Check if a row exists or not in the table.
     *
     * @param string $key The key of the row. Only the first 63 bytes of the key are used.
     * @return bool TRUE if the row exists, FALSE otherwise.
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

    /**
     * Atomically increment a row's column value.
     *
     * If the row doesn't exist yet, it is created first with all its columns initialized to 0 (or to an empty string
     * for string columns), thus the column is incremented from 0. Note that the row is created before the column
     * given is looked up, thus it stays in the table even when this method fails afterwards; when the failure is
     * caused by a column that doesn't exist, the columns of that new row are left holding whatever its memory
     * happened to contain, since they are initialized only after the column has been found.
     *
     * This method also fails with warning "unable to allocate memory" and returns FALSE when a new row has to be
     * created but the memory reserved for hash conflicts is used up (see the $conflict_proportion parameter of the
     * constructor).
     *
     * Row level locking is in effect automatically when using this method, thus there is no need to use locks here
     * manually. Same for method \Swoole\Table::decr().
     *
     * @param string $key The key of the row. Only the first 63 bytes of the key are used.
     * @param string $column Column name. The column must exist and must be of type Table::TYPE_INT or
     *                       Table::TYPE_FLOAT; otherwise, a warning ("column[...] does not exist" or "can't execute
     *                       'incr' on a string type column") is triggered, no column value is incremented, and FALSE
     *                       is returned.
     * @param int|float $incrby The value to increment by. It's cast to an integer for columns of type Table::TYPE_INT,
     *                          and to a float for columns of type Table::TYPE_FLOAT.
     * @return int|float The new value of the column. On failure, FALSE is returned at run time although the return
     *                   type declared for this method is int|float. The type declared here matches the one the
     *                   extension itself declares, i.e., the mismatch is in Swoole, not in this stub.
     * @see \Swoole\Table::decr()
     */
    public function incr(string $key, string $column, int|float $incrby = 1): int|float
    {
    }

    /**
     * Atomically decrement a row's column value.
     *
     * If the row doesn't exist yet, it is created first with all its columns initialized to 0 (or to an empty string
     * for string columns), thus the column is decremented from 0. Note that the row is created before the column
     * given is looked up, thus it stays in the table even when this method fails afterwards; when the failure is
     * caused by a column that doesn't exist, the columns of that new row are left holding whatever its memory
     * happened to contain, since they are initialized only after the column has been found. There is no lower
     * bound: the new value simply goes negative when the decrement is greater than the current value, for both
     * Table::TYPE_INT and Table::TYPE_FLOAT columns.
     *
     * This method also fails with warning "unable to allocate memory" and returns FALSE when a new row has to be
     * created but the memory reserved for hash conflicts is used up (see the $conflict_proportion parameter of the
     * constructor).
     *
     * Row level locking is in effect automatically when using this method, thus there is no need to use locks here
     * manually. Same for method \Swoole\Table::incr().
     *
     * @param string $key The key of the row. Only the first 63 bytes of the key are used.
     * @param string $column Column name. The column must exist and must be of type Table::TYPE_INT or
     *                       Table::TYPE_FLOAT; otherwise, a warning ("column[...] does not exist" or "can't execute
     *                       'decr' on a string type column") is triggered, no column value is decremented, and FALSE
     *                       is returned.
     * @param int|float $incrby The value to decrement by. It's cast to an integer for columns of type Table::TYPE_INT,
     *                          and to a float for columns of type Table::TYPE_FLOAT.
     * @return int|float The new value of the column. On failure, FALSE is returned at run time although the return
     *                   type declared for this method is int|float. The type declared here matches the one the
     *                   extension itself declares, i.e., the mismatch is in Swoole, not in this stub.
     * @see \Swoole\Table::incr()
     */
    public function decr(string $key, string $column, int|float $incrby = 1): int|float
    {
    }

    /**
     * Get maximum number of rows in the table.
     *
     * This method doesn't always return the same value as property \Swoole\Table::$size. The two values are of
     * the same only after the table is created but before it's destroyed. i.e., the two values are of the same only
     * between the calls of method \Swoole\Table::create() and method \Swoole\Table::destroy().
     *
     * @return int Returns maximum number of rows in the table. If the table has been destroyed, returns 0.
     * @see \Swoole\Table::$size
     */
    public function getSize(): int
    {
    }

    /**
     * Get memory allocated (in bytes) for the table. If the table hasn't been created yet (by calling method
     * Table::create()) of if the table has been destroyed (by calling method Table::destroy()), this method
     * will return 0.
     *
     * This method doesn't always return the same value as property \Swoole\Table::$memorySize. The two values are of
     * the same only after the table is created but before it's destroyed. i.e., the two values are of the same only
     * between the calls of method \Swoole\Table::create() and method \Swoole\Table::destroy().
     *
     * Note: the value returned doesn't cover the whole memory block allocated for the table. It covers only the part
     * of the block reserved for rows in hash conflict lists, i.e., the total memory allocated minus the memory taken
     * by the main slots and by the index of the main slots.
     *
     * @return int Returns memory allocated (in bytes) for the table. If the table hasn't been created or has been destroyed, returns 0.
     * @see \Swoole\Table::$memorySize
     */
    public function getMemorySize(): int
    {
    }

    /**
     * Get statistics of the table.
     *
     * The stats array contains the following eight keys:
     *   - num: number of rows currently stored in the table (the same value as returned by method
     *     \Swoole\Table::count()).
     *   - conflict_count: number of times a new row had to be appended to a conflict list because its key was hashed
     *     to an occupied slot.
     *   - conflict_max_level: high water mark of the hash conflict depth, i.e., the highest number of rows ever
     *     chained after a main slot. The value is only ever raised while rows are inserted; deleting rows doesn't
     *     lower it.
     *   - insert_count: number of rows inserted since the object was constructed (rows created implicitly by methods
     *     \Swoole\Table::incr() and \Swoole\Table::decr() are included). The counter is never decremented, thus it
     *     also counts rows that have been deleted since.
     *   - update_count: number of times an existing row has been written to by methods \Swoole\Table::set(),
     *     \Swoole\Table::incr(), and \Swoole\Table::decr().
     *   - delete_count: number of rows deleted since the object was constructed.
     *   - available_slice_num: number of slices still available in the memory pool holding the rows of the conflict
     *     lists.
     *   - total_slice_num: total number of slices in the memory pool holding the rows of the conflict lists.
     *
     * This method reads the two slice counters from the memory pool that method \Swoole\Table::create() sets up,
     * thus it must not be called before the table is created: doing so dereferences a memory pool that doesn't exist
     * yet and crashes the process.
     *
     * @return array|false Return an array of stats information; Return FALSE if the table has been destroyed (via
     *                     method \Swoole\Table::destroy()).
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
     * @return TRow
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
