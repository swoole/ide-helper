<?php

declare(strict_types=1);

namespace Swoole;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Atomic
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

    public function wait(float $timeout = 1): bool
    {
    }

    public function wakeup(int $count = 1): bool
    {
    }

    public function cmpset(int $cmp_value, int $new_value): bool
    {
    }
}
