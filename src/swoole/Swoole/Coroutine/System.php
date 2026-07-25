<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * @alias This class has an alias of "\Co\System" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\System
 */
class System
{
    /**
     * Get the IPv4/IPv6 address corresponding to a given Internet host name.
     *
     * Please check documentation of method \Swoole\Coroutine::gethostbyname() for more details.
     *
     * @param string $domain_name The host name.
     * @param int $type The type of address to resolve. Should be either AF_INET or AF_INET6.
     * @param float $timeout The timeout for domain resolving (in seconds). No timeout if it's not greater than 0.
     * @return string|false Return the IPv4/IPv6 address on success, or FALSE on failure.
     * @alias This method is an alias of method \Swoole\Coroutine::gethostbyname().
     * @see \Swoole\Coroutine::gethostbyname()
     */
    public static function gethostbyname(string $domain_name, int $type = AF_INET, float $timeout = -1): string|false
    {
    }

    /**
     * Lookup the IPv4/IPv6 address corresponding to a given Internet host name.
     *
     * Please check documentation of method \Swoole\Coroutine::dnsLookup() for more details.
     *
     * @param string $domain_name The domain name to be resolved.
     * @param float $timeout The timeout for domain resolving (in seconds). No timeout if it's not greater than 0.
     * @param int $type The type of address to resolve. Should be either AF_INET or AF_INET6.
     * @return string|false Returns the resolved IP address on success, or FALSE on failure.
     * @alias This method is an alias of function \swoole_async_dns_lookup_coro().
     * @see \swoole_async_dns_lookup_coro()
     * @see \Swoole\Coroutine::dnsLookup()
     */
    public static function dnsLookup(string $domain_name, float $timeout = 60, int $type = AF_INET): string|false
    {
    }

    /**
     * Execute a shell command, in a coroutine-friendly way.
     *
     * The command is executed through the shell in a child process. The calling coroutine yields until the command
     * finishes, without blocking the process; meanwhile, other coroutines within the same process keep running.
     *
     * @param string $command The command to be executed.
     * @param bool $get_error_stream If TRUE, the error output of the command (its standard error) is captured as
     *                               part of field "output" of the return value as well. By default, only the standard
     *                               output of the command is captured.
     * @return array|false Returns FALSE if the command fails to run. Otherwise, returns an array with the following fields in it:
     *                     - output: The output of the command.
     *                     - code: The exit code of the command. 0 typically means the command finished successfully.
     *                     - signal: The signal number that terminated the command, or 0 if it exited normally.
     * @see https://www.php.net/shell_exec The built-in PHP function \shell_exec(), which serves a similar purpose but blocks the whole process.
     * @alias This method has an alias of \Swoole\Coroutine::exec().
     * @see \Swoole\Coroutine::exec()
     */
    public static function exec(string $command, bool $get_error_stream = false): array|false
    {
    }

    /**
     * Pause the current coroutine for the given number of seconds.
     *
     * Unlike the built-in PHP function \sleep(), this method blocks the calling coroutine only, not the whole process;
     * other coroutines within the same process keep running while the current one sleeps.
     *
     * @param float $seconds Number of seconds to sleep. It must be no less than 0.001 (one millisecond), which is the
     *                       minimum number of seconds that can be used for time-related operations in Swoole, as
     *                       denoted by constant SWOOLE_TIMER_MIN_SEC.
     * @return bool TRUE once the time is up; FALSE if $seconds is less than 0.001, or if the coroutine is cancelled
     *              while sleeping.
     * @see https://www.php.net/sleep The built-in PHP function \sleep(), which blocks the whole process.
     * @alias This method has an alias of \Swoole\Coroutine::sleep().
     * @see \Swoole\Coroutine::sleep()
     */
    public static function sleep(float $seconds): bool
    {
    }

    /**
     * Resolve a host name into a list of IPv4/IPv6 addresses.
     *
     * Please check documentation of method \Swoole\Coroutine::getaddrinfo() for more details.
     *
     * @param string $domain The host name to be resolved. It can't be an empty string.
     * @param int $family The type of address to resolve. Should be either AF_INET or AF_INET6.
     * @param int $socktype The socket type to resolve for, e.g., SOCK_STREAM or SOCK_DGRAM.
     * @param int $protocol The protocol to resolve for, e.g., STREAM_IPPROTO_TCP or STREAM_IPPROTO_UDP.
     * @param string|null $service The service name or port number to resolve, as accepted by getaddrinfo(3).
     * @param float $timeout The timeout for domain resolving (in seconds). No timeout if it's not greater than 0.
     * @return array|false Returns a list of resolved IP addresses on success, or FALSE on failure.
     * @alias This method has an alias of \Swoole\Coroutine::getaddrinfo().
     * @see \Swoole\Coroutine::getaddrinfo()
     */
    public static function getaddrinfo(string $domain, int $family = AF_INET, int $socktype = SOCK_STREAM, int $protocol = STREAM_IPPROTO_TCP, ?string $service = null, float $timeout = -1): array|false
    {
    }

