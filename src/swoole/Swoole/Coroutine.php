<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Coroutine\Context;
use Swoole\Coroutine\Iterator;

/**
 * @alias This class has an alias of "\co" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \co
 */
class Coroutine
{
    /**
     * @alias This method has two alias functions: \go() and \swoole_coroutine_create().
     * @see \go()
     * @see \swoole_coroutine_create()
     */
    public static function create(callable $func, ...$param): int|false
    {
    }

    /**
     * Defers the execution of a callback function until the surrounding function of a coroutine returns.
     *
     * @alias This method is an alias of function swoole_coroutine_defer().
     * @see \swoole_coroutine_defer()
     *
     * @example
     * <pre>
     * \Swoole\Coroutine::create(function () {  // The surrounding function of a coroutine.
     *   echo '1';
     *   \Swoole\Coroutine::defer(function () { // The callback function to be deferred.
     *     echo '3';
     *   });
     *   echo '2';
     * });
     * <pre>
     */
    public static function defer(callable $callback): void
    {
    }

    /**
     * To set runtime configurations of coroutines.
     *
     * @alias This method has an alias method \Swoole\Coroutine\Scheduler::set().
     * @see \Swoole\Coroutine\Scheduler::set()
     */
    public static function set(array $options): void
    {
    }

    /**
     * To get runtime configurations of coroutines.
     *
     * @alias This method has an alias method \Swoole\Coroutine\Scheduler::getOptions().
     * @see \Swoole\Coroutine\Scheduler::getOptions()
     */
    public static function getOptions(): ?array
    {
    }

    public static function exists(int $cid): bool
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Coroutine::suspend().
     * @see \Swoole\Coroutine::suspend()
     */
    public static function yield(): bool
    {
    }

    public static function cancel(int $cid): bool
    {
    }

    /**
     * Waits for a list of coroutines to finish.
     *
     * This method is similar to class \Swoole\Coroutine\WaitGroup and \Swoole\Coroutine\Barrier. They are different
     * implementations of the same functionality.
     *
     * @param array $cid_array An array of coroutines.
     * @return bool TRUE if succeeds; otherwise FALSE.
     * @see \Swoole\Coroutine\WaitGroup
     * @see \Swoole\Coroutine\Barrier
     * @since 4.8.0
     */
    public static function join(array $cid_array, float $timeout = -1): bool
    {
    }

    public static function isCanceled(): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine::yield().
     * @see \Swoole\Coroutine::yield()
     */
    public static function suspend(): bool
    {
    }

    public static function resume(int $cid): bool
    {
    }

    public static function stats(): array
    {
    }

    /**
     * Get the ID of current coroutine. A coroutine ID is a unique positive integer within the same process.
     *
     * @alias This method has an alias of \Swoole\Coroutine::getuid().
     * @see \Swoole\Coroutine::getuid()
     */
    public static function getCid(): int
    {
    }

    /**
     * Get the ID of current coroutine. A coroutine ID is a unique positive integer within the same process.
     *
     * @alias Alias of method \Swoole\Coroutine::getCid().
     * @see \Swoole\Coroutine::getCid()
     */
    public static function getuid(): int
    {
    }

    /**
     * Get ID of the parent coroutine.
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @return int|false There are three possible return values:
     *                   - > 1: ID of the "parent" coroutine from which current coroutine was created.
     *                   - -1: If current coroutine is created from a non-coroutine context.
     *                   - FALSE: If the method is called from a non-coroutine context.
     */
    public static function getPcid(int $cid = 0): int|false
    {
    }

    /**
     * Return the Context object of the specified coroutine.
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @return Context|null Return the Context object of the specified coroutine. If the specified coroutine does not
     *                      exist or the Context object of the coroutine has been destroyed, NULL will be returned.
     */
    public static function getContext(int $cid = 0): ?Context
    {
    }

