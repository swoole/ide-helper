<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The exception to thrown out when exit() is called unexpectedly in Swoole.
 */
class ExitException extends Exception
{
    /**
     * There are two supported exit flags only: SWOOLE_EXIT_IN_COROUTINE and SWOOLE_EXIT_IN_SERVER.
     *
     * When an ExitException exception is thrown out, property $flags could be one of the following three values:
     *   1. SWOOLE_EXIT_IN_COROUTINE When exit() is called inside a coroutine.
     *   2. SWOOLE_EXIT_IN_SERVER    When exit() is called after the Swoole server is started.
     *   3. Both.
     *
     * @see SWOOLE_EXIT_IN_COROUTINE
     * @see SWOOLE_EXIT_IN_SERVER
     */
    private int $flags = 0;

    /**
     * The status as defined in PHP function exit($status).
     *
     * Before Swoole 5.0.2, the status is always an integer.
     *
     * The type of the status also depends on the PHP version in use, because Swoole intercepts exit() differently:
     *   - On PHP 8.4 and above, where exit() is a function, the status is a string when a string is passed to exit(),
     *     or an integer otherwise (0 when exit() is called without an argument).
     *   - On PHP versions before 8.4, where exit is a language construct, the status is a copy of whatever value is
     *     passed to exit(), of whatever type; it is NULL when exit is called without an operand.
     * This is why the property is not narrowed down to type "string|int" here.
     */
    private mixed $status = 0;

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
     * @return mixed The status as defined in PHP function exit($status). Please check documentation of property
     *               \Swoole\ExitException::$status for the possible types of the returned value.
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public function getStatus(): mixed
    {
        return $this->status;
    }
}
