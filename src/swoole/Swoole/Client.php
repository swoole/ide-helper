<?php

declare(strict_types=1);

namespace Swoole;

/**
 * Synchronous (blocking) TCP/UDP/Unix-socket client.
 *
 * This class provides a blocking-mode network client that can talk to a remote server over TCP, UDP, or Unix domain
 * sockets, with optional SSL/TLS encryption. Each I/O method blocks the current process until it finishes; for
 * non-blocking I/O inside coroutines, use class \Swoole\Coroutine\Client instead. The client also supports
 * persistent connections: when the socket type includes the SWOOLE_KEEP flag, the underlying connection is kept
 * open and reused across multiple objects (and even multiple requests) within the same process.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Coroutine\Client
 */
class Client
{
    /**
     * Flag for methods send() and recv(): process out-of-band (urgent) data.
     *
     * @see \Swoole\Client::send()
     * @see \Swoole\Client::recv()
     */
    public const MSG_OOB = 1;

    /**
     * Flag for method recv(): peek at the incoming data without removing it from the receive buffer, so that a
     * subsequent recv() call returns the same data again.
     *
     * @see \Swoole\Client::recv()
     */
    public const MSG_PEEK = 2;

    /**
     * Flag for method recv(): make this single call non-blocking, returning immediately even if no data is
     * available yet.
     *
     * @see \Swoole\Client::recv()
     */
    public const MSG_DONTWAIT = 64;

    /**
     * Flag for method recv(): block until the full requested number of bytes has been received, instead of
     * returning whatever data happens to be available.
     *
     * @see \Swoole\Client::recv()
     */
    public const MSG_WAITALL = 256;

    /**
     * Option for method shutdown(): disable both further receiving and further sending on the connection.
     *
     * @see \Swoole\Client::shutdown()
     */
    public const SHUT_RDWR = 2;

    /**
     * Option for method shutdown(): disable further receiving on the connection.
     *
     * @see \Swoole\Client::shutdown()
     */
    public const SHUT_RD = 0;

    /**
     * Option for method shutdown(): disable further sending on the connection.
     *
     * @see \Swoole\Client::shutdown()
     */
    public const SHUT_WR = 1;

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
     * File descriptor of the underlying socket, or -1 when the client is not connected.
     */
    public int $sock = -1;

    /**
     * TRUE if the current connection is a reused persistent connection (i.e., the socket type includes the
     * SWOOLE_KEEP flag and an existing pooled connection was picked up by the connect() call instead of a new one
     * being established); otherwise FALSE.
     */
    public bool $reuse = false;

    /**
     * Number of times the underlying persistent connection has been reused. It stays 0 for non-persistent
     * connections.
     */
    public int $reuseCount = 0;

    /**
     * Socket type.
     *
     * It could be in one the following values:
     *    - SWOOLE_SOCK_TCP
     *    - SWOOLE_SOCK_UDP
     *    - SWOOLE_SOCK_TCP6
     *    - SWOOLE_SOCK_UDP6
     *    - SWOOLE_SOCK_UNIX_STREAM
     *    - SWOOLE_SOCK_UNIX_DGRAM
     * In addition to specifying a socket type, it may include the bitwise OR of any of the following socket flags, to
     * modify the behavior of the socket connection:
     *   - SWOOLE_SSL
     *   - SWOOLE_ASYNC (No longer used, but still kept for backward compatibility.)
     *   - SWOOLE_SYNC  (No longer used, but still kept for backward compatibility.)
     *   - SWOOLE_KEEP
     *
     * Thus, the value of $type could be in the format of any of the following:
     *   - SWOOLE_SOCK_TCP
     *   - SWOOLE_SOCK_TCP | SWOOLE_KEEP
     *   - SWOOLE_SOCK_TCP | SWOOLE_KEEP | SWOOLE_SSL
     */
    public int $type = 0;

