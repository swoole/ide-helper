<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * A Task object represents a task dispatched to a task worker process.
 *
 * It is passed to the onTask event callback as the second argument when the server runs with option
 * \Swoole\Constant::OPTION_TASK_OBJECT or option \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE enabled. Otherwise,
 * the same information is passed to the callback as multiple separate arguments (the task ID, the ID of the worker
 * process that dispatched the task, and the task data).
 *
 * @see \Swoole\Constant::OPTION_TASK_OBJECT
 * @see \Swoole\Constant::OPTION_TASK_ENABLE_COROUTINE
 * @see \Swoole\Server::task()
 * @not-serializable Objects of this class cannot be serialized.
 */
final class Task
{
    /**
     * The task data, exactly as it was passed to method \Swoole\Server::task() (or alike).
     *
     * The task data is serialized before being sent to the task worker process, and unserialized before being assigned
     * to this property. Therefore, the task data must be serializable.
     *
     * @see \Swoole\Server::task()
     */
    public mixed $data;

    /**
     * The time when the task was dispatched.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    /**
     * ID of the task.
     *
     * Task IDs are taken from an incremental counter local to the process dispatching the task; therefore, a task ID
     * is unique within that process only, and tasks dispatched from different processes may have the same task ID.
     */
    public int $id = -1;

    /**
     * ID of the worker process that dispatched the task.
     */
    public int $worker_id = -1;

    /**
     * Bit flags describing how the task was dispatched and how it should be replied to. e.g., whether the task was
     * dispatched from a coroutine, whether a result is expected back, and whether a callback function was given to
     * handle the result. The flags are set and used by Swoole internally.
     */
    public int $flags = 0;

    /**
     * Send the result of the task back to the event worker process that dispatched it.
     *
     * Calling this method delivers the result back to the dispatching event worker process, where the onFinish event
     * callback (or the finish callback function passed to method \Swoole\Server::task(), if any) is triggered, or
     * where a call to method \Swoole\Server::taskwait() (and alike) waiting for the result gets it returned. Returning
     * a non-null value from the onTask event callback has the same effect as calling this method.
     *
     * @param mixed $data Serializable data of the task result.
     * @return bool Returns true on success, or false on failure.
     * @see \Swoole\Server::finish()
     * @see \Swoole\Server::task()
     * @see \Swoole\Server::taskwait()
     */
    public function finish(mixed $data): bool
    {
    }

    /**
     * Pack task data.
     *
     * @param mixed $data Task data to be packed.
     * @return string|false The packed task data. Returns false if failed.
     */
    public static function pack(mixed $data): string|false
    {
    }

    /**
     * Unpack task data.
     *
     * @param string $data The packed task data.
     * @return mixed The unpacked data. Returns false if failed.
     * @since 5.0.1
     */
    public static function unpack(string $data): mixed
    {
    }
}
