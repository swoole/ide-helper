<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

use Swoole\Client;

/**
 * A coroutine-friendly socket class used to represent a socket connection.
 *
 * When runtime hook flag SWOOLE_HOOK_SOCKETS is enabled, this class is used to represent a \Socket object (i.e., it's a
 * child class of built-in PHP class \Socket).
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Socket" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Socket
 * @see \Socket
 */
class Socket
{
    /**
     * File descriptor number of the underlying socket, or -1 before the socket is created.
     *
     * @readonly
     */
    public int $fd = -1;

    /**
     * Protocol family of the socket, e.g., AF_INET, AF_INET6, or AF_UNIX.
     *
     * @readonly
     */
    public int $domain = 0;

    /**
     * Type of the socket, e.g., SOCK_STREAM or SOCK_DGRAM.
     *
     * @readonly
     */
    public int $type = 0;

    /**
     * Protocol used by the socket, e.g., IPPROTO_TCP or IPPROTO_UDP.
     *
     * @readonly
     */
    public int $protocol = 0;

    /**
     * Error code of the last failed operation on the socket; 0 when the last operation succeeded.
     *
     * @see \Swoole\Coroutine\Socket::$errMsg
     */
    public int $errCode = 0;

    /**
     * Error message of the last failed operation on the socket; an empty string when the last operation succeeded.
     *
     * @see \Swoole\Coroutine\Socket::$errCode
     */
    public string $errMsg = '';

    /**
     * Internal bookkeeping used when this object is exposed to PHP's own sockets extension; not meant to be read or
     * written by application code.
     *
     * This property exists only when Swoole is built with support for PHP's sockets extension (i.e., the sockets
     * extension is available and Swoole is compiled with the "--enable-sockets" configuration option).
     *
     * @since 5.1.0
     */
    public bool $__ext_sockets_nonblock = false;

    /**
     * Internal bookkeeping used when this object is exposed to PHP's own sockets extension; not meant to be read or
     * written by application code.
     *
     * This property exists only when Swoole is built with support for PHP's sockets extension (i.e., the sockets
     * extension is available and Swoole is compiled with the "--enable-sockets" configuration option).
     *
     * @since 5.1.0
     */
    public int $__ext_sockets_timeout = 0;

    /**
     * Create a new socket.
     *
     * @param int $domain Protocol family of the socket, e.g., AF_INET, AF_INET6, or AF_UNIX.
     * @param int $type Type of the socket, e.g., SOCK_STREAM or SOCK_DGRAM.
     * @param int $protocol Protocol used by the socket, e.g., IPPROTO_TCP or IPPROTO_UDP. The default value IPPROTO_IP
     *                      (which equals 0) picks the default protocol of the given domain and type automatically.
     * @throws Socket\Exception When the underlying socket can not be created.
     */
    public function __construct(int $domain, int $type, int $protocol = IPPROTO_IP)
    {
    }

    /**
     * Bind the socket to a given address and port.
     *
     * @param string $address The IP address (or, for AF_UNIX sockets, the file path) to bind the socket to.
     * @param int $port The port to bind the socket to. If it's 0 (the default), the operating system picks a random
     *                  available port, which can be retrieved with method \Swoole\Coroutine\Socket::getsockname().
     * @return bool Returns TRUE on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::getsockname()
     */
    public function bind(string $address, int $port = 0): bool
    {
    }

    /**
     * Start listening for incoming connections on the socket.
     *
     * The socket should be bound to an address and port first through method \Swoole\Coroutine\Socket::bind().
     *
     * @param int $backlog The maximum number of pending connections queued by the operating system.
     * @return bool Returns TRUE on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::bind()
     * @see \Swoole\Coroutine\Socket::accept()
     */
    public function listen(int $backlog = 512): bool
    {
    }

    /**
     * Accept an incoming connection on a listening socket.
     *
     * The calling coroutine yields until a new connection arrives, without blocking the process.
     *
     * @param float $timeout The maximum time to wait for a connection (in seconds). If it's 0 (the default), the
     *                       socket's own receive timeout applies (60 seconds unless changed); a negative value means
     *                       waiting indefinitely.
     * @return Socket|false Returns a new \Swoole\Coroutine\Socket object representing the accepted connection on
     *                      success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::listen()
     */
    public function accept(float $timeout = 0): Socket|false
    {
    }

