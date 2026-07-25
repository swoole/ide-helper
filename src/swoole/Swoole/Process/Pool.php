<?php

declare(strict_types=1);

namespace Swoole\Process;

use Swoole\Process;

/**
 * A process pool manages a fixed-size group of worker processes: the master process (the process where the pool is
 * created and started) forks the given number of worker processes, replaces them with new ones when they quit, and,
 * depending on the IPC mode chosen, dispatches messages to them.
 *
 * @not-serializable Objects of this class cannot be serialized.
 */
class Pool
{
    /**
     * Process ID of the master process of the pool. The master process is the process where the Pool object is created.
     *
     * This property will be set to a positive integer when method \Swoole\Process\Pool::start() is called successfully.
     *
     * @readonly
     * @since 4.3.2
     */
    public int $master_pid = -1;

    /**
     * Process ID of the current worker process.
     *
     * This property is set right before the "onWorkerStart" callback function of the pool is called when starting the
     * worker process. It remains the same throughout the life cycle of the worker process.
     *
     * @since 6.0.0
     * @readonly
     */
    public int $workerPid = -1;

    /**
     * ID of the current worker process.
     *
     * This property is set right before the "onWorkerStart" callback function of the pool is called when starting the
     * worker process. It remains the same throughout the life cycle of the worker process.
     *
     * @since 6.0.0
     * @readonly
     */
    public int $workerId = -1;

    /**
     * List of the worker processes.
     *
     * A worker process is added to this list only when the process is return from an explicit method call to \Swoole\Process\Pool::getProcess(). Thus, this property may not have all the worker processes included.
     *
     * @var Process[]|null
     * @see \Swoole\Process\Pool::getProcess()
     * @since 4.4.0
     */
    public ?array $workers = null;

    /**
     * If current worker process is considered as running or not.
     *
     * This property is set to TRUE right before the "onWorkerStart" callback function of the pool is called when
     * starting the worker process. It will be set to FALSE before the "onWorkerStop", "onWorkerExit", or "onShutdown"
     * callback function is called.
     *
     * @since 6.0.0
     * @readonly
     */
    public bool $workerRunning = true;

    /**
     * If current (master or worker) process is considered as running or not.
     *
     * @since 6.0.0
     * @readonly
     */
    public bool $running = true;

    /**
     * The constructor.
     *
     * A process pool can be created in PHP CLI mode only, and at most one process pool can be created in a process. It
     * can't be created when a \Swoole\Server object exists. An \Error is thrown out when any of these rules is broken.
     *
     * Coroutine support doesn't have to be enabled when creating the process pool. It can be enabled later by calling
     * method \Swoole\Process\Pool::set([\Swoole\Constant::OPTION_ENABLE_COROUTINE => true]).
     *
     * There are four IPC modes to choose from, which decide how the master process communicates with the worker
     * processes:
     *   - SWOOLE_IPC_NONE (0, the default): No IPC channel is created. Worker processes don't receive messages from
     *     the master process, which means event onMessage is not available; the callback function of event
     *     onWorkerStart is where the code of a worker process runs.
     *   - SWOOLE_IPC_UNIXSOCK (1): IPC over UNIX domain sockets. Messages are delivered to a specific worker process
     *     through method \Swoole\Process\Pool::sendMessage().
     *   - SWOOLE_IPC_MSGQUEUE (2): IPC over a System V message queue identified by parameter $msgqueue_key. Since
     *     Swoole 6.1.3, this mode fails with a warning on systems where System V message queues are not available
     *     (e.g., when Swoole was built on a platform without that feature).
     *   - SWOOLE_IPC_SOCKET (3): IPC over a network socket. Method \Swoole\Process\Pool::listen() is used to listen on
     *     a port, and method \Swoole\Process\Pool::write() to send data back to the client.
     *
     * @param int $worker_num Number of worker processes in the pool. It must be greater than 0; otherwise, a
     *                        \Swoole\Exception is thrown out.
     * @param int $ipc_type One of the four IPC modes described above. When coroutine support is enabled, it must be
     *                      either SWOOLE_IPC_NONE or SWOOLE_IPC_UNIXSOCK; otherwise, an \Error is thrown out.
     * @param int $msgqueue_key Key of the System V message queue. It's used only when $ipc_type is
     *                          SWOOLE_IPC_MSGQUEUE.
     * @param bool $enable_coroutine Support coroutine or not in the worker processes. Default to false. When enabled,
     *                               a callback function has to be registered for event onWorkerStart, and event
     *                               onMessage is dispatched only when $ipc_type is SWOOLE_IPC_UNIXSOCK.
     * @see \Swoole\Process\Pool::set()
     * @see \Swoole\Process\Pool::on()
     */
    public function __construct(int $worker_num, int $ipc_type = SWOOLE_IPC_NONE, int $msgqueue_key = 0, bool $enable_coroutine = false)
    {
    }

