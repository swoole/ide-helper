<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

use Swoole\Client;

/**
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Socket" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Socket
 */
class Socket
{
    public $fd = -1;

    public $domain = 0;

    public $type = 0;

    public $protocol = 0;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct(int $domain, int $type, int $protocol = 0)
    {
    }

    public function bind(string $address, int $port = 0): bool
    {
    }

    /**
     * @param int $backlog The default value (512) is hardcoded in Swoole.
     */
    public function listen(int $backlog = 512): bool
    {
    }

    public function accept(float $timeout = 0): Socket|false
    {
    }

    public function connect(string $host, int $port = 0, float $timeout = 0): bool
    {
    }

    public function checkLiveness(): bool
    {
    }

    /**
     * @param int $length The default value (65536) is hardcoded in Swoole.
     */
    public function peek(int $length = 65536): string|false
    {
    }

    /**
     * @param int $length The default value (65536) is hardcoded in Swoole.
     */
    public function recv(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * @param int $length The default value (65536) is hardcoded in Swoole.
     */
    public function recvAll(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * @param int $length The default value (65536) is hardcoded in Swoole.
     */
    public function recvLine(int $length = 65535, float $timeout = 0): string|false
    {
    }

    /**
     * @param int $length The default value (65536) is hardcoded in Swoole.
     */
    public function recvWithBuffer(int $length = 65535, float $timeout = 0): string|false
    {
    }

    public function recvPacket(float $timeout = 0): string|false
    {
    }

    public function send(string $data, float $timeout = 0): int|false
    {
    }

    public function readVector(array $io_vector, float $timeout = 0): array|false
    {
    }

    public function readVectorAll(array $io_vector, float $timeout = 0): array|false
    {
    }

    public function writeVector(array $io_vector, float $timeout = 0): int|false
    {
    }

    public function writeVectorAll(array $io_vector, float $timeout = 0): int|false
    {
    }

    public function sendFile(string $file, int $offset = 0, int $length = 0): bool
    {
    }

    public function sendAll(string $data, float $timeout = 0): int|false
    {
    }

    public function recvfrom(mixed &$peername, float $timeout = 0): string|false
    {
    }

    public function sendto(string $addr, int $port, string $data): int|false
    {
    }

    public function getOption(int $level, int $opt_name): mixed
    {
    }

    /**
     * @return bool Returns TRUE if succeeds; otherwise FALSE.
     */
    public function setProtocol(array $settings): bool
    {
    }

    public function setOption(int $level, int $opt_name, mixed $opt_value): bool
    {
    }

    /**
     * This method is available only when OpenSSL support is enabled (i.e., when Swoole is installed with configuration
     * option "--enable-openssl" included).
     */
    public function sslHandshake(): bool
    {
    }

    /**
     * @param int $how A Client::SHUT_* constant.
     */
    public function shutdown(int $how = Client::SHUT_RDWR): bool
    {
    }

    /**
     * @param int $event Must be constant SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE.
     */
    public function cancel(int $event = SWOOLE_EVENT_READ): bool
    {
    }

    public function close(): bool
    {
    }

    /**
     * @return array|false If succeeds, return an array with two fields in it: "address" and "port"; otherwise, return FALSE.
     */
    public function getpeername(): array|false
    {
    }

    /**
     * @return array|false If succeeds, return an array with two fields in it: "address" and "port"; otherwise, return FALSE.
     */
    public function getsockname(): array|false
    {
    }

    /**
     * @since 4.8.3
     */
    public function isClosed(): bool
    {
    }

    /**
     * @since 5.0.0
     * @param mixed $stream
     */
    public static function import($stream): Socket|false
    {
    }
}
