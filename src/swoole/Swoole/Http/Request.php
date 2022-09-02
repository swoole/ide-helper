<?php

declare(strict_types=1);

namespace Swoole\Http;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Request
{
    public $fd = 0;

    public $streamId = 0;

    public $header;

    public $server;

    public $cookie;

    public $get;

    public $files;

    public $post;

    public $tmpfiles;

    public function __destruct()
    {
    }

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

    public static function create(array $options = []): Request
    {
    }

    public function parse(string $data): int|false
    {
    }

    public function isCompleted(): bool
    {
    }

    public function getMethod(): string|false
    {
    }
}
