<?php

declare(strict_types=1);

namespace Swoole\Async;

/**
 * @since 6.0.0
 */
class Client extends \Swoole\Client
{
    private $onConnect;

    private $onError;

    private $onReceive;

    private $onClose;

    private $onBufferFull;

    private $onBufferEmpty;

    private $onSSLReady;

    /**
     * @param int $type Socket type. Please check comments on property \Swoole\Client::$type for more details.
     */
    public function __construct(int $type)
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

    public function sleep(): bool
    {
    }

    public function wakeup(): bool
    {
    }

    /**
     * Alias of method \Swoole\Async\Client::sleep().
     *
     * @alias This method is an alias of method \Swoole\Async\Client::sleep().
     * @see \Swoole\Async\Client::sleep()
     */
    public function pause(): bool
    {
    }

    /**
     * Alias of method \Swoole\Async\Client::wakeup().
     *
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
     *                                  is required here: a \Swoole\Exception is thrown if it is omitted or NULL.
     * @return bool TRUE if the SSL handshake is started successfully; otherwise FALSE.
     */
    public function enableSSL(?callable $onSslReady = null): bool
    {
    }

    public function isConnected(): bool
    {
    }

    /**
     * {@inheritDoc}
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
     * @return bool TRUE if the callback was registered; FALSE for an unknown event name.
     */
    public function on(string $event_name, callable $callback): bool
    {
    }
}
