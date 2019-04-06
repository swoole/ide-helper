<?php

namespace Swoole;

class Coroutine
{

    public static function create(callable $func, ... $params)
    {
    }

    public static function exec($command, $get_error_stream = null)
    {
    }

    public static function gethostbyname($domain_name, $family = null, $timeout = null)
    {
    }

    public static function defer($callback)
    {
    }

    public static function set($options)
    {
    }

    public static function exists($cid)
    {
    }

    public static function yield()
    {
    }

    public static function suspend()
    {
    }

    public static function resume($cid)
    {
    }

    public static function stats()
    {
    }

    public static function getCid()
    {
    }

    public static function getuid()
    {
    }

    public static function getPcid()
    {
    }

    public static function getContext($cid = null)
    {
    }

    public static function sleep($seconds)
    {
    }

    public static function fread($handle, $length = null)
    {
    }

    public static function fgets($handle)
    {
    }

    public static function fwrite($handle, $string, $length = null)
    {
    }

    public static function readFile($filename)
    {
    }

    public static function writeFile($filename, $data, $flags = null)
    {
    }

    public static function getaddrinfo($hostname, $family = null, $socktype = null, $protocol = null, $service = null)
    {
    }

    public static function statvfs($path)
    {
    }

    public static function getBackTrace($cid = null, $options = null, $limit = null)
    {
    }

    public static function list()
    {
    }

    public static function listCoroutines()
    {
    }


}
