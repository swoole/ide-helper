<?php

declare(strict_types=1);

namespace Swoole;

class ExitException extends Exception
{
    private $flags = 0;

    private $status = 0;

    public function getFlags(): int
    {
    }

    public function getStatus(): int
    {
    }
}
