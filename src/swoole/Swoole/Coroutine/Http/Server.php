<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\Coroutine\Socket;

/**
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Http\Server" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http\Server
 * @since 4.4.0
 */
final class Server
{
    public $fd = -1;

    public $host;

    public $port = -1;

    public $ssl = false;

    public $settings;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct(string $host, int $port = 0, bool $ssl = false, bool $reuse_port = false)
    {
    }

    public function set(array $settings): bool
    {
    }

    /**
     * Register a callback function to handle the HTTP request specified by the URL pattern.
     *
     * @param string $pattern The URL pattern to match, e.g., "/index".
     * @param callable $callback The callback function to handle the HTTP request.
     * @return bool Return true on success. Return false on failure.
     *              Before Swoole v6.0.0, it returns void.
     */
    public function handle(string $pattern, callable $callback): bool
    {
    }

    public function start(): bool
    {
    }

    public function shutdown(): void
    {
    }

    /**
     * @param Socket $conn Added since Swoole v5.1.0.
     */
    private function onAccept(Socket $conn): void
    {
    }
}
