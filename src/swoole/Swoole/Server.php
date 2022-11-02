<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Connection\Iterator;
use Swoole\Coroutine\Http\Server as AdminServer;
use Swoole\Server\Port;

/**
 * The Swoole Server class.
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

    public Iterator $connections;

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
     * @since 4.8.0
     */
    public AdminServer $admin_server;

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
     * @param int $mode Either SWOOLE_BASE or SWOOLE_PROCESS. Starting from Swoole 5.0.0, default server mode has been
     *                  changed from SWOOLE_PROCESS to SWOOLE_BASE.
     */
    public function __construct(string $host = '0.0.0.0', int $port = 0, int $mode = SWOOLE_BASE, int $sock_type = SWOOLE_SOCK_TCP)
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Server::addlistener().
     * @see \Swoole\Server::addlistener()
     * @see \Swoole\Server::getClientInfo()
     */
    public function listen(string $host, int $port, int $sock_type): Port|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Server::listen().
     * @see \Swoole\Server::listen()
     * @see \Swoole\Server::getClientInfo()
     */
    public function addlistener(string $host, int $port, int $sock_type): Port|false
    {
    }

    public function on(string $event_name, callable $callback): bool
    {
    }

    public function getCallback(string $event_name): \Closure|string|array|null
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
     * @return int|false Return the ID of the process (\Swoole\Process::$id) back if succeeds; otherwise return FALSE.
     * @see \Swoole\Process::$id
     */
    public function addProcess(Process $process): int
    {
    }

    public function stats(): array
    {
    }

    public function getSocket(int $port = 0): \Socket|false
    {
    }

    public function bind(int $fd, int $uid): bool
    {
    }
}
