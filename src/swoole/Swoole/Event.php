<?php

declare(strict_types=1);

namespace Swoole;

class Event
{
    public static function add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): int|false
    {
    }

    public static function del(mixed $fd): bool
    {
    }

    public static function set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
    {
    }

    public static function isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
    {
    }

    public static function dispatch(): bool
    {
    }

    /**
     * @return true
     */
    public static function defer(callable $callback)
    {
    }

    public static function cycle(?callable $callback, bool $before = false): bool
    {
    }

    public static function write(mixed $fd, string $data): bool
    {
    }

    public static function wait(): void
    {
    }

    public static function rshutdown(): void
    {
    }

    public static function exit(): void
    {
    }
}
