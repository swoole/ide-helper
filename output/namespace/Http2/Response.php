<?php

namespace Swoole\Http2;

class Response
{

    public $streamId = 0;

    public $errCode = 0;

    public $statusCode = 0;

    public $pipeline = false;

    public $headers = null;

    public $set_cookie_headers = null;

    public $cookies = null;

    public $data = null;


}
