<?php

declare(strict_types=1);

use Swoole\NameResolver;
use Swoole\NameResolver\Context;
use Swoole\Timer\Iterator;

/**
 * Gets the current Swoole version. This information is also available in the predefined constant SWOOLE_VERSION.
 *
 * @return string returns a string containing the version of Swoole
 */
function swoole_version(): string
{
}

/**
 * Gets the number of CPU cores.
 *
 * @return int returns the number of CPU cores
 */
function swoole_cpu_num(): int
{
}

/**
 * Get the error code of the latest failed operation.
 *
 * To translate the error code to an error message, use the following statement:
 *     swoole_strerror(swoole_last_error(), SWOOLE_STRERROR_SWOOLE);
 *
 * @return int Returns the error code of the latest failed operation.
 * @alias This function has an alias method \Swoole\Server::getLastError().
 * @see \Swoole\Server::getLastError()
 * @see swoole_strerror()
 */
function swoole_last_error(): int
{
}

/**
 * Lookup the IPv4/IPv6 address corresponding to a given Internet host name.
 *
 * Please check documentation of method \Swoole\Coroutine::dnsLookup() for more details.
 *
 * @param string $domain_name The Internet host name to look up, e.g., "www.swoole.com".
 * @param float $timeout Maximum number of seconds to wait before the lookup is aborted. Defaults to 60.
 * @param int $type Type of IP addresses to look up: AF_INET for IPv4 addresses (the default), or AF_INET6 for IPv6 addresses.
 * @return string|false Returns the IP address of the host on success, or false on failure.
 * @alias This function has two alias methods: \Swoole\Coroutine::dnsLookup() and \Swoole\Coroutine\System::dnsLookup().
 * @see \Swoole\Coroutine::dnsLookup()
 * @see \Swoole\Coroutine\System::dnsLookup()
 */
function swoole_async_dns_lookup_coro(string $domain_name, float $timeout = 60, int $type = AF_INET): string|false
{
}

/**
 * Sets global runtime settings. It has to be called before the event loop is created; otherwise a fatal error is
 * raised.
 *
 * Besides the settings listed below, this function also accepts the global settings and the asynchronous I/O settings
 * shared with method \Swoole\Coroutine::set(), e.g., "log_file", "log_level", "dns_server", "socket_timeout",
 * "aio_core_worker_num", and "aio_worker_num".
 *
 * @param array $settings Runtime settings. The following settings are supported:
 *                        - \Swoole\Constant::OPTION_ENABLE_SIGNALFD: whether to handle signals through signalfd
 *                        instead of a plain signal handler. Enabled by default on systems providing signalfd.
 *                        - \Swoole\Constant::OPTION_WAIT_SIGNAL: whether a registered signal listener keeps the event
 *                        loop alive; when disabled (the default), the event loop exits even if there are signal
 *                        listeners left waiting.
 *                        - \Swoole\Constant::OPTION_DNS_CACHE_REFRESH_TIME: lifetime in seconds of an entry in the DNS
 *                        cache used by function swoole_async_dns_lookup_coro(). Defaults to 60.
 *                        - \Swoole\Constant::OPTION_THREAD_NUM: alias of setting
 *                        \Swoole\Constant::OPTION_MIN_THREAD_NUM.
 *                        - \Swoole\Constant::OPTION_MIN_THREAD_NUM: number of threads kept alive in the asynchronous
 *                        I/O thread pool (the pool used for hooked file operations, DNS lookups, etc.). Defaults to
 *                        the number of CPU cores.
 *                        - \Swoole\Constant::OPTION_MAX_THREAD_NUM: maximum number of threads the asynchronous I/O
 *                        thread pool may grow to when under load.
 *                        - \Swoole\Constant::OPTION_SOCKET_DONTWAIT: when enabled, a write on an asynchronous client
 *                        socket fails right away once its output buffer is full, instead of waiting for the buffer
 *                        to drain. Disabled by default.
 *                        - \Swoole\Constant::OPTION_DNS_LOOKUP_RANDOM: when enabled, a DNS lookup returns a randomly
 *                        picked address out of all the addresses resolved, instead of the first one. Disabled by
 *                        default.
 *                        - \Swoole\Constant::OPTION_USE_ASYNC_RESOLVER: kept for backward compatibility only. The
 *                        value is still accepted and stored, but has not been read anywhere in Swoole since the old
 *                        (non-coroutine) async I/O module was removed in Swoole 4.3.0.
 *                        - \Swoole\Constant::OPTION_ENABLE_COROUTINE: whether the built-in coroutine support is
 *                        enabled. Enabled by default; disabling it turns off automatic coroutine creation in
 *                        callbacks.
 *
 * @return bool Returns true on success. Returns false when the settings cannot be applied (e.g. invalid arguments).
 * @see \Swoole\Coroutine::set()
 * @see SWOOLE_HOOK_FILE
 */
function swoole_async_set(array $settings): bool
{
}

/**
 * Create a coroutine.
 *
 * @param callable $func The function to execute inside the new coroutine.
 * @param mixed ...$params The parameters to pass to the function when the coroutine starts.
 * @return int|false Returns the coroutine ID on success, or false on failure. Note that this method won't return
 *                   the coroutine ID back until the new coroutine yields its execution.
 * @alias This function has an alias function \go() and an alias method \Swoole\Coroutine::create().
 * @see \go()
 * @see \Swoole\Coroutine::create()
 */
