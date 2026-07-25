<?php

declare(strict_types=1);

namespace Swoole\Http;

use Swoole\Coroutine\Socket;
use Swoole\WebSocket\Frame;

/**
 * The HTTP Response class.
 *
 * @not-serializable Objects of this class cannot be serialized.
 */
class Response
{
    /**
     * File descriptor of the underlying socket connection.
     */
    public int $fd = 0;

    /**
     * The socket object of the underlying connection.
     *
     * It's set only when the response is served by a coroutine HTTP server, or when the Response object is created
     * from a \Swoole\Coroutine\Socket object using method Response::create(); it's NULL otherwise.
     *
     * @see \Swoole\Http\Response::create()
     * @since 4.4.0
     */
    public ?Socket $socket = null;

    /**
     * HTTP headers of the response.
     *
     * It's NULL until method Response::initHeader() is called or a header is set.
     */
    public ?array $header = null;

    /**
     * HTTP cookies of the response, as a list of "Set-Cookie" header values.
     *
     * It's NULL until method Response::initHeader() is called or a cookie is set.
     */
    public ?array $cookie = null;

    /**
     * Trailer fields.
     *
     * Trailer fields can be useful for supplying message integrity checks, digital signatures, delivery metrics, or
     * post-processing status information. They are included at the end of the response message.
     *
     * It's NULL until method Response::initHeader() is called or a trailer is set.
     *
     * @see https://httpwg.org/specs/rfc9110.html#trailer.fields HTTP Semantics (#trailer.fields)
     * @see https://httpwg.org/specs/rfc9112.html#chunked.trailer.section HTTP/1.1 (#chunked.trailer.section)
     */
    public ?array $trailer = null;

    /**
     * Update property $header, $cookie and $trailer to the latest values.
     *
     * This method provides a way to access headers, cookies, and trailers of the HTTP response. When needed, call
     * this method first before accessing property $header, $cookie, and/or $trailer.
     *
     * This method won't work if
     *   - the server has finished processing the request and sending the response, or
     *   - the underlying HTTP connection has been detached.
     *
     * @return bool Return TRUE on success; return FALSE on failure.
     */
    public function initHeader(): bool
    {
    }

    /**
     * Check if the Response object is still writable.
     *
     * The Response object is still writable unless
     *   - the server has finished processing the request and sending the response, or
     *   - the underlying HTTP connection has been detached.
     *
     * Once the Response object is not writable anymore, every method writing to the response (e.g., initHeader(),
     * header(), trailer(), status(), write(), sendfile(), redirect(), and end()) fails and returns FALSE. e.g.,
     * ```php
     * $server = new \Swoole\Http\Server('0.0.0.0', 9501);
     *
     * $server->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
     *   var_dump($response->isWritable()); // true
     *   $response->end('OK');
     *   var_dump($response->isWritable()); // false
     *   $response->setStatusCode(403);     // This won't work; the method call returns FALSE.
     * });
     *
     * $server->start();
     * ```
     *
     * @see \Swoole\Http\Response::end()
     * @see \Swoole\Http\Response::detach()
     * @since 4.6.0
     */
    public function isWritable(): bool
    {
    }

    /**
     * Set a cookie.
     *
     * This method is exactly the same as method $this->rawcookie() except that the cookie value will be automatically
     * urlencoded when set.
     *
     * @alias This method has an alias of \Swoole\Http\Response::setCookie().
     * @param Cookie|string $name_or_object The name of the cookie as a string, or a Cookie object. When a Cookie
     *                                      object is given, the rest of the parameters are ignored.
     *                                      Only string values were accepted before Swoole 6.0.0.
     * @param string $value The value of the cookie. When an empty string is given, the cookie is marked as deleted
     *                      (expired immediately).
     * @param int $expires When the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie
     *                     that is discarded when the browser is closed.
     * @param string $path The path on the server the cookie applies to.
     * @param string $domain The domain the cookie applies to.
     * @param bool $secure Whether the cookie should only be sent over HTTPS connections.
     * @param bool $httponly Whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly"
     *                       attribute).
     * @param string $samesite The "SameSite" attribute of the cookie: one of "Strict", "Lax", or "None". An empty
     *                         string (the default) omits the attribute.
     * @param string $priority The "Priority" attribute of the cookie: one of "Low", "Medium", or "High". An empty
     *                         string (the default) omits the attribute.
     * @param bool $partitioned Specifies whether the cookie should be stored using partitioned storage.
     *                          Available since Swoole 6.0.0; prior versions did not support partitioned storage for cookies.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the response has been finished or
     *              detached, or when the cookie can't be serialized (no name set, an attribute containing illegal
     *              characters, or an expiration year beyond 9999).
     * @see \Swoole\Http\Response::setCookie()
     * @see \Swoole\Http\Response::rawcookie()
     * @see \Swoole\Http\Cookie
     */
    public function cookie(Cookie|string $name_or_object, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '', bool $partitioned = false): bool
    {
    }

