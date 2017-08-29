<?php
function swoole_version(){}

function swoole_cpu_num(){}

function swoole_last_error(){}

/**
 * @param $fd[required]
 * @param $read_callback[required]
 * @param $write_callback[optional]
 * @param $events[optional]
 * @return mixed
 */
function swoole_event_add($fd, $read_callback, $write_callback=null, $events=null){}

/**
 * @param $fd[required]
 * @param $read_callback[optional]
 * @param $write_callback[optional]
 * @param $events[optional]
 * @return mixed
 */
function swoole_event_set($fd, $read_callback=null, $write_callback=null, $events=null){}

/**
 * @param $fd[required]
 * @return mixed
 */
function swoole_event_del($fd){}

function swoole_event_exit(){}

function swoole_event_wait(){}

/**
 * @param $fd[required]
 * @param $data[required]
 * @return mixed
 */
function swoole_event_write($fd, $data){}

/**
 * @param $callback[required]
 * @return mixed
 */
function swoole_event_defer($callback){}

/**
 * @param $ms[required]
 * @param $callback[required]
 * @param $param[optional]
 * @return mixed
 */
function swoole_timer_after($ms, $callback, $param=null){}

/**
 * @param $ms[required]
 * @param $callback[required]
 * @return mixed
 */
function swoole_timer_tick($ms, $callback){}

/**
 * @param $timer_id[required]
 * @return mixed
 */
function swoole_timer_exists($timer_id){}

/**
 * @param $timer_id[required]
 * @return mixed
 */
function swoole_timer_clear($timer_id){}

/**
 * @param $settings[required]
 * @return mixed
 */
function swoole_async_set($settings){}

/**
 * @param $filename[required]
 * @param $callback[required]
 * @param $chunk_size[optional]
 * @param $offset[optional]
 * @return mixed
 */
function swoole_async_read($filename, $callback, $chunk_size=null, $offset=null){}

/**
 * @param $filename[required]
 * @param $content[required]
 * @param $offset[optional]
 * @param $callback[optional]
 * @return mixed
 */
function swoole_async_write($filename, $content, $offset=null, $callback=null){}

/**
 * @param $filename[required]
 * @param $callback[required]
 * @return mixed
 */
function swoole_async_readfile($filename, $callback){}

/**
 * @param $filename[required]
 * @param $content[required]
 * @param $callback[optional]
 * @param $flags[optional]
 * @return mixed
 */
function swoole_async_writefile($filename, $content, $callback=null, $flags=null){}

/**
 * @param $domain_name[required]
 * @param $content[required]
 * @return mixed
 */
function swoole_async_dns_lookup($domain_name, $content){}

/**
 * @param $read_array[required]
 * @param $write_array[required]
 * @param $error_array[required]
 * @param $timeout[optional]
 * @return mixed
 */
function swoole_client_select($read_array, $write_array, $error_array, $timeout=null){}

/**
 * @param $read_array[required]
 * @param $write_array[required]
 * @param $error_array[required]
 * @param $timeout[optional]
 * @return mixed
 */
function swoole_select($read_array, $write_array, $error_array, $timeout=null){}

/**
 * @param $process_name[required]
 * @return mixed
 */
function swoole_set_process_name($process_name){}

function swoole_get_local_ip(){}

function swoole_get_local_mac(){}

/**
 * @param $errno[required]
 * @return mixed
 */
function swoole_strerror($errno){}

function swoole_errno(){}

