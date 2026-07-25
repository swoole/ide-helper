<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Connection\Iterator;
use Swoole\Coroutine\Http\Server as AdminServer;
use Swoole\Server\Port;

/**
 * The Swoole Server class.
 *
 * There are five types of processes in Swoole server:
 *   - Master process.
 *   - Manager process. Optional.
 *   - Event worker processes. All requests (HTTP, WebSocket, TCP, UDP, etc.) are handled by this type of processes. It supports
 *     coroutine by default.
 *   - Task worker processes. Optional. This type of processes was introduced to handle blocking I/O operations in PHP. Ideally, it
 *     should always work synchronously, although it also supports coroutine and allows asynchronous processing (since Swoole 4.2.12).
 *     The number of task worker processes is set by option \Swoole\Constant::OPTION_TASK_WORKER_NUM before starting the server.
 *   - User processes. Optional. These are self-defined processes attached to the server through method \Swoole\Server::addProcess().
 *
 * History Changes:
 * 1. Following alias methods have been removed from Swoole 5.0.0. Please use the original methods instead.
 *    * \Swoole\Server::after()      => \Swoole\Timer::after().
 *    * \Swoole\Server::clearTimer() => \Swoole\Timer::clearTimer().
 *    * \Swoole\Server::tick()       => \Swoole\Timer::tick().
 *    * \Swoole\Server::defer()      => \Swoole\Event::defer().
 * 2. Starting from Swoole 5.0.0, default server mode has been changed from SWOOLE_PROCESS to SWOOLE_BASE.
 *
 * @not-serializable Objects of this class cannot be serialized.
 */
class Server
{
    /**
     * Settings of the server.
     *
     * This property is NULL until method \Swoole\Server::set() is called or the server is started, whichever happens
     * first; each call to method \Swoole\Server::set() merges the given settings into this property. Some settings
     * resolved while the server starts (e.g., the actual number of worker processes) are merged in as well.
     *
     * @var array<string, mixed>|null
     * @see \Swoole\Server::set()
     */
    public ?array $setting = null;

    /**
     * Established connections of the server.
     *
     * This property is initialized when the Server object is created, and it holds the connections of the whole
     * server. To access the connections of one single port, use property \Swoole\Server\Port::$connections instead.
     *
     * @see \Swoole\Connection\Iterator
     * @see \Swoole\Server\Port::$connections
     */
    public Iterator $connections;

    /**
     * IP address of the network socket, or path of the UNIX domain socket bound to the primary port.
     *
     * If the $sock_type parameter is set to SWOOLE_SOCK_UNIX_STREAM or SWOOLE_SOCK_UNIX_DGRAM in the constructor when
     * creating a Server object, the $host parameter must be set to the path of the UNIX domain socket. Otherwise,
     * the $host parameter must be set to the IP address of the network socket.
     *
     * When setting to the IP address of the network socket, it can be either an IPv4 or IPv6 address:
     * - For IPv4,
     *     - use 127.0.0.1 to listen on the local loopback interface.
     *     - use 0.0.0.0 to listen on all network interfaces.
     * - For IPv6,
     *     - use ::1 to listen on the local loopback interface.
     *     - use :: to listen on all network interfaces.
     */
    public string $host = '';

    /**
     * The primary port of the server. It's the port number actually assigned when creating a Server object.
     */
    public int $port = 0;

    /**
     * Type of the socket bound to the primary port.
     *
     * It can be one of the following values:
     *   - SWOOLE_SOCK_TCP
     *   - SWOOLE_SOCK_UDP
     *   - SWOOLE_SOCK_TCP6
     *   - SWOOLE_SOCK_UDP6
     *   - SWOOLE_SOCK_UNIX_STREAM
     *   - SWOOLE_SOCK_UNIX_DGRAM
     * In addition to specifying a socket type, it may include the bitwise OR of SWOOLE_SSL to enable SSL encryption for
     * network sockets (SWOOLE_SOCK_TCP, SWOOLE_SOCK_UDP, SWOOLE_SOCK_TCP6, and SWOOLE_SOCK_UDP6).
     * Thus, the value of $type could be in the format of either of the following:
     *   - SWOOLE_SOCK_TCP
     *   - SWOOLE_SOCK_TCP | SWOOLE_SSL
     *
     * If SWOOLE_SSL is included, the server must have the following options set properly before starting:
     *   - \Swoole\Constant::OPTION_SSL_CERT_FILE
     *   - \Swoole\Constant::OPTION_SSL_KEY_FILE
     *
     * @see SWOOLE_SOCK_TCP
     * @see SWOOLE_SOCK_UDP
     * @see SWOOLE_SOCK_TCP6
     * @see SWOOLE_SOCK_UDP6
     * @see SWOOLE_SOCK_UNIX_STREAM
     * @see SWOOLE_SOCK_UNIX_DGRAM
     * @see SWOOLE_SSL
     */
    public int $type = 0;

    /**
     * If SSL is enabled or not on the primary port.
     *
     * @since 5.0.0
     */
    public bool $ssl = false;

    /**
     * Server mode. Must be either SWOOLE_BASE, SWOOLE_PROCESS, or SWOOLE_THREAD.
     *
     * Starting from Swoole 5.0.0, default server mode has been changed from SWOOLE_PROCESS to SWOOLE_BASE.
     *
     * Mode SWOOLE_THREAD is supported since 6.0.0. It is available only when PHP is compiled with Zend Thread Safety
     * (ZTS) enabled and Swoole is installed with the "--enable-swoole-thread" configuration option.
     *
     * @see SWOOLE_BASE
     * @see SWOOLE_PROCESS
     * @see SWOOLE_THREAD
     * @readonly
     */
    public int $mode;

    /**
     * All the ports the server listens on, as a list of \Swoole\Server\Port objects.
     *
     * The first element is always the primary port of the server. Ports added afterwards through method
     * \Swoole\Server::listen() follow, in the order they were added.
     *
     * @var Port[]|null
     * @see \Swoole\Server\Port
     * @see \Swoole\Server::listen()
     */
    public ?array $ports = null;

    /**
     * Process ID of the master process.
     */
    public int $master_pid = 0;

    /**
     * Process ID of the manager process.
     */
    public int $manager_pid = 0;

    /**
     * ID of the worker process that the current process is; worker IDs start from 0.
     *
     * Event worker processes take the IDs from 0 to (worker_num - 1); task worker processes follow, taking the IDs
     * from worker_num to (worker_num + task_worker_num - 1). The value is -1 in any other type of process (the master
     * process, the manager process, and user processes).
     */
    public int $worker_id = -1;

    /**
     * Whether the current process is a task worker process or not.
     */
    public bool $taskworker = false;

    /**
     * Process ID of the worker process that the current process is. It is 0 in any other type of process.
     */
    public int $worker_pid = 0;

