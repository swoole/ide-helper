<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * A scheduler for running a set of coroutines to completion.
 *
 * The scheduler collects coroutines added through methods add() and parallel(), then runs them all inside an event
 * loop when method start() is called; start() doesn't return until every coroutine (and everything they spawned)
 * has finished. It's the coroutine counterpart of starting a server: a convenient way to write standalone
 * coroutine-based scripts, e.g.,
 *
 * ```php
 * $scheduler = new Swoole\Coroutine\Scheduler();
 * $scheduler->add(function () {
 *     echo file_get_contents('https://www.example.com/'); // Non-blocking inside a coroutine (with hooks enabled).
 * });
 * $scheduler->start();
 * ```
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\Scheduler" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Scheduler
 * @since 4.4.0
 */
final class Scheduler
{
    /**
     * Add a task (implemented in the callback).
     *
     * @return false|void Returns FALSE if the scheduler has already been started; otherwise nothing returns.
     * @see \Swoole\Coroutine\Scheduler::start()
     * @see \Swoole\Coroutine\Scheduler::parallel()
     */
    public function add(callable $func, ...$params)
    {
    }

    /**
     * Add multiple tasks (implemented in the callback).
     *
     * @return false|void Returns FALSE if the scheduler has already been started; otherwise nothing returns.
     * @see \Swoole\Coroutine\Scheduler::start()
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function parallel(int $n, callable $func, ...$params)
    {
        for ($i = 0; $i < $n; $i++) {
            $this->add($func, ...$params);
        }
    }

    /**
     * To set runtime configurations of coroutines.
     *
     * @alias This method is an alias of method \Swoole\Coroutine::set().
     * @see \Swoole\Coroutine::set()
     */
    public function set(array $settings): void
    {
    }

    /**
     * To get runtime configurations of coroutines.
     *
     * @alias This method is an alias of method \Swoole\Coroutine::getOptions().
     * @see \Swoole\Coroutine::getOptions()
     * @since Swoole 4.6.0
     */
    public function getOptions(): ?array
    {
    }

    /**
     * Start running the list of tasks (callbacks) added through method self::add() and/or self::parallel().
     *
     * For each task, Swoole creates a new coroutine to run its callback function. The scheduler will wait for all the
     * coroutines to finish.
     *
     * @return bool Returns TRUE if all the coroutines have finished successfully; otherwise returns FALSE.
     * @see \Swoole\Coroutine\Scheduler::add()
     * @see \Swoole\Coroutine\Scheduler::parallel()
     */
    public function start(): bool
    {
    }
}
