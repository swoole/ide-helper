<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The exception to thrown out when built-in PHP function exit() is called unexpectedly in Swoole.
 */
class ExitException extends Exception
{
    /**
     * There are two supported exit flags only: SWOOLE_EXIT_IN_COROUTINE and SWOOLE_EXIT_IN_SERVER.
     *
     * When an ExitException exception is thrown out, property $flags could be one of the following three values:
     *   1. SWOOLE_EXIT_IN_COROUTINE When PHP function exit() is called inside a coroutine.
     *   2. SWOOLE_EXIT_IN_SERVER    When PHP function exit() is called after the Swoole server is started.
     *   3. Both.
     *
     * @see SWOOLE_EXIT_IN_COROUTINE
     * @see SWOOLE_EXIT_IN_SERVER
     */
    private int $flags = 0;

    /**
     * The status as defined in PHP function exit($status).
     */
    private int $status = 0;

    /**
     * Get the exit flags.
     *
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function getFlags(): int
    {
        return $this->flags;
    }

    /**
     * Get the exit status.
     *
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}
