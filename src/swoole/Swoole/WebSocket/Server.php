<?php

declare(strict_types=1);

namespace Swoole\WebSocket;

/**
 * A WebSocket server.
 *
 * It extends the HTTP server, since every WebSocket connection starts life as an HTTP request that asks to be upgraded
 * to the WebSocket protocol. On top of the HTTP server's callbacks, this class dispatches events "open" (a client has
 * completed the handshake), "message" (a frame has arrived), and, optionally, "handshake" (to take over the handshake
 * yourself).
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\WebSocket\Frame
 * @see \Swoole\Http\Server
 */
class Server extends \Swoole\Http\Server
{
    /**
     * Send data to a client over an established WebSocket connection.
     *
     * Note that sending a close frame through this method does not close the connection; use method
     * \Swoole\WebSocket\Server::disconnect() when the intent is to close the connection.
     *
     * @param int $fd Session ID of the client to send the data to.
     * @param Frame|string $data The data to send. Pass a \Swoole\WebSocket\Frame object to control every detail of the
     *                           frame, in which case parameters $opcode and $flags are ignored.
     * @param int $opcode Type of the frame to send, telling the client how to interpret the data. Swoole defines the
     *                    opcodes of the WebSocket protocol as SWOOLE_WEBSOCKET_OPCODE_* constants; text and binary
     *                    frames are the two ordinary choices.
     * @param int $flags Frame flags, as a bitmask of the SWOOLE_WEBSOCKET_FLAG_* constants. The default,
     *                   SWOOLE_WEBSOCKET_FLAG_FIN, marks the frame as the last one of a message; leave it out when
     *                   sending a message split into several frames.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., the session doesn't exist, the connection is
     *              not an established WebSocket connection, or the server is not running).
     * @see \Swoole\WebSocket\Server::disconnect()
     * @see \Swoole\WebSocket\Server::ping()
     * @see SWOOLE_WEBSOCKET_OPCODE_TEXT
     * @see SWOOLE_WEBSOCKET_FLAG_FIN
     */
    public function push(int $fd, Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): bool
    {
    }

    /**
     * Close a WebSocket connection by sending a close frame to the client first.
     *
     * Unlike method \Swoole\Server::close(), which drops the connection right away, this method performs the closing
     * handshake the WebSocket protocol asks for: it tells the client why the connection is going away, and only then
     * closes it.
     *
     * @param int $fd Session ID of the client to disconnect.
     * @param int $code Close status code telling the client why the connection is being closed. Swoole defines the
     *                  status codes of the WebSocket protocol as SWOOLE_WEBSOCKET_CLOSE_* constants.
     * @param string $reason A short, human-readable explanation of why the connection is being closed.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., the session doesn't exist, or the server is not
     *              running).
     * @see \Swoole\WebSocket\Server::push()
     * @see \Swoole\Server::close()
     * @see SWOOLE_WEBSOCKET_CLOSE_NORMAL
     */
    public function disconnect(int $fd, int $code = SWOOLE_WEBSOCKET_CLOSE_NORMAL, string $reason = ''): bool
    {
    }

    /**
     * Send a ping frame to a client to check that the connection is still alive.
     *
     * A client is expected to answer with a pong frame carrying the same payload back. Swoole answers incoming ping
     * frames automatically, so a server normally uses this method only to check on quiet connections itself.
     *
     * @param int $fd Session ID of the client to ping.
     * @param string $data Payload to put in the ping frame, which the client is expected to echo back in its pong
     *                     frame. It must not exceed 125 bytes, as the WebSocket protocol requires of control frames.
     * @return bool Return TRUE on success, or FALSE when failed (e.g., the session doesn't exist, or the server is not
     *              running).
     * @see \Swoole\WebSocket\Server::push()
     * @see \Swoole\WebSocket\Server::disconnect()
     * @see SWOOLE_WEBSOCKET_OPCODE_PING
     * @since 6.1.0
     */
    public function ping(int $fd, string $data = ''): bool
    {
    }

    /**
     * Check whether a client has an established WebSocket connection.
     *
     * It returns FALSE for a session that exists but hasn't finished the WebSocket handshake yet, as well as for one
     * that is already closed or closing.
     *
     * @param int $fd Session ID of the client to check.
     * @return bool TRUE when the client has an established WebSocket connection, or FALSE otherwise.
     * @see \Swoole\WebSocket\Server::push()
     */
    public function isEstablished(int $fd): bool
    {
    }

    /**
     * Encode data into a WebSocket frame, as a binary string ready to be written to a socket.
     *
     * This is useful when the frame is to be sent through something other than method
     * \Swoole\WebSocket\Server::push(), e.g., a raw \Swoole\Coroutine\Socket object.
     *
     * @param Frame|string $data The data to encode. Pass a \Swoole\WebSocket\Frame object to control every detail of
     *                           the frame, in which case parameters $opcode and $flags are ignored.
     * @param int $opcode Type of the frame, telling the receiver how to interpret the data. Swoole defines the opcodes
     *                    of the WebSocket protocol as SWOOLE_WEBSOCKET_OPCODE_* constants.
     * @param int $flags Frame flags, as a bitmask of the SWOOLE_WEBSOCKET_FLAG_* constants.
     * @return string The encoded frame.
     * @see \Swoole\WebSocket\Server::unpack()
     * @see \Swoole\WebSocket\Frame::pack()
     * @alias This method has an alias of \Swoole\WebSocket\Frame::pack().
     */
    public static function pack(Frame|string $data, int $opcode = SWOOLE_WEBSOCKET_OPCODE_TEXT, int $flags = SWOOLE_WEBSOCKET_FLAG_FIN): string
    {
    }

    /**
     * Decode a binary WebSocket frame back into a \Swoole\WebSocket\Frame object.
     *
     * @param string $data The encoded frame to decode, as produced by method \Swoole\WebSocket\Server::pack().
     * @return Frame The decoded frame.
     * @see \Swoole\WebSocket\Server::pack()
     * @see \Swoole\WebSocket\Frame::unpack()
     * @alias This method has an alias of \Swoole\WebSocket\Frame::unpack().
     */
    public static function unpack(string $data): Frame
    {
    }
}
