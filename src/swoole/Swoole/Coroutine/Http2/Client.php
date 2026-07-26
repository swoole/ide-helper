<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http2;

use Swoole\Coroutine\Socket;
use Swoole\Http2\Request;
use Swoole\Http2\Response;

/**
 * Coroutine-friendly HTTP/2 client.
 *
 * This class provides an HTTP/2 client to be used inside coroutines. Requests are described with
 * \Swoole\Http2\Request objects and sent with method send(); responses come back as \Swoole\Http2\Response objects
 * from methods recv() and read(). Multiple requests can be multiplexed concurrently over a single connection, each
 * on its own HTTP/2 stream, and streamed (pipelined) request/response bodies are supported as well.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Http2\Client" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http2\Client
 * @see \Swoole\Http2\Request
 * @see \Swoole\Http2\Response
 */
class Client
{
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
     * Unused. The property is declared for backward compatibility but, as of Swoole 6.2.2, is never updated by
     * Swoole; it always stays -1. Use property $socket to access the underlying connection instead.
     *
     * @see \Swoole\Coroutine\Http2\Client::$socket
     */
    public int $sock = -1;

    /**
     * Unused. The property is declared for backward compatibility but, as of Swoole 6.2.2, is never updated by
     * Swoole; it always stays 0.
     */
    public int $type = 0;

    /**
     * Client settings set through method set(). NULL until set() is called for the first time.
     *
     * @see \Swoole\Coroutine\Http2\Client::set()
     */
    public ?array $setting = null;

    /**
     * The underlying socket object of the client. It stays NULL until method connect() succeeds, and goes back to
     * NULL once the connection is closed.
     *
     * @since 5.0.2
     */
    public ?Socket $socket = null;

    /**
     * TRUE while the client is connected to the server (set by a successful connect() call and cleared when the
     * connection is closed); otherwise FALSE.
     */
    public bool $connected = false;

    /**
     * Host name or IP address of the server to connect to, as passed to the constructor. NULL until the constructor
     * runs.
     */
    public ?string $host = null;

    /**
     * Port of the server to connect to, as passed to the constructor.
     */
    public int $port = 0;

    /**
     * Whether the connection to the server is made over TLS/SSL, as requested through the constructor's $open_ssl
     * parameter.
     *
     * @since 4.4.0
     */
    public bool $ssl = false;

    /**
     * ID of the last stream the server processed (or was still going to process) before shutting the connection down,
     * as reported in the GOAWAY frame received from the server.
     *
     * This property is only set when a GOAWAY frame is received from the server.
     *
     * @since 5.1.8 This property was accessible as a dynamic property in versions prior to Swoole 5.1.8, but it has been explicitly declared as of Swoole 5.1.8.
     */
    public int $serverLastStreamId = 0;

    /**
     * Create a new HTTP/2 client for the given server.
     *
     * The constructor only stores the connection details in properties $host, $port, and $ssl; the actual connection
     * is not established until method connect() is called.
     *
     * A \Swoole\Coroutine\Http2\Client\Exception is thrown when $host is an empty string.
     *
     * @param string $host The target host to connect to.
     * @param int $port The target port to connect to. Defaults to 80.
     * @param bool $open_ssl Whether to establish the connection over TLS/SSL. Before Swoole 6.2.0, setting this to
     *                       TRUE was supported only when Swoole was installed with the configuration option
     *                       "--enable-openssl" included, and the constructor threw a
     *                       \Swoole\Coroutine\Http2\Client\Exception otherwise; since Swoole 6.2.0, OpenSSL support
     *                       is always built in, so this option is always supported.
     */
    public function __construct(string $host, int $port = 80, bool $open_ssl = false)
    {
    }

    /**
     * Destructor of the client.
     *
     * There is no need to call this method directly. The underlying connection is closed automatically when the client
     * object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Set options of the client, e.g., timeout settings or SSL options.
     *
     * The settings are merged into any settings passed to previous calls of this method, and can be changed both
     * before and after connecting.
     *
     * @param array $settings Client settings.
     * @return bool Always TRUE.
     * @see \Swoole\Coroutine\Http2\Client::$setting
     */
    public function set(array $settings): bool
    {
    }

    /**
     * Connect to the server, using the host, port, and SSL flag passed to the constructor, and perform the HTTP/2
     * connection handshake (sending the connection preface and initial settings).
     *
     * @return bool TRUE if the connection is established; otherwise FALSE (e.g., when already connected, or when
     *              the underlying socket fails to connect), with properties $errCode and $errMsg updated
     *              accordingly.
     */
    public function connect(): bool
    {
    }

    /**
     * Get statistics of the HTTP/2 connection.
     *
     * @param string $key An optional field name. When given, only the value of that field is returned. Supported
     *                    field names are "current_stream_id", "last_stream_id", "local_settings",
     *                    "remote_settings", and "active_stream_num".
     * @return int|array The value of the requested field, or (when no field name is given) an array containing all
     *                   the fields listed above.
     */
    public function stats(string $key = ''): int|array
    {
    }

    /**
     * Check if the given HTTP/2 stream exists on the connection.
     *
     * @param int $stream_id ID of the stream to check, as returned by method send(). A value of 0 checks whether
     *                       the connection itself exists.
     * @return bool TRUE if the stream exists (i.e., a request was sent on it and its response hasn't completed
     *              yet); otherwise FALSE.
     * @see \Swoole\Coroutine\Http2\Client::send()
     */
    public function isStreamExist(int $stream_id): bool
    {
    }

