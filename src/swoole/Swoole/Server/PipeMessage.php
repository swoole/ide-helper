<?php

declare(strict_types=1);

namespace Swoole\Server;

class PipeMessage
{
    /**
     * The ID of the worker process that sent the message.
     *
     * @see PipeMessage::$worker_id
     */
    public int $source_worker_id = 0;

    /**
     * The ID of the worker process that sent the message.
     *
     * This value is identical to property $this->source_worker_id. Both properties are retained for backward compatibility.
     *
     * @since 6.0.0 This property was accessible as a dynamic property in versions prior to Swoole 6.0.0, but it has been explicitly declared as of Swoole 6.0.0.
     * @see PipeMessage::$source_worker_id
     */
    public int $worker_id = 0;

    public float $dispatch_time = 0;

    public $data;
}
