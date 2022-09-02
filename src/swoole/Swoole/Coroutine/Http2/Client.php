<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http2;

use Swoole\Http2\Request;
use Swoole\Http2\Response;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Client
{
    public $errCode = 0;

    public $errMsg = '';

    public $sock = -1;

    public $type = 0;

    public $setting;

    public $connected = false;

    public $host;

    public $port = 0;

    public $ssl = false;

    public function __construct(string $host, int $port = 80, bool $open_ssl = false)
    {
    }

    public function __destruct()
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

    public function recv(float $timeout = 0): Response|false
    {
    }

    public function read(float $timeout = 0): Response|false
    {
    }

    public function goaway(int $error_code = 0, string $debug_data = ''): bool
    {
    }

    public function ping(): bool
    {
    }

    public function close(): bool
    {
    }
}
