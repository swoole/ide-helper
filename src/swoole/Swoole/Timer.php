<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Timer\Iterator;

class Timer
{
    public static function set(array $settings): void
    {
    }

    public static function tick(int $ms, callable $callback, ...$params): int|false
    {
    }

    public static function after(int $ms, callable $callback, ...$params): int|false
    {
    }

    public static function exists(int $timer_id): bool
    {
    }

    public static function info(int $timer_id): ?array
    {
    }

    public static function stats(): array
    {
    }

    public static function list(): Iterator
    {
    }

    public static function clear(int $timer_id): bool
    {
    }

    public static function clearAll(): bool
    {
    }
}