    /**
     * Set a cookie.
     *
     * @alias Alias of method \Swoole\Http\Response::cookie().
     * @param Cookie|string $name_or_object The name of the cookie as a string, or a Cookie object. When a Cookie
     *                                      object is given, the rest of the parameters are ignored.
     *                                      Only string values were accepted before Swoole 6.0.0.
     * @param string $value The value of the cookie. When an empty string is given, the cookie is marked as deleted
     *                      (expired immediately).
     * @param int $expires When the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie
     *                     that is discarded when the browser is closed.
     * @param string $path The path on the server the cookie applies to.
     * @param string $domain The domain the cookie applies to.
     * @param bool $secure Whether the cookie should only be sent over HTTPS connections.
     * @param bool $httponly Whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly"
     *                       attribute).
     * @param string $samesite The "SameSite" attribute of the cookie: one of "Strict", "Lax", or "None". An empty
     *                         string (the default) omits the attribute.
     * @param string $priority The "Priority" attribute of the cookie: one of "Low", "Medium", or "High". An empty
     *                         string (the default) omits the attribute.
     * @param bool $partitioned Specifies whether the cookie should be stored using partitioned storage.
     *                          Available since Swoole 6.0.0; prior versions did not support partitioned storage for cookies.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the response has been finished or
     *              detached, or when the cookie can't be serialized (no name set, an attribute containing illegal
     *              characters, or an expiration year beyond 9999).
     * @see \Swoole\Http\Response::cookie()
     * @see \Swoole\Http\Cookie
     * @since 4.4.0
     */
    public function setCookie(Cookie|string $name_or_object, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '', bool $partitioned = false): bool
    {
    }

    /**
     * Set a cookie without urlencoding the cookie value.
     *
     * This method is exactly the same as method $this->cookie() except that the cookie value will not be automatically
     * urlencoded when set.
     *
     * @alias This method has an alias of \Swoole\Http\Response::setRawCookie().
     * @param Cookie|string $name_or_object The name of the cookie as a string, or a Cookie object. When a Cookie
     *                                      object is given, the rest of the parameters are ignored.
     *                                      Only string values were accepted before Swoole 6.0.0.
     * @param string $value The value of the cookie. It must not contain illegal characters (control characters and
     *                      the characters ",", ";", " ", "\t", "\r", "\n", "\013", and "\014"), since the value is not
     *                      urlencoded by this method. When an empty string is given, the cookie is marked as deleted
     *                      (expired immediately).
     * @param int $expires When the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie
     *                     that is discarded when the browser is closed.
     * @param string $path The path on the server the cookie applies to.
     * @param string $domain The domain the cookie applies to.
     * @param bool $secure Whether the cookie should only be sent over HTTPS connections.
     * @param bool $httponly Whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly"
     *                       attribute).
     * @param string $samesite The "SameSite" attribute of the cookie: one of "Strict", "Lax", or "None". An empty
     *                         string (the default) omits the attribute.
     * @param string $priority The "Priority" attribute of the cookie: one of "Low", "Medium", or "High". An empty
     *                         string (the default) omits the attribute.
     * @param bool $partitioned Specifies whether the cookie should be stored using partitioned storage.
     *                          Available since Swoole 6.0.0; prior versions did not support partitioned storage for cookies.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the response has been finished or
     *              detached, or when the cookie can't be serialized (no name set, an attribute containing illegal
     *              characters, or an expiration year beyond 9999).
     * @see \Swoole\Http\Response::setRawCookie()
     * @see \Swoole\Http\Response::cookie()
     * @see \Swoole\Http\Cookie
     */
    public function rawcookie(Cookie|string $name_or_object, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '', bool $partitioned = false): bool
    {
    }