    /**
     * Optional name of the client, as passed to the constructor.
     *
     * For persistent connections (socket type including the SWOOLE_KEEP flag), the name is part of the key used to
     * look up pooled connections, so clients created with different names never share the same persistent
     * connection. The property is NULL when no name was given.
     */
    public ?string $id = null;

    /**
     * Client settings set through method set(). The property is NULL until set() is called for the first time.
     *
     * @see \Swoole\Client::set()
     */
    public ?array $setting = null;

    /**
     * Create a new client object of the given socket type.
     *
     * The constructor only stores the socket type (and optional name); the actual socket is not created until
     * method connect() is called.
     *
     * @param int $type Socket type. Please check comments on property $type for more details.
     * @param bool $async Whether to enable asynchronous I/O or not. Since v4.4.8, this class supports synchronous I/O (in blocking mode) only; passing TRUE throws an \Error.
     * @param string $id Optional name of the client, stored in property $id. For persistent connections (socket type including the SWOOLE_KEEP flag), the name is part of the key used to look up pooled connections.
     * @see \Swoole\Client::connect()
     * @see \Swoole\Client::$id
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function __construct(int $type, bool $async = SWOOLE_SOCK_SYNC, string $id = '')
    {
        if ($async) {
            throw new \Error('The $async parameter is not supported');
        }

        // Here are some statements to validate the $type.

        $this->type = $type;
        if (!empty($id)) {
            $this->id = $id;
        }
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly. If the client still holds a live connection when the object is
     * destroyed, the connection is closed automatically (a persistent connection is returned to the in-process
     * connection pool instead).
     */
    public function __destruct()
    {
    }

    /**
     * Set options of the client object before connecting to a remote server.
     *
     * @param array $settings Client settings, merged into any settings passed to previous calls of this method.
     * @return bool TRUE if succeeds; otherwise FALSE.
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function set(array $settings): bool
    {
        $this->setting = array_merge($this->setting ?? [], $settings);
        return true;
    }

    /**
     * Connect to a remote server.
     *
     * For persistent connections (socket type including the SWOOLE_KEEP flag), an existing pooled connection to the
     * same server is reused when available; in that case property $reuse is set to TRUE.
     *
     * @param string $host Server host name or IP address (or socket path for Unix domain sockets). Host names are
     *                     resolved automatically.
     * @param int $port Server port. Not needed for Unix domain sockets.
     * @param float $timeout Connection timeout in seconds. Default: 0.5 seconds.
     * @param int $sock_flag Extra connection flag. For TCP sockets, a non-zero value makes the connect call
     *                       non-blocking; for UDP sockets, a value of 1 binds the socket to the remote address so
     *                       that only packets from that address are received.
     * @return bool TRUE if the connection is established (or a pooled connection is reused); otherwise FALSE, with
     *              property $errCode updated accordingly.
     * @see \Swoole\Client::$reuse
     * @see \Swoole\Client::$errCode
     */
    public function connect(string $host, int $port = 0, float $timeout = 0.5, int $sock_flag = 0): bool
    {
    }

    /**
     * Receive data from the remote server.
     *
     * When the "open_eof_check" or "open_length_check" setting is enabled, a complete protocol packet is returned
     * regardless of the $size parameter; otherwise, at most $size bytes of whatever data is available are returned.
     *
     * @param int $size Maximum number of bytes to receive.
     * @param int $flag Receive flags. It can be a bitwise OR of class constants like Client::MSG_WAITALL or
     *                  Client::MSG_PEEK; a value of 1 is treated as Client::MSG_WAITALL (block until exactly $size
     *                  bytes have been received).
     * @return string|false The data received. An empty string is returned when the server closes the connection,
     *                      and FALSE is returned on error (with property $errCode updated accordingly).
     * @see \Swoole\Client::MSG_WAITALL
     * @see \Swoole\Client::MSG_PEEK
     */
    public function recv(int $size = 65535, int $flag = 0): string|false
    {
    }

