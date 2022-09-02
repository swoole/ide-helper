<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Timer\Iterator;

class Timer
{
    /**
     * @alias This method has an alias function \swoole_timer_set().
     * @see \swoole_timer_set()
     * @deprecated 4.6.0
     */
    public static function set(array $settings): void
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_tick().
     * @see \swoole_timer_tick()
     */
    public static function tick(int $ms, callable $callback, ...$params): int|false
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_after().
     * @see \swoole_timer_after()
     */
    public static function after(int $ms, callable $callback, ...$params): int|false
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_exists().
     * @see \swoole_timer_exists()
     */
    public static function exists(int $timer_id): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_info().
     * @see \swoole_timer_info()
     */
    public static function info(int $timer_id): ?array
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_stats().
     * @see \swoole_timer_stats()
     */
    public static function stats(): array
    {
    }

    /**
     * Get a list of timer IDs of all the timers set in current worker process.
     *
     * @alias This method has an alias function \swoole_timer_list().
     * @see \swoole_timer_list()
     *
     * @example
     * <pre>
     * foreach (\Swoole\Timer::list() as $timerId) {
     *   var_dump(\Swoole\Timer::info($timerId));
     * };
     * <pre>
     */
    public static function list(): Iterator
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_clear().
     * @see \swoole_timer_clear()
     */
    public static function clear(int $timer_id): bool
    {
    }

    /**
     * @alias This method has an alias function \swoole_timer_clear_all().
     * @see \swoole_timer_clear_all()
     */
    public static function clearAll(): bool
    {
    }
}
