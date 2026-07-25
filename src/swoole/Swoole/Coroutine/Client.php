<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * Coroutine-friendly TCP/UDP/Unix-socket client.
 *
 * This class provides a network client to be used inside coroutines: every I/O method suspends only the current
 * coroutine while waiting for data, letting other coroutines keep running. It supports TCP, UDP, and Unix domain
 * sockets, optional SSL/TLS encryption, and the same protocol-framing settings as class \Swoole\Server (e.g.,
 * "open_eof_check" and "open_length_check"). It is the coroutine counterpart of the synchronous client
 * \Swoole\Client; for lower-level socket operations, the underlying socket can be retrieved with method
 * exportSocket().
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Client" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Client
 * @see \Swoole\Client
 * @see \Swoole\Coroutine\Client::exportSocket()
 */
class Client
{
    public const MSG_OOB = 1;

    public const MSG_PEEK = 2;

    public const MSG_DONTWAIT = 64;

    public const MSG_WAITALL = 256;

    /**
     * Error code of the last failed operation.
     *
     * The value is a C error number (errno) or a Swoole error code; it can be turned into a human-readable message
     * with function swoole_strerror().
     *
     * @see \swoole_strerror()
     */
    public int $errCode = 0;

    /**
     * Human-readable error message of the last failed operation.
     */
    public string $errMsg = '';

    /**
     * File descriptor of the underlying socket, or -1 when the client is not connected.
     */
    public int $fd = -1;

    /**
     * Socket type, as passed to the constructor (e.g., SWOOLE_SOCK_TCP, optionally combined with the SWOOLE_SSL
     * flag). Default: SWOOLE_SOCK_TCP.
     */
    public int $type = SWOOLE_SOCK_TCP;

    /**
     * Client settings set through method set(). NULL until set() is called for the first time.
     *
     * @see \Swoole\Coroutine\Client::set()
     */
    public ?array $setting = null;

    /**
     * TRUE while the client is connected to the server (set by a successful connect() call and cleared by close());
     * otherwise FALSE.
     */
    public bool $connected = false;

    /**
     * The socket object of the client.
     *
     * This is a private property before Swoole 5.0.2.
     */
    public ?Socket $socket;

    /**
     * Constructor.
     *
     * @param int $type Socket type: one of SWOOLE_SOCK_TCP, SWOOLE_SOCK_TCP6, SWOOLE_SOCK_UDP, SWOOLE_SOCK_UDP6,
     *                  SWOOLE_SOCK_UNIX_STREAM, or SWOOLE_SOCK_UNIX_DGRAM, optionally combined with the SWOOLE_SSL
     *                  flag (e.g., SWOOLE_SOCK_TCP | SWOOLE_SSL) to enable SSL/TLS encryption.
     * @throws \TypeError When an unknown socket type is given.
     */
    public function __construct(int $type)
    {
    }

    /**
     * Set options of the client, e.g., protocol-framing settings like "open_eof_check" or "open_length_check", or
     * SSL options like "ssl_cert_file".
     *
     * The settings are merged into any settings passed to previous calls of this method.
     *
     * @param array $settings Client settings.
     * @return bool TRUE if succeeds; otherwise FALSE (e.g., when an empty array is given, or when applying the
     *              settings to an already-created socket fails).
     * @see \Swoole\Coroutine\Client::$setting
     */
    public function set(array $settings): bool
    {
    }

    /**
     * Connect to a remote server.
     *
     * @param string $host Server host name or IP address (or socket path for Unix domain sockets). Host names are
     *                     resolved automatically.
     * @param int $port Server port. Not needed for Unix domain sockets.
     * @param float $timeout Timeout in seconds. It applies to the connection attempt itself, and is then used as
     *                       the default read/write timeout of the connection. A value of 0 means using the default
     *                       timeout (ini setting "swoole.socket_connect_timeout" / "swoole.socket_timeout"), and a
     *                       negative value means no timeout.
     * @param int $sock_flag Extra connection flag. For UDP sockets, a value of 1 binds the socket to the remote
     *                       address so that only packets from that address are received.
     * @return bool TRUE if the connection is established; otherwise FALSE, with properties $errCode and $errMsg
     *              updated accordingly.
     */
    public function connect(string $host, int $port = 0, float $timeout = 0, int $sock_flag = 0): bool
    {
    }

    /**
     * Receive data from the remote server.
     *
     * When the "open_eof_check" or "open_length_check" setting is enabled, a complete protocol packet is returned;
     * otherwise, at most 64 KB of whatever data is available is returned.
     *
     * @param float $timeout Timeout in seconds. A value of 0 means using the timeout set when connecting (or the
     *                       default timeout), and a negative value means no timeout.
     * @return string|false The data received. An empty string is returned when the server closes the connection,
     *                      and FALSE is returned on error (with properties $errCode and $errMsg updated
     *                      accordingly).
     */
    public function recv(float $timeout = 0): string|false
    {
    }