function swoole_coroutine_create(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns. e.g.,
 * ```php
 * swoole_coroutine_create(function () {  // The surrounding function of a coroutine.
 *   echo '1';
 *   swoole_coroutine_defer(function () { // The callback function to be deferred.
 *     echo '3';
 *   });
 *   echo '2';
 * });
 * ```
 *
 * @param callable $callback The callback function to be deferred.
 * @alias This function has an alias function \defer() and an alias method \Swoole\Coroutine::defer().
 * @see \defer()
 * @see \Swoole\Coroutine::defer()
 */
function swoole_coroutine_defer(callable $callback): void
{
}

/**
 * Creates a pair of connected sockets, like what PHP function socket_create_pair() does, but returning
 * \Swoole\Coroutine\Socket objects that work inside coroutines without blocking the process.
 *
 * @param int $domain The protocol family of the sockets, e.g., AF_UNIX.
 * @param int $type The communication type of the sockets, e.g., SOCK_STREAM.
 * @param int $protocol The protocol of the sockets, e.g., IPPROTO_IP.
 * @return array|false Returns an array of two connected \Swoole\Coroutine\Socket objects on success (data written to
 *                     one can be read from the other), or false on failure.
 * @see https://www.php.net/socket_create_pair
 * @see \Swoole\Coroutine\Socket
 */
function swoole_coroutine_socketpair(int $domain, int $type, int $protocol): array|false
{
}

/**
 * Creates a kernel-level (C-level) coroutine that sleeps repeatedly. When coroutine support is not activated yet, the
 * function does nothing.
 *
 * @param int $count Number of times the coroutine sleeps before it finishes.
 * @param float $sleep_time Number of seconds to sleep each time.
 * @internal This function is intended for testing purposes only.
 */
function swoole_test_kernel_coroutine(int $count = 100, float $sleep_time = 1.0): void
{
}

/**
 * Waits until some of the given sockets/streams change status, like what PHP function stream_select() does.
 *
 * At least one of the three arrays passed in must be non-empty; entries can be stream resources, socket resources, or
 * objects of class \Swoole\Client. Once the function returns, each array contains only the entries that are ready.
 *
 * Note: this stub used to declare the signature with non-nullable array parameters as
 * swoole_client_select(array &$read, array &$write, array &$except, float $timeout = 0.5); the three array
 * parameters have always been nullable in the Swoole extension itself.
 *
 * @param array|null $read Entries to watch for readability. Pass null to watch none.
 * @param array|null $write Entries to watch for writability. Pass null to watch none.
 * @param array|null $except Entries to watch for exceptional conditions (e.g. a hangup). Pass null to watch none.
 * @param float $timeout Maximum number of seconds to wait. Defaults to 0.5.
 * @return int|false Returns the number of entries that are ready, or false on failure.
 * @alias This function has an alias function swoole_select().
 * @see swoole_select()
 * @see https://www.php.net/stream_select
 */
function swoole_client_select(?array &$read, ?array &$write, ?array &$except, float $timeout = 0.5): int|false
{
}

/**
 * Waits until some of the given sockets/streams change status, like what PHP function stream_select() does.
 *
 * Note: this stub used to declare the signature with non-nullable array parameters as
 * swoole_select(array &$read, array &$write, array &$except, float $timeout = 0.5); the three array parameters have
 * always been nullable in the Swoole extension itself.
 *
 * @param array|null $read Entries to watch for readability. Pass null to watch none.
 * @param array|null $write Entries to watch for writability. Pass null to watch none.
 * @param array|null $except Entries to watch for exceptional conditions (e.g. a hangup). Pass null to watch none.
 * @param float $timeout Maximum number of seconds to wait. Defaults to 0.5.
 * @return int|false Returns the number of entries that are ready, or false on failure.
 * @alias This function is an alias of function swoole_client_select().
 * @see swoole_client_select()
 */
function swoole_select(?array &$read, ?array &$write, ?array &$except, float $timeout = 0.5): int|false
{
}

/**
 * Set the process name.
 *
 * There isn't a method in Swoole to get the process name. You can use PHP function \cli_get_process_title() to get the process name.
 *
 * @param string $process_name The new process name.
 * @return bool Returns true on success or false on failure.
 * @alias This function has an alias method \Swoole\Process::name().
 * @see \Swoole\Process::name()
 * @see https://www.php.net/cli_set_process_title
 * @see https://www.php.net/cli_get_process_title
 * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
 */
function swoole_set_process_name(string $process_name): bool
{
    if (PHP_SAPI !== 'cli') {
        // An E_WARNING level error will be thrown out here.
        return false;
    }

    return \cli_set_process_title($process_name);
}

/**
 * Gets the IPv4 addresses of the network interfaces on the machine.
 *
 * Interfaces that are down, the loopback address 127.0.0.1, and IPv6 addresses are not included in the result.
 *
 * @return array Returns an array mapping each network interface name to its IPv4 address, e.g.,
 *               ["eth0" => "192.168.1.5"]. If the network interfaces cannot be read, a warning is raised and false is
 *               returned instead.
 * @see swoole_get_local_mac()
 */
function swoole_get_local_ip(): array
{
}

/**
 * Gets the MAC (hardware) addresses of the network interfaces on the machine.
 *
 * @return array Returns an array mapping each network interface name to its MAC address in the form
 *               "XX:XX:XX:XX:XX:XX", e.g., ["eth0" => "02:42:AC:11:00:02"]. On systems where the information cannot
 *               be read, a warning is raised and false is returned instead.
 * @see swoole_get_local_ip()
 */
function swoole_get_local_mac(): array
{
}

/**
 * Get the error message corresponding to the given error code.
 *
 * @param int $errno Error code.
 * @param int $error_type Error type. There are four types of error messages:
 *                        - SWOOLE_STRERROR_SYSTEM: Generic system error message.
 *                        - SWOOLE_STRERROR_GAI: Error message from function call getaddrinfo().
 *                        - SWOOLE_STRERROR_DNS: Error message from network host-related functions.
 *                        - SWOOLE_STRERROR_SWOOLE: Error message of Swoole.
 * @return string Return the error message corresponding to the error code.
 * @see swoole_last_error()
 * @see \Swoole\Server::getLastError()
 */
function swoole_strerror(int $errno, int $error_type = SWOOLE_STRERROR_SYSTEM): string
{
}

/**
 * Gets the error code of the most recent failed system call (the C-level "errno" value of the process).
 *
 * @return int Returns the error code of the most recent failed system call, or 0 if there is none.
 * @see swoole_strerror()
 * @see https://man7.org/linux/man-pages/man3/errno.3.html
 */
function swoole_errno(): int
{
}

/**
 * Resets the error code of the latest failed operation back to 0.
 *
 * @see swoole_last_error()
 */
function swoole_clear_error(): void
{
}

/**
 * Writes a message to the Swoole log (the log file configured through setting "log_file", or standard output by
 * default). The message is dropped silently when $level is lower than the configured log level.
 *
 * @param int $level Log level of the message. It should be one of the SWOOLE_LOG_* constants, e.g., SWOOLE_LOG_NOTICE.
 * @param string $msg The message to log.
 * @see swoole_error_log_ex()
 */
function swoole_error_log(int $level, string $msg): void
{
}

/**
 * Writes a message to the Swoole log, with a Swoole error code attached to it.
 *
 * Compared with function swoole_error_log(), this function takes an extra error code, which is included in the
 * message logged and stored as the error code of the latest failed operation. Messages whose error code has been
 * suppressed via function swoole_ignore_error() are not logged.
 *
 * @param int $level Log level of the message. It should be one of the SWOOLE_LOG_* constants, e.g., SWOOLE_LOG_NOTICE.
 * @param int $error A Swoole error code (one of the SWOOLE_ERROR_* constants).
 * @param string $msg The message to log.
 * @see swoole_error_log()
 * @see swoole_ignore_error()
 * @see swoole_last_error()
 * @since 4.8.1
 */
function swoole_error_log_ex(int $level, int $error, string $msg): void
{
}

/**
 * Stops the given Swoole error code from being logged from now on.
 *
 * @param int $error The Swoole error code (one of the SWOOLE_ERROR_* constants) to suppress.
 * @see swoole_error_log_ex()
 * @since 4.8.1
 */
function swoole_ignore_error(int $error): void
{
}

/**
 * Calculates the hash code of a string.
 *
 * @param string $data The string to hash.
 * @param int $type The hash algorithm to use: 0 (the default) uses the same hash algorithm that PHP uses internally
 *                  for arrays (DJBX33A), while 1 uses the "one-at-a-time" hash algorithm.
 * @return int|false Returns the hash code of the string as an integer, or false when $type is not a supported
 *                   algorithm.
 */
function swoole_hashcode(string $data, int $type = 0): int|false
{
}

/**
 * Adds a MIME type to the list of MIME types known to Swoole, unless the given file name suffix is registered already.
 *
 * The swoole_mime_type_*() functions manage one single process-wide list of file name suffixes and their MIME types.
 * That list is used in three places in Swoole:
 * 1. serving static files: unless the request URL matches one of the paths configured in server setting
 *    "static_handler_locations", the static file handler refuses to serve a file whose suffix is not on the list. The
 *    matching MIME type is then used as the value of HTTP header "Content-Type" of the response.
 * 2. method \Swoole\Http\Response::sendfile(): when HTTP header "Content-Type" is not set on the response already,
 *    the MIME type of the file being sent is used as the value of that header.
 * 3. method \Swoole\Coroutine\Http\Client::addFile(): when no content type is passed to the method, the MIME type of
 *    the file being uploaded is used as the content type of that part of the request.
 *
 * @param string $suffix The file name suffix, without a leading dot, e.g., "json". It has to be given in lower case:
 *                       lookups lowercase the suffix taken from the file name, so a suffix registered in upper case
 *                       is never matched.
 * @param string $mime_type The MIME type of the suffix, e.g., "application/json".
 * @return bool Returns TRUE when the MIME type is added, FALSE when the suffix is registered already. Use function
 *              swoole_mime_type_set() instead to overwrite an existing entry.
 * @see https://github.com/deminy/swoole-by-examples/blob/master/examples/servers/http1.php
 * @see \Swoole\Http\Response::sendfile()
 * @see \Swoole\Coroutine\Http\Client::addFile()
 * @see swoole_mime_type_set()
 * @since 4.5.0
 */
function swoole_mime_type_add(string $suffix, string $mime_type): bool
{
}

/**
 * Sets the MIME type of a file name suffix, overwriting the existing entry if there is one.
 *
 * @param string $suffix The file name suffix, without a leading dot, e.g., "json". It has to be given in lower case.
 * @param string $mime_type The MIME type of the suffix, e.g., "application/json".
 * @see swoole_mime_type_add() Description of the list of MIME types managed by the swoole_mime_type_*() functions.
 * @since 4.5.0
 */
function swoole_mime_type_set(string $suffix, string $mime_type): void
{
}

/**
 * Checks if the suffix of the given file name has a MIME type registered.
 *
 * @param string $filename A file name, e.g., "/var/www/index.html". Only its suffix is taken into account.
 * @return bool Returns true if the suffix of the file name has a MIME type registered, false otherwise.
 * @see swoole_mime_type_add() Description of the list of MIME types managed by the swoole_mime_type_*() functions.
 * @since 4.5.0
 */
function swoole_mime_type_exists(string $filename): bool
{
}

/**
 * Removes a file name suffix and its MIME type from the list.
 *
 * @param string $suffix The file name suffix, without a leading dot, e.g., "json". It has to be given in lower case.
 * @return bool Returns TRUE on success, FALSE when the suffix is not on the list.
 * @see swoole_mime_type_add() Description of the list of MIME types managed by the swoole_mime_type_*() functions.
 * @since 4.5.0
 */
function swoole_mime_type_delete(string $suffix): bool
{
}

/**
 * Gets the MIME type registered for the suffix of the given file name.
 *
 * @param string $filename A file name, e.g., "/var/www/index.html". Only its suffix is taken into account.
 * @return string Returns the MIME type registered, or "application/octet-stream" when the suffix is not on the list.
 * @alias This function has an alias function swoole_get_mime_type().
 * @see swoole_get_mime_type()
 * @see swoole_mime_type_add() Description of the list of MIME types managed by the swoole_mime_type_*() functions.
 * @since 4.5.0
 */
function swoole_mime_type_get(string $filename): string
{
}

/**
 * @alias This function is an alias of function swoole_mime_type_get().
 * @see swoole_mime_type_get()
 */
function swoole_get_mime_type(string $filename): string
{
}

/**
 * Gets all the MIME types registered.
 *
 * @return array Returns a list of MIME types. Only the MIME types are returned; the file name suffixes they are
 *               registered for are not included in the returned list.
 * @see swoole_mime_type_add() Description of the list of MIME types managed by the swoole_mime_type_*() functions.
 */
function swoole_mime_type_list(): array
{
}

/**
 * Empties the DNS cache used by Swoole's coroutine-friendly DNS lookups (e.g., function
 * swoole_async_dns_lookup_coro() and method \Swoole\Coroutine\System::gethostbyname()).
 *
 * @see swoole_async_dns_lookup_coro()
 * @see \Swoole\Coroutine\System::gethostbyname()
 */
function swoole_clear_dns_cache(): void
{
}

/**
 * Unserializes a value stored inside the given string, without first copying the substring out.
 *
 * This is a memory-friendly equivalent of unserialize(substr($str, $offset, $length)): the serialized value is read
 * straight out of $str at the given position, so the temporary copy that substr() would create is avoided. It is
 * handy when a small serialized record is stored inside a large buffer.
 *
 * @param string $str The string containing the serialized value.
 * @param int $offset Position in $str to start reading from. A negative offset counts back from the end of the string.
 * @param int $length Number of bytes to read. When 0 (the default), or larger than what remains after $offset, the
 *                    rest of the string is used.
 * @param array $options Options passed through to PHP's unserialize(), e.g. ["allowed_classes" => false].
 * @return mixed Returns the unserialized value, or false on failure (e.g. when $str is empty or $offset falls outside
 *               the string).
 * @see https://www.php.net/unserialize
 */
function swoole_substr_unserialize(string $str, int $offset, int $length = 0, array $options = []): mixed
{
}

/**
 * Decodes a JSON value stored inside the given string, without first copying the substring out.
 *
 * This is a memory-friendly equivalent of json_decode(substr($str, $offset, $length), ...): the JSON is parsed
 * straight out of $str at the given position, so the temporary copy that substr() would create is avoided. It is
 * handy when a small JSON document is embedded in a large buffer.
 *
 * @param string $str The string containing the JSON document.
 * @param int $offset Position in $str to start reading from. A negative offset counts back from the end of the string.
 * @param int $length Number of bytes to read. When 0 (the default), or larger than what remains after $offset, the
 *                    rest of the string is used.
 * @param bool $associative When true, JSON objects are returned as associative arrays instead of objects. Mirrors the
 *                          same argument of PHP's json_decode().
 * @param int $depth Maximum nesting depth. Defaults to 512.
 * @param int $flags Bitmask of JSON decoding flags (the JSON_* constants), e.g. JSON_BIGINT_AS_STRING.
 * @return mixed Returns the decoded value, or null (with an E_WARNING) when $str is empty or $offset falls outside
 *               the string.
 * @see https://www.php.net/json_decode
 */
function swoole_substr_json_decode(string $str, int $offset, int $length = 0, bool $associative = false, int $depth = 512, int $flags = 0): mixed
{
}

/**
 * Internal testing helper that performs a low-level action selected by name, such as triggering a fatal error,
 * exiting with a given status code, aborting the process, or reporting a value's reference count.
 *
 * @param string $fn Name of the action to perform, e.g. "fatal_error", "bailout", "abort", "refcount" or
 *                   "func_handler". An unknown name makes the function throw a \Swoole\Exception.
 * @param mixed $args Optional argument for the selected action (e.g. the exit status for "bailout", or the value
 *                    whose reference count to report for "refcount").
 * @return mixed The result depends on the action selected; most actions return null, while e.g. "refcount" returns an int.
 * @internal This function is intended for testing purposes only.
 * @since 6.0.0
 */
function swoole_implicit_fn(string $fn, mixed $args = null): mixed
{
}

/**
 * Marks the point where PHP starts executing the shutdown functions registered via register_shutdown_function().
 *
 * Swoole registers this function itself as the very first shutdown function, so that it can tell whether code (e.g.
 * coroutine creation) is running during request shutdown. It fails with a warning when called anywhere else.
 *
 * @return bool Returns true when called at the right moment during request shutdown, false (with a warning) otherwise.
 * @internal This function is intended for internal use only.
 */
function swoole_internal_call_user_shutdown_begin(): bool
{
}

/**
 * Get all PHP objects of current call stack.
 *
 * @return array|false Return an array of objects back; return FALSE when no objects exist or when error happens.
 * @since 4.8.1
 */
function swoole_get_objects(): array|false
{
}

/**
 * Get status information of current call stack.
 *
 * @return array The array contains two fields: "object_num" (# of objects) and "resource_num" (# of resources).
 * @since 4.8.1
 */
function swoole_get_vm_status(): array
{
}

/**
 * Get a PHP object by its object handle (the internal ID shown by var_dump() and function spl_object_id()).
 *
 * @param int $handle The object handle.
 * @return object|false Return the specified object back; return FALSE when no object found or when error happens.
 * @see https://www.php.net/spl_object_id
 * @since 4.8.1
 */
function swoole_get_object_by_handle(int $handle): object|false
{
}

/**
 * Translates a service name into a host address using the name resolvers registered via function
 * swoole_name_resolver_add().
 *
 * @param string $name The name to resolve, e.g., a host name or a service name.
 * @param Context $ctx Contextual information passed to the name resolvers.
 * @return string Returns the resolved address. When no registered resolver takes care of the name, a regular DNS
 *                lookup is performed instead; an empty string is returned when the name cannot be resolved at all.
 * @see swoole_name_resolver_add()
 */
function swoole_name_resolver_lookup(string $name, Context $ctx): string
{
}

/**
 * Appends a name resolver to the list of name resolvers used by Swoole.
 *
 * @param NameResolver $ns The name resolver to add.
 * @return bool Returns true on success, false on failure.
 * @see swoole_name_resolver_lookup()
 * @see swoole_name_resolver_remove()
 */
function swoole_name_resolver_add(NameResolver $ns): bool
{
}

/**
 * Removes a name resolver from the list of name resolvers used by Swoole.
 *
 * @param NameResolver $ns The name resolver to remove.
 * @return bool Returns true on success, false when the given name resolver is not on the list.
 * @see swoole_name_resolver_add()
 */
function swoole_name_resolver_remove(NameResolver $ns): bool
{
}

/**
 * Adds a file descriptor to the event loop and watches it for readability and/or writability.
 *
 * @param mixed $fd The descriptor to watch: an int file descriptor, a stream or socket resource, a
 *                  \Swoole\Coroutine\Socket, or an object exposing one of those.
 * @param callable|null $read_callback Called when $fd becomes readable. Required when $events includes SWOOLE_EVENT_READ.
 * @param callable|null $write_callback Called when $fd becomes writable. Required when $events includes SWOOLE_EVENT_WRITE.
 * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
 * @return int|false Returns the file descriptor being watched on success, or false on failure (e.g. an unrecognized
 *                   $fd, a descriptor that is already being watched, or a missing callback for a requested event).
 * @alias This function is an alias of method \Swoole\Event::add().
 * @see \Swoole\Event::add()
 */
function swoole_event_add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): int|false
{
}

