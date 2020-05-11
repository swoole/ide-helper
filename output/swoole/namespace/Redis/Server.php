<?php

namespace Swoole\Redis;

class Server extends \Swoole\Server
{

    public const NIL = 1;

    public const ERROR = 0;

    public const STATUS = 2;

    public const INT = 3;

    public const STRING = 4;

    public const SET = 5;

    public const MAP = 6;

    /**
     * @return mixed
     */
    public function start()
    {
    }

    /**
     * @return mixed
     */
    public function setHandler($command, callable $callback)
    {
    }

    /**
     * @return mixed
     */
    public function getHandler($command)
    {
    }

    /**
     * @return mixed
     */
    public static function format($type, $value = null)
    {
    }


}
