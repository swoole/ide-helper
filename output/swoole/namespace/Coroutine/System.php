<?php

namespace Swoole\Coroutine;

class System
{

    /**
     * @return mixed
     */
    public static function gethostbyname($domain_name, $family = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function dnsLookup($domain_name, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function exec($command, $get_error_stream = null)
    {
    }

    /**
     * @return mixed
     */
    public static function sleep($seconds)
    {
    }

    /**
     * @return mixed
     */
    public static function getaddrinfo($hostname, $family = null, $socktype = null, $protocol = null, $service = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function statvfs($path)
    {
    }

    /**
     * @return mixed
     */
    public static function readFile($filename)
    {
    }

    /**
     * @return mixed
     */
    public static function writeFile($filename, $data, $flags = null)
    {
    }

    /**
     * @return mixed
     */
    public static function wait($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function waitPid($pid, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function waitSignal($signo, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function waitEvent($fd, $events = null, $timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public static function fread($handle, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public static function fwrite($handle, $string, $length = null)
    {
    }

    /**
     * @return mixed
     */
    public static function fgets($handle)
    {
    }


}