/**
 * Removes a file descriptor from the event loop, so that it's no longer watched for readability or writability.
 *
 * @param mixed $fd The descriptor to stop watching. It can be any of the values accepted by function swoole_event_add().
 * @return bool Returns true on success, or false on failure (e.g. the descriptor is not being watched).
 * @alias This function is an alias of method \Swoole\Event::del().
 * @see \Swoole\Event::del()
 * @see swoole_event_add()
 */
function swoole_event_del(mixed $fd): bool
{
}

/**
 * Updates the callbacks and/or the events watched of a file descriptor already added to the event loop.
 *
 * Only the arguments passed with a non-default value are updated; the rest keep their current settings.
 *
 * @param mixed $fd The descriptor being watched. It can be any of the values accepted by function swoole_event_add().
 * @param callable|null $read_callback New callback for when $fd becomes readable.
 * @param callable|null $write_callback New callback for when $fd becomes writable.
 * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
 * @return bool Returns true on success, or false on failure (e.g. the descriptor is not being watched, or a
 *              requested event has no matching callback set).
 * @alias This function is an alias of method \Swoole\Event::set().
 * @see \Swoole\Event::set()
 * @see swoole_event_add()
 */
function swoole_event_set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
{
}

/**
 * Checks if a file descriptor is being watched in the event loop for the given events.
 *
 * @param mixed $fd The descriptor to check. It can be any of the values accepted by function swoole_event_add().
 * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
 * @return bool Returns true if the descriptor is being watched for any of the given events, false otherwise.
 * @alias This function is an alias of method \Swoole\Event::isset().
 * @see \Swoole\Event::isset()
 * @see swoole_event_add()
 */
