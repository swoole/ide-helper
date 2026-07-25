<?php

declare(strict_types=1);

namespace Swoole\Server;

use Swoole\Connection\Iterator;

/**
 * Each port a Swoole server listens on is represented by a Port object. Port objects are created in two ways:
 *     1. When a Swoole Server object is created, a Port object is created for each port that has been added to the
 *        server, which is the port specified in the constructor (or, when systemd socket activation is used, one Port
 *        object per socket passed in by systemd).
 *     2. When method \Swoole\Server::listen() is called, a Port object is created for the newly added port, and
 *        returned as the return value of the method.
 *
 * All Port objects of a server are accessible through property \Swoole\Server::$ports, where the first element is
 * always the primary port of the server.
 *
 * @see \Swoole\Server::$ports
 * @see \Swoole\Server::listen()
 * @not-serializable Objects of this class cannot be serialized.
 */
class Port
{
    /**
     * IP address of the network socket, or path of the UNIX domain socket bound to the port.
     */
    public string $host;

    /**
     * The port number. It is 0 when the port is bound to a UNIX domain socket.
     */
    public int $port = 0;

    /**
     * Type of the socket bound to the port. It is one of the SWOOLE_SOCK_* constants.
     *
     * Unlike the $sock_type parameter accepted by \Swoole\Server::listen() and by the constructor of \Swoole\Server, this
     * value never includes SWOOLE_SSL; whether SSL is enabled on the port is reported by property $ssl instead.
     *
     * @see SWOOLE_SOCK_TCP
     * @see SWOOLE_SOCK_UDP
     * @see SWOOLE_SOCK_TCP6
     * @see SWOOLE_SOCK_UDP6
     * @see SWOOLE_SOCK_UNIX_STREAM
     * @see SWOOLE_SOCK_UNIX_DGRAM
     * @see Port::$ssl
     */
    public int $type = 0;

    /**
     * The file descriptor of the socket listening on the port. It is -1 if the socket has not been created yet.
     */
    public int $sock = -1;

    /**
     * If SSL is enabled or not on the port.
     */
    public bool $ssl = false;

    /**
     * Settings of the port.
     *
     * This property is NULL until method \Swoole\Server\Port::set() is called on the port (directly, or indirectly
     * through method \Swoole\Server::set(), which applies the settings given to the primary port as well); each call
     * merges the given settings into this property.
     *
     * @var array<string, mixed>|null
     * @see \Swoole\Server\Port::set()
     * @see \Swoole\Server::set()
     */
    public ?array $setting = null;

    /**
     * Established connections of the port.
     *
     * This property holds the connections of this single port only. To access the connections of the whole server, use
     * property \Swoole\Server::$connections instead.
     *
     * @see \Swoole\Connection\Iterator
     * @see \Swoole\Server::$connections
     */
    public Iterator $connections;

    /**
     * @var callable
     */
    private $onConnect;

    /**
     * @var callable
     */
    private $onReceive;

    /**
     * @var callable
     */
    private $onClose;

    /**
     * @var callable
     */
    private $onPacket;

    /**
     * @var callable
     */
    private $onBufferFull;

    /**
     * @var callable
     */
    private $onBufferEmpty;

    /**
     * @var callable
     */
    private $onRequest;

    /**
     * @var callable
     */
    private $onHandshake;

    /**
     * @var callable
     */
    private $onOpen;

    /**
     * @var callable
     */
    private $onMessage;

    /**
     * @var callable
     * @since 4.7.0
     */
    private $onDisconnect;

    /**
     * @var callable
     * @since 5.0.3
     */
    private $onBeforeHandshakeResponse;

    /**
     * Creating an object of this class directly is not allowed. It will always throw an error; Port objects are
     * created by Swoole internally (please check the class-level documentation above).
     *
     * @throws \Error
     */
    private function __construct()
    {
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly; it does nothing. The resources held by the port are released
     * internally when the object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Change port-level settings of the port.
     *
     * Only port-level settings (e.g., the ones about SSL, protocol handling, and socket buffers) take effect here;
     * server-level settings should be set through method \Swoole\Server::set() instead. The settings given are merged
     * into property \Swoole\Server\Port::$setting.
     *
     * @param array $settings Settings as key-value pairs. Keys are option names; class \Swoole\Constant contains most of them declared as constants with an "OPTION_" prefix.
     * @see \Swoole\Server\Port::$setting
     * @see \Swoole\Server::set()
     * @see \Swoole\Constant
     */
    public function set(array $settings): void
    {
    }

    /**
     * Register a callback function for an event on the port.
     *
     * Only port events can be registered here (as of Swoole 6.0.2 there are 12 of them; please check method
     * \Swoole\Server::on() for the complete list); server events must be registered on the server object itself. This
     * method can only be called before the server is started.
     *
     * @param string $event_name Event name. It's case-insensitive.
     * @param callable $callback The callback function to be registered for the event.
     * @return bool Returns true on success. Returns false on failure, e.g., the server has already been started, the event name is unknown, or the callback given is not callable.
     * @see \Swoole\Server::on()
     * @see \Swoole\Server\Port::getCallback()
     */
    public function on(string $event_name, callable $callback): bool
    {
    }

    /**
     * Get the callback registered on the port for the given event.
     *
     * The callback is returned exactly as it was registered through method \Swoole\Server\Port::on(): it can be a
     * Closure object, a string holding a function name, an array in the format of [$object, 'method'] or
     * ['ClassName', 'method'], or an object having method __invoke() defined.
     *
     * The event name is case-insensitive. NULL is returned when the event name is unknown, or when no callback has
     * been registered for the event.
     *
     * @param string $event_name Event name. It's case-insensitive.
     * @return ?callable The callback function registered on the port for the event, or null if no callback has been registered for it.
     * @see \Swoole\Server\Port::on()
     * @see \Swoole\Server::getCallback()
     */
    public function getCallback(string $event_name): ?callable
    {
    }

    /**
     * Get the socket handle bound to the port.
     *
     * This method is available only when Swoole is installed with option "--enable-sockets" included.
     *
     * @return \Socket|false Returns a Socket object on success; otherwise FALSE. Since Swoole 6.1.2, the returned
     *                       Socket object holds a duplicate of the underlying socket handle instead of the original
     *                       one, so closing the returned Socket object no longer affects the socket held by Swoole.
     */
    public function getSocket(): \Socket|false
    {
    }
}
