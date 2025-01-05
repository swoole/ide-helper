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

    public function sleep(): bool
    {
    }

    public function wakeup(): bool
    {
    }

    public function pause(): bool
    {
    }

    public function resume(): bool
    {
    }

    /**
     * Enable SSL encryption on the connection.
     *
     * This method is available only when OpenSSL support is enabled (i.e., when Swoole is installed with configuration
     * option "--enable-openssl" included).
     *
     * {@inheritDoc}
     * @param callable|null $onSslReady Callback function to be executed when SSL handshake is successful.
     * @return bool TRUE if SSL handshake is successful; otherwise FALSE.
     */
    public function enableSSL(?callable $onSslReady = null): bool
    {
    }

    public function on(string $host, callable $callback): bool
    {
    }
}
