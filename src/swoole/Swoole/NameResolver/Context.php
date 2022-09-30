<?php

declare(strict_types=1);

namespace Swoole\NameResolver;

/**
 * @since 5.0.0
 * @not-serializable Objects of this class cannot be serialized.
 */
class Context
{
    public function __construct(int $family = AF_INET, bool $withPort = false)
    {
    }
}
