<?php

declare(strict_types=1);

namespace Swoole;

/**
 * Class \Swoole\Thread.
 *
 * This class is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with
 * the "--enable-swoole-thread" configuration option.
 *
 * @not-serializable Objects of this class cannot be serialized.
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

    /**
     * Name of the thread API PHP was built with, as reported by PHP's thread-safety layer (TSRM).
     *
     * The value is platform-dependent: it's "POSIX Threads" on Linux and macOS (the value shown in this stub), or
     * "Windows Threads" on Windows.
     */
    public const API_NAME = 'POSIX Threads';

    /**
     * Scheduling policy for methods \Swoole\Thread::setPriority() and \Swoole\Thread::getPriority(): the operating
     * system's standard time-sharing policy, which is the default for regular threads.
     *
     * @see \Swoole\Thread::setPriority()
     * @see \Swoole\Thread::getPriority()
     * @see https://man7.org/linux/man-pages/man7/sched.7.html
     */
    public const SCHED_OTHER = 0;

    /**
     * Scheduling policy for methods \Swoole\Thread::setPriority() and \Swoole\Thread::getPriority(): the
     * first-in-first-out real-time policy, under which a thread keeps running until it blocks or a higher-priority
     * thread becomes runnable. Using it usually requires elevated (root) privileges.
     *
     * @see \Swoole\Thread::setPriority()
     * @see \Swoole\Thread::getPriority()
     * @see https://man7.org/linux/man-pages/man7/sched.7.html
     */
    public const SCHED_FIFO = 1;

    /**
     * Scheduling policy for methods \Swoole\Thread::setPriority() and \Swoole\Thread::getPriority(): the round-robin
     * real-time policy, which behaves like Thread::SCHED_FIFO except that each thread is only allowed to run for a
     * limited time slice before the next thread of the same priority gets a turn. Using it usually requires elevated
     * (root) privileges.
     *
     * @see \Swoole\Thread::setPriority()
     * @see \Swoole\Thread::getPriority()
     * @see https://man7.org/linux/man-pages/man7/sched.7.html
     */
    public const SCHED_RR = 2;

    /**
     * This constant is defined only on systems whose scheduler provides the SCHED_BATCH policy (Linux).
     */
    public const SCHED_BATCH = 3;

    /**
     * This constant is defined only on systems whose scheduler provides the SCHED_ISO policy.
     */
    public const SCHED_ISO = 4;

    /**
     * This constant is defined only on systems whose scheduler provides the SCHED_IDLE policy (Linux).
     */
    public const SCHED_IDLE = 5;

    /**
     * This constant is defined only on systems whose scheduler provides the SCHED_DEADLINE policy (Linux).
     */
    public const SCHED_DEADLINE = 6;

    /**
     * Thread ID. Default is 0.
     *
     * @readonly
     */
    public int $id = 0;

    /**
     * The constructor.
     *
     * @param string $script_file Path to the PHP script file that will be executed in the thread.
     * @param mixed ...$args List of arguments to pass to the PHP script file.
     *                       Inside the thread created, these arguments can be accessed via method Thread::getArguments().
     * @throws Exception When $script_file is an empty string, or when the operating system fails to create the new
     *                   thread.
     * @see Thread::getArguments()
     */
    public function __construct(string $script_file, mixed ...$args)
    {
    }

    /**
     * Check if this thread is still running or not.
     *
     * @return bool TRUE if the thread is still running, or FALSE if it has finished its execution.
     * @since 6.0.2
     */
    public function isAlive(): bool
    {
    }

    /**
     * Blocks the main thread (the calling thread) until this thread finishes its execution.
     *
     * @return bool TRUE on success, or FALSE on failure.
     * @see https://en.cppreference.com/w/cpp/thread/thread/join
     */
    public function join(): bool
    {
    }

    /**
     * Checks if this thread is joinable or not.
     *
     * A thread is joinable if it hasn't been joined nor detached. A thread that has finished executing code, but has
     * not yet been joined is still considered an active thread of execution and is therefore joinable.
     *
     * @return bool TRUE if the thread is joinable, FALSE otherwise.
     * @see https://en.cppreference.com/w/cpp/thread/thread/joinable
     */
    public function joinable(): bool
    {
    }

    /**
     * Get the exit status of this thread.
     *
     * @return int Exit status of the thread. It stays 0 while the thread is still running, and holds the exit status
     *             of the thread's PHP script once the thread has finished.
     */
    public function getExitStatus(): int
    {
    }

    /**
     * Separate this thread from the main thread (the calling thread), allowing its execution to continue independently.
     * This thread will run in the background, and the main thread (the calling thread) will not wait for it to finish.
     *
     * @return bool TRUE if detached successfully, FALSE otherwise.
     * @see https://en.cppreference.com/w/cpp/thread/thread/detach
     */
    public function detach(): bool
    {
    }

    /**
     * Get the list of arguments passed to the thread.
     *
     * The arguments are the same as the ones passed to the constructor of the thread, excluding the script file.
     *
     * @return array|null List of arguments passed to the constructor of the thread, or NULL when the current thread
     *                    wasn't created with extra arguments (e.g., when the call is made from the main thread).
     * @see Thread::__construct()
     */
    public static function getArguments(): ?array
    {
    }

    /**
     * Get the ID of the current thread (the thread the call is made from).
     *
     * The ID is the one assigned by the threading library (pthreads); it's unique among running threads of the
     * process, but may be reused after a thread finishes. To get the thread ID assigned by the operating system,
     * use method getNativeId() instead.
     *
     * @return int ID of the current thread.
     * @see \Swoole\Thread::getNativeId()
     * @see \Swoole\Thread::$id
     */
    public static function getId(): int
    {
    }

    /**
     * Get information about the threading environment of the process.
     *
     * @return array An array with three keys: "is_main_thread" (whether the call is made from the main thread),
     *               "is_shutdown" (whether the thread system is shutting down), and "thread_num" (the number of
     *               threads currently running, including the main thread).
     * @see \Swoole\Thread::activeCount()
     */
    public static function getInfo(): array
    {
    }

    /**
     * Get the number of threads that are still running, i.e., not yet finished their execution.
     *
     * @return int Number of threads currently running, including the main thread.
     * @since 6.0.2
     */
    public static function activeCount(): int
    {
    }

    /**
     * Yield the current thread, allowing other threads to run.
     *
     * @since 6.0.2
     */
    public static function yield(): void
    {
    }

    /**
     * Set the name of the current thread (the thread the call is made from).
     *
     * @param string $name The new name of the thread.
     * @return bool TRUE on success, or FALSE on failure.
     * @see https://linux.die.net/man/3/pthread_setname_np
     */
    public static function setName(string $name): bool
    {
    }

    /**
     * Set CPU affinity of the current thread (the thread the call is made from).
     *
     * This method is available only on some operating systems that support CPU affinity. It's not available on Windows
     * or macOS.
     *
     * @param array<int> $cpu_settings IDs of the CPU cores the thread is allowed to run on, starting from 0.
     * @return bool TRUE on success, or FALSE on failure.
     * @see https://linux.die.net/man/3/pthread_setaffinity_np
     */
    public static function setAffinity(array $cpu_settings): bool
    {
    }

    /**
     * Get CPU affinity of the current thread (the thread the call is made from).
     *
     * This method is available only on some operating systems that support CPU affinity. It's not available on Windows
     * or macOS.
     *
     * @return array<int> An array of integers representing the affinity mask of current thread. Despite the return
     *                    type declared, FALSE is returned at run time (with an E_WARNING level error thrown out) when
     *                    the underlying system call fails.
     * @see https://linux.die.net/man/3/pthread_getaffinity_np
     */
    public static function getAffinity(): array
    {
    }

    /**
     * Set scheduling policy and priority of the current thread (the thread the call is made from).
     *
     * Note that, as of Swoole 6.2.2, leaving parameter $policy out makes Swoole ask the operating system for an
     * invalid scheduling policy, so the call always fails; pass both parameters explicitly.
     *
     * @param int $priority The new scheduling priority. What counts as a valid value depends on the scheduling policy.
     * @param int $policy The scheduling policy to use. It should be one of the \Swoole\Thread::SCHED_* constants.
     * @return bool Returns true on success or false on failure.
     * @see \Swoole\Thread::getPriority()
     * @see https://linux.die.net/man/3/pthread_setschedparam
     */
    public static function setPriority(int $priority, int $policy = 0): bool
    {
    }

    /**
     * Get scheduling policy and priority of the current thread (the thread the call is made from).
     *
     * @return array{policy: int, priority: int} An array containing the scheduling policy and priority of the thread.
     *                                           Despite the return type declared, FALSE is returned at run time (with
     *                                           an E_WARNING level error thrown out) when the underlying system call
     *                                           fails.
     * @see \Swoole\Thread::setPriority()
     * @see https://linux.die.net/man/3/pthread_getschedparam
     */
    public static function getPriority(): array
    {
    }

    /**
     * Get the operating-system-level ID of the current thread (the thread the call is made from).
     *
     * Unlike the ID returned by method getId(), this is the identifier the operating system itself uses for the
     * thread — e.g., the value of the gettid() system call on Linux — which is what shows up in system tools like
     * `top` or `ps`.
     *
     * @return int Native (operating-system-level) ID of the current thread.
     * @see \Swoole\Thread::getId()
     * @see https://man7.org/linux/man-pages/man2/gettid.2.html
     */
    public static function getNativeId(): int
    {
    }
}
