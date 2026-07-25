<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

class Frame implements \Stringable
{
    public int $fd = 0;

    public string $data = '';

    public int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT;

    public int $flags = SWOOLE_WEBSOCKET_FLAG_FIN;

    /**
     * Whether this frame is the final piece of a message, i.e., whether property $data carries a complete message.
     *
     * When a WebSocket message is split into several frames, only the last frame of the message has this property set
     * to TRUE. Frames returned by \Swoole\Http\Response::recv() and \Swoole\Coroutine\Http\Client::recv() always carry
     * a complete, automatically reassembled message, so this property is always TRUE on them. Note: in Swoole 6.1.0
     * through 6.1.5, this property was incorrectly left FALSE on frames reassembled from several smaller frames by
     * those two methods; this was fixed in Swoole 6.1.6.
     *
     * @see \Swoole\Coroutine\Http\Client::recv()
     * @see \Swoole\Http\Response::recv()
     */
    public bool $finish;

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
