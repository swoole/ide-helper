<?php

declare(strict_types=1);

namespace Swoole\Redis;

/**
 * A server that speaks the Redis protocol.
 *
 * This class makes it easy to build a custom server that any Redis client can talk to: it parses incoming Redis
 * commands automatically, dispatches each command to the handler function registered for it with method
 * setHandler(), and provides method format() to build protocol-compliant replies (strings, integers, errors, lists,
 * maps, etc.). Everything else — ports, event callbacks, server options — works the same as in the parent class
 * \Swoole\Server.
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Redis\Server::setHandler()
 * @see \Swoole\Redis\Server::format()
 */
class Server extends \Swoole\Server
{
    /**
     * To return an ERR reply from the Redis server.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const ERROR = 0;

    /**
     * To return a NULL reply from the Redis server.
     *
     * When used as the 1st parameter "$type" in method \Swoole\Redis\Server::format(), there is no need to pass in the
     * 2nd parameter "$value".
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const NIL = 1;

    /**
     * To return a Status reply from the Redis server.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const STATUS = 2;

    /**
     * To return an Integer reply from the Redis server.
     *
     * When used as the 1st parameter "$type" in method \Swoole\Redis\Server::format(), the 2nd parameter "$value" must
     * be an integer.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const INT = 3;

    /**
     * To return a String reply from the Redis server.
     *
     * When used as the 1st parameter "$type" in method \Swoole\Redis\Server::format(), the 2nd parameter "$value" must
     * be a string.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const STRING = 4;

    /**
     * To return a Set reply from the Redis server.
     *
     * When used as the 1st parameter "$type" in method \Swoole\Redis\Server::format(), the 2nd parameter "$value" must
     * be an array.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const SET = 5;

    /**
     * To return a Map reply from the Redis server.
     *
     * When used as the 1st parameter "$type" in method \Swoole\Redis\Server::format(), the 2nd parameter "$value" must
     * be an associative array.
     *
     * @see \Swoole\Redis\Server::format()
     */
    public const MAP = 6;

    /**
     * Set a handler (a callback function) to process a given Redis command.
     *
     * @param string $command Name of the Redis command to handle (e.g., "GET" or "SET"). Command names are matched
     *                        case-insensitively, and each command can only have one handler (registering a second
     *                        handler for the same command replaces the first one).
     * @param callable $callback The callback function processing the command. It's called with the session ID of the
     *                           connection and an array of the command's arguments, and its return value (a reply
     *                           built with method format()) is sent back to the client.
     * @return bool TRUE on success, or FALSE on failure (e.g., when the command name is empty or too long).
     * @see \Swoole\Redis\Server::getHandler()
     * @see \Swoole\Redis\Server::format()
     */
    public function setHandler(string $command, callable $callback): bool
    {
    }

    /**
     * Get the handler (callback function) registered for a given Redis command through method setHandler().
     *
     * @param string $command Name of the Redis command (e.g., "GET" or "SET"). Command names are matched
     *                        case-insensitively.
     * @return callable|null Returns the callback function if defined, otherwise NULL.
     * @see \Swoole\Redis\Server::setHandler()
     */
    public function getHandler(string $command): ?callable
    {
    }

    /**
     * Format a reply.
     *
     * @param int $type The type of the reply. It can be one of the following seven constants:
     *                  - \Swoole\Redis\Server::ERROR
     *                  - \Swoole\Redis\Server::NIL
     *                  - \Swoole\Redis\Server::STATUS
     *                  - \Swoole\Redis\Server::INT
     *                  - \Swoole\Redis\Server::STRING
     *                  - \Swoole\Redis\Server::SET
     *                  - \Swoole\Redis\Server::MAP
     * @param mixed $value The value to put in the reply. What it should hold depends on parameter $type (see the
     *                     comments on the individual constants); it can be omitted for reply types
     *                     \Swoole\Redis\Server::NIL and \Swoole\Redis\Server::ERROR (for the latter, a default
     *                     error message is used).
     * @return string|false The reply encoded in the Redis protocol, ready to be sent back with method
     *                      \Swoole\Server::send(); or FALSE when the reply cannot be built (e.g., when $type is not
     *                      one of the constants listed above, or $value doesn't match the reply type).
     */
    public static function format(int $type, mixed $value = null): string|false
    {
    }
}
