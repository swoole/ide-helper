<?php

declare(strict_types=1);

namespace Swoole\Connection;

/**
 * This class represents a list of established connections of a server, or of one single port of a server.
 *
 * Objects of this class are created by Swoole internally, and are accessible through properties
 * \Swoole\Server::$connections and \Swoole\Server\Port::$connections. Creating an object of this class directly is not
 * allowed; the constructor always throws an \Error.
 *
 * Only established connections are iterated over. Connections that are not active yet, that have been closed, or whose
 * SSL handshake hasn't been completed yet, are skipped.
 *
 * @see \Swoole\Server::$connections
 * @see \Swoole\Server\Port::$connections
 * @not-serializable Objects of this class cannot be serialized.
 * @implements \Iterator<int, int>
 * @implements \ArrayAccess<int, array<string, mixed>|false>
 */
class Iterator implements \Iterator, \ArrayAccess, \Countable
{
    /**
     * Creating an object of this class directly is not allowed. It will always throw an error.
     *
     * @throws \Error
     */
    public function __construct()
    {
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly; it does nothing. The resources held by the object are released
     * internally when the object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Restart the iteration from the beginning of the server's connection list.
     *
     * This method only resets the internal position; the actual search for the first established connection is
     * performed by the following \Swoole\Connection\Iterator::valid() call (a foreach loop calls the two in that
     * order automatically).
     *
     * @see \Swoole\Connection\Iterator::valid()
     * @see \Iterator::rewind()
     * @see https://www.php.net/manual/en/iterator.rewind.php
     * {@inheritDoc}
     */
    public function rewind(): void
    {
    }

    /**
     * Move the iteration on to the next connection.
     *
     * This method only advances the internal position; the actual search for the next established connection is
     * performed by the following \Swoole\Connection\Iterator::valid() call (a foreach loop calls the two in that
     * order automatically).
     *
     * @see \Swoole\Connection\Iterator::valid()
     * @see \Iterator::next()
     * @see https://www.php.net/manual/en/iterator.next.php
     * {@inheritDoc}
     */
    public function next(): void
    {
    }

    /**
     * Get the session ID of the connection that the iterator currently points to.
     *
     * The session ID is the same value that Swoole passes to event callback functions as parameter $fd, and the one
     * accepted by methods like \Swoole\Server::send() and \Swoole\Server::getClientInfo().
     *
     * Swoole itself declares the return type as mixed (that's what reflection reports), but the method always returns
     * an integer, so the stub declares it as int.
     *
     * @return int Session ID of the current connection.
     * @see \Iterator::current()
     * @see https://www.php.net/manual/en/iterator.current.php
     * {@inheritDoc}
     */
    public function current(): int
    {
    }

    /**
     * Get the sequence number of the connection that the iterator currently points to.
     *
     * The sequence number is not the session ID, but a counter reset when the iteration starts and increased by one
     * for each connection found. Therefore, the first connection of an iteration has key 1, the second one has key 2,
     * and so on. To get the session ID, use method \Swoole\Connection\Iterator::current().
     *
     * Swoole itself declares the return type as mixed (that's what reflection reports), but the method always returns
     * an integer, so the stub declares it as int.
     *
     * @return int Sequence number of the current connection, starting from 1.
     * @see \Swoole\Connection\Iterator::current()
     * @see \Iterator::key()
     * @see https://www.php.net/manual/en/iterator.key.php
     * {@inheritDoc}
     */
    public function key(): int
    {
    }

    /**
     * Check if the iteration has more connections to visit, i.e., whether an established connection can be found at
     * or after the current position.
     *
     * This is the method that does the actual scanning: starting from the current position, it skips over
     * connections that are not fully established (and, when the object was accessed through property
     * \Swoole\Server\Port::$connections, connections belonging to other ports of the server), and positions the
     * iterator on the first established connection found.
     *
     * @return bool TRUE if an established connection was found; FALSE once the iteration has moved past the last
     *              one.
     * @see \Iterator::valid()
     * @see https://www.php.net/manual/en/iterator.valid.php
     * {@inheritDoc}
     */
    public function valid(): bool
    {
    }

    /**
     * Get the number of established connections.
     *
     * The counter is at server level when the object is accessed through property \Swoole\Server::$connections, and at
     * port level when accessed through property \Swoole\Server\Port::$connections.
     *
     * @return int Number of established connections.
     * @see \Countable::count()
     * @see https://www.php.net/manual/en/countable.count.php
     * {@inheritDoc}
     */
    public function count(): int
    {
    }

    /**
     * Check if a connection exists.
     *
     * This method is implemented by calling method \Swoole\Server::exists(). Therefore, it always checks against the
     * whole server, even when the object is accessed through property \Swoole\Server\Port::$connections.
     *
     * Note: this stub used to declare the signature without a native parameter type, as "offsetExists($fd): bool"; it
     * now declares "offsetExists(mixed $fd): bool", matching what the Swoole extension itself declares.
     *
     * @param mixed $fd Session ID of the connection to check for.
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been closed.
     * @see \Swoole\Server::exists()
     * @see \ArrayAccess::offsetExists()
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * {@inheritDoc}
     */
    public function offsetExists(mixed $fd): bool
    {
    }

    /**
     * Get information of a connection.
     *
     * This method is implemented by calling method \Swoole\Server::getClientInfo(). Therefore, it always looks up the
     * whole server, even when the object is accessed through property \Swoole\Server\Port::$connections.
     *
     * Note: this stub used to declare the signature without any native types, as "offsetGet($fd)"; it now declares
     * "offsetGet(mixed $fd): mixed", matching what the Swoole extension itself declares (and what interface
     * \ArrayAccess requires).
     *
     * @param mixed $fd Session ID of the connection.
     * @return array|false Returns an array of connection information, or false on failure. For the list of keys
     *                     included in the array, please check method \Swoole\Server::getClientInfo().
     * @see \Swoole\Server::getClientInfo()
     * @see \ArrayAccess::offsetGet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * {@inheritDoc}
     */
    public function offsetGet(mixed $fd): mixed
    {
    }

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * Note: this stub used to declare the signature without native parameter types, as
     * "offsetSet($fd, $value): void"; it now declares "offsetSet(mixed $fd, mixed $value): void", matching what the
     * Swoole extension itself declares.
     *
     * @param mixed $fd Session ID of the connection. It is ignored by this method.
     * @param mixed $value The value to set. It is ignored by this method.
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet(mixed $fd, mixed $value): void
    {
    }

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * Note: this stub used to declare the signature without a native parameter type, as "offsetUnset($fd): void"; it
     * now declares "offsetUnset(mixed $fd): void", matching what the Swoole extension itself declares.
     *
     * @param mixed $fd Session ID of the connection. It is ignored by this method.
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset(mixed $fd): void
    {
    }
}
