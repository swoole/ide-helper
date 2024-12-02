<?php

declare(strict_types=1);

namespace Swoole\Async;

/**
 * @since 6.0.0-rc1
 */
class Client extends \Swoole\Client
{
    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 64;

    public const MSG_WAITALL = 256;

    public const SHUT_RDWR = 2;

    public const SHUT_RD = 0;

    public const SHUT_WR = 1;

    private $onConnect;

    private $onError;

    private $onReceive;

    private $onClose;

    private $onBufferFull;

    private $onBufferEmpty;

    private $onSSLReady;

    public function __construct(int $type)
    {
    }

    public function __destruct()
    {
    }

    public function connect(string $host, int $port = 0, float $timeout = 0.5, int $sock_flag = 0): bool
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

    public function enableSSL(?callable $onSslReady = null): bool
    {
    }

    public function isConnected(): bool
    {
    }

    public function close(bool $force = false): bool
    {
    }

    public function on(string $host, callable $callback): bool
    {
    }
}
