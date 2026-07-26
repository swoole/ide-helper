<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

/**
 * A WebSocket close frame, i.e., a frame with opcode SWOOLE_WEBSOCKET_OPCODE_CLOSE announcing that the connection
 * is being closed.
 *
 * Frames of this class are received instead of plain \Swoole\WebSocket\Frame objects when the other side closes the
 * WebSocket connection, if setting "open_websocket_close_frame" is enabled; without that setting, Swoole handles
 * close frames internally and never hands them over to PHP code. This applies to the client side (e.g., method
 * \Swoole\Coroutine\Http\Client::recv()) just as much as to the server side. They are also produced by method
 * \Swoole\WebSocket\Frame::unpack() when the decoded data holds a close frame. Besides the properties inherited from
 * \Swoole\WebSocket\Frame, they carry the close status code and an optional human-readable reason.
 *
 * @see \Swoole\WebSocket\Frame
 * @see \Swoole\WebSocket\Frame::unpack()
 */
class CloseFrame extends Frame
{
    /**
     * Opcode of the frame. On close frames it defaults to SWOOLE_WEBSOCKET_OPCODE_CLOSE, the opcode marking a frame
     * as a connection-close frame, instead of the parent class's default of SWOOLE_WEBSOCKET_OPCODE_TEXT.
     *
     * @see \Swoole\WebSocket\Frame::$opcode
     */
    public int $opcode = SWOOLE_WEBSOCKET_OPCODE_CLOSE;

    /**
     * The close status code (e.g., SWOOLE_WEBSOCKET_CLOSE_NORMAL), telling why the connection was closed. The
     * SWOOLE_WEBSOCKET_CLOSE_* constants cover the status codes defined in section 7.4.1 of the WebSocket protocol
     * (RFC 6455).
     *
     * @see https://datatracker.ietf.org/doc/html/rfc6455#section-7.4.1
     */
    public int $code = SWOOLE_WEBSOCKET_CLOSE_NORMAL;

    /**
     * Optional human-readable text explaining why the connection was closed. It can be empty.
     */
    public string $reason = '';
}