    /**
     * The destructor.
     *
     * There is no need to call this method directly. The resources held by the pool are released internally when the
     * object is destroyed.
     */
    public function __destruct()
    {
    }

    /**
     * Set runtime options for the process pool.
     *
     * This method should be called before method \Swoole\Process\Pool::start() is called.
     *
     * Besides all the global options, coroutine options, and AIO options, the following four options are supported:
     *   - \Swoole\Constant::OPTION_ENABLE_COROUTINE (bool): Enable coroutine support in the worker processes or not.
     *     Default to false.
     *   - \Swoole\Constant::OPTION_ENABLE_MESSAGE_BUS (bool): Transfer messages between the master process and the
     *     worker processes over the message bus or not. Default to false. The message bus splits a message into chunks
     *     when needed, which allows messages larger than the socket buffer to be delivered through method
     *     \Swoole\Process\Pool::sendMessage(). It works only when the IPC mode of the pool is SWOOLE_IPC_UNIXSOCK;
     *     otherwise, method \Swoole\Process\Pool::start() fails with a warning logged.
     *   - \Swoole\Constant::OPTION_MAX_PACKAGE_SIZE (int): Maximum size of a message a worker process can receive, in
     *     bytes. Default to 2097152 (2 MB). In IPC mode SWOOLE_IPC_SOCKET, a connection sending a larger package is
     *     closed.
     *   - \Swoole\Constant::OPTION_MAX_WAIT_TIME (int): Number of seconds the master process waits for a worker
     *     process to quit gracefully, when shutting down or reloading the pool. Default to 3. The master process sends
     *     a SIGTERM signal to the worker processes first, then force kills the ones still alive after the given number
     *     of seconds with a SIGKILL signal. When 0 is set, worker processes are never force killed. Added in Swoole
     *     6.0.1.
     *
     * @param array $settings Runtime options, as described above.
     * @see \Swoole\Constant::OPTION_ENABLE_COROUTINE
     * @see \Swoole\Constant::OPTION_ENABLE_MESSAGE_BUS
     * @see \Swoole\Constant::OPTION_MAX_PACKAGE_SIZE
     * @see \Swoole\Constant::OPTION_MAX_WAIT_TIME
     * @since 4.4.4
     */
    public function set(array $settings): void
    {
    }

    /**
     * Register a callback function to be called when an event occurs.
     *
     * This method should be called before method \Swoole\Process\Pool::start() is called. Event names are
     * case-insensitive.
     *
     * There are six events supported:
     *   - \Swoole\Constant::EVENT_START: Triggered in the master process, right before the worker processes are
     *     forked.
     *   - \Swoole\Constant::EVENT_SHUTDOWN: Triggered in the master process when shutting down the pool, right before
     *     the worker processes are terminated.
     *   - \Swoole\Constant::EVENT_WORKER_START: Triggered in a worker process when the worker process starts.
     *   - \Swoole\Constant::EVENT_WORKER_STOP: Triggered in a worker process, right before the worker process quits.
     *   - \Swoole\Constant::EVENT_WORKER_EXIT: Triggered in a worker process when the event loop of the worker process
     *     is about to quit, after the worker process has received a SIGTERM signal. It's available only when coroutine
     *     support is enabled; otherwise, a \Swoole\Exception is thrown out when method \Swoole\Process\Pool::start()
     *     is called.
     *   - \Swoole\Constant::EVENT_MESSAGE: Triggered in a worker process when a message is received from the master
     *     process (or, in IPC mode SWOOLE_IPC_SOCKET, from a client). It's not available when the IPC mode of the pool
     *     is SWOOLE_IPC_NONE; a \Swoole\Exception is thrown out in that case.
     *
     * @param string $name Event name.
     * @param callable $callback The callback function to be called when the event $name is triggered.
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when the pool
     *              has been started already, or when an unknown event name is given.
     * @see \Swoole\Constant::EVENT_START
     * @see \Swoole\Constant::EVENT_SHUTDOWN
     * @see \Swoole\Constant::EVENT_WORKER_START
     * @see \Swoole\Constant::EVENT_WORKER_STOP
     * @see \Swoole\Constant::EVENT_WORKER_EXIT
     * @see \Swoole\Constant::EVENT_MESSAGE
     */
    public function on(string $name, callable $callback): bool
    {
    }