    /**
     * Send data to the remote server.
     *
     * @param string $data The data to send. It cannot be empty.
     * @param int $flag Send flags, e.g., class constant Client::MSG_OOB for out-of-band data.
     * @return int|false Number of bytes sent, or FALSE on error (with property $errCode updated accordingly).
     * @see \Swoole\Client::MSG_OOB
     */
    public function send(string $data, int $flag = 0): int|false
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
     * @return bool TRUE if the whole file (or requested portion) is sent; otherwise FALSE, with property $errCode
     *              updated accordingly.
     */
    public function sendfile(string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Send a UDP packet to the given address, without establishing a connection first.
     *
     * This method is for UDP-type sockets only.
     *
     * @param string $ip IP address (or socket path for Unix datagram sockets) of the target host.
     * @param int $port Port of the target host. Ignored for Unix datagram sockets.
     * @param string $data The data to send. It cannot be empty.
     * @return bool TRUE if the packet is sent; otherwise FALSE, with property $errCode updated accordingly.
     */
    public function sendto(string $ip, int $port, string $data): bool
    {
    }

    /**
     * Shut down part or all of a full-duplex connection, like what PHP function stream_socket_shutdown() does.
     *
     * @param int $how One of the class constants Client::SHUT_RD (disable further receiving), Client::SHUT_WR
     *                 (disable further sending), or Client::SHUT_RDWR (disable both).
     * @return bool TRUE if succeeds; otherwise FALSE.
     * @see \Swoole\Client::SHUT_RD
     * @see \Swoole\Client::SHUT_WR
     * @see \Swoole\Client::SHUT_RDWR
     * @see https://www.php.net/stream_socket_shutdown
     */
    public function shutdown(int $how): bool
    {
    }

    /**
     * Enable SSL encryption on the connection.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @param callable|null $onSslReady Callback function to be executed when SSL handshake is successful. The
     *                                  parameter exists since Swoole 6.0.0 for signature compatibility with child
     *                                  class \Swoole\Async\Client only; passing any value to it here (even NULL)
     *                                  makes this method throw a \Swoole\Exception, since synchronous clients don't
     *                                  support the callback.
     * @return bool TRUE if SSL handshake is successful; otherwise FALSE.
     */
    public function enableSSL(?callable $onSslReady = null): bool
    {
    }

    /**
     * Get the SSL certificate presented by the remote server.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @return string|false The peer certificate in PEM format, or FALSE if there is no established SSL connection or
     *                      the certificate cannot be retrieved.
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
     * @return bool TRUE if the peer certificate passes verification; otherwise FALSE.
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

    /**
     * Get the local host and port of the client socket.
     *
     * @return array|false An array with two keys ("host" and "port") describing the local end of the connection, or
     *                     FALSE on error (with property $errCode updated accordingly).
     */
    public function getsockname(): array|false
    {
    }

    /**
     * Get the host and port of the remote end of the connection.
     *
     * @return array|false An array with two keys ("host" and "port") describing the remote end of the connection,
     *                     or FALSE on error (with property $errCode updated accordingly).
     */
    public function getpeername(): array|false
    {
    }

    /**
     * Close the connection.
     *
     * For persistent connections (socket type including the SWOOLE_KEEP flag), the underlying connection is by
     * default returned to the in-process connection pool for later reuse instead of being closed; pass TRUE to
     * force it to actually close.
     *
     * @param bool $force Whether to force-close the connection even if it's a healthy persistent connection.
     * @return bool TRUE if succeeds; otherwise FALSE.
     */
    public function close(bool $force = false): bool
    {
    }

    /**
     * Get the socket handle of the client.
     *
     * This method is available only when Swoole is installed with option "--enable-sockets" included.
     *
     * @return \Socket|false Returns a Socket object on success; otherwise FALSE. Since Swoole 6.1.2, the returned
     *                       Socket object holds a duplicate of the underlying socket handle instead of the original
     *                       one, so closing the returned Socket object no longer affects the socket held by Swoole.
     */
    public function getSocket(): \Socket|false
    {
    }
}
