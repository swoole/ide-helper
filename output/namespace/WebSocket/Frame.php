<?php

namespace Swoole\WebSocket;

class Frame
{

    public $fd = 0;

    public $data = '';

    public $opcode = 1;

    public $finish = true;

    /**
     * @return mixed
     */
    public function __toString()
    {
    }

    /**
     * @return mixed
     */
    public static function pack($data, $opcode = null, $finish = null, $mask = null)
    {
    }

    /**
     * @return mixed
     */
    public static function unpack($data)
    {
    }


}