    /**
     * ID of the timer used to write statistics of the server periodically into the file specified by option
     * \Swoole\Constant::OPTION_STATS_FILE. It is NULL when the timer is not active.
     *
     * The timer is created in the first event worker process (the one with worker ID 0) when the server starts with
     * option \Swoole\Constant::OPTION_STATS_FILE set, and is cleared when that worker process exits. The interval of
     * the timer is set by option \Swoole\Constant::OPTION_STATS_TIMER_INTERVAL.
     *
     * @see \Swoole\Constant::OPTION_STATS_FILE
     * @see \Swoole\Constant::OPTION_STATS_TIMER_INTERVAL
     */
    public ?int $stats_timer = null;

    /**
     * The admin server, which is a \Swoole\Coroutine\Http\Server instance created when the server starts with option
     * \Swoole\Constant::OPTION_ADMIN_SERVER set. It is NULL when the admin server is not running.
     *
     * @see \Swoole\Constant::OPTION_ADMIN_SERVER
     * @since 4.8.0
     */
    public ?AdminServer $admin_server = null;

    /**
     * This property is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is
     * installed with the "--enable-swoole-thread" configuration option.
     *
     * @since 6.0.0
     */
    public string $bootstrap = '';

    /**
     * @var callable
     */
    private $onStart;

    /**
     * @var callable
     * @since 4.8.0
     */
    private $onBeforeShutdown;

    /**
     * @var callable
     */
    private $onShutdown;

    /**
     * @var callable
     */
    private $onWorkerStart;

    /**
     * @var callable
     */
    private $onWorkerStop;

    /**
     * @var callable
     * @since 4.5.0
     */
    private $onBeforeReload;

    /**
     * @var callable
     * @since 4.5.0
     */
    private $onAfterReload;

    /**
     * @var callable
     */
    private $onWorkerExit;

    /**
     * @var callable
     */
    private $onWorkerError;

    /**
     * @var callable
     */
    private $onTask;

    /**
     * @var callable
     */
    private $onFinish;

    /**
     * @var callable
     */
    private $onManagerStart;

    /**
     * @var callable
     */
    private $onManagerStop;

    /**
     * @var callable
     */
    private $onPipeMessage;

