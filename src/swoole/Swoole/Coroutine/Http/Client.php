<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\Coroutine\Socket;
use Swoole\WebSocket\Frame;

/**
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Http\Client" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Http\Client
 */
class Client
{
    /**
     * The socket object of the client.
     *
     * It's set once the client is connected to the server, and reset back to NULL when the underlying socket is
     * destroyed.
     *
     * @since 5.0.2
     */
    public ?Socket $socket = null;

    /**
     * Error code of the last failed operation; 0 when there is no error.
     *
     * The error codes are compatible with the operating system's error numbers (e.g., ECONNREFUSED), plus Swoole's own
     * SWOOLE_ERROR_* error codes.
     *
     * @see \Swoole\Coroutine\Http\Client::$errMsg
     */
    public int $errCode = 0;

    /**
     * Error message of the last failed operation; an empty string when there is no error.
     *
     * @see \Swoole\Coroutine\Http\Client::$errCode
     */
    public string $errMsg = '';

    /**
     * Whether the client is currently connected to the server.
     */
    public bool $connected = false;

    /**
     * The host name or IP address of the server, as passed to the constructor.
     */
    public string $host = '';

    /**
     * The port of the server, as passed to the constructor.
     */
    public int $port = 0;

    /**
     * Whether SSL/TLS encryption is used for the connection, as passed to the constructor.
     */
    public bool $ssl = false;

    /**
     * Settings of the client.
     *
     * It's NULL until method Client::set() is called.
     *
     * @see \Swoole\Coroutine\Http\Client::set()
     */
    public ?array $setting = null;

    /**
     * The HTTP method to use for the next request, e.g., "GET" or "POST".
     *
     * It's NULL until set, either explicitly using method Client::setMethod(), or implicitly by methods like
     * Client::get(), Client::post(), and Client::upgrade(). When NULL, the request is sent using method "GET" (or
     * "POST" when there is a request body).
     *
     * @see \Swoole\Coroutine\Http\Client::setMethod()
     */
    public ?string $requestMethod = null;

    /**
     * The HTTP headers to send with the requests, as set using method Client::setHeaders().
     *
     * It's NULL until headers are set.
     *
     * @see \Swoole\Coroutine\Http\Client::setHeaders()
     */
    public ?array $requestHeaders = null;

    /**
     * The body of the next request, as set using method Client::setData() or Client::post().
     *
     * It's NULL until a request body is set. An array value is sent as an urlencoded form (or as a multipart/form-data
     * form when files have been added).
     *
     * @see \Swoole\Coroutine\Http\Client::setData()
     * @see \Swoole\Coroutine\Http\Client::post()
     */
    public string|array|null $requestBody = null;

    /**
     * The files to upload with the next request, as added using methods Client::addFile() and Client::addData(). Each
     * entry is an associative array describing one file.
     *
     * It's NULL until a file is added; it's reset back to NULL once the request is sent.
     *
     * @see \Swoole\Coroutine\Http\Client::addFile()
     * @see \Swoole\Coroutine\Http\Client::addData()
     */
    public ?array $uploadFiles = null;

    /**
     * Path of the local file the response body of the next request is written to, as set using method
     * Client::download().
     *
     * It's NULL until a download is requested; it's reset back to NULL once the download finishes.
     *
     * @see \Swoole\Coroutine\Http\Client::download()
     */
    public ?string $downloadFile = null;

    /**
     * Offset in bytes where writing starts in the download file, as set using method Client::download().
     *
     * @see \Swoole\Coroutine\Http\Client::download()
     */
    public int $downloadOffset = 0;

    /**
     * HTTP status code of the last response (e.g., 200, 404), or a negative value when the last request failed.
     *
     * For failed requests, the value is one of the SWOOLE_HTTP_CLIENT_ESTATUS_* constants:
     *   - SWOOLE_HTTP_CLIENT_ESTATUS_CONNECT_FAILED (-1): failed to connect to the server.
     *   - SWOOLE_HTTP_CLIENT_ESTATUS_REQUEST_TIMEOUT (-2): the request timed out.
     *   - SWOOLE_HTTP_CLIENT_ESTATUS_SERVER_RESET (-3): the connection was reset by the server.
     *   - SWOOLE_HTTP_CLIENT_ESTATUS_SEND_FAILED (-4): failed to send the request.
     */
    public int $statusCode = 0;

