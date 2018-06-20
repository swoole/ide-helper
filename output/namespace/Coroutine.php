<?php
namespace Swoole;

/**
 * @since 4.0.1
 */
class Coroutine
{


    /**
     * @param $func[required]
     * @return mixed
     */
    public static function create($func){}

    /**
     * @param $command[required]
     * @return mixed
     */
    public static function exec($command){}

    /**
     * @param $options[required]
     * @return mixed
     */
    public static function set($options){}

    /**
     * @return mixed
     */
    public static function suspend(){}

    /**
     * @param $uid[required]
     * @return mixed
     */
    public static function resume($uid){}

    /**
     * @return mixed
     */
    public static function stats(){}

    /**
     * @return mixed
     */
    public static function getuid(){}

    /**
     * @param $seconds[required]
     * @return mixed
     */
    public static function sleep($seconds){}

    /**
     * @param $handle[required]
     * @param $length[optional]
     * @return mixed
     */
    public static function fread($handle, $length=null){}

    /**
     * @param $handle[required]
     * @return mixed
     */
    public static function fgets($handle){}

    /**
     * @param $handle[required]
     * @param $string[required]
     * @param $length[optional]
     * @return mixed
     */
    public static function fwrite($handle, $string, $length=null){}

    /**
     * @param $filename[required]
     * @return mixed
     */
    public static function readFile($filename){}

    /**
     * @param $filename[required]
     * @param $data[required]
     * @param $flags[optional]
     * @return mixed
     */
    public static function writeFile($filename, $data, $flags=null){}

    /**
     * @param $domain_name[required]
     * @param $family[optional]
     * @return mixed
     */
    public static function gethostbyname($domain_name, $family=null){}

    /**
     * @param $hostname[required]
     * @param $family[optional]
     * @param $socktype[optional]
     * @param $protocol[optional]
     * @param $service[optional]
     * @return mixed
     */
    public static function getaddrinfo($hostname, $family=null, $socktype=null, $protocol=null, $service=null){}


}
