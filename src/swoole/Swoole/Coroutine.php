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
     * Create a coroutine.
     *
     * @param callable $func The function to be executed inside the new coroutine.
     * @param mixed ...$param Arguments passed to the function when the coroutine starts running.
     * @return int|false Returns the coroutine ID on success, or false on failure. Note that this method won't return
     *                   the coroutine ID back until the new coroutine yields its execution.
     * @alias This method has two alias functions: \go() and \swoole_coroutine_create().
     * @see \go()
     * @see \swoole_coroutine_create()
     */
    public static function create(callable $func, ...$param): int|false
    {
    }

    /**
     * Defers the execution of a callback function until the surrounding function of a coroutine returns. e.g.,
     * ```php
     * \Swoole\Coroutine::create(function () {  // The surrounding function of a coroutine.
     *   echo '1';
     *   \Swoole\Coroutine::defer(function () { // The callback function to be deferred.
     *     echo '3';
     *   });
     *   echo '2';
     * });
     * ```
     *
     * @param callable $callback The callback function to be executed when the surrounding function of the current coroutine returns.
     * @alias This method is an alias of function swoole_coroutine_defer().
     * @see \swoole_coroutine_defer()
     */
    public static function defer(callable $callback): void
    {
    }

    /**
     * To set runtime configurations of coroutines.
     *
     * @param array $options An array of runtime options, e.g., "max_coroutine", "hook_flags", "socket_timeout", "enable_preemptive_scheduler", etc.
     * @alias This method has an alias method \Swoole\Coroutine\Scheduler::set().
     * @see \Swoole\Coroutine\Scheduler::set()
     */
    public static function set(array $options): void
    {
    }

    /**
     * To get runtime configurations of coroutines.
     *
     * @return array|null Returns an array of the runtime options previously set through method \Swoole\Coroutine::set()
     *                    (or \Swoole\Coroutine\Scheduler::set()), or NULL if no options have been set yet.
     * @alias This method has an alias method \Swoole\Coroutine\Scheduler::getOptions().
     * @see \Swoole\Coroutine\Scheduler::getOptions()
     */
    public static function getOptions(): ?array
    {
    }

    /**
     * Check if a coroutine exists or not.
     *
     * @param int $cid Coroutine ID. Unlike most other methods of this class, 0 is not treated as the ID of current
     *                 coroutine here; since coroutine IDs start from 1, FALSE is always returned when 0 is given.
     * @return bool Returns true if the coroutine exists, or false if not.
     */
    public static function exists(int $cid): bool
    {
    }

    /**
     * Suspend the execution of current coroutine.
     *
     * The suspended coroutine stays inactive until it's resumed by a call to method \Swoole\Coroutine::resume() (made
     * from some other coroutine or from outside of coroutines), or until it's cancelled by a call to method
     * \Swoole\Coroutine::cancel().
     *
     * @return bool TRUE once the coroutine has been resumed; FALSE if the coroutine was cancelled while suspended, in
     *              which case function \swoole_last_error() returns error code SWOOLE_ERROR_CO_CANCELED.
     * @alias This method has an alias of \Swoole\Coroutine::suspend().
     * @see \Swoole\Coroutine::suspend()
     * @see \Swoole\Coroutine::resume()
     * @see \Swoole\Coroutine::cancel()
     */
    public static function yield(): bool
    {
    }

    /**
     * Cancel the execution of a coroutine.
     *
     * Please note that this method can not cancel the execution of current coroutine.
     *
     * A coroutine that is busy with a file operation can not be cancelled; trying to force it may crash the process.
     * As an exception, since Swoole 6.2.0, when Swoole is installed with the "--enable-iouring" configuration option
     * (so that file operations go through io_uring, a Linux facility for asynchronous I/O), such operations can be
     * cancelled like any other.
     *
     * The signature of this method changed in Swoole 6.1.0:
     *   - before: public static function cancel(int $cid): bool
     *   - now:    public static function cancel(int $cid, bool $throw_exception = false): bool
     *
     * Passing TRUE for the new parameter lets the target coroutine clean up after itself, e.g.,
     *
     * ```php
     * $cid = Swoole\Coroutine::create(function () {
     *     try {
     *         while (true) {
     *             Swoole\Coroutine::sleep(0.1);
     *         }
     *     } catch (Swoole\Coroutine\CanceledException $e) {
     *         echo "cancelled; releasing resources here\n";
     *     }
     * });
     * Swoole\Coroutine::sleep(0.3);
     * Swoole\Coroutine::cancel($cid, true);
     * ```
     *
     * @param int $cid Coroutine ID. Unlike most other methods of this class, 0 is not treated as the ID of current
     *                 coroutine here; since coroutine IDs start from 1, FALSE is always returned when 0 is given.
     * @param bool $throw_exception When TRUE, a \Swoole\Coroutine\CanceledException is thrown inside the target
     *                              coroutine, which the coroutine can catch to clean up before it stops. The coroutine
     *                              is terminated even if it is in a state that normally can not be cancelled. When
     *                              FALSE (the default), the coroutine is simply cancelled without an exception, and
     *                              this method returns FALSE if the coroutine happens to be in a state that can not be
     *                              cancelled.
     * @return bool Returns true on success, or false on failure. Use function \swoole_last_error() to get the error
     *              code when failed, e.g., SWOOLE_ERROR_CO_NOT_EXISTS when the given coroutine doesn't exist, or
     *              SWOOLE_ERROR_CO_CANCELED when the coroutine has already been cancelled this way.
     * @see \Swoole\Coroutine\CanceledException
     * @since 4.7.0
     */
    public static function cancel(int $cid, bool $throw_exception = false): bool
    {
    }

    /**
     * Waits for a list of coroutines to finish.
     *
     * This method is similar to class \Swoole\Coroutine\WaitGroup and \Swoole\Coroutine\Barrier. They are different
     * implementations of the same functionality.
     *
     * @param array $cid_array An array of coroutine IDs. IDs of coroutines that don't exist any more (e.g., because the
     *                         coroutines have finished already) are skipped silently.
     * @param float $timeout The maximum time to wait for the coroutines to finish (in seconds). If specified as 0 or a
     *                       negative number (which is the default), it waits indefinitely until all the given
     *                       coroutines have finished.
     * @return bool TRUE if all the given coroutines finished in time; otherwise FALSE. Use function
     *              \swoole_last_error() to get the error code when failed. Here are the possible error codes:
     *              - SWOOLE_ERROR_INVALID_PARAMS: $cid_array is empty, or none of the given coroutines exists.
     *              - SWOOLE_ERROR_WRONG_OPERATION: $cid_array contains the ID of the calling coroutine itself.
     *              - SWOOLE_ERROR_CO_HAS_BEEN_BOUND: One of the given coroutines is being waited on somewhere else already.
     *              - SWOOLE_ERROR_CO_TIMEDOUT: The given coroutines didn't all finish within the given timeout.
     *              - SWOOLE_ERROR_CO_CANCELED: The calling coroutine was cancelled while waiting.
     * @see \Swoole\Coroutine\WaitGroup
     * @see \Swoole\Coroutine\Barrier
     * @since 4.8.0
     */
    public static function join(array $cid_array, float $timeout = -1): bool
    {
    }

    /**
     * Set a limit on how long the current coroutine may keep running.
     *
     * Once the given number of seconds has passed, a \Swoole\Coroutine\TimeoutException is thrown inside the current
     * coroutine (if it is still running by then), which the coroutine can catch to clean up before it stops; if the
     * exception is not caught, the coroutine is terminated. The coroutine is terminated even if it is in a state that
     * normally can not be cancelled. E.g.,
     *
     * ```php
     * Swoole\Coroutine\run(function () {
     *     try {
     *         Swoole\Coroutine::setTimeLimit(1.0);
     *         while (true) {
     *             Swoole\Coroutine::sleep(0.1);
     *         }
     *     } catch (Swoole\Coroutine\TimeoutException $e) {
     *         echo "time limit exceeded; releasing resources here\n";
     *     }
     * });
     * ```
     *
     * This method must be called inside a coroutine, and the limit applies to the calling coroutine only.
     *
     * @param float $timeout The time limit in seconds. Although the parameter accepts a float, as of Swoole 6.2.0 the
     *                       fractional part is dropped internally, so the limit is effectively whole seconds (e.g.,
     *                       1.5 behaves like 1). When 0 is given, no limit is set and FALSE is returned.
     * @return bool Returns TRUE when the time limit is set, or FALSE when $timeout is 0.
     * @see \Swoole\Coroutine\TimeoutException
     * @see \Swoole\Coroutine::cancel()
     * @since 6.2.0
     */
    public static function setTimeLimit(float $timeout): bool
    {
    }

    /**
     * Check if the current coroutine has been cancelled or not.
     *
     * A coroutine can be cancelled by calling method \Swoole\Coroutine::cancel($cid) in another coroutine.
     *
     * @return bool TRUE if the current coroutine has been cancelled; otherwise FALSE.
     * @since 4.7.0
     */
    public static function isCanceled(): bool
    {
    }

    /**
     * Suspend the execution of current coroutine.
     *
     * @return bool TRUE once the coroutine has been resumed; FALSE if the coroutine was cancelled while suspended, in
     *              which case function \swoole_last_error() returns error code SWOOLE_ERROR_CO_CANCELED.
     * @alias Alias of method \Swoole\Coroutine::yield().
     * @see \Swoole\Coroutine::yield()
     */
    public static function suspend(): bool
    {
    }

    /**
     * Resume the execution of given coroutine.
     *
     * Only coroutines suspended by method \Swoole\Coroutine::yield() (or its alias suspend()) can be resumed by this
     * method; coroutines that are waiting for I/O operations to finish can not.
     *
     * @param int $cid Coroutine ID.
     * @return bool Returns true if successfully resumed, or false on failure (e.g., when the given coroutine doesn't
     *              exist, or when it's waiting for an I/O operation to finish instead of being suspended by method
     *              \Swoole\Coroutine::yield()).
     * @see \Swoole\Coroutine::yield()
     */
    public static function resume(int $cid): bool
    {
    }

    /**
     * Get statistics of coroutines and related resources within the process.
     *
     * @return array Returns an array with the following fields in it:
     *               - event_num: Number of events being watched by the event loop.
     *               - signal_listener_num: Number of signal listeners.
     *               - aio_task_num: Number of pending tasks in the thread pool that handles file I/O and blocking operations.
     *               - aio_worker_num: Number of worker threads in that thread pool.
     *               - aio_queue_size: Size of the task queue of that thread pool.
     *               - c_stack_size: Size of the C stack allocated for each coroutine (in bytes).
     *               - coroutine_num: Number of active coroutines.
     *               - coroutine_peak_num: Peak number of active coroutines.
     *               - coroutine_last_cid: ID of the most recently created coroutine.
     */
    public static function stats(): array
    {
    }

    /**
     * Get the ID of current coroutine. A coroutine ID is a unique positive integer within the same process.
     *
     * @return int Returns the ID of current coroutine, or -1 when called from a non-coroutine context.
     * @alias This method has an alias of \Swoole\Coroutine::getuid().
     * @see \Swoole\Coroutine::getuid()
     */
    public static function getCid(): int
    {
    }

    /**
     * Get the ID of current coroutine. A coroutine ID is a unique positive integer within the same process.
     *
     * @return int Returns the ID of current coroutine, or -1 when called from a non-coroutine context.
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
     *                   - >= 1: ID of the "parent" coroutine from which the specified coroutine was created.
     *                   - -1: If the specified coroutine is created from a non-coroutine context.
     *                   - FALSE: If the specified coroutine doesn't exist, which includes the case where the method is
     *                   called with no argument (or with 0) from a non-coroutine context.
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

    /**
     * Generate a backtrace of the specified coroutine.
     *
     * This method is similar to built-in function \debug_backtrace().
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @param int $options A bitmask for the following options: DEBUG_BACKTRACE_PROVIDE_OBJECT, DEBUG_BACKTRACE_IGNORE_ARGS.
     * @param int $limit To limit the number of stack frames returned. By default (limit=0) it returns all stack frames.
     * @return array|false Returns an array of associative arrays, or FALSE if the specified coroutine does not exist.
     * @see \debug_backtrace()
     */
    public static function getBackTrace(int $cid = 0, int $options = DEBUG_BACKTRACE_PROVIDE_OBJECT, int $limit = 0): array|false
    {
    }

    /**
     * Print a PHP backtrace of the specified coroutine.
     *
     * This method is similar to built-in function \debug_print_backtrace().
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @param int $options A bitmask for the following option(s): DEBUG_BACKTRACE_IGNORE_ARGS.
     * @param int $limit To limit the number of stack frames printed. By default (limit=0) it prints all stack frames.
     * @see \debug_print_backtrace()
     */
    public static function printBackTrace(int $cid = 0, int $options = 0, int $limit = 0): void
    {
    }

    /**
     * Get how long the specified coroutine has been running.
     *
     * The returned value is the wall-clock time elapsed since the coroutine was created, in milliseconds.
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @return int Returns the time elapsed since the specified coroutine was created (in milliseconds), or -1 if the
     *             specified coroutine doesn't exist (including when the method is called with no argument, or with 0,
     *             from a non-coroutine context).
     * @since 4.5.0
     */
    public static function getElapsed(int $cid = 0): int
    {
    }

    /**
     * Get memory usage of a coroutine.
     *
     * @param int $cid Coroutine ID. If not specified or specified as 0, ID of current coroutine will be used.
     * @return int|false Memory usage of the coroutine; FALSE if the specified coroutine doesn't exist.
     * @since 4.8.0
     */
    public static function getStackUsage(int $cid = 0): int|false
    {
    }

    /**
     * Get a list of all running coroutines within the process. e.g.,
     * ```php
     * foreach (\Swoole\Coroutine::list() as $cid) {
     *   var_dump(\Swoole\Coroutine::getBackTrace($cid));
     * };
     * ```
     *
     * @return Iterator An iterator over the IDs of all running coroutines within the process.
     * @alias This method has an alias of \Swoole\Coroutine::listCoroutines().
     * @see \Swoole\Coroutine::listCoroutines()
     * @since 4.4.0
     */
    public static function list(): Iterator
    {
    }

    /**
     * Get a list of all running coroutines within the process. e.g.,
     * ```php
     * foreach (\Swoole\Coroutine::listCoroutines() as $cid) {
     *   var_dump(\Swoole\Coroutine::getBackTrace($cid));
     * };
     * ```
     *
     * @return Iterator An iterator over the IDs of all running coroutines within the process.
     * @alias Alias of method \Swoole\Coroutine::list().
     * @see \Swoole\Coroutine::list()
     * @since 4.4.0
     */
    public static function listCoroutines(): Iterator
    {
    }

    /**
     * Allow the preemptive scheduler to interrupt the current coroutine.
     *
     * The preemptive scheduler forces a coroutine to yield once it has occupied the CPU for more than 10 milliseconds
     * without doing any I/O, so that a CPU-intensive coroutine can not block all the other coroutines running in the
     * same process. Every newly created coroutine allows preemption by default; this method only makes sense after
     * method \Swoole\Coroutine::disableScheduler() has been called in the same coroutine.
     *
     * The preemptive scheduler itself has to be turned on globally first, either through ini directive
     * "swoole.enable_preemptive_scheduler", or through runtime option "enable_preemptive_scheduler" (see method
     * \Swoole\Coroutine::set()). Otherwise, no coroutine gets preempted no matter what this method returns.
     *
     * To understand how it works, please check examples under section "CPU-intensive job scheduling" of repository [deminy/swoole-by-examples](https://github.com/deminy/swoole-by-examples).
     *
     * @return bool TRUE if preemption was disabled for the current coroutine and is now enabled; FALSE if it is enabled
     *              already, or if the method is called from a non-coroutine context.
     * @see \Swoole\Coroutine::disableScheduler()
     * @see \Swoole\Coroutine::set() Runtime option "enable_preemptive_scheduler" turns on the preemptive scheduler.
     * @see https://github.com/deminy/swoole-by-examples/blob/master/examples/csp/scheduling/mixed.php
     * @since 4.4.0
     */
    public static function enableScheduler(): bool
    {
    }

    /**
     * Stop the preemptive scheduler from interrupting the current coroutine.
     *
     * Once called, the current coroutine is never forced to yield by the preemptive scheduler; it keeps the CPU until
     * it finishes, does I/O, or yields explicitly. This affects the calling coroutine only, and can be reverted by
     * method \Swoole\Coroutine::enableScheduler().
     *
     * To understand how it works, please check examples under section "CPU-intensive job scheduling" of repository [deminy/swoole-by-examples](https://github.com/deminy/swoole-by-examples).
     *
     * @return bool TRUE if preemption was enabled for the current coroutine and is now disabled; FALSE if it is
     *              disabled already, or if the method is called from a non-coroutine context.
     * @see \Swoole\Coroutine::enableScheduler()
     * @see \Swoole\Coroutine::set() Runtime option "enable_preemptive_scheduler" turns on the preemptive scheduler.
     * @see https://github.com/deminy/swoole-by-examples/blob/master/examples/csp/scheduling/mixed.php
     * @since 4.4.0
     */
    public static function disableScheduler(): bool
    {
    }

    /**
     * Get execution time of current coroutine.
     *
     * The execution time of a coroutine is the time from the moment when the coroutine is created to the moment when
     * this method is called, minus the time spent in the I/O wait state. Here we use the following code piece as an
     * example:
     *
     *   \Swoole\Coroutine::create(function () { // Create a new coroutine.
     *       // Here is some mathematical calculation that takes 3 seconds to finish.
     *
     *       \Swoole\Coroutine::sleep(5); // A sleep function call to sleep for 5 seconds.
     *
     *       // Next call returns an integer that is close to 3_000_000 (microseconds) but not 8_000_000 (microseconds).
     *       \Swoole\Coroutine::getExecuteTime();
     *   });
     *
     * This method is available only when Swoole is installed with option "--enable-swoole-coro-time" included.
     *
     * The official Docker images of Swoole (phpswoole/swoole) doesn't have option "--enable-swoole-coro-time" included
     * when installing Swoole. Thus, this method can not be used directly in the official Docker images of Swoole.
     *
     * @return int Return the execution time of current coroutine in microseconds, or -1 if not executed within a coroutine.
     * @since 5.0.0
     */
    public static function getExecuteTime(): int
    {
    }

    /**
     * Get the IPv4/IPv6 address corresponding to a given Internet host name.
     *
     * @param string $domain_name The host name.
     * @param int $type The type of address to resolve. Should be either AF_INET or AF_INET6. By default, it resolves to
     *                  an IPv4 address.
     * @param float $timeout The timeout for domain resolving (in seconds).
     *                       - > 0.001: The timeout value in seconds.
     *                       - <= 0: No timeout.
     *                       - Otherwise: 0.001 second. This is the minimum number of seconds that can be used for
     *                       time-related operations in Swoole, as denoted by constant SWOOLE_TIMER_MIN_SEC.
     * @return string|false Return the IPv4/IPv6 address on success, or FALSE on failure.
     *                      Runtime option \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM determines which address to return
     *                      when multiple IPv4/IPv6 addresses are returned during DNS query.
     *                      - If TRUE (enabled), a random address is returned. This is the default behavior.
     *                      - If FALSE (disabled), the first address is returned.
     *                      The result is cached in memory for 60 seconds by default. The expiration time can be
     *                      configured through runtime option \Swoole\Constant::OPTION_DNS_CACHE_EXPIRE.
     *
     * @see \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM Runtime option to enable random DNS lookup (enabled by default).
     * @see \Swoole\Constant::OPTION_DNS_CACHE_EXPIRE Runtime option to set expiration time of DNS cache (in seconds).
     *
     * @see https://www.php.net/gethostbyname The built-in PHP function \gethostbyname()
     *      There are a few differences between this method and the built-in PHP function \gethostbyname():
     *      - PHP function \gethostbyname() only works for IPv4 addresses. This method works for both IPv4 and IPv6 addresses.
     *      - PHP function \gethostbyname() works in blocking mode. This method works in non-blocking mode when invoked in a
     *        coroutine.
     *      - PHP function \gethostbyname() doesn't cache the result. This method caches the result of DNS query in memory.
     *        The result is cached for 60 seconds by default. The expiration time can be configured through runtime option
     *        \Swoole\Constant::OPTION_DNS_CACHE_EXPIRE.
     *      - PHP function \gethostbyname() uses the C function gethostbyname() to resolve the host name. This method uses
     *        C library c-ares if available.
     *
     * @see \Swoole\Coroutine::dnsLookup() This method is very similar to method \Swoole\Coroutine::dnsLookup(), with a
     *      few differences.
     *      - When multiple IPv4/IPv6 addresses are returned during DNS query, both methods rely on runtime option
     *        \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM to determine which address to return. By default, a random
     *        address is returned.
     *      - When library c-ares is available, both methods use c-ares to resolve the host name and return the same result.
     *      - When library c-ares is not available, method dnsLookup() makes a DNS query through UDP socket, while method
     *        gethostbyname() relies on the C function gethostbyname() to resolve the host name.
     *      - They use different runtime options to configure the behavior of caching DNS query result.
     *      - Parameter $timeout doesn't always have the same meaning in both methods, although most times they are the same.
     *
     * @see \Swoole\Coroutine::getaddrinfo()
     *
     * @alias This method has an alias method \Swoole\Coroutine\System::gethostbyname().
     * @see \Swoole\Coroutine\System::gethostbyname()
     */
    public static function gethostbyname(string $domain_name, int $type = AF_INET, float $timeout = -1): string|false
    {
    }

    /**
     * Lookup the IPv4/IPv6 address corresponding to a given Internet host name.
     *
     * @param string $domain_name The domain name to be resolved.
     * @param float $timeout The timeout for domain resolving (in seconds). No timeout if $timeout is no greater than 0.0.
     * @param int $type The type of address to resolve. Should be either AF_INET or AF_INET6. Before Swoole 4.7.0, only AF_INET is supported.
     * @return string|false returns the resolved IP address on success, or false on failure.
     *                      Runtime option \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM determines which address to return
     *                      when multiple IPv4/IPv6 addresses are returned during DNS query.
     *                      - If TRUE (enabled), a random address is returned. This is the default behavior.
     *                      - If FALSE (disabled), the first address is returned.
     *                      The result is cached in memory for 60 seconds by default. The expiration time can be
     *                      configured through runtime option \Swoole\Constant::OPTION_DNS_CACHE_REFRESH_TIME.
     *                      When failed, function swoole_last_error() can be used to get the error code. Here are some
     *                      common errors:
     *                      - SWOOLE_ERROR_DNSLOOKUP_RESOLVE_FAILED: The domain name can not be resolved.
     *                      - SWOOLE_ERROR_DNSLOOKUP_RESOLVE_TIMEOUT: Can't resolve the domain name within the given timeout.
     * @see \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM Runtime option to enable random DNS lookup (enabled by default).
     * @see \Swoole\Constant::OPTION_DNS_CACHE_REFRESH_TIME Runtime option to set refresh time for DNS cache (in seconds).
     *
     * @see \Swoole\Coroutine::gethostbyname() This method is very similar to method \Swoole\Coroutine::gethostbyname(),
     *      with a few differences.
     *      - When multiple IPv4/IPv6 addresses are returned during DNS query, both methods rely on runtime option
     *        \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM to determine which address to return. By default, a random
     *        address is returned.
     *      - When library c-ares is available, both methods use c-ares to resolve the host name and return the same result.
     *      - When library c-ares is not available, method dnsLookup() makes a DNS query through UDP socket, while method
     *        gethostbyname() relies on the C function gethostbyname() to resolve the host name.
     *      - They use different runtime options to configure the behavior of caching DNS query result.
     *      - Parameter $timeout doesn't always have the same meaning in both methods, although most times they are the same.
     *
     * @alias This method is an alias of function \swoole_async_dns_lookup_coro().
     * @see \swoole_async_dns_lookup_coro()
     */
    public static function dnsLookup(string $domain_name, float $timeout = 60, int $type = AF_INET): string|false
    {
    }

    /**
     * Execute a shell command, in a coroutine-friendly way.
     *
     * Please check documentation of method \Swoole\Coroutine\System::exec() for more details.
     *
     * @param string $command The command to be executed.
     * @param bool $get_error_stream If TRUE, the error output of the command (its standard error) is captured as part
     *                               of field "output" of the return value as well.
     * @return array|false Returns FALSE if the command fails to run; otherwise, returns an array with fields "output",
     *                     "code", and "signal" in it.
     * @alias Alias of method \Swoole\Coroutine\System::exec().
     * @see \Swoole\Coroutine\System::exec()
     */
    public static function exec(string $command, bool $get_error_stream = false): array|false
    {
    }

    /**
     * Pause the current coroutine for the given number of seconds.
     *
     * Please check documentation of method \Swoole\Coroutine\System::sleep() for more details.
     *
     * @param float $seconds Number of seconds to sleep. It must be no less than 0.001 (one millisecond).
     * @return bool TRUE once the time is up; FALSE if $seconds is less than 0.001, or if the coroutine is cancelled
     *              while sleeping.
     * @alias Alias of method \Swoole\Coroutine\System::sleep().
     * @see \Swoole\Coroutine\System::sleep()
     */
    public static function sleep(float $seconds): bool
    {
    }

    /**
     * Resolve a host name into a list of IPv4/IPv6 addresses.
     *
     * This method is a coroutine-friendly wrapper of the C function getaddrinfo(3): the actual lookup is executed in a
     * thread pool so that the calling coroutine doesn't block the process. Unlike method
     * \Swoole\Coroutine::gethostbyname(), it returns all the resolved addresses instead of a single one, and it doesn't
     * cache the result.
     *
     * @param string $domain The host name to be resolved. It can't be an empty string.
     * @param int $family The type of address to resolve. Should be either AF_INET or AF_INET6.
     * @param int $socktype The socket type to resolve for, e.g., SOCK_STREAM or SOCK_DGRAM.
     * @param int $protocol The protocol to resolve for, e.g., STREAM_IPPROTO_TCP or STREAM_IPPROTO_UDP.
     * @param string|null $service The service name or port number to resolve, as accepted by getaddrinfo(3).
     * @param float $timeout The timeout for domain resolving (in seconds). No timeout if it's not greater than 0.
     * @return array|false Returns a list of resolved IP addresses (at most 16 of them) on success, or FALSE on failure.
     *                     Use function \swoole_last_error() to get the error code when failed.
     *
     * @see \Swoole\Coroutine::gethostbyname()
     * @see https://man7.org/linux/man-pages/man3/getaddrinfo.3.html The C function getaddrinfo(3) wrapped by this method.
     *
     * @alias Alias of method \Swoole\Coroutine\System::getaddrinfo().
     * @see \Swoole\Coroutine\System::getaddrinfo()
     */
    public static function getaddrinfo(string $domain, int $family = AF_INET, int $socktype = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, ?string $service = null, float $timeout = -1): array|false
    {
    }

    /**
     * Get information about the filesystem that the given path belongs to (e.g., total and free disk space).
     *
     * Please check documentation of method \Swoole\Coroutine\System::statvfs() for more details.
     *
     * @param string $path Path of any file or directory on the filesystem.
     * @return array Returns an array of filesystem statistics, with fields like "bsize", "blocks", "bfree", and "bavail" in it.
     * @alias Alias of method \Swoole\Coroutine\System::statvfs().
     * @see \Swoole\Coroutine\System::statvfs()
     */
    public static function statvfs(string $path): array
    {
    }

    /**
     * Read a whole file into a string, in a coroutine-friendly way.
     *
     * Please check documentation of method \Swoole\Coroutine\System::readFile() for more details.
     *
     * @param string $filename Path of the file to read.
     * @param int $flag Either 0 (the default) or constant LOCK_EX (to acquire an exclusive lock on the file while
     *                  reading it). Since Swoole 6.1.2, constant FILE_LOCK can be used in place of LOCK_EX.
     * @return string|false Returns the content of the file on success, or FALSE on failure.
     * @alias Alias of method \Swoole\Coroutine\System::readFile().
     * @see \Swoole\Coroutine\System::readFile()
     */
    public static function readFile(string $filename, int $flag = 0): string|false
    {
    }

    /**
     * Write a string to a file, in a coroutine-friendly way.
     *
     * Please check documentation of method \Swoole\Coroutine\System::writeFile() for more details.
     *
     * @param string $filename Path of the file to write to.
     * @param string $fileContent The content to write to the file.
     * @param int $flags A bitmask made of constants FILE_APPEND and LOCK_EX, same as in the built-in PHP function
     *                   \file_put_contents(). Since Swoole 6.1.2, constant FILE_LOCK can be used in place of LOCK_EX.
     * @return int|false Returns the number of bytes written on success, or FALSE on failure.
     * @alias Alias of method \Swoole\Coroutine\System::writeFile().
     * @see \Swoole\Coroutine\System::writeFile()
     */
    public static function writeFile(string $filename, string $fileContent, int $flags = 0): int|false
    {
    }

    /**
     * Wait for any child process of the current process to exit, in a coroutine-friendly way.
     *
     * Please check documentation of method \Swoole\Coroutine\System::wait() for more details.
     *
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until a child process exits.
     * @return array|false Returns FALSE on failure; otherwise, returns an array with fields "pid", "code", and "signal" in it.
     * @alias Alias of method \Swoole\Coroutine\System::wait().
     * @see \Swoole\Coroutine\System::wait()
     * @since 4.5.0
     */
    public static function wait(float $timeout = -1): array|false
    {
    }

    /**
     * Wait for a specific child process of the current process to exit, in a coroutine-friendly way.
     *
     * Please check documentation of method \Swoole\Coroutine\System::waitPid() for more details.
     *
     * @param int $pid Process ID of the child process to wait for.
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until the child process exits.
     * @return array|false Returns FALSE on failure; otherwise, returns an array with fields "pid", "code", and "signal" in it.
     * @alias Alias of method \Swoole\Coroutine\System::waitPid().
     * @see \Swoole\Coroutine\System::waitPid()
     * @since 4.5.0
     */
    public static function waitPid(int $pid, float $timeout = -1): array|false
    {
    }

    /**
     * Wait for given signal(s) with a timeout.
     *
     * @param int|array<int> $signals An integer or an array of integers representing the signal number(s).
     *                                Before Swoole v6.0.0, only integer is supported.
     * @param float $timeout The timeout value in seconds. Minimum value is 0.001. -1 means no timeout.
     * @return int|false Returns the signal number received on success, or false on failure.
     * @alias Alias of method \Swoole\Coroutine\System::waitSignal().
     * @see \Swoole\Coroutine\System::waitSignal()
     * @since 4.5.0
     */
    public static function waitSignal(int|array $signals, float $timeout = -1): int|false
    {
    }

    /**
     * Wait until a socket becomes readable and/or writable.
     *
     * Please check documentation of method \Swoole\Coroutine\System::waitEvent() for more details.
     *
     * @param mixed $socket The socket to watch. It can be a stream resource, a \Socket object of the PHP sockets
     *                      extension, or a Swoole object representing a socket connection.
     * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until one of the given events happens.
     * @return int|false Returns the event(s) that happened on the socket (a bitmask of SWOOLE_EVENT_READ and
     *                   SWOOLE_EVENT_WRITE) on success, or FALSE on failure.
     * @alias Alias of method \Swoole\Coroutine\System::waitEvent().
     * @see \Swoole\Coroutine\System::waitEvent()
     * @since 4.5.0
     */
    public static function waitEvent(mixed $socket, int $events = SWOOLE_EVENT_READ, float $timeout = -1): int|false
    {
    }
}