    /**
     * The HTTP headers of the last response, with all header names in lowercase by default (setting "lowercase_header"
     * controls this behavior).
     *
     * It's NULL before the first response arrives; it's reset back to NULL each time a new request is sent.
     */
    public ?array $headers = null;

    /**
     * The raw values of the "Set-Cookie" headers of the last response.
     *
     * It's NULL when the last response carries no "Set-Cookie" header; it's reset back to NULL each time a new request
     * is sent.
     *
     * @see \Swoole\Coroutine\Http\Client::$cookies
     */
    public ?array $set_cookie_headers = null;

    /**
     * The cookies of the client, as name/value pairs.
     *
     * It holds the cookies set using method Client::setCookies(), plus the cookies parsed (and urldecoded) from the
     * "Set-Cookie" headers of responses. It's NULL until a cookie is set or received.
     *
     * @see \Swoole\Coroutine\Http\Client::setCookies()
     * @see \Swoole\Coroutine\Http\Client::$set_cookie_headers
     */
    public ?array $cookies = null;

    /**
     * The body of the last response.
     *
     * It's reset back to an empty string each time a new request is sent. When the response is saved to a file using
     * method Client::download(), the body goes to the file instead of this property.
     *
     * @see \Swoole\Coroutine\Http\Client::getBody()
     * @see \Swoole\Coroutine\Http\Client::download()
     */
    public string $body = '';

    /**
     * Create a coroutine HTTP client.
     *
     * The client doesn't connect to the server until the first request is sent.
     *
     * @param string $host The host name or IP address of the server. It must not be empty.
     * @param int $port The port of the server.
     * @param bool $ssl Whether to use SSL/TLS encryption. Before Swoole 6.2.0, this option was available only when
     *                  Swoole was installed with configuration option "--enable-openssl" included; since Swoole
     *                  6.2.0, OpenSSL support is always built in, so this option is always available.
     * @throws \Swoole\Coroutine\Http\Client\Exception When the host is empty. Before Swoole 6.2.0, it was also
     *                                                 thrown when SSL/TLS was requested but Swoole was installed
     *                                                 without OpenSSL support.
     */
    public function __construct(string $host, int $port = 0, bool $ssl = false)
    {
    }

    /**
     * Destructor of the client.
     *
     * There is no need to call this method directly. The underlying connection is closed automatically when the
     * client object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Update client settings.
     *
     * The settings given are merged into property $setting.
     *
     * @param array $settings Client settings, e.g., "timeout", "keep_alive", "websocket_mask", "websocket_compression",
     *                        "http_compression", "body_decompression", "lowercase_header", and socket options.
     * @return bool Return TRUE on success; return FALSE when an empty array is given.
     * @see \Swoole\Coroutine\Http\Client::$setting
     */
    public function set(array $settings): bool
    {
    }

    /**
     * Check if defer mode is enabled.
     *
     * @return bool Return TRUE when defer mode is enabled; return FALSE otherwise.
     * @see \Swoole\Coroutine\Http\Client::setDefer()
     */
    public function getDefer(): bool
    {
    }

    /**
     * Enable or disable defer mode.
     *
     * In defer mode, methods sending a request (e.g., Client::execute(), Client::get(), and Client::post()) return
     * right after the request is sent, without waiting for the response; call method Client::recv() to wait for and
     * process the response when needed.
     *
     * @param bool $defer Whether to enable defer mode.
     * @return bool Return TRUE always.
     * @see \Swoole\Coroutine\Http\Client::getDefer()
     * @see \Swoole\Coroutine\Http\Client::recv()
     */
    public function setDefer(bool $defer = true): bool
    {
    }

