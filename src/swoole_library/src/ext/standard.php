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

use Swoole\Coroutine\System;

function swoole_gethostbynamel(string $domain)
{
    return System::getaddrinfo($domain);
}

function swoole_mail(string $to, string $subject, string $message, array $headers = []): bool
{
    $client = swoole_get_default_remote_object_client();
    return $client->call('mail', $to, $subject, $message, $headers);
}

function swoole_checkdnsrr(string $hostname, string $type = 'MX'): bool
{
    $client = swoole_get_default_remote_object_client();
    return $client->call('checkdnsrr', ...func_get_args());
}

function swoole_dns_check_record(string $hostname, string $type = 'MX'): bool
{
    return swoole_checkdnsrr($hostname, $type);
}

function swoole_real_getmxrr(string $hostname, ?array $hosts = null, ?array $weights = null): array
{
    if (func_num_args() === 2) {
        $result['result'] = getmxrr($hostname, $hosts);
        $result['host']   = $hosts;
    } else {
        $result['result'] = getmxrr($hostname, $hosts, $weights);
        $result['host']   = $hosts;
        $result['weight'] = $weights;
    }
    return $result;
}

function swoole_getmxrr(string $hostname, array &$hosts, ?array &$weights = null): bool
{
    $client   = swoole_get_default_remote_object_client();
    $_hosts   = $hosts;
    $_weights = $weights === null ? null : $weights;
    $result   = $client->call('swoole_real_getmxrr', $hostname, $_hosts, $_weights);
    $hosts    = $result['host'];
    $weights  = $result['weight'];
    return $result['result'];
}

function swoole_dns_get_mx(string $hostname, array &$hosts, ?array &$weights = null): bool
{
    return swoole_getmxrr($hostname, $hosts, $weights);
}

function swoole_real_dns_get_record(string $hostname, int $type, ?array $authoritative_name_servers = null, ?array $additional_records = null, bool $raw = false): array
{
    if ($authoritative_name_servers === null && $additional_records === null) {
        $result['result'] = dns_get_record($hostname, $type);
    } elseif ($additional_records === null) {
        $result['result'] = dns_get_record($hostname, $type, $authoritative_name_servers);
    } else {
        $result['result'] = dns_get_record($hostname, $type, $authoritative_name_servers, $additional_records);
    }
    $result['authoritative_name_servers'] = $authoritative_name_servers;
    $result['additional_records']         = $additional_records;
    return $result;
}

function swoole_dns_get_record(string $hostname,
    int $type = DNS_ANY,
    ?array &$authoritative_name_servers = null,
    ?array &$additional_records = null,
    bool $raw = false): array|false
{
    $client                     = swoole_get_default_remote_object_client();
    $result                     = $client->call('swoole_real_dns_get_record', $hostname, $type, $authoritative_name_servers, $additional_records, $raw);
    $authoritative_name_servers = $result['authoritative_name_servers'];
    $additional_records         = $result['additional_records'];
    return $result['result'];
}

function swoole_gethostbyaddr(string $ip): string
{
    $client = swoole_get_default_remote_object_client();
    return $client->call('gethostbyaddr', $ip);
}
