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
     * @see \Iterator::rewind()
     * @see https://www.php.net/manual/en/iterator.rewind.php
     * {@inheritDoc}
     */
    public function rewind(): void
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
     * Get the session ID of the connection that the iterator currently points to.
     *
     * The session ID is the same value that Swoole passes to event callback functions as parameter $fd, and the one
     * accepted by methods like \Swoole\Server::send() and \Swoole\Server::getClientInfo().
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
     * @param mixed $fd Session ID of the connection to check for.
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been closed.
     * @see \Swoole\Server::exists()
     * @see \ArrayAccess::offsetExists()
     * @see https://www.php.net/manual/en/arrayaccess.offsetexists.php
     * {@inheritDoc}
     */
    public function offsetExists($fd): bool
    {
    }

    /**
     * Get information of a connection.
     *
     * This method is implemented by calling method \Swoole\Server::getClientInfo(). Therefore, it always looks up the
     * whole server, even when the object is accessed through property \Swoole\Server\Port::$connections.
     *
     * @param mixed $fd Session ID of the connection.
     * @return array|false Returns an array of connection information, or false on failure.
     * @see \Swoole\Server::getClientInfo()
     * @see \ArrayAccess::offsetGet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetget.php
     * {@inheritDoc}
     */
    public function offsetGet($fd)
    {
    }

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * @see \ArrayAccess::offsetSet()
     * @see https://www.php.net/manual/en/arrayaccess.offsetset.php
     * {@inheritDoc}
     */
    public function offsetSet($fd, $value): void
    {
    }

    /**
     * This method doesn't do anything. DON'T use it.
     *
     * @see \ArrayAccess::offsetUnset()
     * @see https://www.php.net/manual/en/arrayaccess.offsetunset.php
     * {@inheritDoc}
     */
    public function offsetUnset($fd): void
    {
    }
}
