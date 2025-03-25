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
    public int $fd = 0;

    public int $streamId = 0;

    public $header;

    public $server;

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
    public ?array $cookie;

    public $get;

    public $files;

    public $post;

    public $tmpfiles;

    /**
     * Get the request content, kind of like function call fopen('php://input').
     *
     * @return string|false Return the request content back; return FALSE when error happens.
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
     * @return string|false Return the request content back; return FALSE when error happens.
     * @alias Alias of method \Swoole\Http\Request::getContent().
     * @see \Swoole\Http\Request::getContent()
     */
    public function rawContent(): string|false
    {
    }

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
     * @since 4.6.0
     */
    public static function create(array $options = []): Request
    {
    }

    /**
     * Parse the raw HTTP request data.
     *
     * @return int|false Return the parsed length of the data; return FALSE when error happens.
     * @since 4.6.0
     */
    public function parse(string $data): int|false
    {
    }

    /**
     * @since 4.6.0
     */
    public function isCompleted(): bool
    {
    }

    public function getMethod(): string|false
    {
    }
}
