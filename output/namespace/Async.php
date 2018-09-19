<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class Async
{


    /**
     * @param $filename [required]
     * @param mixed $callback [required]
     * @param $chunk_size [optional]
     * @param $offset [optional]
     * @return mixed
     */
    public static function read(string $filename, $callback, int $chunk_size=null, int $offset=null){}

    /**
     * @param $filename [required]
     * @param $content [required]
     * @param $offset [optional]
     * @param mixed $callback [optional]
     * @return mixed
     */
    public static function write(string $filename, string $content, int $offset=null, $callback=null){}

    /**
     * @param $filename [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public static function readFile(string $filename, $callback){}

    /**
     * @param $filename [required]
     * @param $content [required]
     * @param mixed $callback [optional]
     * @param $flags [optional]
     * @return mixed
     */
    public static function writeFile(string $filename, string $content, $callback=null, $flags=null){}

    /**
     * @param $hostname [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public static function dnsLookup(string $hostname, $callback){}

    /**
     * @param $domain_name [required]
     * @return mixed
     */
    public static function dnsLookupCoro(string $domain_name){}

    /**
     * @param $settings [required]
     * @return mixed
     */
    public static function set(array $settings){}

    /**
     * @param $command [required]
     * @param mixed $callback [required]
     * @return mixed
     */
    public static function exec(string $command, $callback){}


}
