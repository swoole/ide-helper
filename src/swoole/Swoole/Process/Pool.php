<?php

declare(strict_types=1);

namespace Swoole\Process;

use Swoole\Process;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Pool
{
    public $master_pid = -1;

    public $workers;

    public function __construct(int $worker_num, int $ipc_type = SWOOLE_IPC_NONE, int $msgqueue_key = 0, bool $enable_coroutine = false)
    {
    }

    public function __destruct()
    {
    }

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

    public function stop(): void
    {
    }

    public function shutdown(): bool
    {
    }
}