    /**
     * Set a cookie without urlencoding the cookie value.
     *
     * @alias Alias of method \Swoole\Http\Response::rawcookie().
     * @param Cookie|string $name_or_object The name of the cookie as a string, or a Cookie object. When a Cookie
     *                                      object is given, the rest of the parameters are ignored.
     * @param string $value The value of the cookie. It must not contain illegal characters (control characters and
     *                      the characters ",", ";", " ", "\t", "\r", "\n", "\013", and "\014"), since the value is not
     *                      urlencoded by this method. When an empty string is given, the cookie is marked as deleted
     *                      (expired immediately).
     * @param int $expires When the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie
     *                     that is discarded when the browser is closed.
     * @param string $path The path on the server the cookie applies to.
     * @param string $domain The domain the cookie applies to.
     * @param bool $secure Whether the cookie should only be sent over HTTPS connections.
     * @param bool $httponly Whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly"
     *                       attribute).
     * @param string $samesite The "SameSite" attribute of the cookie: one of "Strict", "Lax", or "None". An empty
     *                         string (the default) omits the attribute.
     * @param string $priority The "Priority" attribute of the cookie: one of "Low", "Medium", or "High". An empty
     *                         string (the default) omits the attribute.
     * @param bool $partitioned Specifies whether the cookie should be stored using partitioned storage.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the response has been finished or
     *              detached, or when the cookie can't be serialized (no name set, an attribute containing illegal
     *              characters, or an expiration year beyond 9999).
     * @see \Swoole\Http\Response::rawcookie()
     * @see \Swoole\Http\Cookie
     * @since 6.0.0
     */
    public function setRawCookie(Cookie|string $name_or_object, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = '', bool $partitioned = false): bool
    {
    }

    /**
     * Set HTTP status code.
     *
     * @param int $http_code HTTP status code. For an HTTP/1.x response, a reason phrase must be given as well when the
     *                       status code is not one of the codes known to Swoole; otherwise the status line falls back
     *                       to "200 OK". For an HTTP/2 response, the status code is always sent as is.
     * @param string $reason The reason phrase to be used with the provided status code. Optional.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., if the HTTP connection has been closed or detached).
     * @alias This method has an alias of \Swoole\Http\Response::setStatusCode().
     * @see \Swoole\Http\Response::setStatusCode()
     */
    public function status(int $http_code, string $reason = ''): bool
    {
    }

    /**
     * Set HTTP status code.
     *
     * @param int $http_code HTTP status code. For an HTTP/1.x response, a reason phrase must be given as well when the
     *                       status code is not one of the codes known to Swoole; otherwise the status line falls back
     *                       to "200 OK". For an HTTP/2 response, the status code is always sent as is.
     * @param string $reason The reason phrase to be used with the provided status code. Optional.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., if the HTTP connection has been closed or detached).
     * @alias Alias of method \Swoole\Http\Response::status().
     * @see \Swoole\Http\Response::status()
     * @since 4.4.0
     */
    public function setStatusCode(int $http_code, string $reason = ''): bool
    {
    }

    /**
     * Set an HTTP header.
     *
     * Note: since Swoole 6.1.5, setting the "Content-Encoding" header manually turns off Swoole's automatic
     * compression of the response body entirely; the server assumes you have already compressed (encoded) the
     * response body yourself to match the declared encoding. Before 6.1.5, automatic compression was skipped only
     * when the "Content-Encoding" header was set to an empty string.
     *
     * @param string $key Name of the header.
     * @param string|array $value Value(s) of the header. When an array is given, the header is sent multiple times,
     *                            once for each value in the array.
     * @param bool $format Format (capitalize) the header name or leave it as is.
     *                     For example, HTTP header name "cOntent-tYpe" is converted to "Content-Type" by default.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @alias This method has an alias of \Swoole\Http\Response::setHeader().
     * @see \Swoole\Http\Response::setHeader()
     */
    public function header(string $key, string|array $value, bool $format = true): bool
    {
    }

    /**
     * Set an HTTP header.
     *
     * Note: since Swoole 6.1.5, setting the "Content-Encoding" header manually turns off Swoole's automatic
     * compression of the response body entirely; the server assumes you have already compressed (encoded) the
     * response body yourself to match the declared encoding. Before 6.1.5, automatic compression was skipped only
     * when the "Content-Encoding" header was set to an empty string.
     *
     * @param string $key Name of the header.
     * @param string|array $value Value(s) of the header. When an array is given, the header is sent multiple times,
     *                            once for each value in the array.
     * @param bool $format Format (capitalize) the header name or leave it as is.
     *                     For example, HTTP header name "cOntent-tYpe" is converted to "Content-Type" by default.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @alias Alias of method \Swoole\Http\Response::header().
     * @see \Swoole\Http\Response::header()
     * @since 4.4.0
     */
    public function setHeader(string $key, string|array $value, bool $format = true): bool
    {
    }

