<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class Coroutine
{


    /**
     * @param $func [required]
     * @return mixed
     */
    public static function create($func){}

    /**
     * @param $command [required]
     * @return mixed
     */
    public static function exec(string $command){}

    /**
     * @param $options [required]
     * @return mixed
     */
    public static function set($options){}

    /**
     * @return mixed
     */
    public static function yield(){}

    /**
     * @return mixed
     */
    public static function suspend(){}

    /**
     * @param $uid [required]
     * @return mixed
     */
    public static function resume(int $uid){}

    /**
     * @return mixed
     */
    public static function stats(){}

    /**
     * @return mixed
     */
    public static function getuid(){}

    /**
     * @param $seconds [required]
     * @return mixed
     */
    public static function sleep($seconds){}

    /**
     * @param $handle [required]
     * @param $length [optional]
     * @return mixed
     */
    public static function fread($handle, int $length=null){}

    /**
     * @param $handle [required]
     * @return mixed
     */
    public static function fgets($handle){}

    /**
     * @param $handle [required]
     * @param $string [required]
     * @param $length [optional]
     * @return mixed
     */
    public static function fwrite($handle, $string, int $length=null){}

    /**
     * @param $filename [required]
     * @return mixed
     */
    public static function readFile(string $filename){}

    /**
     * @param $filename [required]
     * @param $data [required]
     * @param $flags [optional]
     * @return mixed
     */
    public static function writeFile(string $filename, $data, $flags=null){}

    /**
     * @param $domain_name [required]
     * @param $family [optional]
     * @return mixed
     */
    public static function gethostbyname(string $domain_name, $family=null){}

    /**
     * @param $hostname [required]
     * @param $family [optional]
     * @param $socktype [optional]
     * @param $protocol [optional]
     * @param $service [optional]
     * @return mixed
     */
    public static function getaddrinfo(string $hostname, $family=null, $socktype=null, $protocol=null, $service=null){}

    /**
     * @param $cid [required]
     * @param $options [optional]
     * @param $limit [optional]
     * @return mixed
     */
    public static function getBackTrace(int $cid, $options=null, int $limit=null){}

    /**
     * @return mixed
     */
    public static function listCoroutines(){}


}
