<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

define('SWOOLE_LIBRARY', true);

!defined('CURLOPT_HEADEROPT') && define('CURLOPT_HEADEROPT', 229);
!defined('CURLOPT_PROXYHEADER') && define('CURLOPT_PROXYHEADER', 10228);
!defined('CURLOPT_RESOLVE') && define('CURLOPT_RESOLVE', 10203);
!defined('CURLOPT_UNIX_SOCKET_PATH') && define('CURLOPT_UNIX_SOCKET_PATH', 10231);
// Do not define these in the global namespace: native curl clients use their presence for feature detection.
!defined('CURLOPT_PREREQFUNCTION') && define('Swoole\Curl\CURLOPT_PREREQFUNCTION', 20312);
!defined('CURL_PREREQFUNC_OK') && define('Swoole\Curl\CURL_PREREQFUNC_OK', 0);
!defined('CURL_PREREQFUNC_ABORT') && define('Swoole\Curl\CURL_PREREQFUNC_ABORT', 1);