    /**
     * Get information about the filesystem that the given path belongs to (e.g., total and free disk space).
     *
     * This method is a wrapper of the C function statvfs(3).
     *
     * @param string $path Path of any file or directory on the filesystem.
     * @return array Returns an array with the following fields in it, mostly measured in filesystem blocks:
     *               "bsize", "frsize", "blocks", "bfree", "bavail", "files", "ffree", "favail", "fsid", "flag", and "namemax".
     *               For example, multiplying "bavail" by "frsize" gives the disk space (in bytes) available to unprivileged users.
     * @throws \ValueError When $path is an empty string or contains null bytes. (Before Swoole 6.2.1, such a path
     *                     was passed through to the underlying system call and simply produced no useful result;
     *                     since Swoole 6.2.1, it is rejected upfront with a \ValueError instead.)
     * @see https://man7.org/linux/man-pages/man3/statvfs.3.html The C function statvfs(3) wrapped by this method.
     * @alias This method has an alias of \Swoole\Coroutine::statvfs().
     * @see \Swoole\Coroutine::statvfs()
     */
    public static function statvfs(string $path): array
    {
    }

    /**
     * Read a whole file into a string, in a coroutine-friendly way.
     *
     * The file is read in a thread pool so that the calling coroutine yields until the content is ready, without
     * blocking the process.
     *
     * @param string $filename Path of the file to read.
     * @param int $flag Either 0 (the default) or constant LOCK_EX. When LOCK_EX is passed, an exclusive lock is
     *                  acquired on the file while reading it. Since Swoole 6.1.2, constant FILE_LOCK (registered by
     *                  Swoole with the same value as LOCK_EX) can be used interchangeably here.
     * @return string|false Returns the content of the file on success, or FALSE on failure (e.g., when the file
     *                      doesn't exist or is not readable).
     * @throws \ValueError When $filename is an empty string or contains null bytes. (Before Swoole 6.2.1, an empty
     *                     filename simply made the method fail with FALSE returned; since Swoole 6.2.1, such
     *                     filenames are rejected upfront with a \ValueError instead.)
     * @see https://www.php.net/file_get_contents The built-in PHP function \file_get_contents(), which serves a similar purpose but may block the whole process.
     * @see FILE_LOCK
     * @see \Swoole\Coroutine::readFile()
     * @alias This method has an alias of \Swoole\Coroutine::readFile().
     */
    public static function readFile(string $filename, int $flag = 0): string|false
    {
    }

    /**
     * Write a string to a file, in a coroutine-friendly way.
     *
     * The file is written in a thread pool so that the calling coroutine yields until the write finishes, without
     * blocking the process. By default, existing content in the file is replaced.
     *
     * Since Swoole 6.2.1, this method refuses to write through symbolic links: if $filename itself is a symbolic
     * link, the method fails and FALSE is returned. (Under the hood, the file is opened with the O_NOFOLLOW flag,
     * which guards against symlink-based attacks where a link is planted at a writable path to trick the process
     * into overwriting an unintended file.)
     *
     * @param string $filename Path of the file to write to.
     * @param string $fileContent The content to write to the file.
     * @param int $flags A bitmask made of the following constants (same as in the built-in PHP function \file_put_contents()):
     *                   - FILE_APPEND: Append the content to the end of the file instead of replacing existing content.
     *                   - LOCK_EX: Acquire an exclusive lock on the file while writing to it. Since Swoole 6.1.2,
     *                   constant FILE_LOCK (registered by Swoole with the same value as LOCK_EX) can be used
     *                   interchangeably here.
     * @return int|false Returns the number of bytes written on success, or FALSE on failure (e.g., when the file
     *                   can't be opened for writing, or, since Swoole 6.2.1, when $filename is a symbolic link).
     * @throws \ValueError When $filename is an empty string or contains null bytes. (Before Swoole 6.2.1, an empty
     *                     filename simply made the method fail with FALSE returned; since Swoole 6.2.1, such
     *                     filenames are rejected upfront with a \ValueError instead.)
     * @see https://www.php.net/file_put_contents The built-in PHP function \file_put_contents(), which serves a similar purpose but may block the whole process.
     * @see https://man7.org/linux/man-pages/man2/open.2.html The C function open(2), where the O_NOFOLLOW flag used by this method since Swoole 6.2.1 is documented.
     * @see FILE_LOCK
     * @see \Swoole\Coroutine::writeFile()
     * @alias This method has an alias of \Swoole\Coroutine::writeFile().
     */
    public static function writeFile(string $filename, string $fileContent, int $flags = 0): int|false
    {
    }

