<?php

declare(strict_types=1);

namespace Swoole\Client;

/**
 * The exception class reserved for the synchronous client \Swoole\Client.
 *
 * As of Swoole 6.2.2, this class is registered but not thrown anywhere by Swoole: errors in \Swoole\Client are
 * reported through PHP warnings and the client's $errCode property instead.
 *
 * @see \Swoole\Client
 * @see \Swoole\Client::$errCode
 */
class Exception extends \Swoole\Exception
{
}
