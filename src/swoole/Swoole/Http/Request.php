<?php

declare(strict_types=1);

namespace Swoole\Http;

/**
 * The HTTP Request class.
 *
 * @not-serializable Objects of this class cannot be serialized.
 */
class Request
{
    /**
     * File descriptor (session ID) of the connection the request comes from.
     */
    public int $fd = 0;

    /**
     * Stream ID of the request when the HTTP/2 protocol is used; it stays 0 for HTTP/1.x requests.
     */
    public int $streamId = 0;

    /**
     * The HTTP headers of the request, with all header names in lowercase (e.g., $request->header['user-agent']).
     *
     * It's NULL until the request headers have been parsed.
     */
    public ?array $header = null;

    /**
     * Information about the request and the connection, with all keys in lowercase, e.g., "request_method",
     * "request_uri", "path_info", "query_string", "request_time", "server_protocol", "remote_addr", and "remote_port".
     * It's similar to the superglobal $_SERVER in PHP.
     *
     * Since Swoole 6.2.0, when the request is handled by a Swoole HTTP server, the array also contains a
     * "server_addr" entry: the IP address of the server side of the connection (i.e., the local address the client
     * connected to).
     *
     * It's NULL until the request has been parsed.
     */
    public ?array $server = null;

    /**
     * The cookies parsed from the request.
     *
     * It's null if option 'parse_cookie' is set to FALSE when creating the Request object. e.g.,
     * ```php
     * $request = Request::create(['parse_cookie' => false]);
     * $request->parse($data);
     * var_dump($request->cookie); // NULL
     * ```
     */
    public ?array $cookie = null;

    /**
     * The query string parameters of the request, like the superglobal $_GET in PHP.
     *
     * It's NULL when the request has no query string.
     */
    public ?array $get = null;

    /**
     * The files uploaded with the request (via multipart/form-data), like the superglobal $_FILES in PHP.
     *
     * It's NULL when the request contains no uploaded file, or if option 'parse_files' is set to FALSE when creating
     * the Request object.
     */
    public ?array $files = null;

    /**
     * The form data submitted in the request body, like the superglobal $_POST in PHP.
     *
     * It's NULL when the request body contains no form data, or if option 'parse_body' is set to FALSE when creating
     * the Request object.
     */
    public ?array $post = null;

    /**
     * Paths of the temporary files that store the uploaded files of the request.
     *
     * The temporary files are deleted automatically once the request is destroyed. It's NULL when the request contains
     * no uploaded file.
     */
    public ?array $tmpfiles = null;

    /**
     * Get the request content, kind of like function call fopen('php://input').
     *
     * @return string|false Return the body of the request, or an empty string when the request has no body; return
     *                      FALSE when error happens.
     * @alias This method has an alias of \Swoole\Http\Request::rawContent().
     * @see \Swoole\Http\Request::rawContent()
     * @since 4.5.0
     */
    public function getContent(): string|false
    {
    }

    /**
     * Get the request content, kind of like function call fopen('php://input').
     *
     * @return string|false Return the body of the request, or an empty string when the request has no body; return
     *                      FALSE when error happens.
     * @alias Alias of method \Swoole\Http\Request::getContent().
     * @see \Swoole\Http\Request::getContent()
     */
    public function rawContent(): string|false
    {
    }

    /**
     * Get the whole raw HTTP request as received on the wire, i.e., the request line and headers followed by the body.
     *
     * This differs from getContent()/rawContent(), which return the request body only. It works for HTTP/1.x requests
     * only; on an HTTP/2 request it fails with a warning and returns FALSE, because HTTP/2 has no equivalent single raw
     * byte stream.
     *
     * @return string|false Return the raw request data; return an empty string when no data is available; return FALSE
     *                      on error, or when called on an HTTP/2 request.
     * @see \Swoole\Http\Request::getContent()
     * @see \Swoole\Http\Request::rawContent()
     */
    public function getData(): string|false
    {
    }

    /**
     * Create an HTTP request object.
     *
     * @param array $options The options for the Request object. Only the following options are supported:
     *                       - 'parse_cookie' (boolean; default is TRUE): To parse the cookies or not.
     *                       - 'parse_body' (boolean; default is TRUE): To parse the HTTP body or not.
     *                       - 'parse_files' (boolean; default is TRUE): To parse the uploaded files or not.
     *                       - 'upload_tmp_dir' (string; default is "/tmp"): The temporary directory to store the uploaded files.
     *                       - 'enable_compression' (boolean; default is TRUE if Swoole is installed with zlib/Brotli/zstd, otherwise FALSE): To enable HTTP compression or not.
     *                       - 'compression_level' (integer): Compression level. 1-9 are supported. The higher the level, the better the compression, but the more CPU it will consume. The default is 1.
     *                       - 'websocket_compression' (boolean; default is TRUE if zlib extension is enabled, otherwise FALSE): To enable WebSocket compression or not. This is for WebSocket requests only.
     * @return Request The HTTP request object created. Feed it raw request data using method Request::parse().
     * @see \Swoole\Http\Request::parse()
     * @since 4.6.0
     */
    public static function create(array $options = []): Request
    {
    }

    /**
     * Parse the raw HTTP request data.
     *
     * This method can be called multiple times to feed the request data in pieces; use method Request::isCompleted()
     * to check if the whole request has been received.
     *
     * @param string $data The raw HTTP request data (or a piece of it) to parse.
     * @return int|false Return the parsed length of the data; return FALSE when error happens, or when the request has
     *                   already been fully received.
     * @see \Swoole\Http\Request::isCompleted()
     * @since 4.6.0
     */
    public function parse(string $data): int|false
    {
    }

    /**
     * Check if the HTTP request has been fully received.
     *
     * @return bool Return TRUE if the whole request (headers and body) has been received; return FALSE otherwise.
     * @see \Swoole\Http\Request::parse()
     * @since 4.6.0
     */
    public function isCompleted(): bool
    {
    }

    /**
     * Get the HTTP request method (e.g., "GET", "POST").
     *
     * @return string|false Return the request method in uppercase; return FALSE when the request has already been
     *                      finished or is otherwise unavailable.
     */
    public function getMethod(): string|false
    {
    }
}