    /**
     * Return the worker process by its ID.
     *
     * The ID of a worker process is the index of the worker process in the pool. The ID of the first worker process is
     * 0, and the ID of the last worker process is the number of worker processes minus 1.
     *
     * During the life cycle of a pool, new worker processes are created when the old ones are stopped. That way, there
     * are always same amount of worker processes in the pool. The Process object returned by this method is always the
     * same one as long as the ID is the same, even if the process is stopped and recreated.
     *
     * Worker processes are created when method \Swoole\Process\Pool::start() is called successfully. Thus, this method
     * should only be called after method \Swoole\Process\Pool::start() has been called, and it should be called in the
     * callback functions of worker processes, e.g., onWorkerStart.
     *
     * @param int $work_id ID of the work process to get.
     *                     - It should be greater than or equal to 0 and less than the number of worker processes in the pool.
     *                     - If it's not passed or a negative integer is passed, ID of the current worker process will be used.
     * @return Process|false Returns a worker process object back; returns false when the worker process doesn't
     *                       exist (an E_WARNING level error is thrown out in this case) or when the pool hasn't been
     *                       started yet.
     */
    public function getProcess(int $work_id = -1): Process|false
    {
    }

    /**
     * Create the server socket that the worker processes of the pool accept connections from, in IPC mode
     * SWOOLE_IPC_SOCKET.
     *
     * This method can only be used when the IPC mode of the pool is SWOOLE_IPC_SOCKET, and it must be called before
     * method \Swoole\Process\Pool::start() is called. Data received from a client connection is dispatched to a
     * worker process and delivered through the "onMessage" event; method \Swoole\Process\Pool::write() is used to
     * send data back to the client.
     *
     * @param string $host The IP address to listen on, e.g., "127.0.0.1" or "0.0.0.0". To listen on a Unix domain
     *                     socket instead, prefix the path with "unix:", e.g., "unix:/tmp/pool.sock" (parameter $port
     *                     is ignored in that case).
     * @param int $port The port to listen on. It's ignored when listening on a Unix domain socket.
     * @param int $backlog Maximum number of pending connections queued by the operating system for the listening
     *                     socket.
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when the pool
     *              has been started already or when the IPC mode of the pool is not SWOOLE_IPC_SOCKET; it also
     *              returns false when the socket fails to listen (e.g., the port is in use).
     * @see \Swoole\Process\Pool::write()
     * @see \Swoole\Process\Pool::on()
     */
    public function listen(string $host, int $port = 0, int $backlog = 2048): bool
    {
    }

    /**
     * Send data back to the client being served, in IPC mode SWOOLE_IPC_SOCKET.
     *
     * This method is to be called inside a worker process, typically in the callback function of the "onMessage"
     * event, to respond to the client whose data is being handled; the connection is closed once the response has
     * been sent. It can only be used when the IPC mode of the pool is SWOOLE_IPC_SOCKET.
     *
     * @param string $data The data to send. It can't be empty.
     * @return bool Returns true on success. It returns false when $data is empty or when the response fails to be
     *              sent; it also returns false, with an E_WARNING level error thrown out, when the IPC mode of the
     *              pool is not SWOOLE_IPC_SOCKET.
     * @see \Swoole\Process\Pool::listen()
     * @see \Swoole\Process\Pool::on()
     */
    public function write(string $data): bool
    {
    }

