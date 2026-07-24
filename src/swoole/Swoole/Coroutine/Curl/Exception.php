<?php

declare(strict_types=1);

namespace Swoole\Coroutine\Curl;

/**
 * The exception class for runtime hook flag SWOOLE_HOOK_NATIVE_CURL.
 *
 * If runtime hook flag SWOOLE_HOOK_NATIVE_CURL is enabled and some error happens when calling PHP's curl functions, an
 * exception of this class could be thrown out.
 *
 * This class is defined only when option "--enable-swoole-curl" is included during installation. As of Swoole 6.0.2,
 * the class is registered but not yet thrown anywhere by Swoole.
 *
 * @alias This class has an alias of "\Co\Coroutine\Curl\Exception" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Coroutine\Curl\Exception
 * @since 4.6.0
 */
class Exception extends \Swoole\Exception
{
}