    /**
     * Wait for any child process of the current process to exit, in a coroutine-friendly way.
     *
     * This method is a coroutine-friendly replacement of function \pcntl_wait(): the calling coroutine yields until a
     * child process (e.g., one created through class \Swoole\Process) exits, without blocking the process.
     *
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until a child process exits.
     * @return array|false Returns FALSE on failure (e.g., when there is no child process to wait for, or when no child
     *                     process exits within the given timeout). Otherwise, returns an array with the following fields in it:
     *                     - pid: Process ID of the child process that exited.
     *                     - code: The exit code of the child process. 0 typically means the process finished successfully.
     *                     - signal: The signal number that terminated the child process, or 0 if it exited normally.
     * @see https://www.php.net/pcntl_wait The built-in PHP function \pcntl_wait(), which serves a similar purpose but blocks the whole process.
     * @see \Swoole\Coroutine\System::waitPid()
     * @alias This method has an alias of \Swoole\Coroutine::wait().
     * @see \Swoole\Coroutine::wait()
     * @since 4.5.0
     */
    public static function wait(float $timeout = -1): array|false
    {
    }

    /**
     * Wait for a specific child process of the current process to exit, in a coroutine-friendly way.
     *
     * This method works the same way as method \Swoole\Coroutine\System::wait(), except that it waits for a specific
     * child process instead of any of them.
     *
     * @param int $pid Process ID of the child process to wait for.
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until the child process exits.
     * @return array|false Returns FALSE on failure (e.g., when the given process is not a child process of the current
     *                     process, or when it doesn't exit within the given timeout). Otherwise, returns an array with
     *                     the following fields in it:
     *                     - pid: Process ID of the child process that exited.
     *                     - code: The exit code of the child process. 0 typically means the process finished successfully.
     *                     - signal: The signal number that terminated the child process, or 0 if it exited normally.
     * @see https://www.php.net/pcntl_waitpid The built-in PHP function \pcntl_waitpid(), which serves a similar purpose but blocks the whole process.
     * @see \Swoole\Coroutine\System::wait()
     * @alias This method has an alias of \Swoole\Coroutine::waitPid().
     * @see \Swoole\Coroutine::waitPid()
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
     * @alias This method has an alias of \Swoole\Coroutine::waitSignal().
     * @see \Swoole\Coroutine::waitSignal()
     * @since 4.5.0
     */
    public static function waitSignal(int|array $signals, float $timeout = -1): int|false
    {
    }

    /**
     * Wait until a socket becomes readable and/or writable.
     *
     * The calling coroutine yields until one of the given events happens on the socket (or until it times out),
     * without blocking the process.
     *
     * @param mixed $socket The socket to watch. It can be a stream resource (e.g., one created by function
     *                      \stream_socket_client()), a \Socket object of the PHP sockets extension, or a Swoole object
     *                      representing a socket connection.
     * @param int $events A SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
     * @param float $timeout The maximum time to wait (in seconds). If specified as a negative number (which is the
     *                       default), it waits indefinitely until one of the given events happens.
     * @return int|false Returns the event(s) that happened on the socket (a bitmask of SWOOLE_EVENT_READ and
     *                   SWOOLE_EVENT_WRITE) on success, or FALSE on failure (e.g., when the given value is not a
     *                   socket, or when none of the given events happens within the given timeout).
     * @alias This method has an alias of \Swoole\Coroutine::waitEvent().
     * @see \Swoole\Coroutine::waitEvent()
     * @since 4.5.0
     */
    public static function waitEvent(mixed $socket, int $events = SWOOLE_EVENT_READ, float $timeout = -1): int|false
    {
    }
}
