<?php

declare(strict_types=1);

namespace Swoole;

use Swoole\Coroutine\Context;
use Swoole\Coroutine\Iterator;

class Coroutine
{
    public static function create(callable $func, ...$param): int|false
    {
    }

    public static function defer(callable $callback): void
    {
    }

    /**
     * To set runtime configurations of coroutines.
     */
    public static function set(array $options): void
    {
    }

    /**
     * To get runtime configurations of coroutines.
     */
    public static function getOptions(): ?array
    {
    }

    public static function exists(int $cid): bool
    {
    }

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

    public static function suspend(): bool
    {
    }

    public static function resume(int $cid): bool
    {
    }

    public static function stats(): array
    {
    }

    public static function getCid(): int
    {
    }

    public static function getuid(): int
    {
    }

    public static function getPcid(int $cid = 0): int|false
    {
    }

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

    public static function list(): Iterator
    {
    }

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

    public static function gethostbyname(string $domain_name, int $type = AF_INET, float $timeout = -1): string|false
    {
    }

    public static function dnsLookup(string $domain_name, float $timeout = 60, int $type = AF_INET): string|false
    {
    }

    public static function exec(string $command, bool $get_error_stream = false): array|false
    {
    }

    public static function sleep(float $seconds): bool
    {
    }

    public static function getaddrinfo(string $domain, int $family = AF_INET, int $socktype = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, ?string $service = null, float $timeout = -1): bool|array
    {
    }

    public static function statvfs(string $path): array
    {
    }

    public static function readFile(string $filename, int $flag = 0): string|false
    {
    }

    public static function writeFile(string $filename, string $fileContent, int $flags = 0): int|false
    {
    }

    public static function wait(float $timeout = -1): array|false
    {
    }

    public static function waitPid(int $pid, float $timeout = -1): array|false
    {
    }

    public static function waitSignal(int $signo, float $timeout = -1): bool
    {
    }

    public static function waitEvent(mixed $socket, int $events = SWOOLE_EVENT_READ, float $timeout = -1): int|false
    {
    }

    public static function fread($handle, int $length = 0): string|false
    {
    }

    public static function fgets($handle): string|false
    {
    }

    public static function fwrite($handle, string $data, int $length = 0): int|false
    {
    }
}
