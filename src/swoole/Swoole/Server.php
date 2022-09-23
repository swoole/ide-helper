<?php

declare(strict_types=1);

namespace Swoole;

use Closure;
use Socket;
use Swoole\Server\Port;

/**
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

    public $connections;

    public $host = '';

    public $port = 0;

    public $type = 0;

    /**
     * @since 5.0.0
     */
    public $ssl = false;

    public $mode = 0;

    public $ports;

    public $master_pid = 0;

    public $manager_pid = 0;

    public $worker_id = -1;

    public $taskworker = false;

    public $worker_pid = 0;

    public $stats_timer;

    /**
     * @var \Swoole\Coroutine\Http\Server
     * @since 4.8.0
     */
    public $admin_server;

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
     */
    private $onBeforeReload;

    /**
     * @var callable
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
     * @param int $mode Either SWOOLE_BASE or SWOOLE_PROCESS. Starting from Swoole 5.0.0, default server mode has been
     *                  changed from SWOOLE_PROCESS to SWOOLE_BASE.
     */
    public function __construct(string $host = '0.0.0.0', int $port = 0, int $mode = SWOOLE_BASE, int $sock_type = SWOOLE_SOCK_TCP)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Server::addlistener().
     * @see \Swoole\Server::addlistener()
     */
    public function listen(string $host, int $port, int $sock_type): Port|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Server::listen().
     * @see \Swoole\Server::listen()
     */
    public function addlistener(string $host, int $port, int $sock_type): Port|false
    {
    }

    public function on(string $event_name, callable $callback): bool
    {
    }

    public function getCallback(string $event_name): Closure|string|array|null
    {
    }

    public function set(array $settings): bool
    {
    }

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
     * @alias This method has an alias of \Swoole\Server::exist().
     * @see \Swoole\Server::exist()
     */
    public function exists(int $fd): bool
    {
    }

    /**
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
     */
    public function confirm(int $fd): bool
    {
    }

    /**
     * Pause receiving client-side data.
     *
     * @see \Swoole\Server::resume()
     */
    public function pause(int $fd): bool
    {
    }

    /**
     * Resume receiving client-side data.
     *
     * @see \Swoole\Server::pause()
     */
    public function resume(int $fd): bool
    {
    }

    /**
     * @param int $taskWorkerIndex ID of the task worker to which the task is assigned. If it is -1, Swoole will randomly pick an idle task worker.
     *                             Please note that task ID starts from 0; it ranges from 0 to $this->setting[\Swoole\Constant::OPTION_TASK_WORKER_NUM] - 1].
     * @return int|false Returns the task ID on success, or false on failure.
     */
    public function task(mixed $data, int $taskWorkerIndex = -1, ?callable $finishCallback = null): int|false
    {
    }

    /**
     * @param float $timeout The default value (0.5) is hardcoded in Swoole.
     * @param int $taskWorkerIndex ID of the task worker to which the task is assigned. If it is -1, Swoole will randomly pick an idle task worker.
     *                             Please note that task ID starts from 0; it ranges from 0 to $this->setting[\Swoole\Constant::OPTION_TASK_WORKER_NUM] - 1].
     * @return string|false Return FALSE when error happens.
     */
    public function taskwait(mixed $data, float $timeout = 0.5, int $taskWorkerIndex = -1): string|false
    {
    }

    public function taskWaitMulti(array $tasks, float $timeout = 0.5): array|false
    {
    }

    public function taskCo(array $tasks, float $timeout = 0.5): array|false
    {
    }

    public function finish(mixed $data): bool
    {
    }

    public function reload(bool $only_reload_taskworker = false): bool
    {
    }

    public function shutdown(): bool
    {
    }

    public function stop(int $workerId = -1, bool $waitEvent = false): bool
    {
    }

    /**
     * @alias This method is an alias of function \swoole_last_error().
     * @see \swoole_last_error()
     */
    public function getLastError(): int
    {
    }

    public function heartbeat(bool $ifCloseConnection = true): array|false
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Server::connection_info().
     * @see \Swoole\Server::connection_info()
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
     */
    public function getWorkerPid(int $worker_id = -1): int|false
    {
    }

    public function getWorkerStatus(int $worker_id = -1): int|false
    {
    }

    public function getManagerPid(): int
    {
    }

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

    public function sendMessage(mixed $message, int $dst_worker_id): bool
    {
    }

    /**
     * Run a customized command in a specified process of Swoole.
     *
     * @param bool $json_encode If the callback function of the command returns a JSON encoded string back, it can be decoded automatically by setting this parameter to TRUE.
     * @return mixed|false
     * @see \Swoole\Server::addCommand()
     * @since 4.8.0
     */
    public function command(string $name, int $process_id, int $process_type, mixed $data, bool $json_decode = true): string|false
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
     * @param \Swoole\Process $process
     * @return int|false Return the ID of the process (\Swoole\Process::$id) back if succeeds; otherwise return FALSE.
     * @see \Swoole\Process::$id
     */
    public function addProcess(Process $process): int
    {
    }

    public function stats(): array
    {
    }

    public function getSocket(int $port = 0): Socket|false
    {
    }

    public function bind(int $fd, int $uid): bool
    {
    }
}
