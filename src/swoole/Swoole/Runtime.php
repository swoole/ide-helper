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
     * When PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with the
     * "--enable-swoole-thread" configuration option, runtime hooks are shared by all threads. Since Swoole 6.1.3, they
     * can be changed only from the main thread, and only before any child threads (e.g., \Swoole\Thread objects) have
     * been created; calls made from a child thread, or after child threads exist, fail and return false with a warning
     * logged. Before 6.1.3, such calls were partially applied instead of rejected.
     *
     * @param int $flags Enable given runtime hooks, or disable all hooks if 0 is passed.
     * @return bool TRUE on success, or FALSE on failure.
     * @see \Swoole\Runtime::setHookFlags()
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
     * When PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is installed with the
     * "--enable-swoole-thread" configuration option, runtime hooks are shared by all threads. Since Swoole 6.1.3, they
     * can be changed only from the main thread, and only before any child threads (e.g., \Swoole\Thread objects) have
     * been created; calls made from a child thread, or after child threads exist, fail and return false with a warning
     * logged. Before 6.1.3, such calls were partially applied instead of rejected.
     *
     * Since Swoole 6.1.6, the SWOOLE_HOOK_SOCKETS flag is silently dropped from the given flags when the PHP "sockets"
     * extension is not loaded, since the socket_*() functions that the flag hooks come from that extension.
     *
     * Similarly, since Swoole 6.2.0, the SWOOLE_HOOK_NET_FUNCTION and SWOOLE_HOOK_MONGODB flags are silently dropped
     * from the given flags when Swoole Library is disabled (ini option "swoole.enable_library" turned off), since
     * their replacement implementations come from Swoole Library.
     *
     * @param int $flags Enable given runtime hooks, or disable all hooks if 0 is passed.
     * @return bool true on success or false on failure
     * @see \Swoole\Runtime::enableCoroutine()
     * @since 4.5.0
     */
    public static function setHookFlags(int $flags): bool
    {
    }
}
