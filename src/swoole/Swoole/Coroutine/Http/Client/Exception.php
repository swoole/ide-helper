<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Http\Client;

/**
 * Thrown by the constructor of \Swoole\Coroutine\Http\Client when it is given an invalid configuration, e.g. an empty
 * host, or (before Swoole 6.2.0, when OpenSSL support was still optional) an "https://" target while Swoole was
 * compiled without OpenSSL support. The helper functions in namespace Swoole\Coroutine\Http (e.g.
 * \Swoole\Coroutine\Http\request()) throw it as well when given an illegal URL or an unsupported scheme.
 *
 * @alias This class has an alias of "\Co\Http\Client\Exception" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Swoole\Coroutine\Http\Client
 * @see \Co\Http\Client\Exception
 * @since 4.5.8
 */
class Exception extends \Swoole\Exception
{
}
