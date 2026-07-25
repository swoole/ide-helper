<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\Coroutine\Socket;

/**
 * A coroutine-style HTTP server.
 *
 * Since Swoole 6.2.0, when Swoole is installed with the "--enable-uring-socket" configuration option (which in turn
 * requires the "--enable-iouring" or "--with-liburing-dir" option), the sockets of this server are driven by
 * io_uring, a Linux facility for asynchronous I/O that can reduce the number of system calls needed per request. This
 * changes nothing in how the server is used from PHP.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Http\Server" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http\Server
 * @since 4.4.0
 */
final class Server
{
    /**
     * File descriptor of the listening socket of the server.
     *
     * It's -1 until the server is constructed successfully.
     */
    public int $fd = -1;

    /**
     * The host name or IP address the server is bound to, as passed to the constructor.
     */
    public ?string $host = null;

    /**
     * The port the server listens on.
     *
     * When port 0 (the default) is passed to the constructor, this property holds the actual port picked by the
     * operating system; it's -1 until the server is constructed successfully.
     */
    public int $port = -1;

    /**
     * Whether SSL/TLS encryption is enabled on the server.
     */
    public bool $ssl = false;

    /**
     * Settings of the server.
     *
     * It's NULL until method Server::set() is called, or until the server is constructed with SSL/TLS enabled (which
     * stores setting "open_ssl" here).
     *
     * @see \Swoole\Coroutine\Http\Server::set()
     */
    public ?array $settings = null;

    /**
     * Error code of the last error happening on the listening socket; 0 when there is no error.
     *
     * @see \Swoole\Coroutine\Http\Server::$errMsg
     */
    public int $errCode = 0;

    /**
     * Error message of the last error happening on the listening socket; an empty string when there is no error.
     *
     * @see \Swoole\Coroutine\Http\Server::$errCode
     */
    public string $errMsg = '';

    /**
     * Create a coroutine HTTP server, bind it to the given host and port, and start listening.
     *
     * @param string $host The host name or IP address to bind to. It must not be empty. To listen on a Unix socket,
     *                     use a path prefixed with "unix:" (e.g., "unix:///tmp/server.sock").
     * @param int $port The port to listen on. When 0 (the default) is given for a TCP server, a random port is picked
     *                  by the operating system; check property $port for the actual port used.
     * @param bool $ssl Whether to enable SSL/TLS encryption. Before Swoole 6.2.0, this option was available only
     *                  when Swoole was installed with configuration option "--enable-openssl" included; since Swoole
     *                  6.2.0, OpenSSL support is always built in, so this option is always available.
     * @param bool $reuse_port Whether to allow multiple server processes to listen on the same port (socket option
     *                         SO_REUSEPORT).
     * @throws \Swoole\Exception When the host is empty, or when the server fails to bind to or listen on the given
     *                           host and port. Before Swoole 6.2.0, it was also thrown when SSL/TLS was requested but
     *                           Swoole was installed without OpenSSL support.
     */
    public function __construct(string $host, int $port = 0, bool $ssl = false, bool $reuse_port = false)
    {
    }

    /**
     * Update server settings.
     *
     * The settings given are merged into property $settings; they take effect when method Server::start() is called.
     *
     * @param array $settings Settings to update, e.g., "http_parse_cookie", "http_parse_post", "http_parse_files",
     *                        "http_compression", "upload_tmp_dir", and protocol options of the underlying socket.
     * @return bool Return TRUE on success; return FALSE when an empty array is given.
     * @see \Swoole\Coroutine\Http\Server::$settings
     * @see \Swoole\Coroutine\Http\Server::start()
     */
    public function set(array $settings): bool
    {
    }

    /**
     * Register a callback function to handle the HTTP requests specified by the URL pattern.
     *
     * @param string $pattern The URL pattern to match, e.g., "/index". A request is dispatched to the handler whose
     *                        pattern is a case-insensitive prefix of the request path. Pattern "/" is special: it is
     *                        the fallback handler for requests matching no other pattern. Requests matching no pattern
     *                        at all are answered with a "404 Not Found" response. When multiple patterns (other than
     *                        "/") match the same request path, which handler wins is undefined, so avoid registering
     *                        overlapping patterns.
     * @param callable $callback The callback function to handle the HTTP requests. It is called with two parameters: a
     *                           \Swoole\Http\Request object and a \Swoole\Http\Response object.
     * @return bool Return true on success. Return false on failure.
     *              Before Swoole v6.0.0, it returns void.
     * @see \Swoole\Http\Request
     * @see \Swoole\Http\Response
     */
    public function handle(string $pattern, callable $callback): bool
    {
    }

    /**
     * Start the server, accepting incoming connections in a loop.
     *
     * The call blocks the current coroutine until the server is stopped with method Server::shutdown(), or until an
     * unrecoverable error happens while accepting connections (check properties $errCode and $errMsg in that case).
     * Each incoming connection is handled in a new coroutine.
     *
     * @return bool Return TRUE once the server stops.
     * @see \Swoole\Coroutine\Http\Server::shutdown()
     * @see \Swoole\Coroutine\Http\Server::$errCode
     * @see \Swoole\Coroutine\Http\Server::$errMsg
     */
    public function start(): bool
    {
    }

    /**
     * Stop the server, making method Server::start() return.
     *
     * @see \Swoole\Coroutine\Http\Server::start()
     */
    public function shutdown(): void
    {
    }

    /**
     * Handle an incoming connection: parse the HTTP requests received on it and dispatch them to the registered
     * handlers. This method is used internally by method Server::start(); it runs in a separate coroutine, one for
     * each connection.
     *
     * @param Socket $conn The socket object of the incoming connection. Added since Swoole v5.1.0.
     * @see \Swoole\Coroutine\Http\Server::start()
     */
    private function onAccept(Socket $conn): void
    {
    }
}
