<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

/**
 * A WebSocket data frame.
 *
 * Objects of this class are passed to the "message" event callback of a WebSocket server, and returned by methods
 * \Swoole\Http\Response::recv() and \Swoole\Coroutine\Http\Client::recv() on the two sides of an upgraded WebSocket
 * connection. They can also be created directly in PHP code and passed to sending methods like
 * \Swoole\WebSocket\Server::push() to control the opcode and flags of outgoing data. Casting a Frame object to a
 * string produces the binary WebSocket encoding of the frame, as if by method pack().
 *
 * @see \Swoole\WebSocket\Server::push()
 * @see \Swoole\WebSocket\Server::pack()
 * @see \Swoole\WebSocket\CloseFrame
 */
class Frame implements \Stringable
{
    /**
     * File descriptor of the WebSocket connection that the frame was received from. It's set on frames passed to
     * the "message" event callback of a WebSocket server, and stays 0 on frames created in PHP code or received by
     * client-side methods.
     */
    public int $fd = 0;

    /**
     * Payload of the frame. For frames received from the other side of the connection, this normally carries a
     * complete (automatically reassembled) message.
     */
    public string $data = '';

    /**
     * Opcode of the frame, telling how property $data should be interpreted. One of the
     * SWOOLE_WEBSOCKET_OPCODE_* constant values, e.g., SWOOLE_WEBSOCKET_OPCODE_TEXT (a text message),
     * SWOOLE_WEBSOCKET_OPCODE_BINARY (a binary message), or SWOOLE_WEBSOCKET_OPCODE_PING.
     */
    public int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT;

    /**
     * Bitwise OR of the SWOOLE_WEBSOCKET_FLAG_* constant values describing the frame, e.g.,
     * SWOOLE_WEBSOCKET_FLAG_FIN (the frame is the final piece of a message) or SWOOLE_WEBSOCKET_FLAG_COMPRESS (the
     * payload is/should be compressed).
     */
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

    /**
     * Get the binary WebSocket encoding of the frame, ready to be written to a raw socket.
     *
     * This is what makes `(string) $frame` work; the result is the same as passing the frame to method pack().
     *
     * @return string The frame encoded as binary WebSocket protocol data.
     * @see \Swoole\WebSocket\Frame::pack()
     */
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
