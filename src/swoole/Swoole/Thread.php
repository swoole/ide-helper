<?php

declare(strict_types=1);

namespace Swoole;

/**
 * Class \Swoole\Thread.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @since 6.0.0
 */
final class Thread
{
    /**
     * The number of concurrent threads supported by the hardware.
     *
     * Note that value of this constant is system- and implementation- specific, and may not be exact, but just an
     * approximation. The actual value on your machine could be smaller or (much) larger than the number hardcoded here.
     */
    public const HARDWARE_CONCURRENCY = 12;

    public const API_NAME = 'POSIX Threads';

    public const SCHED_OTHER = 0;

    public const SCHED_FIFO = 1;

    public const SCHED_RR = 2;

    public const SCHED_BATCH = 3;

    public const SCHED_ISO = 4;

    public const SCHED_IDLE = 5;

    public const SCHED_DEADLINE = 6;

    /**
     * Thread ID. Default is 0.
     *
     * @readonly
     */
    public int $id = 0;

    public function __construct(string $script_file, mixed ...$args)
    {
    }

    public function join(): bool
    {
    }

    public function joinable(): bool
    {
    }

    public function getExitStatus(): int
    {
    }

    public function detach(): bool
    {
    }

    public static function getArguments(): ?array
    {
    }

    public static function getId(): int
    {
    }

    public static function getInfo(): array
    {
    }

    /**
     * Set the name of the thread.
     *
     * @param string $name The name of the thread.
     * @return bool TRUE on success, or FALSE on failure.
     * @see https://linux.die.net/man/3/pthread_setname_np
     */
    public static function setName(string $name): bool
    {
    }

    /**
     * Set CPU affinity of a thread.
     *
     * This method is available only on some operating systems that support CPU affinity. It's not available on Windows
     * or macOS.
     *
     * @param array<int> $cpu_settings
     * @return bool TRUE on success, or FALSE on failure.
     * @see https://linux.die.net/man/3/pthread_setaffinity_np
     */
    public static function setAffinity(array $cpu_settings): bool
    {
    }

    /**
     * Get CPU affinity of a thread.
     *
     * This method is available only on some operating systems that support CPU affinity. It's not available on Windows
     * or macOS.
     *
     * @return array<int> An array of integers representing the affinity mask of current thread.
     * @see https://linux.die.net/man/3/pthread_getaffinity_np
     */
    public static function getAffinity(): array
    {
    }

    /**
     * set scheduling policy and priority of a thread.
     *
     * @return bool Returns true on success or false on failure.
     * @see \Swoole\Swoole::getPriority()
     * @see https://linux.die.net/man/3/pthread_setschedparam
     */
    public static function setPriority(int $priority, int $policy = 0): bool
    {
    }

    /**
     * Get scheduling policy and parameters of a thread.
     *
     * @return array{policy: int, priority: int} An array containing the scheduling policy and priority of the thread.
     * @see \Swoole\Swoole::setPriority()
     * @see https://linux.die.net/man/3/pthread_getschedparam
     */
    public static function getPriority(): array
    {
    }

    public static function getNativeId(): int
    {
    }
}