    /**
     * Set the HTTP method to use for the next request.
     *
     * The method applies to the next request only; it's reset once the request is sent.
     *
     * @param string $method An HTTP method, e.g., "GET", "POST", or "DELETE", in uppercase.
     * @return bool Return TRUE always.
     * @see \Swoole\Coroutine\Http\Client::$requestMethod
     */
    public function setMethod(string $method): bool
    {
    }

    /**
     * Set the HTTP headers to send with the requests.
     *
     * The headers apply to every request sent afterwards, until replaced by another call to this method.
     *
     * @param array $headers The HTTP headers, as name/value pairs.
     * @return bool Return TRUE always.
     * @see \Swoole\Coroutine\Http\Client::$requestHeaders
     */
    public function setHeaders(array $headers): bool
    {
    }

    /**
     * Set the username and password for HTTP basic authentication.
     *
     * The credentials are sent with every request afterwards, in header "Authorization".
     *
     * @param string $username The username.
     * @param string $password The password.
     * @since 4.4.0
     */
    public function setBasicAuth(string $username, string $password): void
    {
    }

    /**
     * Set the cookies to send with the requests.
     *
     * The cookies apply to every request sent afterwards. Note that cookies received in responses are merged into the
     * same property $cookies and sent back with subsequent requests automatically.
     *
     * @param array $cookies The cookies, as name/value pairs. Values are urlencoded when the cookies are sent.
     * @return bool Return TRUE always.
     * @see \Swoole\Coroutine\Http\Client::$cookies
     */
    public function setCookies(array $cookies): bool
    {
    }

    /**
     * Set the body of the next request.
     *
     * A request carrying a body is sent using method "POST", unless another method has been set explicitly.
     *
     * @param string|array $data The request body. An array is sent as an urlencoded form (or as a multipart/form-data
     *                           form when files have been added).
     * @return bool Return TRUE always.
     * @see \Swoole\Coroutine\Http\Client::$requestBody
     */
    public function setData(string|array $data): bool
    {
    }

