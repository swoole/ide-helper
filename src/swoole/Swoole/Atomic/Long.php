<?php

declare(strict_types=1);

namespace Swoole\Atomic;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Long
{
    public function __construct(int $value = 0)
    {
    }

    public function add(int $add_value = 1): int
    {
    }

    public function sub(int $sub_value = 1): int
    {
    }

    public function get(): int
    {
    }

    public function set(int $value): void
    {
    }

    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
