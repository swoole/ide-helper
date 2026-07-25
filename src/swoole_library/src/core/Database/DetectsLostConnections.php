<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Database;

class DetectsLostConnections
{
    /**
     * @var array<string>
     */
    private const ERROR_MESSAGES = [
        'server has gone away',
        'Server has gone away',
        'no connection to the server',
        'Lost connection',
        'is dead or not enabled',
        'Error while sending',
        'decryption failed or bad record mac',
        'server closed the connection unexpectedly',
        'SSL connection has been closed unexpectedly',
        'Error writing data to the connection',
        'Resource deadlock avoided',
        'Transaction() on null',
        'child connection forced to terminate due to client_idle_limit',
        'query_wait_timeout',
        'reset by peer',
        'Physical connection is not usable',
        'TCP Provider: Error code 0x68',
        'ORA-03113',
        'ORA-03114',
        'Packets out of order. Expected',
        'Adaptive Server connection failed',
        'Communication link failure',
        'connection is no longer usable',
        'Login timeout expired',
        'SQLSTATE[HY000] [2002] Connection refused',
        'running with the --read-only option so it cannot execute this statement',
        'The connection is broken and recovery is not possible. The connection is marked by the client driver as unrecoverable. No attempt was made to restore the connection.',
        'SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Try again',
        'SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Name or service not known',
        'SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for',
        'SQLSTATE[HY000]: General error: 7 SSL SYSCALL error: EOF detected',
        'SSL error: unexpected eof',
        'SQLSTATE[HY000] [2002] Connection timed out',
        'SSL: Connection timed out',
        'SQLSTATE[HY000]: General error: 1105 The last transaction was aborted due to Seamless Scaling. Please retry.',
        'Temporary failure in name resolution',
        'SQLSTATE[08S01]: Communication link failure',
        'SQLSTATE[08006] [7] could not connect to server: Connection refused Is the server running on host',
        'SQLSTATE[HY000]: General error: 7 SSL SYSCALL error: No route to host',
        'The client was disconnected by the server because of inactivity. See wait_timeout and interactive_timeout for configuring this behavior.',
        'SQLSTATE[08006] [7] could not translate host name',
        'TCP Provider: Error code 0x274C',
        'SQLSTATE[HY000] [2002] No such file or directory',
        'SSL: Operation timed out',
        'Reason: Server is in script upgrade mode. Only administrator can connect at this time.',
        'Unknown $curl_error_code: 77',
        'SSL: Handshake timed out',
        'SQLSTATE[08006] [7] SSL error: sslv3 alert unexpected message',
        'SQLSTATE[08006] [7] unrecognized SSL error code:',
        'SQLSTATE[HY000] [1045] Access denied for user',
        'SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it',
        'SQLSTATE[HY000] [2002] A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond',
        'SQLSTATE[HY000] [2002] Network is unreachable',
        'SQLSTATE[HY000] [2002] The requested address is not valid in its context',
        'SQLSTATE[HY000] [2002] A socket operation was attempted to an unreachable network',
        'SQLSTATE[HY000] [2002] Operation now in progress',
        'SQLSTATE[HY000] [2002] Operation in progress',
        'SQLSTATE[HY000]: General error: 3989',
        'went away',
        'No such file or directory',
        'server is shutting down',
        'failed to connect to',
        'Channel connection is closed',
        'Connection lost',
        'Broken pipe',
        'SQLSTATE[25006]: Read only sql transaction: 7',
        'vtgate connection error: no healthy endpoints',
        'primary is not serving, there may be a reparent operation in progress',
        'current keyspace is being resharded',
        'no healthy tablet available',
        'transaction pool connection limit exceeded',
        'SSL operation failed with code 5',
        // PDO::prepare(): Send of 77 bytes failed with errno=110 Operation timed out
        // SSL: Handshake timed out
        // SSL: Operation timed out
        // SSL: Connection timed out
        // SQLSTATE[HY000] [2002] Connection timed out
        'timed out',
        'Error reading result',
    ];

    public static function causedByLostConnection(\Throwable $e): bool
    {
        $message = $e->getMessage();
        foreach (self::ERROR_MESSAGES as $needle) {
            if (mb_strpos($message, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
