<?php

declare(strict_types=1);

namespace Swoole;

class Thread
{
    public int $id;

    public function __construct(string $script_file, mixed ...$args)
    {
    }

    public function join(): bool
    {
    }

    public function joinable(): bool
    {
    }

    public function getExitStatus(): int
    {
    }

    public function detach(): bool
    {
    }

    public static function getArguments(): ?array
    {
    }

    public static function getId(): int
    {
    }

    public static function getInfo(): array
    {
    }

    public static function setName(string $name): bool
    {
    }

    public static function setAffinity(array $cpu_settings): bool
    {
    }

    public static function getAffinity(): array
    {
    }

    public function setPriority(int $priority, int $policy = 0): bool
    {
    }

    public function getPriority(): array
    {
    }

    public function getNativeId(): int
    {
    }
}
