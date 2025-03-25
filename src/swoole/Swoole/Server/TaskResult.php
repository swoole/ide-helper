<?php

declare(strict_types=1);

namespace Swoole\Server;

class TaskResult
{
    public int $task_id = 0;

    public int $task_worker_id = 0;

    /**
     * The time when the task result was created.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    public mixed $data;
}