    /**
     * Add a trailer to the HTTP response.
     *
     * @param string $key Name of the trailer field. It must be less than 128 bytes in length.
     * @param string|null $value Value of the trailer field. When NULL is given, the field is recorded without a value.
     *                           Although Swoole declares this parameter as a non-nullable string, NULL is accepted at
     *                           runtime.
     * @return bool TRUE on success, or FALSE when failed. Typically, it fails because of one of the following reasons:
     *              - Name of the trailer field is too long.
     *              - The server has finished processing the request and sending the response.
     *              - The underlying HTTP connection has been detached.
     */
    public function trailer(string $key, ?string $value): bool
    {
    }

    /**
     * Send a PING frame to the remote peer to check that the connection is still alive.
     *
     * This method works on HTTP/2 connections and, since Swoole 6.1.0, on WebSocket connections as well. On any other
     * kind of connection it fails with an E_WARNING level error.
     *
     * The signature of this method changed in Swoole 6.1.0:
     *   - before: public function ping(): bool
     *   - now:    public function ping(string $data = ''): bool
     *
     * @param string $data Payload to put in the PING frame, which the remote peer is expected to echo back in its PONG
     *                     frame. It is used on WebSocket connections only, and is ignored on HTTP/2 connections.
     * @return bool Return TRUE on success; return FALSE when failed, or when the connection is neither an HTTP/2 nor a
     *              WebSocket connection.
     * @see \Swoole\Http\Response::disconnect()
     * @see \Swoole\Coroutine\Http2\Client::ping()
     */
    public function ping(string $data = ''): bool
    {
    }

    /**
     * Close a WebSocket connection by sending a close frame to the client first.
     *
     * Unlike method \Swoole\Http\Response::close(), which drops the underlying connection right away, this method
     * performs the closing handshake the WebSocket protocol asks for: it tells the client why the connection is going
     * away, and only then closes it. The connection is closed regardless of whether the close frame could be sent.
     *
     * This method works only on a WebSocket connection served by \Swoole\Coroutine\Http\Server; it fails with an
     * E_WARNING level error otherwise.
     *
     * @param int $code Close status code telling the client why the connection is being closed. Swoole defines the
     *                  status codes of the WebSocket protocol as SWOOLE_WEBSOCKET_CLOSE_* constants.
     * @param string $reason A short, human-readable explanation of why the connection is being closed.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., the connection is not a WebSocket connection,
     *              or the close frame could not be sent).
     * @see \Swoole\Http\Response::close()
     * @see \Swoole\Http\Response::ping()
     * @see \Swoole\WebSocket\Server::disconnect()
     * @see SWOOLE_WEBSOCKET_CLOSE_NORMAL
     * @since 6.1.0
     */
    public function disconnect(int $code = SWOOLE_WEBSOCKET_CLOSE_NORMAL, string $reason = ''): bool
    {
    }

    /**
     * Send a GOAWAY frame to the remote peer.
     *
     * This method works only when the HTTP/2 protocol is used.
     *
     * @param int $error_code An HTTP2 error code that contains the reason for closing the connection. HTTP2 error codes are defined as SWOOLE_HTTP2_ERROR_* constants.
     * @param string $debug_data Additional debug data to send to the remote peer.
     * @return bool TRUE on success or FALSE on failure.
     * @see \Swoole\Coroutine\Http2\Client::goaway()
     */
    public function goaway(int $error_code = SWOOLE_HTTP2_ERROR_NO_ERROR, string $debug_data = ''): bool
    {
    }

