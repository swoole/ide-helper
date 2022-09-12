<?php

declare(strict_types=1);

namespace Swoole\Http;

use Swoole\WebSocket\Frame;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Response
{
    public $fd = 0;

    public $socket;

    public $header;

    public $cookie;

    public $trailer;

    public function __destruct()
    {
    }

    public function initHeader(): bool
    {
    }

    public function isWritable(): bool
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Http\Response::setCookie().
     * @see \Swoole\Http\Response::setCookie()
     */
    public function cookie(string $name, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = ''): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Http\Response::cookie().
     * @see \Swoole\Http\Response::cookie()
     */
    public function setCookie(string $name, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = ''): bool
    {
    }

    public function rawcookie(string $name, string $value = '', int $expires = 0, string $path = '/', string $domain = '', bool $secure = false, bool $httponly = false, string $samesite = '', string $priority = ''): bool
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Http\Response::setStatusCode().
     * @see \Swoole\Http\Response::setStatusCode()
     */
    public function status(int $http_code, string $reason = ''): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Http\Response::status().
     * @see \Swoole\Http\Response::status()
     */
    public function setStatusCode(int $http_code, string $reason = ''): bool
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Http\Response::setHeader().
     * @see \Swoole\Http\Response::setHeader()
     */
    public function header(string $key, string|array $value, bool $format = true): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Http\Response::header().
     * @see \Swoole\Http\Response::header()
     */
    public function setHeader(string $key, string|array $value, bool $format = true): bool
    {
    }

    public function trailer(string $key, string $value): bool
    {
    }

    public function ping(): bool
    {
    }

    public function goaway(int $error_code = 0, string $debug_data = ''): bool
    {
    }

    public function write(string $content): bool
    {
    }

    public function end(?string $content = null): bool
    {
    }

    public function sendfile(string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    public function redirect(string $location, int $http_code = 302): bool
    {
    }

    public function detach(): bool
    {
    }

    public static function create(int|array|object $server = -1, int $fd = -1): Response|false
    {
    }

    public function upgrade(): bool
    {
    }

    public function push(Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): bool
    {
    }

    public function recv(float $timeout = 0): Frame|string|false
    {
    }

    public function close(): bool
    {
    }
}
