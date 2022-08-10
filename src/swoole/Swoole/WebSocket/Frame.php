<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

use Stringable;

class Frame implements Stringable
{
    public $fd = 0;

    public $data = '';

    public $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT;

    public $flags = SWOOLE_WEBSOCKET_FLAG_FIN;

    public $finish;

    public function __toString(): string
    {
    }

    /**
     * @alias Alias of method \Swoole\WebSocket\Server::pack().
     * @see \Swoole\WebSocket\Server::pack()
     */
    public static function pack(Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): string
    {
    }

    /**
     * @alias Alias of method \Swoole\WebSocket\Server::unpack().
     * @see \Swoole\WebSocket\Server::unpack()
     */
    public static function unpack(string $data): Frame
    {
    }
}
