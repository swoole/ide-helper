<?php

/**
 * @param $filename[required]
 * @param $callback[required]
 * @param $chunk_size[optional]
 * @param $offset[optional]
 * @return mixed
 */
function swoole_async_read($filename, $callback, $chunk_size = null, $offset = null){}

/**
 * @param $filename[required]
 * @param $content[required]
 * @param $offset[optional]
 * @param $callback[optional]
 * @return mixed
 */
function swoole_async_write($filename, $content, $offset = null, $callback = null){}

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
function swoole_async_writefile($filename, $content, $callback = null, $flags = null){}

/**
 * @param $hostname[required]
 * @param $callback[required]
 * @return mixed
 */
function swoole_async_dns_lookup($hostname, $callback){}

