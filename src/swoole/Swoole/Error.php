<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The error thrown out when an unrecoverable error happens inside Swoole.
 *
 * This class is used by the Swoole core only; it's never thrown out on behalf of user code. Examples of such errors are
 * calling a coroutine API outside of a coroutine, forking a process inside a coroutine, and failing to allocate memory
 * for the stack of a new coroutine.
 *
 * Objects of this class can't be caught in practice: right after one is thrown, Swoole prints it out as a PHP fatal
 * error and terminates the process with exit status 255.
 *
 * @since 4.4.0
 */
class Error extends \Error
{
}