    /**
     * Send a chunk of the response body to the client using chunked transfer encoding.
     *
     * The first call sends the HTTP headers with header "Transfer-Encoding: chunked" included; each call (including
     * the first one) sends one chunk of the response body. Content compression is turned off as soon as this method
     * is used. Call method Response::end() afterwards to finish the response.
     *
     * Unlike method Response::end(), which sends the whole response body in one single write, this method allows
     * sending a response body of any size; each chunk itself is still subject to server option "buffer_output_size"
     * (or "output_buffer_size").
     *
     * @param string $content The chunk of data to be sent. It must not be empty.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @see \Swoole\Http\Response::end()
     * @see \Swoole\Constant::OPTION_BUFFER_OUTPUT_SIZE
     * @see \Swoole\Constant::OPTION_OUTPUT_BUFFER_SIZE
     */
    public function write(string $content): bool
    {
    }

    /**
     * Send the HTTP response to the client, and finish processing the request.
     *
     * The end() method can be called once only. To send data to the client multiple times, call the method write() instead.
     *
     * If the end() method has never been called when the Response object is destructed, and the response hasn't been
     * detached, Swoole finishes the response automatically, as if end() were called with no content. In that case,
     * status code 500 is used when no status code has been set explicitly.
     *
     * If the request doesn't allow the connection to be kept alive (e.g., an HTTP/1.0 request without header
     * "Connection: keep-alive", or a request carrying header "Connection: close"), the connection is closed after the
     * response is sent.
     *
     * The response body is sent in one single write; for a server running in SWOOLE_PROCESS mode, its size is limited
     * by option "buffer_output_size" (or "output_buffer_size") of the server, which defaults to 4294967295 bytes. If
     * the content is larger than the buffer size, the end() method will return FALSE. There are a few solutions to
     * address the issue:
     *   - Put the content in a file, and use method Response::sendfile() instead.
     *   - Send the content as chunks using method Response::write().
     *   - Set option "buffer_output_size" (or "output_buffer_size") of the server to a larger value.
     *
     * @param string|null $content The content to be sent to the client. If method Response::write() has been called
     *                             before, the content is sent as the last chunk of the response body.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @see \Swoole\Http\Response::sendfile()
     * @see \Swoole\Http\Response::write()
     * @see \Swoole\Constant::OPTION_BUFFER_OUTPUT_SIZE
     * @see \Swoole\Constant::OPTION_OUTPUT_BUFFER_SIZE
     */
    public function end(?string $content = null): bool
    {
    }