    /**
     * Connect the socket to a remote address.
     *
     * The calling coroutine yields until the connection is established, without blocking the process.
     *
     * @param string $host The IP address or host name to connect to; for AF_UNIX sockets, the file path of the Unix socket.
     * @param int $port The port to connect to. It's required for AF_INET and AF_INET6 sockets, and must be between 1 and 65535.
     * @param float $timeout The maximum time to wait for the connection to be established (in seconds). If it's 0 (the
     *                       default), the socket's own connect timeout applies (2 seconds unless changed); a negative
     *                       value means waiting indefinitely.
     * @return bool Returns TRUE on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     */
    public function connect(string $host, int $port = 0, float $timeout = 0): bool
    {
    }

    /**
     * Check liveness of the socket.
     *
     * @return bool Returns true if the socket is still alive, false otherwise.
     * @since 4.5.0
     */
    public function checkLiveness(): bool
    {
    }

    /**
     * Get the coroutine ID that the socket is bound to of the specified event type.
     *
     * @param int $event Type of the event that the socket is performing inside the coroutine. It can be one of the following values:
     *                   - SWOOLE_EVENT_READ
     *                   - SWOOLE_EVENT_WRITE
     *                   - SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE.
     * @return int Returns the coroutine ID that the socket is bound to of the specified event type. Returns 0 if no matching coroutine is found.
     * @since 5.0.2
     */
    public function getBoundCid(int $event): int
    {
    }

    /**
     * Peek at the data currently available on the socket, without removing it from the socket buffer.
     *
     * The same data can still be received afterwards with one of the recv*() methods. This method returns immediately
     * without waiting; use it only when there is a specific reason to inspect data ahead of receiving it.
     *
     * @param int $length The maximum number of bytes to peek at.
     * @return string|false Returns the data currently available (up to $length bytes; possibly an empty string when
     *                      the peer has closed the connection) on success; otherwise FALSE, with properties $errCode
     *                      and $errMsg updated accordingly.
     * @since 4.5.0
     */
    public function peek(int $length = 65536): string|false
    {
    }

