<?php

declare(strict_types=1);

namespace Swoole\Http;

class Cookie
{
    public function __construct(bool $encode = true)
    {
    }

    public function withName(string $name): Cookie
    {
    }

    public function withValue(string $value = ''): Cookie
    {
    }

    public function withExpires(int $expires = 0): Cookie
    {
    }

    public function withPath(string $path = '/'): Cookie
    {
    }

    public function withDomain(string $domain = ''): Cookie
    {
    }

    public function withSecure(bool $secure = false): Cookie
    {
    }

    public function withHttpOnly(bool $httpOnly = false): Cookie
    {
    }

    public function withSameSite(string $sameSite = ''): Cookie
    {
    }

    public function withPriority(string $priority = ''): Cookie
    {
    }

    public function withPartitioned(bool $partitioned = false): Cookie
    {
    }

    public function toString(): string|false
    {
    }

    public function toArray(): array
    {
    }

    public function reset(): void
    {
    }
}
