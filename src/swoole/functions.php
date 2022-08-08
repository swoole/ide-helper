<?php

declare(strict_types=1);

use Swoole\NameResolver;
use Swoole\NameResolver\Context;
use Swoole\timer\Iterator;

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
 * @return mixed
 */
function swoole_last_error()
{
}

/**
 * @param $domain_name[required]
 * @return mixed
 */
function swoole_async_dns_lookup_coro($domain_name, float $timeout = 60, int $type = AF_INET)
{
}

/**
 * @return mixed
 */
function swoole_async_set(array $settings)
{
}

function swoole_coroutine_create(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns.
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

/**
 * @return mixed
 */
function swoole_coroutine_socketpair(int $domain, int $type, int $protocol)
{
}

/**
 * @return mixed
 */
function swoole_test_kernel_coroutine(int $count = 100, float $sleep_time = 1.0)
{
}

/**
 * @return mixed
 */
function swoole_client_select(array &$read_array, array &$write_array, array &$error_array, float $timeout = 0.5)
{
}

/**
 * @return mixed
 */
function swoole_select(array &$read_array, array &$write_array, array &$error_array, float $timeout = 0.5)
{
}

/**
 * @return mixed
 */
function swoole_set_process_name(string $process_name)
{
}

/**
 * @return mixed
 */
function swoole_get_local_ip()
{
}

/**
 * @return mixed
 */
function swoole_get_local_mac()
{
}

/**
 * @param $errno[required]
 * @param $error_type[optional]
 * @return mixed
 */
function swoole_strerror(int $errno, int $error_type = SWOOLE_STRERROR_SYSTEM)
{
}

/**
 * @return mixed
 */
function swoole_errno()
{
}

/**
 * @return mixed
 */
function swoole_clear_error()
{
}

/**
 * @return void
 */
function swoole_error_log(int $level, string $msg)
{
}

/**
 * @return void
 * @since 4.8.1
 */
function swoole_error_log_ex(int $level, int $error, string $msg)
{
}

/**
 * @return void
 * @since 4.8.1
 */
function swoole_ignore_error(int $error)
{
}

/**
 * @return mixed
 */
function swoole_hashcode(string $data, int $type = 0)
{
}

/**
 * @param $suffix[required]
 * @param $mime_type[required]
 * @return mixed
 */
function swoole_mime_type_add($suffix, $mime_type)
{
}

/**
 * @param $suffix[required]
 * @param $mime_type[required]
 * @return mixed
 */
function swoole_mime_type_set($suffix, $mime_type)
{
}

/**
 * @param $suffix[required]
 * @return mixed
 */
function swoole_mime_type_delete($suffix)
{
}

/**
 * @param $filename[required]
 * @return mixed
 */
function swoole_mime_type_get($filename)
{
}

/**
 * @param $filename[required]
 * @return mixed
 */
function swoole_get_mime_type($filename)
{
}

/**
 * @param $filename[required]
 * @return mixed
 */
function swoole_mime_type_exists($filename)
{
}

/**
 * @return mixed
 */
function swoole_mime_type_list()
{
}

/**
 * @return mixed
 */
function swoole_clear_dns_cache()
{
}

/**
 * @return mixed
 */
function swoole_substr_unserialize(string $str, int $offset, int $length, array $options = [])
{
}

/**
 * @return mixed
 */
function swoole_substr_json_decode(string $str, int $offset, int $length, bool $associative = false, int $depth = 512, int $flags = 0)
{
}

/**
 * @return mixed
 */
function swoole_internal_call_user_shutdown_begin()
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
 * This function is an alias of function swoole_coroutine_create(); it's available only when directive
 * "swoole.use_shortname" is not explicitly turned off.
 *
 * @see swoole_coroutine_create()
 */
function go(callable $func, ...$params): int|false
{
}

/**
 * Defers the execution of a callback function until the surrounding function of a coroutine returns.
 *
 * This function is an alias of function swoole_coroutine_defer(); it's available only when directive
 * "swoole.use_shortname" is not explicitly turned off.
 *
 * @see swoole_coroutine_defer()
 *
 * @example
 * <pre>
 * go(function () {      // The surrounding function of a coroutine.
 *   echo '1';
 *   defer(function () { // The callback function to be deferred.
 *     echo '3';
 *   });
 *   echo '2';
 * });
 * <pre>
 */
function defer(callable $callback): void
{
}

/**
 * This function is an alias of method \Swoole\Event::add().
 *
 * @see \Swoole\Event::add()
 */
function swoole_event_add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::del().
 *
 * @see \Swoole\Event::del()
 */
function swoole_event_del(mixed $fd): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::set().
 *
 * @see \Swoole\Event::set()
 */
function swoole_event_set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::isset().
 *
 * @see \Swoole\Event::isset()
 */
function swoole_event_isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::dispatch().
 *
 * @see \Swoole\Event::dispatch()
 */
function swoole_event_dispatch(): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::defer().
 *
 * @return true
 * @see \Swoole\Event::defer()
 */
function swoole_event_defer(callable $callback)
{
}

/**
 * This function is an alias of method \Swoole\Event::cycle().
 *
 * @see \Swoole\Event::cycle()
 */
function swoole_event_cycle(?callable $callback, bool $before = false): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::write().
 *
 * @see \Swoole\Event::write()
 */
function swoole_event_write(mixed $fd, string $data): bool
{
}

/**
 * This function is an alias of method \Swoole\Event::wait().
 *
 * @see \Swoole\Event::wait()
 */
function swoole_event_wait(): void
{
}

/**
 * This function is an alias of method \Swoole\Event::exit().
 *
 * @see \Swoole\Event::exit()
 */
function swoole_event_exit(): void
{
}

/**
 * This function is an alias of method \Swoole\Timer::set().
 *
 * @see \Swoole\Timer::set()
 */
function swoole_timer_set(array $settings): void
{
}

/**
 * This function is an alias of method \Swoole\Timer::after().
 *
 * @see \Swoole\Timer::after()
 */
function swoole_timer_after(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * This function is an alias of method \Swoole\Timer::tick().
 *
 * @see \Swoole\Timer::tick()
 */
function swoole_timer_tick(int $ms, callable $callback, ...$params): int|false
{
}

/**
 * This function is an alias of method \Swoole\Timer::exists().
 *
 * @see \Swoole\Timer::exists()
 */
function swoole_timer_exists(int $timer_id): bool
{
}

/**
 * This function is an alias of method \Swoole\Timer::info().
 *
 * @see \Swoole\Timer::info()
 */
function swoole_timer_info(int $timer_id): ?array
{
}

/**
 * This function is an alias of method \Swoole\Timer::stats().
 *
 * @return array
 * @see \Swoole\Timer::stats()
 */
function swoole_timer_stats(): array
{
}

/**
 * This function is an alias of method \Swoole\Timer::list().
 *
 * @see \Swoole\Timer::list()
 */
function swoole_timer_list(): Iterator
{
}

/**
 * This function is an alias of method \Swoole\Timer::clear().
 *
 * @see \Swoole\Timer::clear()
 */
function swoole_timer_clear(int $timer_id): bool
{
}

/**
 * This function is an alias of method \Swoole\Timer::clearAll().
 *
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