    /**
     * Send a file (or part of it) as the body of the HTTP response, and finish processing the request.
     *
     * The file is sent directly from disk without being loaded into PHP memory first, so this method is the preferred
     * way to serve files of any size. Header "Content-Type" is set based on the file extension automatically, unless
     * it has been set explicitly. This method can't be used after method Response::write(); use one or the other.
     *
     * @param string $filename Path to the file to send. It must be a regular file, and must not be empty.
     * @param int $offset Offset in bytes from the beginning of the file where the data to send starts. Default is 0
     *                    (from the beginning of the file).
     * @param int $length Number of bytes to send. Default is 0, meaning everything from the offset to the end of the
     *                    file.
     * @return bool Return TRUE on success; return FALSE when failed, e.g., when the file doesn't exist or is not a
     *              regular file, when the offset/length given exceeds the size of the file, when chunked transfer
     *              encoding is in use (method Response::write() has been called), or when the response has been
     *              finished or detached.
     * @see \Swoole\Http\Response::end()
     * @see \Swoole\Http\Response::write()
     */
    public function sendfile(string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Redirect the client to another URL.
     *
     * This method sets HTTP header "Location", then calls method Response::end() internally. Therefore, the response
     * is finished after this call, and methods like Response::write() and Response::end() won't work anymore.
     *
     * @param string $location The redirect location.
     * @param int $http_code HTTP status code. Default is 302.
     * @return bool Returns true on success or false on failure.
     * @see \Swoole\Http\Response::end()
     * @see \Swoole\Http\Response::isWritable()
     */
    public function redirect(string $location, int $http_code = 302): bool
    {
    }

    /**
     * Detach the underlying HTTP connection from the Response object.
     *
     * Once detached, the Response object is not writable anymore, and Swoole neither sends the response (not even when
     * the Response object is destructed) nor closes the connection. The connection is left open, so that the response
     * can be sent later on, and somewhere else, by
     *   - creating a new Response object bound to the same connection using method Response::create(),
     *   - sending raw data over the connection using method Server::send(), or
     *   - sending raw data over the \Swoole\Coroutine\Socket object held by property $socket (coroutine HTTP servers).
     *
     * @return bool Return TRUE on success, or FALSE when the response has been finished or detached already.
     * @see \Swoole\Http\Response::create()
     * @see \Swoole\Http\Response::isWritable()
     * @see \Swoole\Server::send()
     */
    public function detach(): bool
    {
    }

    /**
     * Create a Response object bound to an existing connection.
     *
     * This method is used together with method Response::detach(), to send the HTTP response of a detached connection
     * from somewhere else (e.g., from a task worker). It can be called in the following ways:
     *   - \Swoole\Http\Response::create(\Swoole\Server $server, int $fd);
     *   - \Swoole\Http\Response::create(\Swoole\Coroutine\Socket $socket);
     *   - \Swoole\Http\Response::create([\Swoole\Server $server, \Swoole\Http\Request $request], int $fd);
     *   - \Swoole\Http\Response::create([\Swoole\Coroutine\Socket $socket, \Swoole\Http\Request $request]);
     *   - \Swoole\Http\Response::create(int $fd);
     *
     * When a \Swoole\Http\Request object is given, the new Response object is bound to the HTTP context of that
     * request; otherwise a brand-new HTTP context is created, with keep-alive turned on.
     *
     * @param int|array|object $server A \Swoole\Server object, a \Swoole\Coroutine\Socket object, one of the two
     *                                 paired with a \Swoole\Http\Request object as a two-element array, or the session
     *                                 ID of a connection of the current server. Passing an object of any other type
     *                                 triggers a warning and makes the method call fail.
     * @param int $fd Session ID of the connection. It is required when a \Swoole\Server object is given, and must
     *                reference an established connection of that server; it is ignored when a
     *                \Swoole\Coroutine\Socket object is given, since the file descriptor is read from the socket.
     * @return Response|false The HTTP response object created, or false on failure.
     * @see \Swoole\Http\Response::detach()
     * @see \Swoole\Server::send()
     */
    public static function create(int|array|object $server = -1, int $fd = -1): Response|false
    {
    }

    /**
     * Upgrade the HTTP connection to the WebSocket protocol by performing a handshake with the client.
     *
     * This method is supported by coroutine HTTP servers only; it fails on asynchronous HTTP servers.
     *
     * @return bool Returns true on success or false on failure.
     * @see \Swoole\Http\Response::push()
     * @see \Swoole\Http\Response::recv()
     * @since 4.4.0
     */
    public function upgrade(): bool
    {
    }

    /**
     * Send data to the client over the attached WebSocket connection.
     *
     * This method works only when the connection has been upgraded to the WebSocket protocol using method
     * Response::upgrade(), which in turn is supported by coroutine HTTP servers only.
     *
     * @param Frame|string $data Data to be sent to the client. When a \Swoole\WebSocket\Frame object is given,
     *                           parameters $opcode and $flags are ignored, and the properties of the frame are used
     *                           instead.
     * @param int $opcode Type of the WebSocket frame, defined as SWOOLE_WEBSOCKET_OPCODE_* constants. It defaults to
     *                    SWOOLE_WEBSOCKET_OPCODE_TEXT, and can't be greater than SWOOLE_WEBSOCKET_OPCODE_PONG.
     * @param int $flags A bitmask of the SWOOLE_WEBSOCKET_FLAG_* constants. It defaults to SWOOLE_WEBSOCKET_FLAG_FIN,
     *                   marking the frame as the final fragment of a message.
     * @return bool Return TRUE on success, or FALSE when failed.
     * @see \Swoole\Http\Response::upgrade()
     * @see \Swoole\WebSocket\Frame
     * @since 4.4.0
     */
    public function push(Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): bool
    {
    }

    /**
     * Receive data from the attached WebSocket connection.
     *
     * Like method Response::push(), this method works only when the connection has been upgraded to the WebSocket
     * protocol using method Response::upgrade().
     *
     * @param float $timeout Timeout in seconds. -1 means never timeout; 0 means to use the default value of option "socket_read_timeout".
     * @return Frame|string|false
     *                            Returns a \Swoole\WebSocket\Frame object when succeeds.
     *                            Returns an empty string when the HTTP connection is closed.
     *                            Returns FALSE when error happens. Use method \swoole_last_error() to get error code.
     * @see \Swoole\Constant::OPTION_SOCKET_READ_TIMEOUT
     * @see \Swoole\WebSocket\Frame
     * @see \swoole_last_error()
     */
    public function recv(float $timeout = 0): Frame|string|false
    {
    }

    /**
     * Close a WebSocket connection.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function close(): bool
    {
    }
}
