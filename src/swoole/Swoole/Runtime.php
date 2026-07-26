<?php

declare(strict_types=1);

namespace Swoole;

/**
 * Class for managing Swoole's runtime hooks.
 *
 * Runtime hooks transparently replace PHP's blocking, built-in functionality (e.g., function sleep(), file and
 * stream operations, and database extensions like PDO and mysqli) with coroutine-friendly implementations, so that
 * existing synchronous code can run inside coroutines without blocking the whole process. Which parts of PHP get
 * hooked is controlled by the SWOOLE_HOOK_* flags (e.g., SWOOLE_HOOK_ALL, SWOOLE_HOOK_TCP, SWOOLE_HOOK_SLEEP),
 * passed to method enableCoroutine() or setHookFlags().
 *
 * This class can't be instantiated; all of its methods are static.
 *
 * @see \Swoole\Runtime::enableCoroutine()
 * @see \Swoole\Runtime::setHookFlags()
 */
class Runtime
{
    /**
     * To enable/disable runtime hooks in coroutines.
     *
     * This method can only be used when PHP runs in command-line (CLI) mode; calling it under any other SAPI raises a
     * fatal error.
     *
     * Before Swoole 6.0.0, this method accepts different types of parameters to enable or disable runtime hooks.
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
     *
     * @return int A bitwise combination of the SWOOLE_HOOK_* constants currently in effect; 0 when runtime hooks are
     *             disabled.
     * @see \Swoole\Runtime::setHookFlags()
     * @since 4.5.0
     */
    public static function getHookFlags(): int
    {
    }

    /**
     * Set runtime hook flags. This overrides any flags set previously.
     *
     * This method can only be used when PHP runs in command-line (CLI) mode; calling it under any other SAPI raises a
     * fatal error.
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
