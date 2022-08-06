<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

class Channel
{
    public $capacity = 0;

    public $errCode = 0;

    public function __construct(int $size = 1)
    {
    }

    public function push(mixed $data, float $timeout = -1): bool
    {
    }

    public function pop(float $timeout = -1): mixed
    {
    }

    public function isEmpty(): bool
    {
    }

    public function isFull(): bool
    {
    }

    public function close(): bool
    {
    }

    public function stats(): array
    {
    }

    public function length(): int
    {
    }
}
