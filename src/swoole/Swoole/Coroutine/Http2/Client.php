<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http2;

use Swoole\Coroutine\Socket;
use Swoole\Http2\Request;
use Swoole\Http2\Response;

/**
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Http2\Client" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http2\Client
 */
class Client
{
    public int $errCode = 0;

    public string $errMsg = '';

    public int $sock = -1;

    public int $type = 0;

    public $setting;

    /**
     * The socket object of the client.
     *
     * @since 5.0.2
     */
    public ?Socket $socket;

    public bool $connected = false;

    public $host;

    public int $port = 0;

    /**
     * @since 4.4.0
     */
    public bool $ssl = false;

    /**
     * ID of the last stream that the client has received from the server to shutdown the connection.
     *
     * This property is only set when a GOAWAY frame is received from the server.
     *
     * @since 5.1.8 This property was accessible as a dynamic property in versions prior to Swoole 5.1.8, but it has been explicitly declared as of Swoole 5.1.8.
     */
    public int $serverLastStreamId = 0;

    /**
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

    public function set(array $settings): bool
    {
    }

    public function connect(): bool
    {
    }

    public function stats(string $key = ''): int|array
    {
    }

    public function isStreamExist(int $stream_id): bool
    {
    }

    public function send(Request $request): int|false
    {
    }

    public function write(int $stream_id, mixed $data, bool $end_stream = false): bool
    {
    }

    /**
     * Receive a response from the server.
     *
     * Frames that don't complete a response (SETTINGS, PING, WINDOW_UPDATE, PUSH_PROMISE, and frames belonging to an
     * unknown or already closed stream) are handled internally and don't make this method return; the method keeps
     * waiting for the next frame instead.
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

    public function ping(): bool
    {
    }

    public function close(): bool
    {
    }
}
