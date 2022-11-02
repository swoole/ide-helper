<?php

declare(strict_types=1);

namespace Swoole\Process;

use Swoole\Process;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Pool
{
    /**
     * Process ID of the master process of the pool. The master process is the process where the Pool object is created.
     *
     * This property will be set to a positive integer when method \Swoole\Process\Pool::start() is called successfully.
     *
     * @since 4.3.2
     */
    public int $master_pid = -1;

    public $workers;

    public function __construct(int $worker_num, int $ipc_type = SWOOLE_IPC_NONE, int $msgqueue_key = 0, bool $enable_coroutine = false)
    {
    }

    /**
     * @since 4.4.4
     */
    public function set(array $settings): void
    {
    }

    public function on(string $name, callable $callback): bool
    {
    }

    public function getProcess(int $work_id = -1): Process|false
    {
    }

    public function listen(string $host, int $port = 0, int $backlog = 2048): bool
    {
    }

    public function write(string $data): bool
    {
    }

    public function detach(): bool
    {
    }

    /**
     * @return false|null
     */
    public function start()
    {
    }

    /**
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
     * @since 4.3.2
     */
    public function shutdown(): bool
    {
    }
}