    public static function getBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0): array|false
    {
    }

    public static function printBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0): void
    {
    }

    public static function getElapsed(int $cid = 0): int
    {
    }

    /**
     * Get memory usage of a coroutine.
     *
     * @param int $cid If this parameter is not passed in, current coroutine ID will be used.
     * @return int|false Memory usage of the coroutine; FALSE if the specified coroutine doesn't exist.
     * @since 4.8.0
     */
    public static function getStackUsage(int $cid = 0): int|false
    {
    }

    /**
     * @alias This method has an alias of \Swoole\Coroutine::listCoroutines().
     * @see \Swoole\Coroutine::listCoroutines()
     */
    public static function list(): Iterator
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine::list().
     * @see \Swoole\Coroutine::list()
     */
    public static function listCoroutines(): Iterator
    {
    }

    public static function enableScheduler(): bool
    {
    }

    public static function disableScheduler(): bool
    {
    }

    /**
     * Get execution time of current coroutine.
     *
     * This method is available only when Swoole is installed with option "--enable-swoole-coro-time" included.
     *
     * The official Docker images of Swoole (phpswoole/swoole) doesn't have "--enable-swoole-coro-time" included when
     * installing Swoole. Thus, this method can not be used directly in the official Docker images of Swoole.
     *
     * @since 5.0.0
     */
    public static function getExecuteTime(): int
    {
    }

    /**
     * @alias This method has an alias method \Swoole\Coroutine\System::gethostbyname().
     * @see \Swoole\Coroutine\System::gethostbyname()
     */
    public static function gethostbyname(string $domain_name, int $type = AF_INET, float $timeout = -1): string|false
    {
    }

    /**
     * @alias This method has an alias method \Swoole\Coroutine\System::dnsLookup().
     * @see \Swoole\Coroutine\System::dnsLookup()
     * @param float $timeout The default value (60) is hardcoded in Swoole.
     */
    public static function dnsLookup(string $domain_name, float $timeout = 60, int $type = AF_INET): string|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::exec().
     * @see \Swoole\Coroutine\System::exec()
     */
    public static function exec(string $command, bool $get_error_stream = false): array|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::sleep().
     * @see \Swoole\Coroutine\System::sleep()
     */
    public static function sleep(float $seconds): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::getaddrinfo().
     * @see \Swoole\Coroutine\System::getaddrinfo()
     */
    public static function getaddrinfo(string $domain, int $family = AF_INET, int $socktype = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, ?string $service = null, float $timeout = -1): bool|array
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::statvfs().
     * @see \Swoole\Coroutine\System::statvfs()
     */
    public static function statvfs(string $path): array
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::readFile().
     * @see \Swoole\Coroutine\System::readFile()
     */
    public static function readFile(string $filename, int $flag = 0): string|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::writeFile().
     * @see \Swoole\Coroutine\System::writeFile()
     */
    public static function writeFile(string $filename, string $fileContent, int $flags = 0): int|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::wait().
     * @see \Swoole\Coroutine\System::wait()
     */
    public static function wait(float $timeout = -1): array|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::waitPid().
     * @see \Swoole\Coroutine\System::waitPid()
     */
    public static function waitPid(int $pid, float $timeout = -1): array|false
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::waitSignal().
     * @see \Swoole\Coroutine\System::waitSignal()
     */
    public static function waitSignal(int $signo, float $timeout = -1): bool
    {
    }

    /**
     * @alias Alias of method \Swoole\Coroutine\System::waitEvent().
     * @see \Swoole\Coroutine\System::waitEvent()
     */
    public static function waitEvent(mixed $socket, int $events = SWOOLE_EVENT_READ, float $timeout = -1): int|false
    {
    }

    /**
     * @alias This method is an alias of method \Swoole\Coroutine\System::fread().
     * @see \Swoole\Coroutine\System::fread()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fread() directly.
     * @param mixed $handle
     */
    public static function fread($handle, int $length = 0): string|false
    {
    }

    /**
     * @alias This method is an alias of method \Swoole\Coroutine\System::fgets().
     * @see \Swoole\Coroutine\System::fgets()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fgets() directly.
     * @param mixed $handle
     */
    public static function fgets($handle): string|false
    {
    }

    /**
     * @alias This method is an alias of method \Swoole\Coroutine\System::fwrite().
     * @see \Swoole\Coroutine\System::fwrite()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fwrite() directly.
     * @param mixed $handle
     */
    public static function fwrite($handle, string $data, int $length = 0): int|false
    {
    }
}