function swoole_event_isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
{
}

/**
 * Runs a single iteration of the event loop, processing the events that are ready at the moment.
 *
 * Unlike function swoole_event_wait(), this function doesn't keep looping; it's meant for programs that manage their
 * own main loop.
 *
 * @return bool Returns true on success, false on failure.
 * @alias This function is an alias of method \Swoole\Event::dispatch().
 * @see \Swoole\Event::dispatch()
 * @see swoole_event_wait()
 */
function swoole_event_dispatch(): bool
{
}

/**
 * Defers the execution of the given callback.
 *
 * This function works similarly to statement setTimeout(callback, 0) in JavaScript.
 *
 * @param callable $callback The callback to be executed.
 * @return true This method always returns true.
 * @alias This function is an alias of method \Swoole\Event::defer().
 * @see \Swoole\Event::defer()
 * @see \swoole_timer_after() Add a timer that only runs once after the specified number of milliseconds.
 */
function swoole_event_defer(callable $callback): bool
{
}

/**
 * Sets a callback function to be executed at the end (or, optionally, at the beginning) of each iteration of the
 * event loop.
 *
 * @param callable|null $callback The callback function. Pass null to remove the callback currently set.
 * @param bool $before When true, the callback is executed at the beginning of each iteration instead of at the end.
 * @return bool Returns true on success, or false on failure (e.g. when passing null while no callback is set).
 * @alias This function is an alias of method \Swoole\Event::cycle().
 * @see \Swoole\Event::cycle()
 */