    /**
     * Receive data from the socket.
     *
     * The calling coroutine yields until some data arrives, without blocking the process. This method returns as soon
     * as any data is available, which can be fewer than $length bytes; use method recvAll() to keep receiving until
     * exactly $length bytes are returned.
     *
     * @param int $length The maximum number of bytes to receive.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return string|false Returns the data received on success (an empty string when the peer has closed the
     *                      connection); otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::recvAll()
     * @see \Swoole\Coroutine\Socket::recvLine()
     * @see \Swoole\Coroutine\Socket::recvWithBuffer()
     */
    public function recv(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * Receive data from the socket, waiting until the requested number of bytes has arrived.
     *
     * Unlike method recv(), this method keeps receiving until exactly $length bytes have been collected, the peer
     * closes the connection, or an error occurs.
     *
     * @param int $length The number of bytes to receive.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return string|false Returns the data received on success (fewer than $length bytes when the peer closes the
     *                      connection halfway; an empty string when the connection is closed before any data arrives);
     *                      otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::recv()
     * @see \Swoole\Coroutine\Socket::recvLine()
     * @see \Swoole\Coroutine\Socket::recvWithBuffer()
     */
    public function recvAll(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * Receive a single line of data from the socket.
     *
     * This method stops receiving once a newline ("\n") or carriage-return ("\r") character is received, or once
     * $length bytes have been collected, whichever comes first. The line-ending character, if any, is included in the
     * returned string.
     *
     * @param int $length The maximum number of bytes to receive.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return string|false Returns the line received on success (an empty string when the peer has closed the
     *                      connection); otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::recv()
     * @see \Swoole\Coroutine\Socket::recvAll()
     * @see \Swoole\Coroutine\Socket::recvWithBuffer()
     */
    public function recvLine(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * Receive data from the socket, using an internal read buffer to reduce the number of system calls.
     *
     * This method behaves like method recv(), except that data is first read into an internal buffer in larger chunks
     * and then handed out from there. It's useful when making many small reads (e.g., a few bytes at a time).
     *
     * @param int $length The maximum number of bytes to receive.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return string|false Returns the data received on success (an empty string when the peer has closed the
     *                      connection); otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::recv()
     * @see \Swoole\Coroutine\Socket::recvAll()
     * @see \Swoole\Coroutine\Socket::recvLine()
     */
    public function recvWithBuffer(int $length = 65536, float $timeout = 0): string|false
    {
    }

    /**
     * Receive a complete protocol packet from the socket.
     *
     * Packet boundaries are detected according to the protocol settings configured through method
     * \Swoole\Coroutine\Socket::setProtocol() (e.g., length-based or EOF-based packet framing).
     *
     * @param float $timeout The maximum time to wait for a complete packet (in seconds). If it's 0 (the default), the
     *                       socket's own receive timeout applies (60 seconds unless changed); a negative value means
     *                       waiting indefinitely.
     * @return string|false Returns a complete packet on success (an empty string when the peer has closed the
     *                      connection); otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::setProtocol()
     * @since 4.4.0
     */
    public function recvPacket(float $timeout = 0): string|false
    {
    }

    /**
     * Send data through the socket.
     *
     * The calling coroutine yields until the data is handed over to the operating system, without blocking the
     * process. This method may send only part of the data; use method sendAll() to make sure the whole string is sent.
     *
     * @param string $data The data to send.
     * @param float $timeout The maximum time to wait (in seconds). If it's 0 (the default), the socket's own send
     *                       timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return int|false Returns the number of bytes sent (which can be fewer than the length of $data) on success;
     *                   otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::sendAll()
     */
    public function send(string $data, float $timeout = 0): int|false
    {
    }

    /**
     * Receive data from the socket into multiple strings at once.
     *
     * This is a "scatter read": a single receive operation fills a list of strings of the given sizes one after
     * another, backed by the C function readv(2). Like method recv(), it returns as soon as some data is available,
     * which can be less than the total requested size; use method readVectorAll() to keep receiving until all the
     * requested bytes have arrived.
     *
     * @param array $io_vector A list of positive integers, each being the number of bytes to read into the string at
     *                         the same position of the returned array. It can contain at most IOV_MAX (typically 1024)
     *                         elements. An exception of class \Swoole\Coroutine\Socket\Exception is thrown if any
     *                         element is not an integer or is a negative integer.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return array|false Returns a list of strings holding the data received on success (an empty array when the peer
     *                     has closed the connection); when fewer bytes arrive than requested, the returned array
     *                     contains fewer and/or shorter strings than requested. Otherwise, returns FALSE, with
     *                     properties $errCode and $errMsg updated accordingly.
     * @see https://man7.org/linux/man-pages/man2/readv.2.html The C function readv(2) behind this method.
     * @see \Swoole\Coroutine\Socket::readVectorAll()
     * @since 4.5.7
     */
    public function readVector(array $io_vector, float $timeout = 0): array|false
    {
    }

    /**
     * Receive data from the socket into multiple strings at once, waiting until all the requested bytes have arrived.
     *
     * This method works the same way as method readVector(), except that it keeps receiving until all the requested
     * bytes have been collected, the peer closes the connection, or an error occurs.
     *
     * @param array $io_vector A list of positive integers, each being the number of bytes to read into the string at
     *                         the same position of the returned array. It can contain at most IOV_MAX (typically 1024)
     *                         elements. An exception of class \Swoole\Coroutine\Socket\Exception is thrown if any
     *                         element is not an integer or is a negative integer.
     * @param float $timeout The maximum time to wait for data (in seconds). If it's 0 (the default), the socket's own
     *                       receive timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return array|false Returns a list of strings holding the data received on success (an empty array when the peer
     *                     has closed the connection). Otherwise, returns FALSE, with properties $errCode and $errMsg
     *                     updated accordingly.
     * @see https://man7.org/linux/man-pages/man2/readv.2.html The C function readv(2) behind this method.
     * @see \Swoole\Coroutine\Socket::readVector()
     * @since 4.5.7
     */
    public function readVectorAll(array $io_vector, float $timeout = 0): array|false
    {
    }

    /**
     * Send multiple strings through the socket at once.
     *
     * This is a "gather write": a single send operation writes a list of strings one after another, backed by the C
     * function writev(2). Like method send(), it may send only part of the data; use method writeVectorAll() to make
     * sure everything is sent.
     *
     * @param array $io_vector A list of non-empty strings to send, in order. It can contain at most IOV_MAX (typically
     *                         1024) elements. An exception of class \Swoole\Coroutine\Socket\Exception is thrown if
     *                         any element is not a non-empty string.
     * @param float $timeout The maximum time to wait (in seconds). If it's 0 (the default), the socket's own send
     *                       timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return int|false Returns the number of bytes sent (which can be fewer than the total length of the given
     *                   strings) on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see https://man7.org/linux/man-pages/man2/writev.2.html The C function writev(2) behind this method.
     * @see \Swoole\Coroutine\Socket::writeVectorAll()
     * @since 4.5.7
     */
    public function writeVector(array $io_vector, float $timeout = 0): int|false
    {
    }

    /**
     * Send multiple strings through the socket at once, waiting until all the data has been sent.
     *
     * This method works the same way as method writeVector(), except that it keeps sending until all the given data
     * has been sent, the connection is closed, or an error occurs.
     *
     * @param array $io_vector A list of non-empty strings to send, in order. It can contain at most IOV_MAX (typically
     *                         1024) elements. An exception of class \Swoole\Coroutine\Socket\Exception is thrown if
     *                         any element is not a non-empty string.
     * @param float $timeout The maximum time to wait (in seconds). If it's 0 (the default), the socket's own send
     *                       timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return int|false Returns the number of bytes sent on success; otherwise FALSE, with properties $errCode and
     *                   $errMsg updated accordingly.
     * @see https://man7.org/linux/man-pages/man2/writev.2.html The C function writev(2) behind this method.
     * @see \Swoole\Coroutine\Socket::writeVector()
     * @since 4.5.7
     */
    public function writeVectorAll(array $io_vector, float $timeout = 0): int|false
    {
    }

    /**
     * Send a file through the socket.
     *
     * The calling coroutine yields until the whole file (or the requested part of it) has been sent, without blocking
     * the process.
     *
     * @param string $file Path of the file to send. It can't be an empty string.
     * @param int $offset Offset (in bytes) in the file to start sending from. By default, sending starts from the
     *                    beginning of the file.
     * @param int $length Number of bytes to send. By default (0), everything from $offset to the end of the file is sent.
     * @return bool Returns TRUE on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @since 4.4.0
     */
    public function sendFile(string $file, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Send data through the socket, waiting until all the data has been sent.
     *
     * Unlike method send(), this method keeps sending until the whole string has been sent, the connection is closed,
     * or an error occurs.
     *
     * @param string $data The data to send.
     * @param float $timeout The maximum time to wait (in seconds). If it's 0 (the default), the socket's own send
     *                       timeout applies (60 seconds unless changed); a negative value means waiting indefinitely.
     * @return int|false Returns the number of bytes sent on success (which can be fewer than the length of $data if
     *                   the connection is closed halfway); otherwise FALSE, with properties $errCode and $errMsg
     *                   updated accordingly.
     * @see \Swoole\Coroutine\Socket::send()
     */
    public function sendAll(string $data, float $timeout = 0): int|false
    {
    }

    /**
     * Receive a message from the socket, along with the address it was sent from.
     *
     * This method is typically used on connectionless sockets (e.g., UDP or Unix datagram sockets).
     *
     * @param mixed $peername Variable passed by reference. On success, it's set to an array with two fields in it:
     *                        "address" (the sender's IP address or Unix socket path) and "port" (the sender's port; 0
     *                        for Unix sockets).
     * @param float $timeout The maximum time to wait for a message (in seconds). If it's 0 (the default), the socket's
     *                       own receive timeout applies (60 seconds unless changed); a negative value means waiting
     *                       indefinitely.
     * @return string|false Returns the message received on success (up to 65536 bytes; an empty string when a socket
     *                      of a connection-based type has been closed by the peer); otherwise FALSE, with properties
     *                      $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::sendto()
     */
    public function recvfrom(mixed &$peername, float $timeout = 0): string|false
    {
    }

    /**
     * Send a message to a given address through the socket.
     *
     * This method is typically used on connectionless sockets (e.g., UDP or Unix datagram sockets), and doesn't
     * require the socket to be connected first.
     *
     * @param string $addr The IP address (or Unix socket path) to send the message to.
     * @param int $port The port to send the message to; use 0 for Unix sockets.
     * @param string $data The message to send.
     * @return int|false Returns the number of bytes sent on success; otherwise FALSE, with properties $errCode and
     *                   $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::recvfrom()
     */
    public function sendto(string $addr, int $port, string $data): int|false
    {
    }

    /**
     * Get a socket option.
     *
     * This method works like the PHP function \socket_get_option() of the sockets extension.
     *
     * @param int $level The protocol level at which the option resides, e.g., SOL_SOCKET, IPPROTO_IP, or IPPROTO_IPV6.
     * @param int $opt_name The option to retrieve, e.g., SO_REUSEADDR or SO_LINGER.
     * @return mixed The value of the given option: an integer for most options, or an array for structured options
     *               (e.g., SO_LINGER, SO_RCVTIMEO, SO_SNDTIMEO, or TCP_INFO). Returns FALSE on failure.
     * @see https://www.php.net/socket_get_option The PHP function \socket_get_option(), which this method mirrors.
     * @see \Swoole\Coroutine\Socket::setOption()
     */
    public function getOption(int $level, int $opt_name): mixed
    {
    }

    /**
     * Configure protocol handling on the socket, e.g., packet framing and SSL settings.
     *
     * The settings mainly affect how method \Swoole\Coroutine\Socket::recvPacket() detects packet boundaries.
     *
     * @param array $settings An array of protocol options, e.g., "open_length_check", "package_length_type",
     *                        "package_length_offset", "package_body_offset", "package_max_length", "open_eof_check",
     *                        "package_eof", and "open_ssl". It can't be an empty array.
     * @return bool Returns TRUE if succeeds; otherwise FALSE.
     * @see \Swoole\Coroutine\Socket::recvPacket()
     * @since 4.4.0
     */
    public function setProtocol(array $settings): bool
    {
    }

    /**
     * Set a socket option.
     *
     * This method works like the PHP function \socket_set_option() of the sockets extension.
     *
     * @param int $level The protocol level at which the option resides, e.g., SOL_SOCKET, IPPROTO_IP, or IPPROTO_IPV6.
     * @param int $opt_name The option to set, e.g., SO_REUSEADDR or SO_LINGER.
     * @param mixed $opt_value The value to set the option to: an integer for most options, or an array for structured
     *                         options (e.g., ["l_onoff" => ..., "l_linger" => ...] for SO_LINGER, or ["sec" => ...,
     *                         "usec" => ...] for SO_RCVTIMEO and SO_SNDTIMEO).
     * @return bool Returns TRUE on success, or FALSE on failure.
     * @see https://www.php.net/socket_set_option The PHP function \socket_set_option(), which this method mirrors.
     * @see \Swoole\Coroutine\Socket::getOption()
     */
    public function setOption(int $level, int $opt_name, mixed $opt_value): bool
    {
    }

    /**
     * Perform an SSL/TLS handshake on the socket.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @return bool Returns TRUE on success, or FALSE on failure.
     * @since 4.5.0
     */
    public function sslHandshake(): bool
    {
    }

    /**
     * Stop further receiving, sending, or both on the socket, without closing it.
     *
     * @param int $how One of the following constants:
     *                 - Client::SHUT_RD: Stop receiving data.
     *                 - Client::SHUT_WR: Stop sending data.
     *                 - Client::SHUT_RDWR: Stop both receiving and sending data. This is the default.
     * @return bool Returns TRUE on success; otherwise FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::close()
     */
    public function shutdown(int $how = Client::SHUT_RDWR): bool
    {
    }

    /**
     * Wake up a coroutine that is waiting on the socket, making its pending operation fail.
     *
     * Inside the coroutine that gets woken up, the pending method call on the socket (e.g., a call to method recv() or
     * send()) returns FALSE with error code SOCKET_ECANCELED.
     *
     * @param int $event The type of operation to cancel: SWOOLE_EVENT_READ for a coroutine waiting to receive data
     *                   (the default), or SWOOLE_EVENT_WRITE for a coroutine waiting to send data.
     * @return bool Returns TRUE on success, or FALSE on failure (e.g., when no coroutine is waiting on the socket for
     *              the given type of operation).
     * @since 4.4.0
     */
    public function cancel(int $event = SWOOLE_EVENT_READ): bool
    {
    }

    /**
     * Close the socket.
     *
     * @return bool Returns TRUE on success, or FALSE if the socket is owned by another object (e.g., when it's
     *              retrieved through method \Swoole\Coroutine\Client::exportSocket() or method
     *              \Swoole\Process::exportSocket()) and thus can't be closed directly.
     * @see \Swoole\Coroutine\Client::exportSocket()
     * @see \Swoole\Process::exportSocket()
     */
    public function close(): bool
    {
    }

    /**
     * Get the address and port of the remote endpoint the socket is connected to.
     *
     * @return array|false If succeeds, return an array with two fields in it: "address" and "port"; otherwise, return
     *                     FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::getsockname()
     */
    public function getpeername(): array|false
    {
    }

    /**
     * Get the local address and port that the socket is bound to.
     *
     * @return array|false If succeeds, return an array with two fields in it: "address" and "port"; otherwise, return
     *                     FALSE, with properties $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Socket::getpeername()
     */
    public function getsockname(): array|false
    {
    }

    /**
     * Check if the socket is closed.
     *
     * @return bool Returns true if the socket is closed, false otherwise.
     * @since 4.8.3
     */
    public function isClosed(): bool
    {
    }

    /**
     * Create a \Swoole\Coroutine\Socket object out of an existing PHP stream.
     *
     * The stream must wrap a socket (e.g., one created by function \stream_socket_client() or \stream_socket_server()).
     *
     * @param mixed $stream A PHP stream resource that wraps a socket.
     * @return Socket|false Returns a new \Swoole\Coroutine\Socket object on success, or FALSE if the given stream
     *                      doesn't wrap a socket or its details can't be retrieved.
     * @since 5.0.0
     */
    public static function import($stream): Socket|false
    {
    }
}
