<?php

namespace Swoole\WebSocket;

class Server extends \Swoole\Http\Server
{

    public function push($fd, $data, $opcode = null, $finish = null)
    {
    }

    public function disconnect($fd, $code = null, $reason = null)
    {
    }

    public function isEstablished($fd)
    {
    }

    public static function pack($data, $opcode = null, $finish = null, $mask = null)
    {
    }

    public static function unpack($data)
    {
    }


}
