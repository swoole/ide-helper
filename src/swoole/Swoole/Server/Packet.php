<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * A Packet object carries a datagram received on a UDP/UDP6 port, or on a UNIX datagram socket, of a Swoole server.
 *
 * It is passed to the onPacket callback as the second argument when option \Swoole\Constant::OPTION_EVENT_OBJECT is
 * enabled on the server. Otherwise, the same information is passed to the callback as three separate arguments: the
 * received data, and an array holding the rest of the fields below.
 *
 * @see \Swoole\Constant::OPTION_EVENT_OBJECT
 */
class Packet
{
    /**
     * File descriptor of the listening socket (the server-side socket) the datagram was received on.
     */
    public int $server_socket = 0;

    /**
     * The port number the datagram was received on. It is 0 when the listening socket can no longer be found.
     */
    public int $server_port = 0;

    /**
     * The time when the datagram was dispatched.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    /**
     * The client-side address of the datagram: an IP address for a UDP/UDP6 socket, or the path of the peer UNIX
     * datagram socket for a UNIX datagram socket.
     */
    public ?string $address = null;

    /**
     * The client-side port number of the datagram. It is 0 for a UNIX datagram socket, which has no port number.
     */
    public int $port = 0;

    /**
     * The datagram payload received from the client.
     */
    public ?string $data = null;
}
