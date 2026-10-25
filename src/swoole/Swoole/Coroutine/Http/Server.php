<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\Coroutine\Socket;

/**
 * A coroutine-style HTTP server.
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
     * Error code of the last error happening on the listening socket; 0 when there is no error. Since Swoole 6.1.10,
     * it is set to SOCKET_EINVAL as well when method Server::start() rejects the settings in property $settings.
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
     * Since Swoole 6.1.11, the constructor can only be called once per object; calling it a second time throws an
     * \Error.
     *
     * @param string $host The host name or IP address to bind to. It must not be empty. To listen on a Unix socket,
     *                     use a path prefixed with "unix:" (e.g., "unix:///tmp/server.sock").
     * @param int $port The port to listen on. When 0 (the default) is given for a TCP server, a random port is picked
     *                  by the operating system; check property $port for the actual port used.
     * @param bool $ssl Whether to enable SSL/TLS encryption. This option is available only when OpenSSL support is
     *                  enabled (i.e., when Swoole is installed with configuration option "--enable-openssl" included).
     * @param bool $reuse_port Whether to allow multiple server processes to listen on the same port (socket option
     *                         SO_REUSEPORT).
     * @throws \Swoole\Exception When the host is empty, when SSL/TLS is requested but Swoole is installed without
     *                           OpenSSL support, or when the server fails to bind to or listen on the given host and
     *                           port.
     */
    public function __construct(string $host, int $port = 0, bool $ssl = false, bool $reuse_port = false)
    {
    }

    /**
     * Update server settings.
     *
     * The settings given are merged into property $settings; they take effect (and, since Swoole 6.1.10, are validated)
     * when method Server::start() is called: an invalid protocol setting makes that method fail with FALSE returned.
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
     *              Before Swoole 6.0.0, it returns void.
     * @see \Swoole\Http\Request
     * @see \Swoole\Http\Response
     */
    public function handle(string $pattern, callable $callback): bool
    {
    }

    /**
     * Start the server, accepting incoming connections in a loop.
     *
     * The settings in property $settings are applied first. The call then blocks the current coroutine until the
     * server is stopped with method Server::shutdown(), or until an unrecoverable error happens while accepting
     * connections. Each incoming connection is handled in a new coroutine.
     *
     * Since Swoole 6.1.11, when an HTTP/1.1 request carries header "Expect: 100-continue", a "100 Continue" interim
     * response is sent back before the server waits for the request body (HTTP/1.0 clients don't understand interim
     * responses, so none is sent to them), and a request whose chunked body grows beyond the "package_max_length"
     * setting is answered with a "413 Request Entity Too Large" response.
     *
     * @return bool Returns TRUE once the server is stopped with method Server::shutdown(). Returns FALSE, with
     *              properties $errCode and $errMsg updated accordingly, in two cases:
     *              - Property $settings holds an invalid protocol setting (e.g., an unknown "package_length_type");
     *              $errCode is set to SOCKET_EINVAL then. Before Swoole 6.1.10, such a setting was reported with a
     *              warning only, and the server started anyway.
     *              - An unrecoverable error happens while accepting a connection (e.g., the SSL context of the
     *              listening socket can't be created because of a bad certificate or key file, which sets $errCode
     *              to SWOOLE_ERROR_SSL_CREATE_CONTEXT_FAILED); a warning is raised as well. Before Swoole 6.1.10, the
     *              method returned TRUE in this case, as if the server had been shut down normally.
     * @see \Swoole\Coroutine\Http\Server::shutdown()
     * @see \Swoole\Coroutine\Http\Server::set()
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
     * @param Socket $conn The socket object of the incoming connection. Added since Swoole 5.1.0.
     * @see \Swoole\Coroutine\Http\Server::start()
     */
    private function onAccept(Socket $conn): void
    {
    }
}
