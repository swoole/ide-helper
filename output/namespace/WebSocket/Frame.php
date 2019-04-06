<?php

namespace Swoole\WebSocket;

class Frame
{

    public $fd = 0;

    public $data = '';

    public $opcode = 1;

    public $finish = true;

    public function __toString()
    {
    }

    public static function pack($data, $opcode = null, $finish = null, $mask = null)
    {
    }

    public static function unpack($data)
    {
    }


}
