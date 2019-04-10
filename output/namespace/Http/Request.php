<?php

namespace Swoole\Http;

class Request
{

    public $fd = 0;

    public $streamId = 0;

    public $header = null;

    public $server = null;

    public $request = null;

    public $cookie = null;

    public $get = null;

    public $files = null;

    public $post = null;

    public $tmpfiles = null;

    /**
     * @return mixed
     */
    public function rawContent()
    {
    }

    /**
     * @return mixed
     */
    public function getData()
    {
    }

    public function __destruct()
    {
    }


}