    /**
     * Peek at the data currently in the socket buffer, without removing it.
     *
     * Unlike recv(), this method doesn't suspend the current coroutine: it returns immediately with whatever data
     * is already available. A later recv() call still returns the same data.
     *
     * @param int $length Maximum number of bytes to peek at.
     * @return string|false The data available in the socket buffer (possibly an empty string), or FALSE on error
     *                      (with properties $errCode and $errMsg updated accordingly).
     * @see \Swoole\Coroutine\Client::recv()
     */
    public function peek(int $length = 65535): string|false
    {
    }

    /**
     * Send data to the remote server.
     *
     * @param string $data The data to send. It cannot be empty.
     * @param float $timeout Timeout in seconds. A value of 0 means using the timeout set when connecting (or the
     *                       default timeout), and a negative value means no timeout.
     * @return int|false Number of bytes sent, or FALSE on error (with properties $errCode and $errMsg updated
     *                   accordingly).
     */
    public function send(string $data, float $timeout = 0): int|false
    {
    }

    /**
     * Send a file to the remote server.
     *
     * This method works on stream-type sockets only (TCP or Unix stream sockets); it cannot be used on UDP sockets.
     *
     * @param string $filename Path of the file to send. It cannot be empty.
     * @param int $offset Offset in bytes from where to start reading the file. Default: 0 (the beginning of the file).
     * @param int $length Number of bytes to send. Default: 0 (until the end of the file).
     * @return bool TRUE if the whole file (or requested portion) is sent; otherwise FALSE, with properties $errCode
     *              and $errMsg updated accordingly.
     */
    public function sendfile(string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Send a UDP packet to the given address, without establishing a connection first.
     *
     * This method is for UDP-type sockets only.
     *
     * @param string $address IP address (or socket path for Unix datagram sockets) of the target host.
     * @param int $port Port of the target host. Ignored for Unix datagram sockets.
     * @param string $data The data to send. It cannot be empty.
     * @return bool TRUE if the packet is sent; otherwise FALSE, with properties $errCode and $errMsg updated
     *              accordingly.
     */
    public function sendto(string $address, int $port, string $data): bool
    {
    }

    /**
     * Receive a UDP packet, along with the address and port it was sent from.
     *
     * This method is for UDP-type sockets only.
     *
     * @param int $length Maximum number of bytes to receive.
     * @param mixed &$address Variable to be filled with the IP address of the sending host.
     * @param mixed &$port Variable to be filled with the port of the sending host.
     * @return string|false The data received, or FALSE on error (with properties $errCode and $errMsg updated
     *                      accordingly).
     */
    public function recvfrom(int $length, mixed &$address, mixed &$port = 0): string|false
    {
    }

    /**
     * Enable SSL/TLS encryption on an established connection and perform the SSL handshake.
     *
     * This method is for TCP sockets only, and can only be called once per connection. It's typically used for
     * protocols that upgrade a plaintext connection to an encrypted one (e.g., STARTTLS).
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @return bool TRUE if the SSL handshake succeeds; otherwise FALSE, with properties $errCode and $errMsg
     *              updated accordingly.
     */
    public function enableSSL(): bool
    {
    }

    /**
     * Get the SSL certificate presented by the remote server.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @return string|false The peer certificate in PEM format, or FALSE if there is no established SSL connection
     *                      or the certificate cannot be retrieved.
     */
    public function getPeerCert(): string|false
    {
    }

    /**
     * Verify the SSL certificate presented by the remote server.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @param bool $allow_self_signed Whether to accept self-signed certificates.
     * @return bool TRUE if the peer certificate passes verification; otherwise FALSE.
     */
    public function verifyPeerCert(bool $allow_self_signed = false): bool
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

    /**
     * Get the local address and port of the client socket.
     *
     * @return array|false An array with three keys ("host", "address", and "port") describing the local end of the
     *                     connection (keys "host" and "address" hold the same value; "host" is kept for backward
     *                     compatibility), or FALSE on error (with properties $errCode and $errMsg updated
     *                     accordingly).
     */
    public function getsockname(): array|false
    {
    }

    /**
     * Get the address and port of the remote end of the connection.
     *
     * @return array|false An array with three keys ("host", "address", and "port") describing the remote end of the
     *                     connection (keys "host" and "address" hold the same value; "host" is kept for backward
     *                     compatibility), or FALSE on error (with properties $errCode and $errMsg updated
     *                     accordingly).
     */
    public function getpeername(): array|false
    {
    }

    /**
     * Close the connection.
     *
     * @return bool TRUE if succeeds; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     */
    public function close(): bool
    {
    }

    /**
     * Export the underlying socket as a \Swoole\Coroutine\Socket object, for lower-level socket operations.
     *
     * The returned object refers to the same underlying connection as the client itself.
     *
     * @return Socket|false The underlying socket object, or FALSE on failure.
     * @see \Swoole\Coroutine\Socket
     */
    public function exportSocket(): Socket|false
    {
    }
}
