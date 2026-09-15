<?php

declare(strict_types=1);

namespace Swoole\NameResolver;

/**
 * Instance of this class is only used as value of the second parameter of function \swoole_name_resolver_lookup().
 *
 * @since 5.0.0
 * @not-serializable Objects of this class cannot be serialized.
 * @see \swoole_name_resolver_lookup()
 */
class Context
{
    /**
     * Constructor.
     *
     * @param int $family Address family to resolve names to: AF_INET for IPv4, or AF_INET6 for IPv6.
     * @param bool $withPort Whether a port is allowed to be part of the resolved result (e.g., when the name
     *                       resolver returns an "IP:port" pair instead of just an IP address).
     */
    public function __construct(int $family = AF_INET, bool $withPort = false)
    {
    }
}
