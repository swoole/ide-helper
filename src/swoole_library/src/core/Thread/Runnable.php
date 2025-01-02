<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Thread;

/**
 * @since 6.0.0-beta
 */
abstract class Runnable
{
    protected Atomic $running;

    protected int $id;

    public function __construct($running, $index)
    {
        $this->running = $running;
        $this->id      = $index;
    }

    abstract public function run(array $args): void;

    protected function isRunning(): bool
    {
        return $this->running->get() === 1;
    }

    protected function shutdown(): void
    {
        $this->running->set(0);
    }
}
