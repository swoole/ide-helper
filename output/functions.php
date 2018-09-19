<?php
function swoole_version(){}

function swoole_cpu_num(){}

function swoole_last_error(){}

/**
 * @param $fd [required]
 * @param $read_callback [required]
 * @param $write_callback [optional]
 * @param $events [optional]
 * @return mixed
 */
function swoole_event_add(int $fd, $read_callback, $write_callback=null, $events=null){}

/**
 * @param $fd [required]
 * @param $read_callback [optional]
 * @param $write_callback [optional]
 * @param $events [optional]
 * @return mixed
 */
function swoole_event_set(int $fd, $read_callback=null, $write_callback=null, $events=null){}

/**
 * @param $fd [required]
 * @return mixed
 */
function swoole_event_del(int $fd){}

function swoole_event_exit(){}

function swoole_event_wait(){}

/**
 * @param $fd [required]
 * @param $data [required]
 * @return mixed
 */
function swoole_event_write(int $fd, $data){}

/**
 * @param mixed $callback [required]
 * @return mixed
 */
function swoole_event_defer($callback){}

/**
 * @param mixed $callback [required]
 * @param $before [optional]
 * @return mixed
 */
function swoole_event_cycle($callback, $before=null){}

function swoole_event_dispatch(){}

/**
 * @param $fd [required]
 * @param $events [optional]
 * @return mixed
 */
function swoole_event_isset(int $fd, $events=null){}

/**
 * @param $ms [required]
 * @param mixed $callback [required]
 * @param $param [optional]
 * @return mixed
 */
function swoole_timer_after(int $ms, $callback, $param=null){}

/**
 * @param $ms [required]
 * @param mixed $callback [required]
 * @return mixed
 */
function swoole_timer_tick(int $ms, $callback){}

/**
 * @param $timer_id [required]
 * @return mixed
 */
function swoole_timer_exists(int $timer_id){}

/**
 * @param $timer_id [required]
 * @return mixed
 */
function swoole_timer_clear(int $timer_id){}

/**
 * @param $settings [required]
 * @return mixed
 */
function swoole_async_set(array $settings){}

/**
 * @param $filename [required]
 * @param mixed $callback [required]
 * @param $chunk_size [optional]
 * @param $offset [optional]
 * @return mixed
 */
function swoole_async_read(string $filename, $callback, int $chunk_size=null, int $offset=null){}

/**
 * @param $filename [required]
 * @param $content [required]
 * @param $offset [optional]
 * @param mixed $callback [optional]
 * @return mixed
 */
function swoole_async_write(string $filename, string $content, int $offset=null, $callback=null){}

/**
 * @param $filename [required]
 * @param mixed $callback [required]
 * @return mixed
 */
function swoole_async_readfile(string $filename, $callback){}

/**
 * @param $filename [required]
 * @param $content [required]
 * @param mixed $callback [optional]
 * @param $flags [optional]
 * @return mixed
 */
function swoole_async_writefile(string $filename, string $content, $callback=null, $flags=null){}

/**
 * @param $hostname [required]
 * @param mixed $callback [required]
 * @return mixed
 */
function swoole_async_dns_lookup(string $hostname, $callback){}

/**
 * @param $domain_name [required]
 * @return mixed
 */
function swoole_async_dns_lookup_coro(string $domain_name){}

/**
 * @param $func [required]
 * @return mixed
 */
function swoole_coroutine_create($func){}

/**
 * @param $command [required]
 * @return mixed
 */
function swoole_coroutine_exec(string $command){}

/**
 * @param $func [required]
 * @return mixed
 */
function go($func){}

/**
 * @param $read_array [required]
 * @param $write_array [required]
 * @param $error_array [required]
 * @param $timeout [optional]
 * @return mixed
 */
function swoole_client_select(array $read_array, array $write_array, array $error_array, float $timeout=null){}

/**
 * @param $read_array [required]
 * @param $write_array [required]
 * @param $error_array [required]
 * @param $timeout [optional]
 * @return mixed
 */
function swoole_select(array $read_array, array $write_array, array $error_array, float $timeout=null){}

/**
 * @param $process_name [required]
 * @return mixed
 */
function swoole_set_process_name(string $process_name){}

function swoole_get_local_ip(){}

function swoole_get_local_mac(){}

/**
 * @param $errno [required]
 * @param $error_type [optional]
 * @return mixed
 */
function swoole_strerror($errno, $error_type=null){}

function swoole_errno(){}

/**
 * @param $data [required]
 * @param $type [optional]
 * @return mixed
 */
function swoole_hashcode($data, $type=null){}

function swoole_call_user_shutdown_begin(){}

