<?php

declare(strict_types=1);

namespace Swoole;

class Runtime
{
    /**
     * @param int|bool $enable
     * @return bool true on success or false on failure
     */
    public static function enableCoroutine($enable = true, int $flags = SWOOLE_HOOK_ALL)
    {
    }

    /**
     * @return int
     */
    public static function getHookFlags()
    {
    }

    /**
     * @return bool true on success or false on failure
     */
    public static function setHookFlags(int $flags)
    {
    }
}