    /**
     * Constructor of the Swoole Server class.
     *
     * @param string $host IP address of the network socket, or path of the UNIX domain socket bound to the primary port. For details, please check property \Swoole\Server::$host.
     * @param int $port The primary port of the server.
     *                  - If 0 is passed, a random (ephemeral) port will be assigned by the operating system. The port actually assigned is then accessible through property \Swoole\Server::$port.
     *                  - This parameter is ignored for UNIX domain socket (when parameter $sock_type is SWOOLE_SOCK_UNIX_STREAM or SWOOLE_SOCK_UNIX_DGRAM).
     * @param int $mode Server mode. Must be one of SWOOLE_BASE, SWOOLE_PROCESS, and SWOOLE_THREAD; any other value
     *                  throws an \Error. Starting from Swoole 5.0.0, default server mode has been changed from
     *                  SWOOLE_PROCESS to SWOOLE_BASE. For details, please check property \Swoole\Server::$mode.
     * @param int $sock_type Type of the socket. For details, please check property \Swoole\Server::$type.
     * @throws \Error When an invalid server mode is given, or when the constructor is called more than once on the same object.
     * @see \Swoole\Server::$mode
     */
    public function __construct(string $host = '0.0.0.0', int $port = 0, int $mode = SWOOLE_BASE, int $sock_type = SWOOLE_SOCK_TCP)
    {
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly; it does nothing. The resources held by the server are released
     * internally when the object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Listen on a port.
     *
     * - This method can only be called before the server is started.
     * - The parameters have the same meanings as their counterparts in the constructor (method
     *   \Swoole\Server::__construct()), except that all of them are required here.
     * - To check which port a connection is on, use method \Swoole\Server::getClientInfo().
     * - Root permission is required to listen on a port below 1024.
     *
     * @param string $host IP address of the network socket, or path of the UNIX domain socket. For details, please check property \Swoole\Server::$host.
     * @param int $port The port to listen on.
     *                  - If 0 is passed, a random (ephemeral) port will be assigned by the operating system. The port actually assigned is then accessible through property \Swoole\Server\Port::$port of the returned object.
     *                  - This parameter is ignored for UNIX domain socket (when parameter $sock_type is SWOOLE_SOCK_UNIX_STREAM or SWOOLE_SOCK_UNIX_DGRAM).
     * @param int $sock_type Type of the socket. For details, please check property \Swoole\Server::$type.
     * @return Port|false Returns a Port object on success, or false on failure.
     * @alias This method has an alias of \Swoole\Server::addlistener().
     * @see \Swoole\Server::addlistener()
     * @see \Swoole\Server::getClientInfo()
     */
    public function listen(string $host, int $port, int $sock_type): Port|false
    {
    }

    /**
     * Listen on a port.
     *
     * - This method can only be called before the server is started.
     * - The parameters have the same meanings as their counterparts in the constructor (method
     *   \Swoole\Server::__construct()), except that all of them are required here.
     * - To check which port a connection is on, use method \Swoole\Server::getClientInfo().
     * - Root permission is required to listen on a port below 1024.
     *
     * @param string $host IP address of the network socket, or path of the UNIX domain socket. For details, please check property \Swoole\Server::$host.
     * @param int $port The port to listen on.
     *                  - If 0 is passed, a random (ephemeral) port will be assigned by the operating system. The port actually assigned is then accessible through property \Swoole\Server\Port::$port of the returned object.
     *                  - This parameter is ignored for UNIX domain socket (when parameter $sock_type is SWOOLE_SOCK_UNIX_STREAM or SWOOLE_SOCK_UNIX_DGRAM).
     * @param int $sock_type Type of the socket. For details, please check property \Swoole\Server::$type.
     * @return Port|false Returns a Port object on success, or false on failure.
     * @alias Alias of method \Swoole\Server::listen().
     * @see \Swoole\Server::listen()
     * @see \Swoole\Server::getClientInfo()
     */
    public function addlistener(string $host, int $port, int $sock_type): Port|false
    {
    }

    /**
     * Register a callback function for an event.
     *
     * There are two groups of events: server events and port events. A server event is registered on the server object
     * itself, while a port event is forwarded to and registered on the primary port ($this->ports[0]). Thus, calling
     * this method with a port event is equivalent to calling method \Swoole\Server\Port::on() on the primary port.
     *
     * Event names are case-insensitive. This method can only be called before the server is started.
     *
     * As of Swoole 6.0.2, there are
     *   - 14 server events.
     *     - \Swoole\Constant::EVENT_START
     *     - \Swoole\Constant::EVENT_BEFORE_SHUTDOWN
     *     - \Swoole\Constant::EVENT_SHUTDOWN
     *     - \Swoole\Constant::EVENT_WORKER_START
     *     - \Swoole\Constant::EVENT_WORKER_STOP
     *     - \Swoole\Constant::EVENT_BEFORE_RELOAD
     *     - \Swoole\Constant::EVENT_AFTER_RELOAD
     *     - \Swoole\Constant::EVENT_TASK
     *     - \Swoole\Constant::EVENT_FINISH
     *     - \Swoole\Constant::EVENT_WORKER_EXIT
     *     - \Swoole\Constant::EVENT_WORKER_ERROR
     *     - \Swoole\Constant::EVENT_MANAGER_START
     *     - \Swoole\Constant::EVENT_MANAGER_STOP
     *     - \Swoole\Constant::EVENT_PIPE_MESSAGE
     *   - 12 port events.
     *     - \Swoole\Constant::EVENT_CONNECT
     *     - \Swoole\Constant::EVENT_RECEIVE
     *     - \Swoole\Constant::EVENT_CLOSE
     *     - \Swoole\Constant::EVENT_PACKET
     *     - \Swoole\Constant::EVENT_BUFFER_FULL
     *     - \Swoole\Constant::EVENT_BUFFER_EMPTY
     *     - \Swoole\Constant::EVENT_REQUEST
     *     - \Swoole\Constant::EVENT_HANDSHAKE
     *     - \Swoole\Constant::EVENT_BEFORE_HAND_SHAKE_RESPONSE
     *     - \Swoole\Constant::EVENT_OPEN
     *     - \Swoole\Constant::EVENT_MESSAGE
     *     - \Swoole\Constant::EVENT_DISCONNECT
     *
     * @param string $event_name Event name. It's case-insensitive.
     * @param callable $callback The callback function to be registered for the event.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server\Port::on()
     * @see \Swoole\Server::getCallback()
     * @see https://github.com/swoole/swoole-src/blob/v6.2.2/ext-src/swoole_server.cc#L50
     * @see https://github.com/swoole/swoole-src/blob/v6.2.2/ext-src/swoole_server_port.cc#L33
     */
    public function on(string $event_name, callable $callback): bool
    {
    }

    /**
     * Get the callback function registered for an event.
     *
     * The value returned is the callback exactly as it was registered through method \Swoole\Server::on(): it can be a
     * Closure object, a string holding a function name, an array in the format of [$object, 'method'] or
     * ['ClassName', 'method'], or an object having method __invoke() defined. If the given event name is not a server
     * event, the callback registered on the primary port ($this->ports[0]) is returned instead.
     *
     * @param string $event_name Event name. It's case-insensitive.
     * @return ?callable The callback function registered for the event, or null if no callback has been registered for it.
     * @see \Swoole\Server::on()
     * @see \Swoole\Server\Port::getCallback()
     */
    public function getCallback(string $event_name): ?callable
    {
    }

    /**
     * Change runtime settings of the server.
     *
     * This method can only be called before the server is started. The settings given are merged into property
     * \Swoole\Server::$setting, and are applied to the primary port ($this->ports[0]) as well; to change port-level
     * settings of another port, call method \Swoole\Server\Port::set() on that port instead.
     *
     * @param array $settings Settings as key-value pairs. Keys are option names; class \Swoole\Constant contains most of them declared as constants with an "OPTION_" prefix.
     * @return bool Returns true on success. Returns false if the server has already been started, or (in the SWOOLE_THREAD mode) when called in a thread not related to the server.
     * @see \Swoole\Server::$setting
     * @see \Swoole\Server\Port::set()
     * @see \Swoole\Constant
     */
    public function set(array $settings): bool
    {
    }

    /**
     * Start the server.
     *
     * This method creates the worker processes and then blocks, running the event loop of the master process until the
     * server is shut down. Code placed after this method won't be executed until then.
     *
     * - All the event callback functions and all the listening ports must be registered/added before calling this
     *   method.
     * - If the server fails to start, a fatal error (E_ERROR) is raised instead of false being returned.
     *
     * @return bool Returns true when the server is shut down. Returns false if the server has already been started or
     *              shut down, or if an event loop has already been created in the current process.
     * @see \Swoole\Server::shutdown()
     */
    public function start(): bool
    {
    }

    /**
     * Send data to a client.
     *
     * For a connection on a stream (TCP or UNIX-stream) port, the data may be queued in the send buffer of the
     * connection if it can't be written out at once.
     *
     * @param int|string $fd Session ID of the connection. To send data back to a client on a UNIX domain datagram socket, pass the path of the peer socket as a string instead.
     * @param string $send_data The data to send. It must not be empty.
     * @param int $serverSocket This parameter is used only when sending data back to a client on a UNIX domain datagram socket, to specify the file descriptor of the listening socket to send the data from; by default (-1), the socket where the server received the last datagram is used. It's ignored otherwise.
     * @return bool Returns true on success. Returns false on failure, e.g., the server is not running yet, the data given is empty, or the connection specified does not exist or is already closed.
     * @see \Swoole\Server::sendwait()
     */
    public function send(int|string $fd, string $send_data, int $serverSocket = -1): bool
    {
    }

    /**
     * Send data to a client of a datagram (UDP, UDP6, or UNIX-datagram) port.
     *
     * The server must be listening on a datagram port matching the type of the target address; otherwise this method
     * fails.
     *
     * @param string $ip IP address of the client, either IPv4 or IPv6. If it starts with a "/", it is treated as the path of a peer UNIX domain datagram socket instead.
     * @param int $port Port number of the client. It's ignored when sending to a UNIX domain datagram socket.
     * @param string $send_data The data to send. It must not be empty.
     * @param int $server_socket File descriptor of the listening socket to send the data from. By default (-1), the first listening socket matching the type of the target address is used.
     * @return bool Returns true on success, or false on failure.
     */
    public function sendto(string $ip, int $port, string $send_data, int $server_socket = -1): bool
    {
    }

    /**
     * Send data to a client synchronously, blocking until all the data has been written out.
     *
     * Unlike method \Swoole\Server::send(), this method never queues the data in the send buffer of the connection;
     * it keeps writing until the whole payload has been handed over to the operating system. It can be used in the
     * SWOOLE_BASE mode only, and only in event worker processes.
     *
     * @param int $conn_fd Session ID of the connection.
     * @param string $send_data The data to send. It must not be empty.
     * @return bool Returns true on success. Returns false on failure, e.g., the data given is empty, the connection does not exist, or the method is used in the SWOOLE_PROCESS mode or in a task worker process.
     * @see \Swoole\Server::send()
     * @see SWOOLE_BASE
     */
    public function sendwait(int $conn_fd, string $send_data): bool
    {
    }

    /**
     * Check if a connection exists.
     *
     * @param int $fd The connection file descriptor.
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been
     *              closed. Since Swoole 6.1.2, false is also returned while the connection is still in the process of
     *              being closed (previously, true was returned until the connection was fully closed).
     * @alias This method has an alias of \Swoole\Server::exist().
     * @see \Swoole\Server::exist()
     */
    public function exists(int $fd): bool
    {
    }

    /**
     * Check if a connection exists.
     *
     * @param int $fd The connection file descriptor.
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been
     *              closed. Since Swoole 6.1.2, false is also returned while the connection is still in the process of
     *              being closed (previously, true was returned until the connection was fully closed).
     * @alias Alias of method \Swoole\Server::exists().
     * @see \Swoole\Server::exists()
     */
    public function exist(int $fd): bool
    {
    }

    /**
     * Protect a connection from being closed by the heartbeat check.
     *
     * A protected connection is never treated as inactive, no matter how long it stays quiet: neither the periodic
     * heartbeat check (option \Swoole\Constant::OPTION_HEARTBEAT_CHECK_INTERVAL) nor method
     * \Swoole\Server::heartbeat() will close it.
     *
     * @param int $fd Session ID of the connection.
     * @param bool $is_protected Whether to protect the connection (true) or to remove the protection from it (false).
     * @return bool Returns true on success, or false if the connection does not exist or is already closed.
     * @see \Swoole\Server::heartbeat()
     * @see \Swoole\Constant::OPTION_HEARTBEAT_CHECK_INTERVAL
     */
    public function protect(int $fd, bool $is_protected = true): bool
    {
    }

    /**
     * Send a file to a client.
     *
     * The file is sent by the operating system directly (using the sendfile(2) system call where available), without
     * being loaded into PHP memory first.
     *
     * @param int $conn_fd Session ID of the connection.
     * @param string $filename Path of the file to send.
     * @param int $offset Offset in bytes from where the transfer starts. By default, the file is sent from the beginning.
     * @param int $length Number of bytes to send. By default, the rest of the file (starting from $offset) is sent.
     * @return bool Returns true on success. Returns false on failure, e.g., the file does not exist, the connection is invalid, or the method is called in the master process (which is not allowed).
     * @see https://man7.org/linux/man-pages/man2/sendfile.2.html
     */
    public function sendfile(int $conn_fd, string $filename, int $offset = 0, int $length = 0): bool
    {
    }

    /**
     * Close a connection.
     *
     * @param int $fd File descriptor of the connection.
     * @param bool $reset Whether to reset the connection or not.
     *                    - FALSE: If there is data pending in the send buffer of the connection, the connection is closed only after the pending data has been sent out.
     *                    - TRUE: The send buffer is discarded and the connection is closed immediately. When Swoole is built with SO_LINGER support included, the socket is also closed with a linger timeout of 0, which resets the connection (sends a TCP RST packet) instead of closing it gracefully.
     * @return bool Returns true on success, or false on failure.
     * @see SO_LINGER
     */
    public function close(int $fd, bool $reset = false): bool
    {
    }

    /**
     * Confirm current client-side connection and start receiving client-side data. This method is to protect the
     * server from DDoS attacks.
     *
     * @param int $fd Session ID of the connection.
     * @return bool Returns true on success, or false if the connection does not exist or the operation fails.
     * @alias Although this method and method \Swoole\Server::resume() are used for different purposes, they are
     *        implemented exactly the same in Swoole.
     * @see \Swoole\Server::resume()
     * @see https://github.com/deminy/swoole-by-examples/blob/master/examples/servers/ddos-protection.php Example of DDoS protection using this method
     */
    public function confirm(int $fd): bool
    {
    }

    /**
     * Pause receiving client-side data.
     *
     * @param int $fd File descriptor of the connection.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server::resume()
     */
    public function pause(int $fd): bool
    {
    }

    /**
     * Resume receiving client-side data.
     *
     * @param int $fd File descriptor of the connection.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server::pause()
     */
    public function resume(int $fd): bool
    {
    }

    /**
     * Dispatch a task to a task worker process without waiting for the result.
     *
     * Before dispatching a task, the server should
     *   - have option \Swoole\Constant::OPTION_TASK_WORKER_NUM set to a value greater than 0.
     *   - register a callback function for the onTask event.
     *   - (optional) register a callback function for the onFinish event.
     *
     * Method Server::task() can be called from the following processes:
     *   | PROCESS TYPE           | INVOCABLE? | CALLBACK? |
     *   | master process         | yes        |  no       |
     *   | manager process        | yes        |  no       |
     *   | event worker processes | yes        |  yes      |
     *   | task worker processes  | no         |  no       |
     *   | user processes         | yes        |  no       |
     *
     *   - User processes are self-defined processes attached through method Server::addProcess().
     *   - The task result is delivered back only when the task is dispatched from an event worker process. When
     *     dispatched from any other type of process, the task is flagged as "no reply": neither the onFinish event nor
     *     the callback function specified through parameter $finishCallback is triggered.
     *   - Method Server::task() cannot be called from task worker processes.
     *
     * @param mixed $data Serializable task data.
     * @param int $taskWorkerIndex ID of the task worker to which the task is assigned. If it is -1, Swoole will randomly pick an idle task worker.
     *                             Please note that task worker ID starts from 0; it ranges from 0 to $this->setting[\Swoole\Constant::OPTION_TASK_WORKER_NUM] - 1].
     * @param callable|null $finishCallback Callback function to be executed when the task is finished. If specified, the onFinish event will not be triggered.
     * @return int|false Returns the task ID on success, or false on failure. Task ID is a non-negative integer taken
     *                   from an incremental counter local to the process dispatching the task; therefore, it is unique
     *                   within that process only, and different processes may generate the same task ID.
     * @see \Swoole\Server::taskwait() From the caller's point of view, method Server::task() works asynchronously while method Server::taskwait() works synchronously.
     */
    public function task(mixed $data, int $taskWorkerIndex = -1, ?callable $finishCallback = null): int|false
    {
    }

    /**
     * Dispatch a task to a task worker process and wait for the result.
     *
     * Before dispatching a task, the server should
     *   - have option \Swoole\Constant::OPTION_TASK_WORKER_NUM set to a value greater than 0.
     *   - register a callback function for the onTask event.
     *
     * Unlike method Server::task(), method Server::taskwait() can be called from event worker processes only. Calling
     * it from any other type of process (the master process, the manager process, a task worker process, or a user
     * process attached through method Server::addProcess()) fails with warning "taskwait method can only be used in
     * the worker process".
     *
     * The task result is returned to the caller directly; the onFinish event is not triggered.
     *
     * If this method is called inside a coroutine, only the current coroutine is suspended while waiting for the task
     * result, and the other coroutines of the process keep running. Otherwise, the whole event worker process is
     * blocked until the result arrives or the timeout is exceeded.
     *
     * @param mixed $data Serializable task data.
     * @param float $timeout The maximum waiting time (in seconds) for the task result.
     * @param int $taskWorkerIndex ID of the task worker to which the task is assigned. If it is -1, Swoole will randomly pick an idle task worker.
     *                             Please note that task worker ID starts from 0; it ranges from 0 to $this->setting[\Swoole\Constant::OPTION_TASK_WORKER_NUM] - 1].
     * @return mixed Returns the task result, which is the value returned by the onTask event callback function, or the
     *               value passed to method \Swoole\Server\Task::finish() or \Swoole\Server::finish(). The value is
     *               unserialized before being returned, so it can be of any serializable type. Returns false when the
     *               timeout is exceeded, or when something goes wrong.
     * @see \Swoole\Server::task() From the caller's point of view, method Server::task() works asynchronously while method Server::taskwait() works synchronously.
     * @see \Swoole\Server::finish()
     */
    public function taskwait(mixed $data, float $timeout = 0.5, int $taskWorkerIndex = -1): mixed
    {
    }

    /**
     * Dispatch tasks to task worker processes.
     *
     * This method can be used only when the server has task worker processes included/created. i.e., the server should
     * have option \Swoole\Constant::OPTION_TASK_WORKER_NUM set to a value greater than 0.
     *
     * Before Swoole 4.8.12+ and 5.0.1+, this method doesn't support coroutine. If the server is running with option
     * Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE set to true, use method Server::taskCo() instead.
     *
     * Method \Swoole\Server::taskWaitMulti() works exactly the same as method \Swoole\Server::taskCo() when all the
     * following conditions are met:
     *   - used in Swoole 4.8.12+ or 5.0.1+.
     *   - server option \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE is set to TRUE.
     *
     * @param mixed[] $tasks List of tasks to be dispatched. Maximum number of tasks: 1024.
     * @param float $timeout The maximum waiting time (in seconds) for the task results. If the timeout is exceeded, results of unfinished tasks will be discarded.
     * @return mixed[]|false Return an array of task results, or false on failure. For details, please check the pseudocode included in this method.
     * @see \Swoole\Server::taskCo()
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function taskWaitMulti(array $tasks, float $timeout = 0.5): array|false
    {
        if (!empty($this->setting[Constant::OPTION_TASK_ENABLE_COROUTINE])) { // Task worker processes have coroutine enabled.
            if (SWOOLE_MAJOR_VERSION < 5) {
                if (version_compare(SWOOLE_VERSION, '4.8.12', '>=')) { // If Swoole version is 4.8.12 or later, but less than 5.0.0.
                    return $this->taskCo($tasks, $timeout);
                }
            } else {
                if (version_compare(SWOOLE_VERSION, '5.0.1', '>=')) { // If Swoole version is 5.0.1 or later.
                    return $this->taskCo($tasks, $timeout);
                }
            }
        }

        // Now, the server dispatches tasks to task worker processes and waits for the results.

        // Finally, let's see how the return value looks like.

        // Variable $tasks denotes an array of tasks to be dispatched, which may succeed, timeout, or fail.
        $tasks = [
            0 => 'a successfully finished task',
            1 => 'a timeout task',
            2 => 'a failed task',
        ];

        // When timeout is exceeded or all the tasks are completed, this method returns an array of task results (here we assume the return value is $results):
        //   - The array of task results matches the order of the tasks in the $tasks parameter. e.g., $results[0] is the result of $tasks[0].
        //   - If a task exceeds the timeout, it won't be included in the return value. e.g., $results[1] is not set (included) since $tasks[1] exceeds the timeout.
        //   - If a task fails, the corresponding result will be false. e.g., $results[2] is false since $tasks[2] fails.
        return [
            0 => 'a successfully finished task',
            2 => false,
        ];
    }

    /**
     * To dispatch tasks to task worker processes, with the following constraints applied:
     *   - The server should have option \Swoole\Constant::OPTION_TASK_WORKER_NUM set to a value greater than 0.
     *   - The server should have option \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE set to true.
     *
     * Here is a piece of code to illustrate how to configure the server before using this method:
     *   $server = new \Swoole\Server('0.0.0.0', 9501);
     *   $server->set(
     *     [
     *       \Swoole\Constant::OPTION_TASK_WORKER_NUM       => 3,    // Have three task worker processes included/created.
     *       \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE => true, // Support coroutine in task worker processes.
     *       // ...
     *     ]
     *   );
     *
     * Method \Swoole\Server::taskCo() works exactly the same as method \Swoole\Server::taskWaitMulti() when all the
     * following conditions are met:
     *   - used in Swoole 4.8.12+ or 5.0.1+.
     *   - server option \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE is set to TRUE.
     *
     * @param mixed[] $tasks List of tasks to be dispatched. Maximum number of tasks: 1024.
     * @param float $timeout The maximum waiting time (in seconds) for the task results. If the timeout is exceeded, results of unfinished tasks will be discarded.
     * @return mixed[]|false Return an array of task results, or false on failure. For details, please check the pseudocode included in this method.
     * @see \Swoole\Server::taskWaitMulti()
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function taskCo(array $tasks, float $timeout = 0.5): array|false
    {
        // The pseudocode here shows how the return value looks like.

        // Variable $tasks denotes an array of tasks to be dispatched, which may succeed, timeout, or fail.
        $tasks = [
            0 => 'a successfully finished task',
            1 => 'a timeout task',
            2 => 'a failed task',
        ];

        // When timeout is exceeded or all the tasks are completed, this method returns an array of task results (here we assume the return value is $results):
        //   - The array of task results matches the order of the tasks in the $tasks parameter. e.g., $results[0] is the result of $tasks[0].
        //   - If a task fails or exceeds the timeout, the corresponding result will be false. e.g., $results[1] is false since $tasks[1] exceeds the timeout.
        return [
            0 => 'result of $tasks[0]',
            1 => false,
            2 => false,
        ];
    }

    /**
     * Send the result of a task back from a task worker process to the event worker process that dispatched the task.
     *
     * This method can only be called inside the onTask event callback, in task worker processes. It delivers the
     * result back to the dispatching event worker process, where the onFinish event callback (or the finish callback
     * function passed to method \Swoole\Server::task(), if any) is triggered, or where a call to method
     * \Swoole\Server::taskwait() (and alike) waiting for the result gets it returned. Returning a non-null value from
     * the onTask event callback has the same effect as calling this method.
     *
     * When the server runs with option \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE enabled, this method can't be
     * used; use method \Swoole\Server\Task::finish() instead.
     *
     * @param mixed $data Serializable data of the task result.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server\Task::finish()
     * @see \Swoole\Server::task()
     * @see \Swoole\Server::taskwait()
     * @see \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE
     */
    public function finish(mixed $data): bool
    {
    }

    /**
     * Reload worker processes.
     *
     * This method can be used to reload event worker processes and task worker processes. It won't reload the master
     * process, the manager process, or user processes.
     *
     * The reloading is carried out by the manager process; this method simply sends signal SIGUSR1 (to reload all the
     * worker processes) or SIGUSR2 (to reload task worker processes only) to it. Therefore, a manager process is
     * required. There is no manager process when the server runs in the BASE mode with a single event worker process,
     * no task worker process, no user process, and option \Swoole\Constant::OPTION_MAX_REQUEST unset; in that case this
     * method fails with error "not supported with single process mode".
     *
     * In the THREAD mode (SWOOLE_THREAD), worker threads are reloaded instead of worker processes.
     *
     * @param bool $only_reload_taskworker Whether to reload task worker processes only or not.
     *                                     - TRUE: Only task worker processes will be reloaded.
     *                                     - FALSE: Both event worker processes and task worker processes will be reloaded.
     * @return bool Return true on success, or false on failure.
     */
    public function reload(bool $only_reload_taskworker = false): bool
    {
    }

    /**
     * Shutdown the server.
     *
     * This method has the same effect as the following command line commands:
     *   - kill -SIGTERM $master_pid
     *   - kill -15      $master_pid
     * The above commands send TERM signals to the master process of the Swoole server. $master_pid is the process ID of
     * the master process.
     *
     * This method can be called from worker processes.
     *
     * @return bool TRUE on success, FALSE on failure.
     */
    public function shutdown(): bool
    {
    }

    /**
     * Stop a worker process (either an event worker process or a task worker process).
     *
     * The worker process exits gracefully. When there is a manager process, it then creates a new worker process to
     * replace the stopped one.
     *
     * When stopping the current worker process from within itself, the exit happens right after the current event
     * callback returns. Any other worker process is stopped by sending signal SIGTERM to it. In the SWOOLE_THREAD
     * mode, a shutdown message is delivered to the target worker thread instead.
     *
     * The signature of this method changed in Swoole 6.1.0:
     *   - before: public function stop(int $workerId = -1, bool $waitEvent = false): bool
     *   - now:    public function stop(int $workerId = -1): bool
     *
     * The second parameter $waitEvent was dropped. To let a worker process finish the events already queued in its
     * event loop before it exits, turn on server option "reload_async" through method \Swoole\Server::set() instead.
     *
     * @param int $workerId ID of the worker process to stop. By default (-1), the current worker process is stopped.
     * @return bool Returns true on success. Returns false on failure, e.g., the server is not running yet, or the worker ID given is invalid.
     * @see \Swoole\Server::shutdown()
     * @see \Swoole\Server::set()
     * @see \Swoole\Constant::OPTION_RELOAD_ASYNC
     */
    public function stop(int $workerId = -1): bool
    {
    }

    /**
     * Get the error code of the latest failed operation.
     *
     * To translate the error code to an error message, use the following statement:
     *     \swoole_strerror($server->getLastError(), SWOOLE_STRERROR_SWOOLE);
     *
     * @return int The error code of the latest failed operation. The error codes are defined in the SWOOLE_ERROR_* constants.
     * @alias This method is an alias of function \swoole_last_error().
     * @see \swoole_last_error()
     * @see \swoole_strerror()
     */
    public function getLastError(): int
    {
    }

    /**
     * Find connections that haven't sent any data to the server for a long time, and optionally close them.
     *
     * A connection is treated as inactive when no data has been received from it for more than the number of seconds
     * set by option \Swoole\Constant::OPTION_HEARTBEAT_IDLE_TIME on the port the connection is on. Connections
     * protected by method \Swoole\Server::protect() are never treated as inactive.
     *
     * NOTE: the method signature published by Swoole declares parameter $ifCloseConnection with a default value of
     * true, but the underlying implementation treats an omitted argument as false. In other words, when this method is
     * called without an argument, the inactive connections found are NOT closed; pass true explicitly to have them
     * closed. The default value declared here reflects the actual behavior.
     *
     * @param bool $ifCloseConnection Whether to close the inactive connections found or not.
     * @return array|false Returns an array of session IDs of the inactive connections found. Returns false on failure, e.g., the server is not running yet, or option \Swoole\Constant::OPTION_HEARTBEAT_CHECK_INTERVAL is not set on the server.
     * @see \Swoole\Server::protect()
     * @see \Swoole\Constant::OPTION_HEARTBEAT_IDLE_TIME
     * @see \Swoole\Constant::OPTION_HEARTBEAT_CHECK_INTERVAL
     * @see https://github.com/swoole/swoole-src/blob/v6.2.2/ext-src/swoole_server.cc#L3054 The actual default value of parameter $ifCloseConnection
     */
    public function heartbeat(bool $ifCloseConnection = false): array|false
    {
    }

    /**
     * Get information of a connection.
     *
     * The return value is an array with the following keys included:
     *   - server_fd: File descriptor of the listening socket (the server-side socket) the connection was accepted on.
     *   - socket_fd: File descriptor of the connection itself. Please note that it is not the session ID (parameter $fd).
     *   - socket_type: Type of the socket. e.g., SWOOLE_SOCK_TCP.
     *   - remote_port: Port number of the client side.
     *   - remote_ip: IP address of the client side.
     *   - reactor_id: ID of the reactor thread (in the SWOOLE_PROCESS mode) or of the event worker process (in the
     *     SWOOLE_BASE mode) the connection belongs to.
     *   - connect_time: The timestamp (in seconds) when the connection was established.
     *   - last_time: The timestamp (in seconds) when data was last received on the connection. It's the integer part
     *     of the value of key "last_recv_time".
     *   - last_recv_time: The timestamp (in seconds, with microsecond precision) when data was last received on the connection.
     *   - last_send_time: The timestamp (in seconds, with microsecond precision) when data was last sent on the connection.
     *   - last_dispatch_time: The timestamp (in seconds, with microsecond precision) when data of the connection was
     *     last dispatched to an event worker process.
     *   - close_errno: The error code set when the connection failed to close. It is 0 if no error happened.
     *   - recv_queued_bytes: Number of bytes received but not processed yet.
     *   - send_queued_bytes: Number of bytes waiting in the send buffer to be sent out.
     *   - server_port: The port number the connection is on. Optional; included only when the listening socket the
     *     connection was accepted on can still be found.
     *   - uid: The user ID bound to the connection through method \Swoole\Server::bind(). Optional; included only when
     *     a user ID has been bound, or when the server runs with option \Swoole\Constant::OPTION_DISPATCH_MODE set to
     *     SWOOLE_DISPATCH_UIDMOD.
     *   - worker_id: ID of the event worker process the connection is bound to. Optional; included only when the
     *     connection is bound to an event worker process, or when the server runs with option
     *     \Swoole\Constant::OPTION_DISPATCH_MODE set to SWOOLE_DISPATCH_CO_CONN_LB.
     *   - websocket_status: Status of the WebSocket connection (one of the SWOOLE_WEBSOCKET_STATUS_* constants).
     *     Optional; included only when the WebSocket protocol is enabled on the port the connection is on.
     *   - ssl_client_cert: The client-side SSL certificate in PEM format. Optional; included only when the client sends
     *     one, and only in the process where the certificate was received.
     *
     * @param int $fd File descriptor of the connection.
     * @param int $reactor_id This parameter is accepted for backward compatibility only; it is not used at all.
     * @param bool $ignoreError Whether to return information of a closed connection or not. By default, false is
     *                          returned for a connection that is not active (established) anymore; set this parameter
     *                          to TRUE to have the information of such a connection returned.
     * @return array|false Return an array of connection information, or false on failure.
     * @alias This method has an alias of \Swoole\Server::connection_info().
     * @see \Swoole\Server::connection_info()
     * @see SWOOLE_DISPATCH_UIDMOD
     * @see SWOOLE_DISPATCH_CO_CONN_LB
     */
    public function getClientInfo(int $fd, int $reactor_id = -1, bool $ignoreError = false): array|false
    {
    }

    /**
     * Get session IDs of current active connections, in batches.
     *
     * At most $find_count session IDs are returned per call. To walk through all the connections of the server, pass
     * the last session ID of the previous batch as parameter $start_fd of the next call, and repeat until the method
     * returns false. Alternatively, iterate over property \Swoole\Server::$connections instead.
     *
     * @param int $start_fd Session ID to start searching from; the connection with this session ID itself is not included in the result. By default (0), searching starts from the very first connection.
     * @param int $find_count Maximum number of session IDs to return. It can't be greater than 100.
     * @return array|false Returns a list of session IDs on success. Returns false on failure, e.g., the server is not running yet, parameter $find_count is greater than 100, parameter $start_fd is not an existing session ID, or there are no more connections to return.
     * @alias This method has an alias of \Swoole\Server::connection_list().
     * @see \Swoole\Server::connection_list()
     * @see \Swoole\Server::$connections
     */
    public function getClientList(int $start_fd = 0, int $find_count = 10): array|false
    {
    }

    /**
     * Get the ID of current worker (either an event worker or a task worker).
     *
     * @return int|false Returns the ID of current worker. Returns false if not called within a worker process (either
     *                   an event worker process or a task worker process).
     * @since 4.5.0
     */
    public function getWorkerId(): int|false
    {
    }

    /**
     * Get the process ID of a given worker process (specified by a worker ID).
     *
     * @param int $worker_id ID of the worker process (either an event worker or a task worker). By default (-1), the current worker process.
     * @return int|false Returns the process ID of a given worker process (specified by a worker ID). If the worker ID
     *                   is a negative integer or not passed in, returns the process ID of current worker process.
     *                   Returns false if something wrong happens (e.g., the worker process doesn't exist, or an invalid
     *                   worker ID specified.).
     * @since 4.5.0
     */
    public function getWorkerPid(int $worker_id = -1): int|false
    {
    }

    /**
     * Get the status of a worker process (either an event worker or a task worker).
     *
     * @param int $worker_id ID of the worker process. By default (-1), the current worker process.
     * @return int|false Returns the status of the worker process: SWOOLE_WORKER_BUSY (when it is busy handling a
     *                   request/task), SWOOLE_WORKER_IDLE (when it is waiting for one), or SWOOLE_WORKER_EXIT (when it
     *                   is exiting). Returns false if the server is not running yet or the worker ID given is invalid.
     * @see SWOOLE_WORKER_BUSY
     * @see SWOOLE_WORKER_IDLE
     * @see SWOOLE_WORKER_EXIT
     * @since 4.5.0
     */
    public function getWorkerStatus(int $worker_id = -1): int|false
    {
    }

    /**
     * Get the process ID of the manager process.
     *
     * @return int Process ID of the manager process. It is 0 when there is no manager process (e.g., before the server is started).
     * @see \Swoole\Server::$manager_pid
     * @since 4.5.0
     */
    public function getManagerPid(): int
    {
    }

    /**
     * Get the process ID of the master process.
     *
     * @return int Process ID of the master process. It is 0 before the server is started.
     * @see \Swoole\Server::$master_pid
     * @since 4.5.0
     */
    public function getMasterPid(): int
    {
    }

    /**
     * Get information of a connection.
     *
     * @param int $fd File descriptor of the connection.
     * @param int $reactor_id This parameter is accepted for backward compatibility only; it is not used at all.
     * @param bool $ignoreError Whether to return information of a closed connection or not. By default, false is
     *                          returned for a connection that is not active (established) anymore; set this parameter
     *                          to TRUE to have the information of such a connection returned.
     * @return array|false Return an array of connection information, or false on failure. For the list of keys included in the array, please check method \Swoole\Server::getClientInfo().
     * @alias Alias of method \Swoole\Server::getClientInfo().
     * @see \Swoole\Server::getClientInfo()
     */
    public function connection_info(int $fd, int $reactor_id = -1, bool $ignoreError = false): array|false
    {
    }

    /**
     * Get session IDs of current active connections, in batches.
     *
     * @param int $start_fd Session ID to start searching from; the connection with this session ID itself is not included in the result. By default (0), searching starts from the very first connection.
     * @param int $find_count Maximum number of session IDs to return. It can't be greater than 100.
     * @return array|false Returns a list of session IDs on success, or false on failure. For details, please check method \Swoole\Server::getClientList().
     * @alias Alias of method \Swoole\Server::getClientList().
     * @see \Swoole\Server::getClientList()
     */
    public function connection_list(int $start_fd = 0, int $find_count = 10): array|false
    {
    }

    /**
     * Send a message to a worker process (either an event worker process or a task worker process).
     *
     * A callback function for the onPipeMessage event must have been registered before this method is used; otherwise
     * this method fails.
     *
     * @param mixed $message A string message or serializable data.
     * @param int $dst_worker_id Target worker ID. It must be in the range of 0 to
     *                           ($this->setting[\Swoole\Constant::OPTION_WORKER_NUM] + $this->setting[\Swoole\Constant::OPTION_TASK_WORKER_NUM] - 1),
     *                           where event worker processes come first, followed by task worker processes. There is no
     *                           way to broadcast a message to all the worker processes at once; any value out of the
     *                           range, including -1, makes this method fail. A worker process can't send a message to
     *                           itself either.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server\PipeMessage
     */
    public function sendMessage(mixed $message, int $dst_worker_id): bool
    {
    }

    /**
     * Run a customized command in a specified process of Swoole.
     *
     * The command must have been registered through method \Swoole\Server::addCommand() before the server started.
     * This method must be called inside a coroutine; the current coroutine is suspended until the response of the
     * command arrives.
     *
     * @param string $name Name of the command to run.
     * @param int $process_id ID of the target process, e.g., a worker ID when the command runs in an event worker or a task worker process.
     * @param int $process_type Type of the target process. It should be one of the constants SWOOLE_SERVER_COMMAND_MASTER, SWOOLE_SERVER_COMMAND_MANAGER, SWOOLE_SERVER_COMMAND_EVENT_WORKER, and SWOOLE_SERVER_COMMAND_TASK_WORKER.
     * @param mixed $data Data to pass to the callback function of the command. It is JSON-encoded before being sent to the target process, so it must be JSON-serializable.
     * @param bool $json_decode If the callback function of the command returns a JSON encoded string back, it can be decoded automatically by setting this parameter to TRUE.
     * @return string|array|false Returns the response of the command: the raw string returned by the callback function
     *                            of the command when parameter $json_decode is false, or the JSON-decoded value of it
     *                            otherwise. Returns false on failure, e.g., the server is not running yet, the data
     *                            given can't be JSON-encoded, the command doesn't exist, or the target process is invalid.
     * @see \Swoole\Server::addCommand()
     * @see SWOOLE_SERVER_COMMAND_MASTER
     * @see SWOOLE_SERVER_COMMAND_MANAGER
     * @see SWOOLE_SERVER_COMMAND_EVENT_WORKER
     * @see SWOOLE_SERVER_COMMAND_TASK_WORKER
     * @since 4.8.0
     */
    public function command(string $name, int $process_id, int $process_type, mixed $data, bool $json_decode = true): string|array|false
    {
    }

    /**
     * Add a customized command.
     *
     * Commands can be added to the master process, the manager process, or worker processes. Commands can only be added
     * before the server is started.
     *
     * @param string $name Name of the command.
     * @param int $accepted_process_types One or multiple types of processes. e.g., "SWOOLE_SERVER_COMMAND_EVENT_WORKER | SWOOLE_SERVER_COMMAND_TASK_WORKER". Reactor threads (SWOOLE_SERVER_COMMAND_REACTOR_THREAD) are not supported.
     * @param callable $callback The callback function should return a (serialized) string back.
     * @return bool TRUE if succeeds, otherwise FALSE.
     * @see \Swoole\Server::command()
     * @see SWOOLE_SERVER_COMMAND_MASTER
     * @see SWOOLE_SERVER_COMMAND_MANAGER
     * @see SWOOLE_SERVER_COMMAND_EVENT_WORKER
     * @see SWOOLE_SERVER_COMMAND_TASK_WORKER
     * @since 4.8.0
     */
    public function addCommand(string $name, int $accepted_process_types, callable $callback): bool
    {
    }

    /**
     * Attach a user process to the server.
     *
     * The attached process is started when the server starts, and restarted automatically by the manager process when
     * it exits. This method can only be called before the server is started.
     *
     * @param Process $process The process to attach to the server.
     * @return int|false Return the ID of the process (\Swoole\Process::$id) back if succeeds; otherwise return FALSE.
     * @see \Swoole\Process::$id
     */
    public function addProcess(Process $process): int|false
    {
    }

    /**
     * Get statistics of the server.
     *
     * If the server is not running yet, a warning is raised and false is returned instead of an array.
     *
     * @return array Statistics of the server, including (among others) the following keys:
     *               - start_time: The timestamp (in seconds) when the server was started.
     *               - connection_num: Number of current active connections.
     *               - abort_count: Number of connections aborted.
     *               - accept_count: Number of connections accepted.
     *               - close_count: Number of connections closed.
     *               - worker_num: Number of event worker processes.
     *               - task_worker_num: Number of task worker processes.
     *               - user_worker_num: Number of user processes attached through method \Swoole\Server::addProcess().
     *               - idle_worker_num: Number of idle event worker processes.
     *               - dispatch_count: Number of requests/messages dispatched by the master process to event worker processes.
     *               - request_count: Number of requests received by the server.
     *               - response_count: Number of responses sent out by the server.
     *               - total_recv_bytes: Total number of bytes received.
     *               - total_send_bytes: Total number of bytes sent out.
     *               - pipe_packet_msg_id: Internal counter of messages transferred between processes through pipes.
     *               - concurrency: Number of requests being processed at the moment.
     *               - session_round: Internal counter used to generate session IDs.
     *               - min_fd: The smallest file descriptor among current active connections.
     *               - max_fd: The largest file descriptor among current active connections.
     *               - coroutine_num: Number of active coroutines in the current process.
     *               - coroutine_peek_num: Peak number of coroutines in the current process.
     *               When called in a worker process, keys worker_request_count, worker_response_count,
     *               worker_dispatch_count, and worker_concurrency report the same type of counters at the level of the
     *               current worker process. When the server has task worker processes, keys task_idle_worker_num,
     *               tasking_num, and task_count are included as well (plus task_queue_num and task_queue_bytes when
     *               tasks are delivered through a message queue).
     * @see \Swoole\Server::addProcess()
     */
    public function stats(): array
    {
    }

    /**
     * Get the socket handle bound to the given port of the server.
     *
     * This method is available only when Swoole is installed with option "--enable-sockets" included.
     *
     * A port is looked up by port number, which means only network sockets can be located through parameter $port,
     * since UNIX domain sockets have no port number bound to them. A UNIX domain socket can still be retrieved when it
     * is bound to the primary port, by leaving parameter $port unset.
     *
     * @param int $port Port number. Use the primary port (the first port of property \Swoole\Server::$ports) if not
     *                  passed in or passed in as 0. The behavior is undefined when the server is not listening on the
     *                  given port.
     * @return \Socket|false Returns a Socket object on success; otherwise FALSE. Since Swoole 6.1.2, the returned
     *                       Socket object holds a duplicate of the underlying socket handle instead of the original
     *                       one, so closing the returned Socket object no longer affects the socket held by Swoole.
     * @see \Swoole\Server\Port::getSocket()
     */
    public function getSocket(int $port = 0): \Socket|false
    {
    }

    /**
     * Bind a user-defined ID to a connection.
     *
     * Once bound, the ID shows up as field "uid" in the return value of method \Swoole\Server::getClientInfo(). When
     * the server runs with option \Swoole\Constant::OPTION_DISPATCH_MODE set to SWOOLE_DISPATCH_UIDMOD, data received
     * from connections is dispatched to event worker processes based on this ID (instead of the session ID), so that
     * data from connections sharing the same ID is always processed by the same worker process.
     *
     * @param int $fd File descriptor of the connection.
     * @param int $uid The ID to bind to the connection. It must fit in a 32-bit integer. A connection can have an ID bound to it once only.
     * @return bool Returns true on success. Returns false on failure, e.g., the connection does not exist, the connection already has an ID bound to it, or parameter $uid is out of range.
     * @see \Swoole\Server::getClientInfo()
     * @see SWOOLE_DISPATCH_UIDMOD
     */
    public function bind(int $fd, int $uid): bool
    {
    }
}
