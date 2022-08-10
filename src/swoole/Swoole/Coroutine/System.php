<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

class System
{
    /**
     * @alias This method is an alias of method \Swoole\Coroutine::gethostbyname().
     * @see \Swoole\Coroutine::gethostbyname()
     */
    public static function gethostbyname(string $domain_name, int $type = AF_INET, float $timeout = -1): string|false
    {
    }

    /**
     * @alias This method is an alias of method \Swoole\Coroutine::dnsLookup().
     * @param float $timeout The default value (60) is hardcoded as constant SW_SOCKET_DEFAULT_DNS_TIMEOUT in Swoole.
     * @see \Swoole\Coroutine::dnsLookup()
     */
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

    /**
     * @alias This method has an alias method \Swoole\Coroutine::fread().
     * @see \Swoole\Coroutine::fread()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fread() directly.
     * @param mixed $handle
     */
    public static function fread($handle, int $length = 0): string|false
    {
    }

    /**
     * @alias This method has an alias method \Swoole\Coroutine::fwrite().
     * @see \Swoole\Coroutine::fwrite()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fwrite() directly.
     * @param mixed $handle
     */
    public static function fwrite($handle, string $data, int $length = 0): int|false
    {
    }

    /**
     * @alias This method has an alias method \Swoole\Coroutine::fgets().
     * @see \Swoole\Coroutine::fgets()
     * @deprecated 4.5.1 Turn on runtime hook SWOOLE_HOOK_FILE or SWOOLE_HOOK_ALL, and use the built-in PHP function fgets() directly.
     * @param mixed $handle
     */
    public static function fgets($handle): string|false
    {
    }
}
