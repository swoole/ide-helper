<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Task
{
    public $data;

    public $dispatch_time = 0;

    public $id = -1;

    public $worker_id = -1;

    public $flags = 0;

    public function finish(mixed $data): bool
    {
    }

    public static function pack(mixed $data): string|false
    {
    }
}
