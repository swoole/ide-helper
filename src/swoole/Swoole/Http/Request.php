<?php

declare(strict_types=1);

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

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function rawContent()
    {
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
    }

    /**
     * @return mixed
     */
    public function getData()
    {
    }

    /**
     * @param mixed|null $options
     * @return mixed
     */
    public static function create($options = null)
    {
    }

    /**
     * @param mixed $data
     * @return mixed
     */
    public function parse($data)
    {
    }

    /**
     * @return mixed
     */
    public function isCompleted()
    {
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
    }
}
