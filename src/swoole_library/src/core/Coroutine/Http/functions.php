<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Coroutine\Http;

use Swoole\Coroutine\Http\Client\Exception;

/**
 * @param mixed $data
 * @throws Exception
 * @return mixed
 */
function request(string $url, string $method, $data = null, array $options = null, array $headers = null, array $cookies = null)
{
    $info = parse_url($url);
    if (empty($info['scheme'])) {
        throw new Exception('The URL given is illegal [no scheme]');
    }
    if ($info['scheme'] == 'http') {
        $client = new Client($info['host'], swoole_array_default_value($info, 'port', 80), false);
    } elseif ($info['scheme'] == 'https') {
        $client = new Client($info['host'], swoole_array_default_value($info, 'port', 443), true);
    } else {
        throw new Exception('unknown scheme "' . $info['scheme'] . '"');
    }
    $client->setMethod($method);
    if ($data) {
        $client->setData($data);
    }
    if (is_array($options)) {
        $client->set($options);
    }
    if (is_array($headers)) {
        $client->setHeaders($headers);
    }
    if (is_array($cookies)) {
        $client->setCookies($cookies);
    }
    $request_url = swoole_array_default_value($info, 'path', '/');
    if (!empty($info['query'])) {
        $request_url .= '?' . $info['query'];
    }
    if ($client->execute($request_url)) {
        return $client;
    }
    return false;
}

/**
 * @param mixed $data
 * @throws Exception
 * @return Client|false|mixed
 */
function post(string $url, $data, array $options = null, array $headers = null, array $cookies = null)
{
    return request($url, 'POST', $data, $options, $headers, $cookies);
}

/**
 * @throws Exception
 * @return Client|false|mixed
 */
function get(string $url, array $options = null, array $headers = null, array $cookies = null)
{
    return request($url, 'GET', null, $options, $headers, $cookies);
}
