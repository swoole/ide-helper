<?php

namespace Swoole\Http;

class Request
{

    public $fd = 0;

    public $streamId = 0;

    public $header;

    public $server;

    public $cookie;

    public $get;

    public $files;

    public $post;

    public $tmpfiles;

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
