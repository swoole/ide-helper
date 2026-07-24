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
     * @var int ID of the worker.
     */
    public int $worker_id = 0;

    /**
     * @var int Process ID of the worker.
     */
    public int $worker_pid = 0;

    /**
     * @var int The raw process status reported by the operating system when the worker process exited (the status
     *          value filled in by the waitpid(2) system call). Properties $exit_code and $signal are both derived
     *          from this value, so usually there is no need to inspect it directly.
     * @see https://man7.org/linux/man-pages/man2/waitpid.2.html
     */
    public int $status = 0;

    /**
     * @var int Exit status of the worker process.
     */
    public int $exit_code = 0;

    /**
     * @var int The signal that caused the worker process to exit.
     */
    public int $signal = 0;
}