    /**
     * Send a message to a worker process of the pool, in IPC mode SWOOLE_IPC_UNIXSOCK.
     *
     * The message is delivered to the worker process identified by $dst_worker_id, where it triggers the "onMessage"
     * event. This method can only be used after the pool has been started, and only when the IPC mode of the pool is
     * SWOOLE_IPC_UNIXSOCK. Messages larger than the socket buffer require the message bus to be enabled (see option
     * \Swoole\Constant::OPTION_ENABLE_MESSAGE_BUS of method \Swoole\Process\Pool::set()).
     *
     * @param string $data The message to send.
     * @param int $dst_worker_id ID of the worker process to deliver the message to, ranging from 0 to the number of
     *                           worker processes minus 1.
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when the pool
     *              hasn't been started yet or when the IPC mode of the pool is not SWOOLE_IPC_UNIXSOCK; it also
     *              returns false when the message fails to be sent.
     * @see \Swoole\Process\Pool::on()
     * @see \Swoole\Process\Pool::set()
     * @since 5.0.3
     */
    public function sendMessage(string $data, int $dst_worker_id): bool
    {
    }

    /**
     * Detach the current worker process from the process pool.
     *
     * This method is to be called inside a worker process. It notifies the master process that the current worker
     * process has stopped serving the pool, so that the master process forks a new worker process (using the same
     * worker ID) to replace it immediately. The calling process itself is not terminated: it stops handling messages
     * dispatched by the pool, and continues to run its own code independently. That way, a worker process can be used
     * to run a long-running task without blocking the pool. e.g.,
     * ```php
     * use Swoole\Process\Pool;
     *
     * $pool = new Pool(2, SWOOLE_IPC_SOCKET);
     *
     * $pool->on('Message', function (Pool $pool, string $message) {
     *     $pool->detach(); // The master process forks a new worker process to replace the current one.
     *     while (true) {   // The current process keeps running, and is not managed by the pool anymore.
     *         sleep(1);
     *         echo 'pid=', posix_getpid(), PHP_EOL;
     *     }
     * });
     *
     * $pool->listen('127.0.0.1', 8089);
     * $pool->start();
     * ```
     *
     * @return bool Returns true on success; returns false when the method is not called inside a running worker
     *              process of the pool.
     * @since 4.7.0
     */
    public function detach(): bool
    {
    }

    /**
     * Start the process pool: the worker processes are forked, and the master process starts managing them.
     *
     * This method blocks in the master process until the pool is shut down (e.g., by method
     * \Swoole\Process\Pool::shutdown(), or by a SIGTERM signal sent to the master process); worker processes that
     * quit are replaced with new ones automatically in the meantime. The registered callback functions are executed
     * in the master process ("onStart"/"onShutdown") and in the worker processes (the rest) accordingly.
     *
     * @return false|null Returns null in the master process after the pool has been shut down. It returns false, with
     *                    an E_WARNING or E_ERROR level error thrown out, when the pool has been started already, when
     *                    a required callback function is missing (a callback function for event "onWorkerStart" or
     *                    "onMessage" is required when coroutine support is enabled, or when the IPC mode is not
     *                    SWOOLE_IPC_NONE), or when the pool fails to start.
     * @throws \Swoole\Exception When a callback function is registered for event "onWorkerExit" but coroutine support
     *                           is not enabled.
     * @see \Swoole\Process\Pool::on()
     * @see \Swoole\Process\Pool::shutdown()
     */
    public function start()
    {
    }

    /**
     * Mark the pool as no longer running in the current process, and stop the event loop of the current worker
     * process so that the process can quit gracefully.
     *
     * This method is normally called inside a worker process (e.g., in the callback function of event "onMessage")
     * to make the worker process stop processing events and quit. It does nothing when the pool hasn't been started.
     *
     * @see \Swoole\Process\Pool::shutdown()
     * @since 4.7.0
     */
    public function stop(): void
    {
    }

    /**
     * Shutdown the process pool.
     *
     * All this method does is to send a SIGTERM signal to the master process of the pool. It will kill the master
     * process and all worker processes.
     *
     * @return bool TRUE on success, FALSE on failure.
     * @throws \Swoole\Exception When the pool hasn't been started yet (i.e., when property
     *                           \Swoole\Process\Pool::$master_pid is not a positive integer).
     * @see \Swoole\Process\Pool::$master_pid
     * @since 4.3.2
     */
    public function shutdown(): bool
    {
    }
}
