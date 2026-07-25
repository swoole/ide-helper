<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * When an event worker process or a task worker process crashes, an onWorkerError event will be triggered in the manager
 * process, with a StatusInfo object as the second parameter. The StatusInfo object can be used to log the issue and
 * send out alerts. e.g.,
 * ```php
 * $server->on('WorkerError', function (Swoole\Server $serv, Swoole\Server\StatusInfo $info) {
 *   var_dump($info);
 * });
 * ```
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
