<?php

declare(strict_types=1);

namespace Swoole;

class Event
{
    /**
     * @alias This method has an alias function \swoole_event_add().
     * @see \swoole_event_add()
     */
    public static function add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): int|false
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_del().
     * @see \swoole_event_del()
     */
    public static function del(mixed $fd): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_set().
     * @see \swoole_event_set()
     */
    public static function set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_isset().
     * @see \swoole_event_isset()
     */
    public static function isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_dispatch().
     * @see \swoole_event_dispatch()
     */
    public static function dispatch(): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_defer().
     * @see \swoole_event_defer()
     * @return true
     */
    public static function defer(callable $callback)
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_cycle().
     * @see \swoole_event_cycle()
     */
    public static function cycle(?callable $callback, bool $before = false): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_write().
     * @see \swoole_event_write()
     */
    public static function write(mixed $fd, string $data): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_wait().
     * @see \swoole_event_wait()
     */
    public static function wait(): void
    {
    }

    public static function rshutdown(): void
    {
    }

    /**
     * @alias This method has an alias function \swoole_event_exit().
     * @see \swoole_event_exit()
     */
    public static function exit(): void
    {
    }
}
