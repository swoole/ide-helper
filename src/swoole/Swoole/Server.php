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
    public $setting;

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

    public $ports;

    /**
     * Process ID of the master process.
     */
    public $master_pid = 0;

    /**
     * Process ID of the manager process.
     */
    public $manager_pid = 0;

    public $worker_id = -1;

    public $taskworker = false;

    public $worker_pid = 0;

    public $stats_timer;

    /**
     * @since 4.8.0
     */
    public AdminServer $admin_server;

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
     * @see https://github.com/swoole/swoole-src/blob/v6.0.2/ext-src/swoole_server.cc#L53
     * @see https://github.com/swoole/swoole-src/blob/v6.0.2/ext-src/swoole_server_port.cc#L33
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

    public function send(int|string $fd, string $send_data, int $serverSocket = -1): bool
    {
    }

    public function sendto(string $ip, int $port, string $send_data, int $server_socket = -1): bool
    {
    }

    public function sendwait(int $conn_fd, string $send_data): bool
    {
    }

    /**
     * Check if a connection exists.
     *
     * @param int $fd The connection file descriptor.
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been closed.
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
     * @return bool Returns true if the connection exists, or false if the connection does not exist or has been closed.
     * @alias Alias of method \Swoole\Server::exists().
     * @see \Swoole\Server::exists()
     */
    public function exist(int $fd): bool
    {
    }

    public function protect(int $fd, bool $is_protected = true): bool
    {
    }

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

    public function stop(int $workerId = -1, bool $waitEvent = false): bool
    {
    }

    /**
     * Get the error code of the latest failed operation.
     *
     * To translate the error code to an error message, use the following statement:
     *     \swoole_strerror($server->getLastError(), SWOOLE_STRERROR_SWOOLE);
     *
     * @alias This method is an alias of function \swoole_last_error().
     * @see \swoole_last_error()
     * @see \swoole_strerror()
     */
    public function getLastError(): int
    {
    }

    public function heartbeat(bool $ifCloseConnection = true): array|false
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
     * @alias This method has an alias of \Swoole\Server::connection_list().
     * @see \Swoole\Server::connection_list()
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
     * @since 4.5.0
     */
    public function getWorkerStatus(int $worker_id = -1): int|false
    {
    }

    /**
     * @since 4.5.0
     */
    public function getManagerPid(): int
    {
    }

    /**
     * @since 4.5.0
     */
    public function getMasterPid(): int
    {
    }

    /**
     * @alias Alias of method \Swoole\Server::getClientInfo().
     * @see \Swoole\Server::getClientInfo()
     */
    public function connection_info(int $fd, int $reactor_id = -1, bool $ignoreError = false): array|false
    {
    }

    /**
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
     * @param bool $json_encode If the callback function of the command returns a JSON encoded string back, it can be decoded automatically by setting this parameter to TRUE.
     * @see \Swoole\Server::addCommand()
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
     * @param int $accepted_process_types One or multiple types of processes. e.g., "SWOOLE_SERVER_COMMAND_EVENT_WORKER | SWOOLE_SERVER_COMMAND_TASK_WORKER".
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
     * @return int|false Return the ID of the process (\Swoole\Process::$id) back if succeeds; otherwise return FALSE.
     * @see \Swoole\Process::$id
     */
    public function addProcess(Process $process): int|false
    {
    }

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
     * @return \Socket|false Returns a Socket object on success; otherwise FALSE.
     * @see \Swoole\Server\Port::getSocket()
     */
    public function getSocket(int $port = 0): \Socket|false
    {
    }

    public function bind(int $fd, int $uid): bool
    {
    }
}
