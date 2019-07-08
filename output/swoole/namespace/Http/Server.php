<?php

namespace Swoole\Http;

class Server extends \Swoole\Server
{

    private $onRequest = null;

    private $onHandshake = null;


}
