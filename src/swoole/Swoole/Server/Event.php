<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * An Event object is passed to an event callback as the second argument when option
 * \Swoole\Constant::OPTION_EVENT_OBJECT is enabled on the server. Otherwise, the same information is passed to the
 * callback as multiple separate arguments.
 *
 * Event objects are used for the following three types of events in a Swoole server:
 *   1. onConnect event.
 *   2. onReceive event.
 *   3. onClose event. The same object is also passed to the onDisconnect callback, which takes the place of the
 *      onClose callback when a connection on a WebSocket port is closed before the WebSocket handshake is completed.
 *
 * @see \Swoole\Constant::OPTION_EVENT_OBJECT
 */
class Event
{
    /**
     * ID of the reactor thread where the event was dispatched from.
     */
    public int $reactor_id = 0;

    /**
     * The session ID (also referred to as the file descriptor, or fd) of the connection.
     */
    public int $fd = 0;

    /**
     * The time when the event was dispatched.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    /**
     * The data received from the client.
     *
     * This property is set for the onReceive event only. It is NULL for the onConnect, onClose, and onDisconnect
     * events.
     */
    public ?string $data = null;
}
