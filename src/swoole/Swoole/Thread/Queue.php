<?php

declare(strict_types=1);

namespace Swoole\Thread;

use Countable;

class Queue implements Countable
{
    public const NOTIFY_NONE = 0;
    public const NOTIFY_ONE = 1;
    public const NOTIFY_ALL = 2;

    public function __construct()
    {
    }

    public function push(mixed $value, int $notify_which = 0): void
    {
    }

    public function pop(float $wait = 0): mixed
    {
    }

    public function count(): int
    {
    }

    public function clean(): void
    {
    }
}

