<?php

declare(strict_types=1);

namespace Swoole;

class Runtime
{
    /**
     * To enable/disable runtime hooks in coroutines.
     *
     * For backward-compatible reason, there are four different ways to call this method:
     *   #1. Swoole\Runtime::enableCoroutine();             // Enable runtime hooks represented by constant SWOOLE_HOOK_ALL.
     *   #2. Swoole\Runtime::enableCoroutine($flags);       // Enable specified runtime hooks.
     *   #3. Swoole\Runtime::enableCoroutine(true, $flags); // Enable specified runtime hooks.
     *   #4. Swoole\Runtime::enableCoroutine(false);        // Disable runtime hooks.
     * Following statements are of the same (when used to disable runtime hooks):
     *   Swoole\Runtime::enableCoroutine(0);       // #2
     *   Swoole\Runtime::enableCoroutine(true, 0); // #3
     *   Swoole\Runtime::enableCoroutine(false);   // #4
     *
     * @return bool TRUE on success, or FALSE on failure.
     */
    public static function enableCoroutine(bool|int $enable = SWOOLE_HOOK_ALL, int $flags = SWOOLE_HOOK_ALL): bool
    {
    }

    public static function getHookFlags(): int
    {
    }

    /**
     * @return bool true on success or false on failure
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public static function setHookFlags(int $flags): bool
    {
        if (PHP_SAPI !== 'cli') {
            // An E_ERROR level error will be thrown out here.
            return false;
        }

        return self::enableCoroutine(true, $flags);
    }
}
