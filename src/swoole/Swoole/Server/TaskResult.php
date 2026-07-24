<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * A TaskResult object carries the result of a finished task back to the event worker process that dispatched the task.
 *
 * It is passed to the onFinish event callback (registered through method \Swoole\Server::on()) as the second argument
 * when option \Swoole\Constant::OPTION_EVENT_OBJECT is enabled on the server. Otherwise, the task ID and the result
 * data are passed to the callback as two separate arguments.
 *
 * @see \Swoole\Constant::OPTION_EVENT_OBJECT
 * @see \Swoole\Server::task()
 * @see \Swoole\Server::finish()
 */
class TaskResult
{
    /**
     * ID of the task that produced the result.
     *
     * @see \Swoole\Server\Task::$id
     */
    public int $task_id = 0;

    /**
     * ID of the task worker process that processed the task and produced the result.
     */
    public int $task_worker_id = 0;

    /**
     * The time when the task result was created.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    /**
     * The result data of the task: the value returned by the onTask event callback, or the value passed to method
     * \Swoole\Server\Task::finish() or \Swoole\Server::finish().
     *
     * The result data is serialized before being sent back to the event worker process, and unserialized before being
     * assigned to this property. Therefore, the result data must be serializable.
     *
     * @see \Swoole\Server\Task::finish()
     * @see \Swoole\Server::finish()
     */
    public mixed $data;
}
