<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\RemoteObject;

class Exception extends \RuntimeException
{
    private ?string $remoteClass = null;

    private int|string|null $remoteCode = null;

    /**
     * Builds the exception for an error response of the remote object server, i.e. one whose code is not 0.
     *
     * The server answers its own errors with a message under 'msg' (-1 invalid request, -3 invalid API key), and
     * an exception it caught (-2) with that exception's message, code and class under 'exception'. The relayed
     * code is not always an integer (a PDOException carries its SQLSTATE, e.g. "42S02"), and a PHP exception code
     * has to be one, so it is kept as it is in getRemoteCode() and used as getCode() only when it is an integer.
     */
    public static function fromResponse(array $response): self
    {
        $ex = $response['exception'] ?? null;
        if (!is_array($ex)) {
            return new self('Server Error: ' . ($response['msg'] ?? 'unknown error'), (int) ($response['code'] ?? 0));
        }

        $code            = $ex['code'] ?? 0;
        $e               = new self('Server Error: ' . ($ex['message'] ?? ''), is_int($code) ? $code : 0);
        $e->remoteClass  = isset($ex['class']) ? (string) $ex['class'] : null;
        $e->remoteCode   = is_int($code) || is_string($code) ? $code : null;
        return $e;
    }

    /**
     * The class of the exception the server caught, or null when the error is the server's own.
     */
    public function getRemoteClass(): ?string
    {
        return $this->remoteClass;
    }

    /**
     * The code of the exception the server caught, as it was, or null when the error is the server's own.
     */
    public function getRemoteCode(): int|string|null
    {
        return $this->remoteCode;
    }
}
