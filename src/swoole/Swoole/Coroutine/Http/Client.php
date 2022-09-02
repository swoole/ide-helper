<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\WebSocket\Frame;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Client
{
    public $errCode = 0;

    public $errMsg = '';

    public $connected = false;

    public $host = '';

    public $port = 0;

    public $ssl = false;

    public $setting;

    public $requestMethod;

    public $requestHeaders;

    public $requestBody;

    public $uploadFiles;

    public $downloadFile;

    public $downloadOffset = 0;

    public $statusCode = 0;

    public $headers;

    public $set_cookie_headers;

    public $cookies;

    public $body = '';

    public function __construct(string $host, int $port = 0, bool $ssl = false)
    {
    }

    public function __destruct()
    {
    }

    public function set(array $settings): bool
    {
    }

    public function getDefer(): bool
    {
    }

    public function setDefer(bool $defer = true): bool
    {
    }

    public function setMethod(string $method): bool
    {
    }

    public function setHeaders(array $headers): bool
    {
    }

    public function setBasicAuth(string $username, string $password): void
    {
    }

    public function setCookies(array $cookies): bool
    {
    }

    public function setData(string|array $data): bool
    {
    }

    public function addFile(string $path, string $name, ?string $type = null, ?string $filename = null, int $offset = 0, int $length = 0): bool
    {
    }

    public function addData(string $path, string $name, ?string $type = null, ?string $filename = null): bool
    {
    }

    public function execute(string $path): bool
    {
    }

    public function getpeername(): array|false
    {
    }

    public function getsockname(): array|false
    {
    }

    public function get(string $path): bool
    {
    }

    public function post(string $path, mixed $data): bool
    {
    }

    public function download(string $path, string $file, int $offset = 0): bool
    {
    }

    public function getBody(): string|false
    {
    }

    public function getHeaders(): array|false|null
    {
    }

    public function getCookies(): array|false|null
    {
    }

    public function getStatusCode(): int|false
    {
    }

    public function getHeaderOut(): string|false
    {
    }

    public function getPeerCert(): string|false
    {
    }

    public function upgrade(string $path): bool
    {
    }

    public function push(mixed $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): bool
    {
    }

    public function recv(float $timeout = 0): Frame|bool
    {
    }

    public function close(): bool
    {
    }
}