function swoole_event_cycle(?callable $callback, bool $before = false): bool
{
}

/**
 * Writes data to a file descriptor through the event loop: the data is sent right away if possible, with the
 * remainder buffered and sent automatically once the descriptor becomes writable.
 *
 * @param mixed $fd The descriptor to write to. It can be any of the values accepted by function swoole_event_add().
 * @param string $data The data to write.
 * @return bool Returns true on success, false on failure.
 * @alias This function is an alias of method \Swoole\Event::write().
 * @see \Swoole\Event::write()
 * @see swoole_event_add()
 */
function swoole_event_write(mixed $fd, string $data): bool
{
}

/**
 * Starts the event loop and keeps it running until there is nothing left to watch. Code after this call only runs
 * once the event loop has finished.
 *
 * @alias This function is an alias of method \Swoole\Event::wait().
 * @see \Swoole\Event::wait()
 * @see swoole_event_exit()
 */
function swoole_event_wait(): void
{
}

/**
 * Asks the running event loop to stop, making function swoole_event_wait() return.
 *
 * @alias This function is an alias of method \Swoole\Event::exit().
 * @see \Swoole\Event::exit()
 * @see swoole_event_wait()
 */
function swoole_event_exit(): void
{
}

/**
 * Add a timer that only runs once after the specified number of milliseconds.
 *
 * This method is different from PHP function sleep() in that it does not block the process when coroutine support is enabled.
 *
 * If coroutine support is enabled, Swoole will create a new coroutine to execute the callback function. Thus, there
 * is no need to create a new coroutine manually in the callback function.
 *
 * After a timer has been added, it can be removed by calling \swoole_timer_clear().
 *
 * @param int $ms The number of milliseconds to wait before the timer is executed.  It must be no less than SWOOLE_TIMER_MIN_MS (1 millisecond).
 * @param callable $callback The callback function to execute when the timer is executed.
 * @param mixed ...$params The parameters to pass to the callback function.
 * @return int|false Returns the timer ID on success, or false on failure.
 * @alias This function is an alias of method \Swoole\Timer::after().
 * @see SWOOLE_TIMER_MIN_MS
 * @see \Swoole\Timer::after()
 * @see \swoole_timer_clear()
 * @see \swoole_timer_clear_all()
 * @see \swoole_event_defer() Defers the execution of a callback.
 */
