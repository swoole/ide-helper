<?php

declare(strict_types=1);

namespace Swoole\Async;

/**
 * Asynchronous (event-driven) TCP/UDP/Unix-socket client.
 *
 * This class provides a callback-style network client: instead of blocking, methods like connect() register the
 * operation with the event loop and return immediately, and results are delivered later through the event callbacks
 * registered with method on() (e.g., "connect", "receive", "close", "error"). It's the asynchronous counterpart of
 * the synchronous client \Swoole\Client, which it extends. In coroutine-style code, prefer
 * \Swoole\Coroutine\Client instead.
 *
 * Before Swoole 6.0.0, this class was provided by the separate ext-async extension; it has been part of Swoole
 * itself since 6.0.0.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @since 6.0.0
 * @see \Swoole\Client
 * @see \Swoole\Coroutine\Client
 * @see \Swoole\Async\Client::on()
 */
class Client extends \Swoole\Client
{
    /**
     * Callback for the "connect" event, fired when the connection to the server has been established.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onConnect;

    /**
     * Callback for the "error" event, fired when the connection attempt fails.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onError;

    /**
     * Callback for the "receive" event, fired when data is received from the server.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onReceive;

    /**
     * Callback for the "close" event, fired when the connection is closed.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onClose;

    /**
     * Callback for the "bufferFull" event, fired when the send buffer is full.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onBufferFull;

    /**
     * Callback for the "bufferEmpty" event, fired when the send buffer has been drained.
     * NULL until registered through method on().
     *
     * @var callable|null
     * @see \Swoole\Async\Client::on()
     */
    private $onBufferEmpty;

    /**
     * Callback fired when the SSL handshake has completed successfully.
     * Unlike the other callbacks, it's registered through the $onSslReady parameter of method enableSSL(), not
     * through method on(). NULL until enableSSL() is called.
     *
     * @var callable|null
     * @see \Swoole\Async\Client::enableSSL()
     */
    private $onSSLReady;

    /**
     * Create a new asynchronous client object of the given socket type.
     *
     * The constructor only stores the socket type (and makes sure the process has an event loop to register the
     * client with later); the actual socket is not created until method connect() is called. Unlike the parent
     * class's constructor, it takes neither an $async nor an $id parameter.
     *
     * @param int $type Socket type. Please check comments on property \Swoole\Client::$type for more details.
     * @see \Swoole\Async\Client::connect()
     */
    public function __construct(int $type)
    {
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly. If the connection is still open when the object is destroyed, it
     * is closed automatically.
     */
    public function __destruct()
    {
    }

    /**
     * Start connecting to a remote server.
     *
     * Unlike the synchronous parent method \Swoole\Client::connect(), this call does not block: it registers the
     * connection attempt with the event loop and returns immediately. The result is delivered later through the
     * "connect" or "error" callbacks registered via Async\Client::on().
     *
     * {@inheritDoc}
     * @see \Swoole\Async\Client::on()
     */
    public function connect(string $host, int $port = 0, float $timeout = 0.5, int $sock_flag = 0): bool
    {
    }

    /**
     * Temporarily stop receiving data from the connection.
     *
     * The connection is taken out of the event loop's read watch list, so the "receive" callback stops firing until
     * method wakeup() is called. This can be used to apply backpressure when data comes in faster than it can be
     * processed.
     *
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when the client is not connected, or receiving is
     *              already stopped).
     * @alias This method has an alias of \Swoole\Async\Client::pause().
     * @see \Swoole\Async\Client::pause()
     * @see \Swoole\Async\Client::wakeup()
     */
    public function sleep(): bool
    {
    }

    /**
     * Resume receiving data from the connection, undoing an earlier sleep() call.
     *
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when the client is not connected, or receiving is not
     *              stopped).
     * @alias This method has an alias of \Swoole\Async\Client::resume().
     * @see \Swoole\Async\Client::resume()
     * @see \Swoole\Async\Client::sleep()
     */
    public function wakeup(): bool
    {
    }

    /**
     * Stop receiving data from the server, without closing the connection.
     *
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when the client isn't connected, or receiving has been
     *              stopped already).
     * @alias This method is an alias of method \Swoole\Async\Client::sleep().
     * @see \Swoole\Async\Client::sleep()
     */
    public function pause(): bool
    {
    }

    /**
     * Start receiving data from the server again, after it was stopped.
     *
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when the client isn't connected, or receiving hasn't been
     *              stopped).
     * @alias This method is an alias of method \Swoole\Async\Client::wakeup().
     * @see \Swoole\Async\Client::wakeup()
     */
    public function resume(): bool
    {
    }

    /**
     * Enable SSL encryption on the connection.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * {@inheritDoc}
     * @param callable|null $onSslReady Callback function to be executed when the SSL handshake is successful. Although
     *                                  the parameter is nullable for signature compatibility with the parent class, it
     *                                  is effectively required here: a \Swoole\Exception is thrown if it's left out,
     *                                  and passing NULL explicitly makes the method fail with a warning raised and
     *                                  FALSE returned.
     * @return bool TRUE if the SSL handshake is started successfully; otherwise FALSE.
     */
    public function enableSSL(?callable $onSslReady = null): bool
    {
    }

    /**
     * Check if the client is connected or not.
     *
     * {@inheritDoc}
     *
     * @return bool TRUE if the client is connected; otherwise FALSE.
     */
    public function isConnected(): bool
    {
    }

    /**
     * Close the connection, causing the "close" event callback registered via method on() to fire.
     *
     * Unlike in the parent class, the $force parameter has no effect here: it's accepted only for signature
     * compatibility, and the connection is always actually closed (asynchronous clients don't support persistent
     * connections).
     *
     * {@inheritDoc}
     *
     * @param bool $force Ignored by this class.
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when the client is not connected).
     * @see \Swoole\Async\Client::on()
     */
    public function close(bool $force = false): bool
    {
    }

    /**
     * Register a callback for one of the client's events.
     *
     * @param string $event_name Name of the event to listen for. It must be one of the following (case-insensitive):
     *                           - "connect"     Fired when the connection to the server has been established.
     *                           - "receive"     Fired when data is received from the server.
     *                           - "close"       Fired when the connection is closed.
     *                           - "error"       Fired when the connection attempt fails.
     *                           - "bufferFull"  Fired when the send buffer is full.
     *                           - "bufferEmpty" Fired when the send buffer has been drained.
     *                           Any other name triggers a warning and makes the method return FALSE.
     * @param callable $callback The callback to run when the event fires.
     * @return bool TRUE if the callback was registered; FALSE for an unknown event name. NULL comes back instead
     *              (with a warning raised) when $callback isn't actually callable.
     */
    public function on(string $event_name, callable $callback): bool
    {
    }
}
