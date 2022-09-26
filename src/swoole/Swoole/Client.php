<?php

declare(strict_types=1);

namespace Swoole;

use Socket;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Client
{
    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 64;

    public const MSG_WAITALL = 256;

    public const SHUT_RDWR = 2;

    public const SHUT_RD = 0;

    public const SHUT_WR = 1;

    public int $errCode = 0;

    public int $sock = -1;

    public bool $reuse = false;

    public int $reuseCount = 0;

    /**
     * Socket type. It can be one of the following fix values:
     *
     * @see SWOOLE_SOCK_TCP
     * @see SWOOLE_SOCK_UDP
     * @see SWOOLE_SOCK_TCP6
     * @see SWOOLE_SOCK_UDP6
     * @see SWOOLE_SOCK_UNIX_STREAM
     * @see SWOOLE_SOCK_UNIX_DGRAM
     */
    public int $type;

    public string $id;

    public array $setting;

    /**
     * @param int $type Socket type. It can be one of the following fix values:
     *                  - SWOOLE_SOCK_TCP
     *                  - SWOOLE_SOCK_UDP
     *                  - SWOOLE_SOCK_TCP6
     *                  - SWOOLE_SOCK_UDP6
     *                  - SWOOLE_SOCK_UNIX_STREAM
     *                  - SWOOLE_SOCK_UNIX_DGRAM
     * @param bool $async Whether to enable asynchronous I/O or not. Since v4.4.8, this class supports synchronous I/O (in blocking mode) only.
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function __construct(int $type, bool $async = SWOOLE_SOCK_SYNC, string $id = '')
    {
        if ($async) {
            throw new \Error('Please install the ext-async extension, and use class Swoole\Async\Client instead.');
        }

        if (($type < SWOOLE_SOCK_TCP) || ($type > SWOOLE_SOCK_UNIX_DGRAM)) {
            throw new \TypeError(__METHOD__ . " expects parameter 1 to be client type, unknown type {$type} given");
        }

        $this->type = $type;
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    public function __destruct()
    {
    }

    /**
     * Set options of the client object before connecting to a remote server.
     *
     * @return bool TRUE if succeeds; otherwise FALSE.
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function set(array $settings): bool
    {
        $this->setting = array_merge($this->setting ?? [], $settings);
        return true;
    }

    public function connect(string $host, int $port = 0, float $timeout = 0.5, int $sock_flag = 0): bool
    {
    }

    /**
     * @param int $size The default value (65536) is hardcoded in Swoole.
     */
    public function recv(int $size = 65536, int $flag = 0): string|false
    {
    }

    public function send(string $data, int $flag = 0): int|false
    {
    }

    public function sendfile(string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    public function sendto(string $ip, int $port, string $data): bool
    {
    }

    public function shutdown(int $how): bool
    {
    }

    /**
     * This method is available only when OpenSSL support is enabled (i.e., when Swoole is installed with configuration
     * option "--enable-openssl" included).
     */
    public function enableSSL(): bool
    {
    }

    /**
     * This method is available only when OpenSSL support is enabled (i.e., when Swoole is installed with configuration
     * option "--enable-openssl" included).
     */
    public function getPeerCert(): bool|string
    {
    }

    /**
     * This method is available only when OpenSSL support is enabled (i.e., when Swoole is installed with configuration
     * option "--enable-openssl" included).
     */
    public function verifyPeerCert(): bool
    {
    }

    /**
     * Check if the client is connected or not.
     *
     * @return bool TRUE if the client is connected; otherwise FALSE.
     */
    public function isConnected(): bool
    {
    }

    public function getsockname(): array|false
    {
    }

    public function getpeername(): array|false
    {
    }

    public function close(bool $force = false): bool
    {
    }

    public function getSocket(): Socket|false
    {
    }
}