function swoole_timer_after(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * Add a timer that will run when the specified timer interval has elapsed.
 *
 * If coroutine support is enabled, Swoole will create a new coroutine to execute the callback function. Thus, there
 * is no need to create a new coroutine manually in the callback function.
 *
 * After a timer has been added, it can be removed by calling \swoole_timer_clear().
 *
 * Execution time of the callback function does not affect the next trigger time. In the following example, the
 * timer is set to trigger every 10 ms, and the callback function takes 5 ms to execute. The timer is triggered at
 * 0.000 s for the first time, and finishes at 0.005 s. The next one will be triggered at 0.010 s, but not 0.015 s.
 *
 *     Swoole\Timer::tick(10, function() { // Triggered every 10 ms.
 *         // Assuming the callback function takes 5 ms to execute.
 *     });
 *
 * The actual time between the timer being scheduled and the timer being executed may be longer than the specified
 * interval. A timer may be skipped if the callback function takes too long to execute; in this case, the timer will
 * be triggered again at the next interval. In the following example, the timer is set to trigger every 10 ms, and
 * the callback function takes 12 ms to execute. The timer is triggered at 0.000 s for the first time, and finishes
 * at 0.012 s. The one scheduled at 0.010 s will be skipped, and the next one will be triggered at 0.020 s.
 *
 *     Swoole\Timer::tick(10, function() { // Triggered every 10 ms.
 *         // Assuming the callback function takes 12 ms to execute.
 *     });
 *
 * @param int $ms The timer interval in milliseconds. It must be no less than SWOOLE_TIMER_MIN_MS (1 millisecond).
 * @param callable $callback The callback function to be executed when the timer interval has elapsed.
 * @param mixed ...$params The parameters to be passed to the callback function.
 * @return int|false Returns the timer ID on success, or false on failure.
 * @alias This function is an alias of method \Swoole\Timer::tick().
 * @see SWOOLE_TIMER_MIN_MS
 * @see \Swoole\Timer::tick()
 * @see \swoole_timer_clear()
 * @see \swoole_timer_clear_all()
 * @see \swoole_event_defer() Defers the execution of a callback.
 */
function swoole_timer_tick(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * Check if the timer exists.
 *
 * @param int $timer_id Timer ID returned by \Swoole\Timer::tick() or \Swoole\Timer::after().
 * @return bool Returns true if the timer exists, otherwise false.
 * @alias This function is an alias of method \Swoole\Timer::exists().
 * @see \Swoole\Timer::exists()
 */
function swoole_timer_exists(int $timer_id): bool
{
}

/**
 * Get the timer information.
 *
 * Timer information returned is in array format, with the following five fields included:
 *   - exec_msec (integer): Relative time of the next execution (in milliseconds).
 *   - exec_count (integer): The number of times the timer has been executed. Added in Swoole 4.8.0.
 *   - interval (integer): The interval of the timer (for timers added via method \Swoole\Timer::tick()).
 *   - round (integer): The number of rounds the underling event loop has been executed when the timer was first added.
 *   - removed (boolean): Whether the timer has been removed.
 *
 * @param int $timer_id Timer ID returned by \Swoole\Timer::tick() or \Swoole\Timer::after().
 * @return array|null Returns an array of timer information, or null if the timer does not exist.
 * @alias This function is an alias of method \Swoole\Timer::info().
 * @see \Swoole\Timer::info()
 */
function swoole_timer_info(int $timer_id): ?array
{
}

/**
 * Get statistics of all timers.
 *
 * This method returns an array with three fields included:
 *   - initialized (boolean): Whether Swoole has been initialized to execute timers.
 *   - num (integer): Number of timers.
 *   - round (integer): The number of rounds the underling event loop has been executed.
 *
 * @return array Returns an array of timer statistics.
 * @alias This function is an alias of method \Swoole\Timer::stats().
 * @see \Swoole\Timer::stats()
 */
function swoole_timer_stats(): array
{
}

/**
 * Get a list of timer IDs of all the timers set in current process. e.g.,
 * ```php
 * foreach (swoole_timer_list() as $timerId) {
 *   var_dump(swoole_timer_info($timerId));
 * };
 * ```
 *
 * @return Iterator Returns an iterator of timer IDs, which can be traversed with a foreach loop.
 * @alias This function is an alias of method \Swoole\Timer::list().
 * @see \Swoole\Timer::list()
 */
function swoole_timer_list(): Iterator
{
}

/**
 * Clear a timer in current process.
 *
 * @param int $timer_id Timer ID returned by \Swoole\Timer::tick() or \Swoole\Timer::after().
 * @return bool Returns true on success, false on failure or if the timer does not exist.
 * @alias This function is an alias of method \Swoole\Timer::clear().
 * @see \Swoole\Timer::clear()
 */
function swoole_timer_clear(int $timer_id): bool
{
}

/**
 * Clear all timers set in current process.
 *
 * @return bool Returns true on success, false on failure.
 * @alias This function is an alias of method \Swoole\Timer::clearAll().
 * @see \Swoole\Timer::clearAll()
 */
function swoole_timer_clear_all(): bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_close().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @see curl_close()
 * @see https://www.php.net/curl_close
 */
function swoole_native_curl_close(CurlHandle $handle): void
{
}

/**
 * The coroutine version of PHP's cURL function curl_copy_handle().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return CurlHandle|false Returns a new cURL handle, or false on failure.
 * @see curl_copy_handle()
 * @see https://www.php.net/curl_copy_handle
 */
function swoole_native_curl_copy_handle(CurlHandle $handle): CurlHandle|false
{
}

/**
 * The coroutine version of PHP's cURL function curl_errno().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return int Returns the error number of the last cURL operation on the given handle, or 0 (CURLE_OK) if no error happened.
 * @see curl_errno()
 * @see https://www.php.net/curl_errno
 */
function swoole_native_curl_errno(CurlHandle $handle): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_error().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return string Returns the error message of the last cURL operation on the given handle, or an empty string if no error happened.
 * @see curl_error()
 * @see https://www.php.net/curl_error
 */
function swoole_native_curl_error(CurlHandle $handle): string
{
}

/**
 * The coroutine version of PHP's cURL function curl_escape().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param string $string The string to be encoded.
 * @return string|false Returns the URL-encoded string, or false on failure.
 * @see curl_escape()
 * @see https://www.php.net/curl_escape
 */
function swoole_native_curl_escape(CurlHandle $handle, string $string): string|false
{
}

/**
 * The coroutine version of PHP's cURL function curl_exec().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return string|bool Returns true on success, or false on failure. However, when option CURLOPT_RETURNTRANSFER is set on the
 *                     handle, the response is returned as a string instead of true.
 * @see curl_exec()
 * @see https://www.php.net/curl_exec
 */
function swoole_native_curl_exec(CurlHandle $handle): string|bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_getinfo().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param int|null $option A CURLINFO_* constant selecting the piece of information to return. When omitted or null, an
 *                         associative array with all the available pieces of information is returned.
 * @return mixed Returns the requested piece of information (or all of them as an array), or false on failure.
 * @see curl_getinfo()
 * @see https://www.php.net/curl_getinfo
 */
function swoole_native_curl_getinfo(CurlHandle $handle, ?int $option = null): mixed
{
}

/**
 * The coroutine version of PHP's cURL function curl_init().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param string|null $url When given, option CURLOPT_URL is set to this value.
 * @return CurlHandle|false Returns a cURL handle on success, or false on failure.
 * @see curl_init()
 * @see https://www.php.net/curl_init
 */
function swoole_native_curl_init(?string $url = null): CurlHandle|false
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_add_handle().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param CurlHandle $handle The cURL handle to add.
 * @return int Returns 0 (CURLM_OK) on success, or one of the CURLM_* error codes on failure.
 * @see curl_multi_add_handle()
 * @see https://www.php.net/curl_multi_add_handle
 */
function swoole_native_curl_multi_add_handle(CurlMultiHandle $multi_handle, CurlHandle $handle): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_close().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @see curl_multi_close()
 * @see https://www.php.net/curl_multi_close
 */
function swoole_native_curl_multi_close(CurlMultiHandle $multi_handle): void
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_errno().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @return int Returns the error number of the last cURL multi operation on the given handle, or 0 (CURLM_OK) if no
 *             error happened.
 * @see curl_multi_errno()
 * @see https://www.php.net/curl_multi_errno
 */
function swoole_native_curl_multi_errno(CurlMultiHandle $multi_handle): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_exec().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param int $still_running Set to the number of transfers that are still running.
 * @return int Returns 0 (CURLM_OK) on success, or one of the CURLM_* error codes on failure.
 * @see curl_multi_exec()
 * @see https://www.php.net/curl_multi_exec
 */
function swoole_native_curl_multi_exec(CurlMultiHandle $multi_handle, int &$still_running): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_getcontent().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return string|null Returns the content fetched by the handle when option CURLOPT_RETURNTRANSFER is set on it, or
 *                     null otherwise.
 * @see curl_multi_getcontent()
 * @see https://www.php.net/curl_multi_getcontent
 */
function swoole_native_curl_multi_getcontent(CurlHandle $handle): ?string
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_info_read().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * Note: this stub used to declare parameter $queued_messages with a native type, as "?int &$queued_messages = null";
 * the parameter has always been untyped in the Swoole extension itself, matching PHP's own curl_multi_info_read().
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param int|null $queued_messages Set to the number of messages still in the queue.
 * @return array|false Returns an associative array with information about a finished transfer, or false when there is
 *                     no message left.
 * @see curl_multi_info_read()
 * @see https://www.php.net/curl_multi_info_read
 */
function swoole_native_curl_multi_info_read(CurlMultiHandle $multi_handle, &$queued_messages = null): array|false
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_init().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @return CurlMultiHandle Returns a new cURL multi handle.
 * @see curl_multi_init()
 * @see https://www.php.net/curl_multi_init
 */
function swoole_native_curl_multi_init(): CurlMultiHandle
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_remove_handle().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param CurlHandle $handle The cURL handle to remove.
 * @return int Returns 0 (CURLM_OK) on success, or one of the CURLM_* error codes on failure.
 * @see curl_multi_remove_handle()
 * @see https://www.php.net/curl_multi_remove_handle
 */
function swoole_native_curl_multi_remove_handle(CurlMultiHandle $multi_handle, CurlHandle $handle): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_select().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param float $timeout Maximum number of seconds to wait.
 * @return int Returns the number of handles with activity, or -1 on failure.
 * @see curl_multi_select()
 * @see https://www.php.net/curl_multi_select
 */
function swoole_native_curl_multi_select(CurlMultiHandle $multi_handle, float $timeout = 1.0): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_setopt().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlMultiHandle $multi_handle The cURL multi handle.
 * @param int $option A CURLMOPT_* constant selecting the option to set.
 * @param mixed $value The value to set the option to.
 * @return bool Returns true on success, or false on failure.
 * @see curl_multi_setopt()
 * @see https://www.php.net/curl_multi_setopt
 */
function swoole_native_curl_multi_setopt(CurlMultiHandle $multi_handle, int $option, mixed $value): bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_multi_strerror().
 *
 * This function is available only when PHP is 8.4 or above and Swoole is installed with option "--enable-swoole-curl"
 * included. Don't use this function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param int $error_code One of the CURLM_* error codes.
 * @return string|null Returns a text description of the given error code, or null when the error code is unknown.
 * @see curl_multi_strerror()
 * @see https://www.php.net/curl_multi_strerror
 * @since 6.0.0
 */
function swoole_native_curl_multi_strerror(int $error_code): ?string
{
}

/**
 * The coroutine version of PHP's cURL function curl_pause().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param int $flags One of the CURLPAUSE_* constants, telling which directions of the transfer to pause or resume.
 * @return int Returns 0 (CURLE_OK) on success, or one of the CURLE_* error codes on failure.
 * @see curl_pause()
 * @see https://www.php.net/curl_pause
 */
function swoole_native_curl_pause(CurlHandle $handle, int $flags): int
{
}

/**
 * The coroutine version of PHP's cURL function curl_reset().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @see curl_reset()
 * @see https://www.php.net/curl_reset
 */
function swoole_native_curl_reset(CurlHandle $handle): void
{
}

/**
 * The coroutine version of PHP's cURL function curl_setopt_array().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param array $options An array mapping CURLOPT_* constants to the values to set them to.
 * @return bool Returns true if all the options are set successfully, false otherwise.
 * @see curl_setopt_array()
 * @see https://www.php.net/curl_setopt_array
 */
function swoole_native_curl_setopt_array(CurlHandle $handle, array $options): bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_setopt().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param int $option A CURLOPT_* constant selecting the option to set.
 * @param mixed $value The value to set the option to.
 * @return bool Returns true on success, or false on failure.
 * @see curl_setopt()
 * @see https://www.php.net/curl_setopt
 */
function swoole_native_curl_setopt(CurlHandle $handle, int $option, mixed $value): bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_strerror().
 *
 * This function is available only when PHP is 8.4 or above and Swoole is installed with option "--enable-swoole-curl"
 * included. Don't use this function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param int $error_code One of the CURLE_* error codes.
 * @return string|null Returns a text description of the given error code, or null when the error code is unknown.
 * @see curl_strerror()
 * @see https://www.php.net/curl_strerror
 * @since 6.0.0
 */
function swoole_native_curl_strerror(int $error_code): ?string
{
}

/**
 * The coroutine version of PHP's cURL function curl_unescape().
 *
 * This function is available only when Swoole is installed with option "--enable-swoole-curl" included. Don't use this
 * function directly; always use the corresponding PHP's cURL function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @param string $string The URL-encoded string to be decoded.
 * @return string|false Returns the decoded string, or false on failure.
 * @see curl_unescape()
 * @see https://www.php.net/curl_unescape
 */
function swoole_native_curl_unescape(CurlHandle $handle, string $string): string|false
{
}

/**
 * The coroutine version of PHP's cURL function curl_upkeep().
 *
 * This function is available only when PHP is 8.4 or above, Swoole is installed with option "--enable-swoole-curl"
 * included, and libcurl is 7.62.0 or above. Don't use this function directly; always use the corresponding PHP's cURL
 * function instead.
 *
 * @param CurlHandle $handle The cURL handle.
 * @return bool Returns true on success, or false on failure.
 * @see curl_upkeep()
 * @see https://www.php.net/curl_upkeep
 * @since 6.0.0
 */
function swoole_native_curl_upkeep(CurlHandle $handle): bool
{
}

/**
 * The coroutine version of PHP's cURL function curl_version().
 *
 * This function is available only when PHP is 8.4 or above and Swoole is installed with option "--enable-swoole-curl"
 * included. Don't use this function directly; always use the corresponding PHP's cURL function instead.
 *
 * @return array|false Returns an associative array with information about the cURL version in use, or false on failure.
 * @see curl_version()
 * @see https://www.php.net/curl_version
 * @since 6.0.0
 */
function swoole_native_curl_version(): array|false
{
}