    /**
     * Send an HTTP/2 request to the server on a new stream.
     *
     * This method returns as soon as the request has been written out; it doesn't wait for the response. Call
     * method recv() (or read()) to receive the response. Multiple requests can be sent before receiving any
     * response; each request gets its own stream ID.
     *
     * @param Request $request The request to send.
     * @return int|false ID of the HTTP/2 stream created for the request (an odd number, increasing with every
     *                   request), or FALSE on failure (e.g., when the client is not connected), with properties
     *                   $errCode and $errMsg updated accordingly.
     * @see \Swoole\Coroutine\Http2\Client::recv()
     */
    public function send(Request $request): int|false
    {
    }

    /**
     * Write more body data to a stream created in streaming (pipeline) mode.
     *
     * The stream must have been created by sending a request with property $pipeline set to TRUE, and must not have
     * been ended yet.
     *
     * @param int $stream_id ID of the stream to write to, as returned by method send().
     * @param mixed $data The data to write: either a string (sent as is) or an array of form fields (sent
     *                    URL-encoded).
     * @param bool $end_stream Whether to mark the request as finished after writing this piece of data.
     * @return bool TRUE if the data is written out; otherwise FALSE, with properties $errCode and $errMsg updated
     *              accordingly.
     * @see \Swoole\Http2\Request::$pipeline
     */
    public function write(int $stream_id, mixed $data, bool $end_stream = false): bool
    {
    }

    /**
     * Receive a response from the server.
     *
     * Frames that don't complete a response (SETTINGS, PING, WINDOW_UPDATE, PUSH_PROMISE, RST_STREAM, and frames
     * belonging to an unknown or already closed stream) are handled internally and don't make this method return; the
     * method keeps waiting for the next frame instead. Note that this covers streams the server terminates: when an
     * RST_STREAM frame arrives, the affected stream is discarded quietly and no response is handed back for it.
     *
     * @param float $timeout The maximum time to wait for a response (in seconds).
     *                       - > 0: The timeout value in seconds.
     *                       - < 0: No timeout.
     *                       - 0 (the default): Use the read timeout configured on the underlying socket, which is 60
     *                       seconds unless changed through option "timeout" of method \Swoole\Coroutine\Http2\Client::set().
     * @return Response|false Returns a Response object, or FALSE in the following cases:
     *                        - The connection is not established yet, or has been closed already. Property $errCode is
     *                        set to SWOOLE_ERROR_CLIENT_NO_CONNECTION in this case.
     *                        - No complete frame is received within the given timeout, or reading from the socket fails
     *                        (e.g., because the server closed the connection).
     *                        - A GOAWAY frame is received. The connection gets closed, and properties $errCode, $errMsg
     *                        and $serverLastStreamId are updated based on the content of the frame.
     *                        - A received frame can't be handled, e.g., when sending back a SETTINGS/PING
     *                        acknowledgement or a WINDOW_UPDATE frame fails, or when the payload of a gzip-compressed
     *                        DATA frame can't be decompressed.
     *                        Properties $errCode and $errMsg are updated in all the cases above.
     * @see \Swoole\Coroutine\Http2\Client::read()
     */
    public function recv(float $timeout = 0): Response|false
    {
    }

    /**
     * Read a response from the server in pipeline mode.
     *
     * This method behaves the same as method \Swoole\Coroutine\Http2\Client::recv(), except that it returns a Response
     * object as soon as a piece of a pipelined (streamed) response is available, instead of waiting for the whole
     * response to end. Property $pipeline of the returned Response object tells if more pieces are still to come.
     *
     * @param float $timeout The maximum time to wait for a response (in seconds). Please check method
     *                       \Swoole\Coroutine\Http2\Client::recv() for what the values mean.
     * @return Response|false Returns a Response object, or FALSE on failure. Please check method
     *                        \Swoole\Coroutine\Http2\Client::recv() for the exact failure cases.
     * @see \Swoole\Coroutine\Http2\Client::recv()
     * @since 4.5.0
     */
    public function read(float $timeout = 0): Response|false
    {
    }

    /**
     * Send a GOAWAY frame to the remote peer.
     *
     * @param int $error_code An HTTP2 error code that contains the reason for closing the connection. HTTP2 error codes are defined as SWOOLE_HTTP2_ERROR_* constants.
     * @param string $debug_data Additional debug data to send to the remote peer.
     * @return bool TRUE on success or FALSE on failure.
     * @see \Swoole\Http\Response::goaway()
     */
    public function goaway(int $error_code = SWOOLE_HTTP2_ERROR_NO_ERROR, string $debug_data = ''): bool
    {
    }

    /**
     * Send a PING frame to the server, to check the connection or keep it alive.
     *
     * This method only sends the frame; the server's PING acknowledgement is handled internally by recv()/read().
     *
     * @return bool TRUE if the PING frame is sent; otherwise FALSE (e.g., when the client is not connected), with
     *              properties $errCode and $errMsg updated accordingly.
     */
    public function ping(): bool
    {
    }

    /**
     * Close the connection to the server.
     *
     * Any streams still active on the connection are discarded.
     *
     * @return bool TRUE if the connection was open and is now closed; otherwise FALSE (e.g., when there was no open
     *              connection, or when the underlying socket fails to close), with properties $errCode and $errMsg
     *              updated accordingly.
     */
    public function close(): bool
    {
    }
}
