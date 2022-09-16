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
 * @alias This function has an alias method \Swoole\Server::getLastError().
 * @see \Swoole\Server::getLastError()
 */
function swoole_last_error(): int
{
}

function swoole_async_dns_lookup_coro(mixed $domain_name, float $timeout = 60, int $type = AF_INET): string|false
{
}

function swoole_async_set(array $settings): void
{
}

/**
 * @alias This function has an alias function \go() and an alias method \Swoole\Coroutine::create().
 * @see \go()
 * @see \Swoole\Coroutine::create()
 */
function swoole_coroutine_create(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns.
 *
 * @alias This function has an alias function \defer() and an alias method \Swoole\Coroutine::defer().
 * @see \defer()
 * @see \Swoole\Coroutine::defer()
 *
 * @example
 * <pre>
 * swoole_coroutine_create(function () {  // The surrounding function of a coroutine.
 *   echo '1';
 *   swoole_coroutine_defer(function () { // The callback function to be deferred.
 *     echo '3';
 *   });
 *   echo '2';
 * });
 * <pre>
 */
function swoole_coroutine_defer(callable $callback): void
{
}

function swoole_coroutine_socketpair(int $domain, int $type, int $protocol): array|false
{
}

function swoole_test_kernel_coroutine(int $count = 100, float $sleep_time = 1.0): void
{
}

/**
 * @alias This function has an alias function swoole_select().
 * @see swoole_select()
 */
function swoole_client_select(array &$read_array, array &$write_array, array &$error_array, float $timeout = 0.5): int|false
{
}

/**
 * @alias This function is an alias of function swoole_client_select().
 * @see swoole_client_select()
 */
function swoole_select(array &$read_array, array &$write_array, array &$error_array, float $timeout = 0.5): int|false
{
}

/**
 * @alias This function has an alias method \Swoole\Process::name().
 * @see \Swoole\Process::name()
 */
function swoole_set_process_name(string $process_name): bool
{
}

function swoole_get_local_ip(): array
{
}

function swoole_get_local_mac(): array
{
}

function swoole_strerror(int $errno, int $error_type = SWOOLE_STRERROR_SYSTEM): string
{
}

function swoole_errno(): int
{
}

function swoole_clear_error(): void
{
}

function swoole_error_log(int $level, string $msg): void
{
}

/**
 * @since 4.8.1
 */
function swoole_error_log_ex(int $level, int $error, string $msg): void
{
}

/**
 * @since 4.8.1
 */
function swoole_ignore_error(int $error): void
{
}

function swoole_hashcode(string $data, int $type = 0): int|false
{
}

function swoole_mime_type_add(string $suffix, string $mime_type): bool
{
}

function swoole_mime_type_set(string $suffix, string $mime_type): void
{
}

function swoole_mime_type_delete(string $suffix): bool
{
}

/**
 * @alias This function has an alias function swoole_get_mime_type().
 * @see swoole_get_mime_type()
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

function swoole_mime_type_exists(string $filename): bool
{
}

function swoole_mime_type_list(): array
{
}

function swoole_clear_dns_cache(): void
{
}

function swoole_substr_unserialize(string $str, int $offset, int $length, array $options = []): mixed
{
}

function swoole_substr_json_decode(string $str, int $offset, int $length, bool $associative = false, int $depth = 512, int $flags = 0): mixed
{
}

function swoole_internal_call_user_shutdown_begin(): bool
{
}

/**
 * Get all PHP objects of current call stack.
 *
 * @return array|false Return an array of objects back; return FALSE when no objects exist or when error happens.
 * @since 4.8.1
 */
function swoole_get_objects()
{
}

/**
 * Get status information of current call stack.
 *
 * @return array The array contains two fields: "object_num" (# of objects) and "resource_num" (# of resources).
 * @since 4.8.1
 */
function swoole_get_vm_status()
{
}

/**
 * @return array|false Return the specified object back; return FALSE when no object found or when error happens.
 * @since 4.8.1
 */
function swoole_get_object_by_handle(int $handle)
{
}

function swoole_name_resolver_lookup(string $name, Context $ctx): string
{
}

function swoole_name_resolver_add(NameResolver $ns): bool
{
}

function swoole_name_resolver_remove(NameResolver $ns): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::add().
 * @see \Swoole\Event::add()
 */
function swoole_event_add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::del().
 * @see \Swoole\Event::del()
 */
function swoole_event_del(mixed $fd): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::set().
 * @see \Swoole\Event::set()
 */
function swoole_event_set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::isset().
 * @see \Swoole\Event::isset()
 */
function swoole_event_isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::dispatch().
 * @see \Swoole\Event::dispatch()
 */
function swoole_event_dispatch(): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::defer().
 * @see \Swoole\Event::defer()
 * @return true
 */
function swoole_event_defer(callable $callback)
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::cycle().
 * @see \Swoole\Event::cycle()
 */
function swoole_event_cycle(?callable $callback, bool $before = false): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::write().
 * @see \Swoole\Event::write()
 */
function swoole_event_write(mixed $fd, string $data): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::wait().
 * @see \Swoole\Event::wait()
 */
function swoole_event_wait(): void
{
}

/**
 * @alias This function is an alias of method \Swoole\Event::exit().
 * @see \Swoole\Event::exit()
 */
function swoole_event_exit(): void
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::set().
 * @see \Swoole\Timer::set()
 * @deprecated 4.6.0
 */
function swoole_timer_set(array $settings): void
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::after().
 * @see \Swoole\Timer::after()
 */
function swoole_timer_after(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::tick().
 * @see \Swoole\Timer::tick()
 */
function swoole_timer_tick(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::exists().
 * @see \Swoole\Timer::exists()
 */
function swoole_timer_exists(int $timer_id): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::info().
 * @see \Swoole\Timer::info()
 */
function swoole_timer_info(int $timer_id): ?array
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::stats().
 * @see \Swoole\Timer::stats()
 */
function swoole_timer_stats(): array
{
}

/**
 * Get a list of timer IDs of all the timers set in current worker process.
 *
 * @alias This function is an alias of method \Swoole\Timer::list().
 * @see \Swoole\Timer::list()
 *
 * @example
 * <pre>
 * foreach (swoole_timer_list() as $timerId) {
 *   var_dump(swoole_timer_info($timerId));
 * };
 * <pre>
 */
function swoole_timer_list(): Iterator
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::clear().
 * @see \Swoole\Timer::clear()
 */
function swoole_timer_clear(int $timer_id): bool
{
}

/**
 * @alias This function is an alias of method \Swoole\Timer::clearAll().
 * @see \Swoole\Timer::clearAll()
 */
function swoole_timer_clear_all(): bool
{
}

/**
 * @param $port[required]
 * @param $backlog[optional]
 * @return mixed
 */
function swoole_native_socket_create_listen($port, $backlog = 128)
{
}

/**
 * @param $socket[required]
 * @return mixed
 */
function swoole_native_socket_accept($socket)
{
}

/**
 * @param $socket[required]
 * @return mixed
 */
function swoole_native_socket_set_nonblock($socket)
{
}

/**
 * @param $socket[required]
 * @return mixed
 */
function swoole_native_socket_set_block($socket)
{
}

/**
 * @param $socket[required]
 * @param $backlog[optional]
 * @return mixed
 */
function swoole_native_socket_listen($socket, $backlog)
{
}

/**
 * @param $socket[required]
 * @return mixed
 */
function swoole_native_socket_close($socket)
{
}

/**
 * @param $socket[required]
 * @param $data[required]
 * @param $length[optional]
 * @return mixed
 */
function swoole_native_socket_write($socket, $data, $length = null)
{
}

/**
 * @param $socket[required]
 * @param $length[required]
 * @param $mode[optional]
 * @return mixed
 */
function swoole_native_socket_read($socket, $length, $mode = 2)
{
}

/**
 * @param $socket[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_getsockname($socket, &$address, &$port = null)
{
}

/**
 * @param $socket[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_getpeername($socket, &$address, &$port = null)
{
}

/**
 * @param $domain[required]
 * @param $type[required]
 * @param $protocol[required]
 * @return mixed
 */
function swoole_native_socket_create($domain, $type, $protocol)
{
}

/**
 * @param $socket[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_connect($socket, $address, $port = null)
{
}

/**
 * @param $error_code[required]
 * @return mixed
 */
function swoole_native_socket_strerror($error_code)
{
}

/**
 * @param $socket[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_bind($socket, $address, $port)
{
}

/**
 * @param $socket[required]
 * @param $data[required]
 * @param $length[required]
 * @param $flags[required]
 * @return mixed
 */
function swoole_native_socket_recv($socket, &$data, $length, $flags)
{
}

/**
 * @param $socket[required]
 * @param $data[required]
 * @param $length[required]
 * @param $flags[required]
 * @return mixed
 */
function swoole_native_socket_send($socket, $data, $length, $flags)
{
}

/**
 * @param $socket[required]
 * @param $data[required]
 * @param $length[required]
 * @param $flags[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_recvfrom($socket, &$data, $length, $flags, &$address, &$port = null)
{
}

/**
 * @param $socket[required]
 * @param $data[required]
 * @param $length[required]
 * @param $flags[required]
 * @param $address[required]
 * @param $port[optional]
 * @return mixed
 */
function swoole_native_socket_sendto($socket, $data, $length, $flags, $address, $port = null)
{
}

/**
 * @param $socket[required]
 * @param $level[required]
 * @param $option[required]
 * @return mixed
 */
function swoole_native_socket_get_option($socket, $level, $option)
{
}

/**
 * @param $socket[required]
 * @param $level[required]
 * @param $option[required]
 * @param $value[required]
 * @return mixed
 */
function swoole_native_socket_set_option($socket, $level, $option, $value)
{
}

/**
 * @param $socket[required]
 * @param $level[required]
 * @param $option[required]
 * @return mixed
 */
function swoole_native_socket_getopt($socket, $level, $option)
{
}

/**
 * @param $socket[required]
 * @param $level[required]
 * @param $option[required]
 * @param $value[required]
 * @return mixed
 */
function swoole_native_socket_setopt($socket, $level, $option, $value)
{
}

/**
 * @param $socket[required]
 * @param $mode[optional]
 * @return mixed
 */
function swoole_native_socket_shutdown($socket, $mode = 2)
{
}

/**
 * @param $socket[optional]
 * @return mixed
 */
function swoole_native_socket_last_error($socket = null)
{
}

/**
 * @param $socket[optional]
 * @return mixed
 */
function swoole_native_socket_clear_error($socket = null)
{
}

/**
 * @param $stream[required]
 * @return mixed
 */
function swoole_native_socket_import_stream($stream)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_close($handle)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_copy_handle($handle)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_errno($handle)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_error($handle)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_exec($handle)
{
}

/**
 * @param $handle[required]
 * @param $option[optional]
 * @return mixed
 */
function swoole_native_curl_getinfo($handle, $option = null)
{
}

/**
 * @param $url[optional]
 * @return mixed
 */
function swoole_native_curl_init($url = null)
{
}

/**
 * @param $handle[required]
 * @param $option[required]
 * @param $value[required]
 * @return mixed
 */
function swoole_native_curl_setopt($handle, $option, $value)
{
}

/**
 * @param $handle[required]
 * @param $options[required]
 * @return mixed
 */
function swoole_native_curl_setopt_array($handle, $options)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_reset($handle)
{
}

/**
 * @param $handle[required]
 * @param $string[required]
 * @return mixed
 */
function swoole_native_curl_escape($handle, $string)
{
}

/**
 * @param $handle[required]
 * @param $string[required]
 * @return mixed
 */
function swoole_native_curl_unescape($handle, $string)
{
}

/**
 * @param $handle[required]
 * @param $flags[required]
 * @return mixed
 */
function swoole_native_curl_pause($handle, $flags)
{
}

/**
 * @param $multi_handle[required]
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_multi_add_handle($multi_handle, $handle)
{
}

/**
 * @param $multi_handle[required]
 * @return mixed
 */
function swoole_native_curl_multi_close($multi_handle)
{
}

/**
 * @param $multi_handle[required]
 * @return mixed
 */
function swoole_native_curl_multi_errno($multi_handle)
{
}

/**
 * @param $multi_handle[required]
 * @param $still_running[required]
 * @return mixed
 */
function swoole_native_curl_multi_exec($multi_handle, &$still_running)
{
}

/**
 * @param $multi_handle[required]
 * @param $timeout[optional]
 * @return mixed
 */
function swoole_native_curl_multi_select($multi_handle, $timeout = 1.0)
{
}

/**
 * @param $multi_handle[required]
 * @param $option[required]
 * @param $value[required]
 * @return mixed
 */
function swoole_native_curl_multi_setopt($multi_handle, $option, $value)
{
}

/**
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_multi_getcontent($handle)
{
}

/**
 * @param $multi_handle[required]
 * @param $queued_messages[optional]
 * @return mixed
 */
function swoole_native_curl_multi_info_read($multi_handle, &$queued_messages = null)
{
}

/**
 * @return mixed
 */
function swoole_native_curl_multi_init()
{
}

/**
 * @param $multi_handle[required]
 * @param $handle[required]
 * @return mixed
 */
function swoole_native_curl_multi_remove_handle($multi_handle, $handle)
{
}
