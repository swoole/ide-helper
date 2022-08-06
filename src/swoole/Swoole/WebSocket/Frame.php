<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

use Stringable;

class Frame implements Stringable
{
    public $fd = 0;

    public $data = '';

    public $opcode = 1;

    public $flags = 1;

    public $finish;

    public function __toString(): string
    {
    }

    public static function pack(Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): string
    {
    }

    public static function unpack(string $data): Frame
    {
    }
}
