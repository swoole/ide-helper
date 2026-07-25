<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

/* @noinspection PhpComposerExtensionStubsInspection */

declare(strict_types=1);

function swoole_curl_init(string $url = ''): Swoole\Curl\Handler
{
    return new Swoole\Curl\Handler($url);
}

function swoole_curl_setopt(Swoole\Curl\Handler $obj, int $opt, $value): bool
{
    return $obj->setOpt($opt, $value);
}

function swoole_curl_setopt_array(Swoole\Curl\Handler $obj, $array): bool
{
    foreach ($array as $k => $v) {
        if ($obj->setOpt($k, $v) !== true) {
            return false;
        }
    }
    return true;
}

function swoole_curl_exec(Swoole\Curl\Handler $obj)
{
    return $obj->exec();
}

function swoole_curl_getinfo(Swoole\Curl\Handler $obj, int $opt = 0)
{
    $info = $obj->getInfo();
    if (is_array($info) and $opt) {
        return match ($opt) {
            CURLINFO_EFFECTIVE_URL      => $info['url'],
            CURLINFO_HTTP_CODE          => $info['http_code'],
            CURLINFO_CONTENT_TYPE       => $info['content_type'],
            CURLINFO_REDIRECT_COUNT     => $info['redirect_count'],
            CURLINFO_REDIRECT_URL       => $info['redirect_url'],
            CURLINFO_TOTAL_TIME         => $info['total_time'],
            CURLINFO_STARTTRANSFER_TIME => $info['starttransfer_time'],
            CURLINFO_SIZE_DOWNLOAD      => $info['size_download'],
            CURLINFO_SPEED_DOWNLOAD     => $info['speed_download'],
            CURLINFO_REDIRECT_TIME      => $info['redirect_time'],
            CURLINFO_HEADER_SIZE        => $info['header_size'],
            CURLINFO_PRIMARY_IP         => $info['primary_ip'],
            CURLINFO_PRIVATE            => $info['private'],
            default                     => null,
        };
    }
    return $info;
}

function swoole_curl_errno(Swoole\Curl\Handler $obj): int
{
    return $obj->errno();
}

function swoole_curl_error(Swoole\Curl\Handler $obj): string
{
    return $obj->error();
}

function swoole_curl_reset(Swoole\Curl\Handler $obj)
{
    return $obj->reset();
}

function swoole_curl_close(Swoole\Curl\Handler $obj): void
{
    $obj->close();
}

function swoole_curl_multi_getcontent(Swoole\Curl\Handler $obj)
{
    return $obj->getContent();
}
