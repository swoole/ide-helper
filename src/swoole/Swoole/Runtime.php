<?php

declare(strict_types=1);

namespace Swoole;

class Runtime
{
    /**
     * To enable/disable runtime hooks in coroutines.
     *
     * Before Swoole v6.0.0, this method accepts different types of parameters to enable or disable runtime hooks.
     *
     * @param int $flags Enable given runtime hooks, or disable all hooks if 0 is passed.
     * @return bool TRUE on success, or FALSE on failure.
     * @pseudocode-included This is a built-in method in Swoole. The PHP code included inside this method is for explanation purpose only.
     */
    public static function enableCoroutine(int $flags = SWOOLE_HOOK_ALL): bool
    {
        return self::setHookFlags($flags);
    }

    /**
     * Get current runtime hook flags.
     */
    public static function getHookFlags(): int
    {
    }

    /**
     * Set runtime hook flags. This overrides any flags set previously.
     *
     * Here are some examples of setting runtime hook flags:
     * - setHookFlags(SWOOLE_HOOK_TCP): Enable TCP hook only.
     * - setHookFlags(SWOOLE_HOOK_TCP | SWOOLE_HOOK_UDP | SWOOLE_HOOK_SOCKETS): Enable TCP, UDP and socket hooks.
     * - setHookFlags(SWOOLE_HOOK_ALL): Enable all runtime hooks.
     * - setHookFlags(SWOOLE_HOOK_ALL ^ SWOOLE_HOOK_FILE ^ SWOOLE_HOOK_STDIO): Enable all runtime hooks except file and stdio hooks.
     * - setHookFlags(0): Disable runtime hooks.
     *
     * @param int $flags Enable given runtime hooks, or disable all hooks if 0 is passed.
     * @return bool true on success or false on failure
     * @since 4.5.0
     */
    public static function setHookFlags(int $flags): bool
    {
    }
}
