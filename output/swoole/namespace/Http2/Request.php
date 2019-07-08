<?php

namespace Swoole\Http2;

class Request
{

    public $path = '/';

    public $method = 'GET';

    public $headers = null;

    public $cookies = null;

    public $data = '';

    public $pipeline = false;


}
