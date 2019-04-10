<?php

namespace Swoole\Redis;

class Server extends \Swoole\Server
{

    const NIL = 1;

    const ERROR = 0;

    const STATUS = 2;

    const INT = 3;

    const STRING = 4;

    const SET = 5;

    const MAP = 6;

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
