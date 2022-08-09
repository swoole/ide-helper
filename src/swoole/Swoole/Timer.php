<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Timer\Iterator;

class Timer
{
    /**
     * This method has an alias function \swoole_timer_set().
     *
     * @see \swoole_timer_set()
     * @deprecated 4.6.0
     */
    public static function set(array $settings): void
    {
    }

    /**
     * This method has an alias function \swoole_timer_tick().
     *
     * @see \swoole_timer_tick()
     */
    public static function tick(int $ms, callable $callback, ...$params): int|false
    {
    }

    /**
     * This method has an alias function \swoole_timer_after().
     *
     * @see \swoole_timer_after()
     */
    public static function after(int $ms, callable $callback, ...$params): int|false
    {
    }

    /**
     * This method has an alias function \swoole_timer_exists().
     *
     * @see \swoole_timer_exists()
     */
    public static function exists(int $timer_id): bool
    {
    }

    /**
     * This method has an alias function \swoole_timer_info().
     *
     * @see \swoole_timer_info()
     */
    public static function info(int $timer_id): ?array
    {
    }

    /**
     * This method has an alias function \swoole_timer_stats().
     *
     * @see \swoole_timer_stats()
     */
    public static function stats(): array
    {
    }

    /**
     * This method has an alias function \swoole_timer_list().
     *
     * @see \swoole_timer_list()
     */
    public static function list(): Iterator
    {
    }

    /**
     * This method has an alias function \swoole_timer_clear().
     *
     * @see \swoole_timer_clear()
     */
    public static function clear(int $timer_id): bool
    {
    }

    /**
     * This method has an alias function \swoole_timer_clear_all().
     *
     * @see \swoole_timer_clear_all()
     */
    public static function clearAll(): bool
    {
    }
}