    /**
     * Add a local file to upload (as a multipart/form-data form field) with the next request.
     *
     * @param string $path Path of the file to upload. The file must exist and must not be empty.
     * @param string $name Name of the form field.
     * @param string|null $type MIME type of the file. When not given, it's detected from the file extension.
     * @param string|null $filename File name to report to the server. When not given, the base name of parameter $path
     *                              is used.
     * @param int $offset Offset in bytes from the beginning of the file where the data to upload starts. Default is 0
     *                    (from the beginning of the file).
     * @param int $length Number of bytes to upload. Default is 0, meaning everything from the offset to the end of the
     *                    file.
     * @return bool Return TRUE on success; return FALSE when the file doesn't exist or is empty, or when the
     *              offset/length given exceeds the size of the file.
     * @see \Swoole\Coroutine\Http\Client::$uploadFiles
     * @see \Swoole\Coroutine\Http\Client::addData()
     */
    public function addFile(string $path, string $name, ?string $type = null, ?string $filename = null, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Add in-memory data to upload as a file (a multipart/form-data form field) with the next request.
     *
     * This method works like method Client::addFile(), except that the content is given directly as a string instead
     * of being read from a file on disk.
     *
     * @param string $path Content of the "file" to upload.
     * @param string $name Name of the form field.
     * @param string|null $type MIME type of the content. When not given, "application/octet-stream" is used.
     * @param string|null $filename File name to report to the server. When not given, parameter $name is used.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @see \Swoole\Coroutine\Http\Client::$uploadFiles
     * @see \Swoole\Coroutine\Http\Client::addFile()
     */
    public function addData(string $path, string $name, ?string $type = null, ?string $filename = null): bool
    {
    }

    /**
     * Send an HTTP request to the server, using the method, headers, cookies, and body set beforehand.
     *
     * The client connects to the server automatically if not connected yet. Unless defer mode is enabled, the call
     * waits for the response, which is then available through properties like $statusCode, $headers, and $body (and
     * their getter methods).
     *
     * @param string $path The path (plus optional query string) to request, e.g., "/index.php?a=b".
     * @return bool Return TRUE on success; return FALSE when the request fails — check properties $errCode, $errMsg,
     *              and $statusCode for the reason.
     * @see \Swoole\Coroutine\Http\Client::setMethod()
     * @see \Swoole\Coroutine\Http\Client::setDefer()
     */
    public function execute(string $path): bool
    {
    }

    /**
     * Get the address and port of the remote side of the connection.
     *
     * @return array|false Return an array with the address (key "address") and port (key "port") of the remote side;
     *                     return FALSE when the client is not connected, or when the underlying system call fails.
     * @see \Swoole\Coroutine\Http\Client::getsockname()
     * @since 4.5.0
     */
    public function getpeername(): array|false
    {
    }

    /**
     * Get the local address and port of the connection.
     *
     * @return array|false Return an array with the local address (key "address") and port (key "port") of the
     *                     connection; return FALSE when the client is not connected, or when the underlying system
     *                     call fails.
     * @see \Swoole\Coroutine\Http\Client::getpeername()
     * @since 4.5.0
     */
    public function getsockname(): array|false
    {
    }

    /**
     * Send a GET request to the server.
     *
     * This method works like method Client::execute(), with the HTTP method forced to "GET".
     *
     * @param string $path The path (plus optional query string) to request, e.g., "/index.php?a=b".
     * @return bool Return TRUE on success; return FALSE when the request fails — check properties $errCode, $errMsg,
     *              and $statusCode for the reason.
     * @see \Swoole\Coroutine\Http\Client::execute()
     */
    public function get(string $path): bool
    {
    }

    /**
     * Send a POST request to the server.
     *
     * This method works like method Client::execute(), with the HTTP method forced to "POST" and the request body set
     * to parameter $data.
     *
     * @param string $path The path (plus optional query string) to request, e.g., "/index.php?a=b".
     * @param mixed $data The request body, either a string or an array. An array is sent as an urlencoded form (or as
     *                    a multipart/form-data form when files have been added).
     * @return bool Return TRUE on success; return FALSE when the request fails — check properties $errCode, $errMsg,
     *              and $statusCode for the reason.
     * @see \Swoole\Coroutine\Http\Client::execute()
     * @see \Swoole\Coroutine\Http\Client::setData()
     */
    public function post(string $path, mixed $data): bool
    {
    }

    /**
     * Send a request to the server, saving the response body to a local file.
     *
     * The response body is written to the file piece by piece as it arrives, instead of being accumulated in property
     * $body; this keeps memory usage low regardless of the size of the download.
     *
     * @param string $path The path (plus optional query string) to request, e.g., "/download.php?id=1".
     * @param string $file Path of the local file to write the response body to. The file is created if it doesn't
     *                     exist.
     * @param int $offset Offset in bytes where writing starts in the file; the file is truncated first when 0 (the
     *                    default) is given. This option can be used to resume a partial download.
     * @return bool Return TRUE on success; return FALSE when the request fails — check properties $errCode, $errMsg,
     *              and $statusCode for the reason.
     * @see \Swoole\Coroutine\Http\Client::$downloadFile
     * @see \Swoole\Coroutine\Http\Client::$downloadOffset
     */
    public function download(string $path, string $file, int $offset = 0): bool
    {
    }

    /**
     * Get the body of the last response, i.e., the current value of property $body.
     *
     * @return string|false The body of the last response; an empty string when no response has been received. Although
     *                      the return type is declared as "string|false", in practice the method never returns FALSE —
     *                      it simply returns the current value of property $body.
     * @see \Swoole\Coroutine\Http\Client::$body
     */
    public function getBody(): string|false
    {
    }

    /**
     * Get the HTTP headers of the last response, i.e., the current value of property $headers.
     *
     * @return array|false|null The headers of the last response, with all header names in lowercase by default; NULL
     *                          when no response has been received. Although the return type is declared as
     *                          "array|false|null", in practice the method never returns FALSE — it simply returns the
     *                          current value of property $headers.
     * @see \Swoole\Coroutine\Http\Client::$headers
     */
    public function getHeaders(): array|false|null
    {
    }

    /**
     * Get the cookies of the client, i.e., the current value of property $cookies.
     *
     * @return array|false|null The cookies as name/value pairs; NULL when no cookie has been set or received. Although
     *                          the return type is declared as "array|false|null", in practice the method never returns
     *                          FALSE — it simply returns the current value of property $cookies.
     * @see \Swoole\Coroutine\Http\Client::$cookies
     */
    public function getCookies(): array|false|null
    {
    }

    /**
     * Get the HTTP status code of the last response, i.e., the current value of property $statusCode.
     *
     * @return int|false The status code of the last response (e.g., 200, 404), or a negative
     *                   SWOOLE_HTTP_CLIENT_ESTATUS_* value when the last request failed. Although the return type is
     *                   declared as "int|false", in practice the method never returns FALSE — it simply returns the
     *                   current value of property $statusCode.
     * @see \Swoole\Coroutine\Http\Client::$statusCode
     */
    public function getStatusCode(): int|false
    {
    }

    /**
     * Get the raw head of the last request sent, i.e., the request line and the request headers.
     *
     * @return string|false Return the raw head of the last request; return FALSE when no request has been sent yet.
     */
    public function getHeaderOut(): string|false
    {
    }

    /**
     * Get the SSL/TLS certificate of the server.
     *
     * Before Swoole 6.2.0, this method was available only when Swoole was installed with configuration option
     * "--enable-openssl" included; since Swoole 6.2.0, OpenSSL support is always built in, so this method is always
     * available.
     *
     * @return string|false Return the certificate of the server in PEM format; return FALSE when the client is not
     *                      connected, or when the server has no certificate.
     * @since 4.5.0
     */
    public function getPeerCert(): string|false
    {
    }

    /**
     * Upgrade the connection to the WebSocket protocol by performing a handshake with the server.
     *
     * Once upgraded, use methods Client::push() and Client::recv() to exchange WebSocket messages with the server.
     * Defer mode is turned off by this method.
     *
     * @param string $path The path to send the handshake request to, e.g., "/websocket".
     * @return bool Return TRUE on success; return FALSE when the handshake fails — check properties $errCode, $errMsg,
     *              and $statusCode for the reason.
     * @see \Swoole\Coroutine\Http\Client::push()
     * @see \Swoole\Coroutine\Http\Client::recv()
     */
    public function upgrade(string $path): bool
    {
    }

    /**
     * Send data to the server over the WebSocket connection.
     *
     * This method works only after the connection has been upgraded to the WebSocket protocol using method
     * Client::upgrade().
     *
     * @param mixed $data Data to be sent to the server, either a string or a \Swoole\WebSocket\Frame object. When a
     *                    Frame object is given, parameters $opcode and $flags are ignored, and the properties of the
     *                    frame are used instead.
     * @param int $opcode Type of the WebSocket frame, defined as SWOOLE_WEBSOCKET_OPCODE_* constants. It defaults to
     *                    SWOOLE_WEBSOCKET_OPCODE_TEXT.
     * @param int $flags A bitmask of the SWOOLE_WEBSOCKET_FLAG_* constants. It defaults to SWOOLE_WEBSOCKET_FLAG_FIN,
     *                   marking the frame as the final fragment of a message.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the connection has not been upgraded
     *              to the WebSocket protocol, or when sending fails.
     * @see \Swoole\Coroutine\Http\Client::upgrade()
     * @see \Swoole\WebSocket\Frame
     */
    public function push(mixed $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): bool
    {
    }

    /**
     * Receive a response (in defer mode) or a WebSocket message.
     *
     * This method serves two purposes:
     *   - In defer mode, it waits for the response of the request sent beforehand, and returns a boolean indicating
     *     whether the response has been received and processed successfully.
     *   - On a connection upgraded to the WebSocket protocol, it waits for a message from the server, and returns it
     *     as a \Swoole\WebSocket\Frame object.
     *
     * Since Swoole 6.1.0, a message split by the server into several frames is reassembled automatically, so the frame
     * returned always carries the complete message. Control frames are handled automatically and are not returned to
     * the caller either: an incoming ping frame is answered with a pong frame, an incoming close frame is answered with
     * a close frame, and an incoming pong frame is simply skipped. To receive them yourself instead, turn on the
     * corresponding "open_websocket_ping_frame", "open_websocket_pong_frame", or "open_websocket_close_frame" setting
     * through method \Swoole\Coroutine\Http\Client::set().
     *
     * The return type of this method changed in Swoole 6.1.0:
     *   - before: public function recv(float $timeout = 0): Frame|bool
     *   - now:    public function recv(float $timeout = 0): Frame|bool|string
     *
     * The extra string type covers a case that used to be indistinguishable from an error: an empty string is now
     * returned when the server closed the connection, while FALSE still means an actual failure or a timeout.
     *
     * @param float $timeout Timeout in seconds. 0 means to use the timeout setting of the client; -1 means never
     *                       timeout.
     * @return Frame|bool|string Return a \Swoole\WebSocket\Frame object (WebSocket connections) or TRUE (defer mode) on
     *                           success; return an empty string when the server closed the WebSocket connection; return
     *                           FALSE when failed, or when the operation times out — check properties $errCode and
     *                           $errMsg for the reason.
     * @see \Swoole\Coroutine\Http\Client::setDefer()
     * @see \Swoole\Coroutine\Http\Client::upgrade()
     * @see \Swoole\Coroutine\Http\Client::ping()
     * @see \Swoole\Coroutine\Http\Client::disconnect()
     * @see \Swoole\WebSocket\Frame
     */
    public function recv(float $timeout = 0): Frame|bool|string
    {
    }

    /**
     * Send a ping frame to the server to check that the connection is still alive.
     *
     * The server is expected to answer with a pong frame carrying the same payload back. The connection must have been
     * upgraded to the WebSocket protocol first.
     *
     * @param string $data Payload to put in the ping frame, which the server is expected to echo back in its pong
     *                     frame. It must not exceed 125 bytes, as the WebSocket protocol requires of control frames.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., the connection is not an established WebSocket
     *              connection).
     * @see \Swoole\Coroutine\Http\Client::upgrade()
     * @see \Swoole\Coroutine\Http\Client::push()
     * @see \Swoole\Coroutine\Http\Client::disconnect()
     * @see SWOOLE_WEBSOCKET_OPCODE_PING
     * @since 6.1.0
     */
    public function ping(string $data = ''): bool
    {
    }

    /**
     * Close a WebSocket connection by sending a close frame to the server first.
     *
     * Unlike method \Swoole\Coroutine\Http\Client::close(), which drops the connection right away, this method performs
     * the closing handshake the WebSocket protocol asks for: it tells the server why the connection is going away, and
     * only then closes it. The connection is closed regardless of whether the close frame could be sent.
     *
     * @param int $code Close status code telling the server why the connection is being closed. Swoole defines the
     *                  status codes of the WebSocket protocol as SWOOLE_WEBSOCKET_CLOSE_* constants.
     * @param string $reason A short, human-readable explanation of why the connection is being closed.
     * @return bool Return TRUE when the close frame was sent successfully, or FALSE otherwise (e.g., the connection is
     *              not an established WebSocket connection).
     * @see \Swoole\Coroutine\Http\Client::close()
     * @see \Swoole\Coroutine\Http\Client::ping()
     * @see SWOOLE_WEBSOCKET_CLOSE_NORMAL
     * @since 6.1.0
     */
    public function disconnect(int $code = SWOOLE_WEBSOCKET_CLOSE_NORMAL, string $reason = ''): bool
    {
    }

    /**
     * Close the connection to the server.
     *
     * The client object stays usable after this call: sending another request reconnects automatically.
     *
     * @return bool Return TRUE on success; return FALSE when the connection has been closed already, or when closing
     *              the underlying socket fails.
     */
    public function close(): bool
    {
    }
}
