<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * When an event worker process or a task worker process crashes, an onWorkerError event will be triggered in the manager
 * process.
 *
 * A StatusInfo object is passed to the onWorkerError callback as the second argument when option
 * \Swoole\Constant::OPTION_EVENT_OBJECT is enabled on the server. Otherwise, the same information is passed to the
 * callback as four separate arguments (the worker ID, the process ID of the worker process, the exit code, and the
 * signal number; the raw process status held by property $status is not passed along in that form). Either way, the
 * information can be used to log the issue and send out alerts. e.g.,
 * ```php
 * $server->set([\Swoole\Constant::OPTION_EVENT_OBJECT => true]);
 * $server->on('WorkerError', function (\Swoole\Server $server, \Swoole\Server\StatusInfo $info) {
 *     var_dump($info);
 * });
 * ```
 *
 * @see \Swoole\Constant::OPTION_EVENT_OBJECT
 */
class StatusInfo
{
    /**
     * ID of the worker process that exited, i.e., the same value the process had in property
     * \Swoole\Server::$worker_id while it was running.
     *
     * @see \Swoole\Server::$worker_id
     */
    public int $worker_id = 0;

    /**
     * Operating-system process ID of the worker process that exited.
     */
    public int $worker_pid = 0;

    /**
     * The raw process status reported by the operating system when the worker process exited (the status
     * value filled in by the waitpid(2) system call). Properties $exit_code and $signal are both derived
     * from this value, so usually there is no need to inspect it directly.
     *
     * @see https://man7.org/linux/man-pages/man2/waitpid.2.html
     */
    public int $status = 0;

    /**
     * Exit code the worker process exited with (0-255). It is derived from property $status, and is only meaningful
     * when the process exited on its own rather than being killed by a signal.
     *
     * @see \Swoole\Server\StatusInfo::$status
     */
    public int $exit_code = 0;

    /**
     * Number of the signal that killed the worker process (e.g., 11 for SIGSEGV). It is derived from property
     * $status, and is only meaningful when the process was killed by a signal rather than exiting on its own.
     *
     * @see \Swoole\Server\StatusInfo::$status
     */
    public int $signal = 0;
}
