<?php

declare(strict_types=1);

/*
 * Swoole version information.
 *
 * Note: no Swoole release ever reports a SWOOLE_VERSION_ID of 60104. Swoole 6.1.4 forgot to update the ID in the
 * source code (it kept reporting 60103, the value from Swoole 6.1.3), and Swoole 6.1.5 corrected it straight to
 * 60105. Keep this in mind when comparing against SWOOLE_VERSION_ID to detect Swoole 6.1.4.
 *
 * @see https://github.com/swoole/swoole-src/blob/v6.2.2/include/swoole_version.h#L26
 */
define('SWOOLE_VERSION', '6.2.2');
define('SWOOLE_VERSION_ID', 60202);
define('SWOOLE_MAJOR_VERSION', 6);
define('SWOOLE_MINOR_VERSION', 2);
define('SWOOLE_RELEASE_VERSION', 2);
define('SWOOLE_EXTRA_VERSION', '');

/*
 * If debug logging is enabled or not in Swoole.
 *
 * Debug logging is enabled when Swoole is installed with configuration option "--enable-debug-log" included, in which
 * case this constant is true; otherwise it is false, as shown here.
 */
define('SWOOLE_DEBUG', false);

/*
 * Next three constants tell which compression libraries were found and built in when Swoole was compiled. Each of them
 * is defined (as true) only when the corresponding support is available; otherwise the constant does not exist at all:
 *   - SWOOLE_HAVE_COMPRESSION: at least one of the supported compression libraries (zlib, brotli, or zstd) is built in,
 *     so HTTP requests/responses can be compressed and decompressed.
 *   - SWOOLE_HAVE_ZLIB: the zlib library (for gzip/deflate compression) is built in.
 *   - SWOOLE_HAVE_BROTLI: the brotli library (for Brotli compression) is built in.
 */
#ifdef SW_HAVE_COMPRESSION
define('SWOOLE_HAVE_COMPRESSION', true);
#endif
#ifdef SW_HAVE_ZLIB
define('SWOOLE_HAVE_ZLIB', true);
#endif
#ifdef SW_HAVE_BROTLI
define('SWOOLE_HAVE_BROTLI', true);
#endif

// HTTP/2 support is always built into Swoole, so this constant is always defined as true.
define('SWOOLE_USE_HTTP2', true);

// Support short names or not. Short names are all the aliases listed in file ./shortnames.php.
define('SWOOLE_USE_SHORTNAME', (bool) ini_get('swoole.use_shortname'));

/*
 * Next two constants define types of socket connections. They are used in method Swoole\Client::__construct().
 *
 * There are two types of socket connections: synchronous (blocking) and asynchronous (non-blocking).
 */
define('SWOOLE_SOCK_SYNC', false);
define('SWOOLE_SOCK_ASYNC', true); // No longer used, but still kept for backward compatibility.

// Socket types, which are to specify the communication semantics.
define('SWOOLE_SOCK_TCP', 1);
define('SWOOLE_SOCK_UDP', 2);
define('SWOOLE_SOCK_TCP6', 3);
define('SWOOLE_SOCK_UDP6', 4);
define('SWOOLE_SOCK_UNIX_STREAM', 5);
define('SWOOLE_SOCK_UNIX_DGRAM', 6);

/*
 * Next two constants are for raw sockets, which let a program read and write network packets itself instead of letting
 * the operating system build them. Creating a raw socket normally requires root privileges.
 *
 * @see https://man7.org/linux/man-pages/man7/raw.7.html
 */
define('SWOOLE_SOCK_RAW', 7); // @since 6.1.0
define('SWOOLE_SOCK_RAW6', 8); // @since 6.1.0

// Simple aliases of socket types.
define('SWOOLE_TCP', SWOOLE_SOCK_TCP);
define('SWOOLE_UDP', SWOOLE_SOCK_UDP);
define('SWOOLE_TCP6', SWOOLE_SOCK_TCP6);
define('SWOOLE_UDP6', SWOOLE_SOCK_UDP6);
define('SWOOLE_UNIX_STREAM', SWOOLE_SOCK_UNIX_STREAM);
define('SWOOLE_UNIX_DGRAM', SWOOLE_SOCK_UNIX_DGRAM);
define('SWOOLE_RAW', SWOOLE_SOCK_RAW); // @since 6.1.0
define('SWOOLE_RAW6', SWOOLE_SOCK_RAW6); // @since 6.1.0

/*
 * Socket flags. They can be used in conjunction with socket types to modify the behavior of socket connections.
 *
 * There are four flags for socket connections:
 *   - SWOOLE_SSL   (2^9)
 *   - SWOOLE_ASYNC (2^10) (No longer used, but still kept for backward compatibility.)
 *   - SWOOLE_SYNC  (2^11) (No longer used, but still kept for backward compatibility.)
 *   - SWOOLE_KEEP  (2^12)
 */
define('SWOOLE_ASYNC', 1024); // 2^10 (No longer used, but still kept for backward compatibility.)
define('SWOOLE_SYNC', 2048);  // 2^11 (No longer used, but still kept for backward compatibility.)
define('SWOOLE_KEEP', 4096);  // 2^12

// Read/Write events of sockets.
define('SWOOLE_EVENT_READ', 512);   // 2^9
define('SWOOLE_EVENT_WRITE', 1024); // 2^10

/*
 * File locking flag for methods \Swoole\Coroutine\System::readFile() and \Swoole\Coroutine\System::writeFile().
 *
 * When included in the flags passed to either method, an exclusive lock is held on the file while it is being read or
 * written, so that other processes locking the same file cannot read or write it at the same time. The constant has
 * the same value as the built-in PHP constant LOCK_EX, and the two can be used interchangeably in those methods.
 *
 * @see \Swoole\Coroutine\System::readFile()
 * @see \Swoole\Coroutine\System::writeFile()
 */
define('FILE_LOCK', 2); // @since 6.1.2

/*
 * Error types. They are used as value of the second parameter of function swoole_strerror(int $errno, int $error_type).
 *
 * @see swoole_strerror()
 */
define('SWOOLE_STRERROR_SYSTEM', 0);
define('SWOOLE_STRERROR_GAI', 1);
define('SWOOLE_STRERROR_DNS', 2);
define('SWOOLE_STRERROR_SWOOLE', 9);

// Error codes.
define('SWOOLE_ERROR_MALLOC_FAIL', 501);
define('SWOOLE_ERROR_SYSTEM_CALL_FAIL', 502);
define('SWOOLE_ERROR_PHP_FATAL_ERROR', 503);
define('SWOOLE_ERROR_NAME_TOO_LONG', 504);
define('SWOOLE_ERROR_INVALID_PARAMS', 505);
define('SWOOLE_ERROR_QUEUE_FULL', 506);
define('SWOOLE_ERROR_OPERATION_NOT_SUPPORT', 507);
define('SWOOLE_ERROR_PROTOCOL_ERROR', 508);
define('SWOOLE_ERROR_WRONG_OPERATION', 509);
define('SWOOLE_ERROR_PHP_RUNTIME_NOTICE', 510); // @since 5.1.0
define('SWOOLE_ERROR_FOR_TEST', 511); // @since 6.0.0
define('SWOOLE_ERROR_NO_PAYLOAD', 550); // @since 6.0.0
define('SWOOLE_ERROR_UNDEFINED_BEHAVIOR', 600); // @since 6.0.0
define('SWOOLE_ERROR_NOT_THREAD_SAFETY', 601); // @since 6.0.0
define('SWOOLE_ERROR_FILE_NOT_EXIST', 700);
define('SWOOLE_ERROR_FILE_TOO_LARGE', 701);
define('SWOOLE_ERROR_FILE_EMPTY', 702);
define('SWOOLE_ERROR_DIR_NOT_EXIST', 703); // @since 6.1.0
define('SWOOLE_ERROR_DNSLOOKUP_DUPLICATE_REQUEST', 710);
define('SWOOLE_ERROR_DNSLOOKUP_RESOLVE_FAILED', 711);
define('SWOOLE_ERROR_DNSLOOKUP_RESOLVE_TIMEOUT', 712);
define('SWOOLE_ERROR_DNSLOOKUP_UNSUPPORTED', 713);
define('SWOOLE_ERROR_DNSLOOKUP_NO_SERVER', 714);
define('SWOOLE_ERROR_BAD_IPV6_ADDRESS', 720);
define('SWOOLE_ERROR_UNREGISTERED_SIGNAL', 721);
define('SWOOLE_ERROR_BAD_HOST_ADDR', 722); // @since 6.0.0
define('SWOOLE_ERROR_BAD_PORT', 723); // @since 6.1.0
define('SWOOLE_ERROR_BAD_SOCKET_TYPE', 724); // @since 6.1.0
define('SWOOLE_ERROR_EVENT_REMOVE_FAILED', 800); // @since 6.1.0
define('SWOOLE_ERROR_EVENT_ADD_FAILED', 801); // @since 6.1.0
define('SWOOLE_ERROR_EVENT_UPDATE_FAILED', 802); // @since 6.1.0
define('SWOOLE_ERROR_EVENT_UNKNOWN_DATA', 803); // @since 6.1.0
define('SWOOLE_ERROR_SESSION_CLOSED_BY_SERVER', 1001);
define('SWOOLE_ERROR_SESSION_CLOSED_BY_CLIENT', 1002);
define('SWOOLE_ERROR_SESSION_CLOSING', 1003);
define('SWOOLE_ERROR_SESSION_CLOSED', 1004);
define('SWOOLE_ERROR_SESSION_NOT_EXIST', 1005);
define('SWOOLE_ERROR_SESSION_INVALID_ID', 1006);
define('SWOOLE_ERROR_SESSION_DISCARD_TIMEOUT_DATA', 1007);
define('SWOOLE_ERROR_SESSION_DISCARD_DATA', 1008);
define('SWOOLE_ERROR_OUTPUT_BUFFER_OVERFLOW', 1009);
define('SWOOLE_ERROR_OUTPUT_SEND_YIELD', 1010);
define('SWOOLE_ERROR_SSL_NOT_READY', 1011);
define('SWOOLE_ERROR_SSL_CANNOT_USE_SENFILE', 1012);
define('SWOOLE_ERROR_SSL_EMPTY_PEER_CERTIFICATE', 1013);
define('SWOOLE_ERROR_SSL_VERIFY_FAILED', 1014);
define('SWOOLE_ERROR_SSL_BAD_CLIENT', 1015);
define('SWOOLE_ERROR_SSL_BAD_PROTOCOL', 1016);
define('SWOOLE_ERROR_SSL_RESET', 1017);
define('SWOOLE_ERROR_SSL_HANDSHAKE_FAILED', 1018);
define('SWOOLE_ERROR_SSL_CREATE_CONTEXT_FAILED', 1019); // @since 6.1.0
define('SWOOLE_ERROR_SSL_CREATE_SESSION_FAILED', 1020); // @since 6.1.0
define('SWOOLE_ERROR_PACKAGE_LENGTH_TOO_LARGE', 1201);
define('SWOOLE_ERROR_PACKAGE_LENGTH_NOT_FOUND', 1202);
define('SWOOLE_ERROR_DATA_LENGTH_TOO_LARGE', 1203);
define('SWOOLE_ERROR_PACKAGE_MALFORMED_DATA', 1204);
define('SWOOLE_ERROR_TASK_PACKAGE_TOO_BIG', 2001);
define('SWOOLE_ERROR_TASK_DISPATCH_FAIL', 2002);
define('SWOOLE_ERROR_TASK_TIMEOUT', 2003);
define('SWOOLE_ERROR_HTTP2_STREAM_ID_TOO_BIG', 3001);
define('SWOOLE_ERROR_HTTP2_STREAM_NO_HEADER', 3002);
define('SWOOLE_ERROR_HTTP2_STREAM_NOT_FOUND', 3003);
define('SWOOLE_ERROR_HTTP2_STREAM_IGNORE', 3004);
define('SWOOLE_ERROR_HTTP2_SEND_CONTROL_FRAME_FAILED', 3005);
define('SWOOLE_ERROR_HTTP2_INTERNAL_ERROR', 3006); // @since 6.1.0
define('SWOOLE_ERROR_AIO_BAD_REQUEST', 4001);
define('SWOOLE_ERROR_AIO_CANCELED', 4002);
define('SWOOLE_ERROR_AIO_TIMEOUT', 4003);
define('SWOOLE_ERROR_CLIENT_NO_CONNECTION', 5001);
define('SWOOLE_ERROR_SOCKET_CLOSED', 6001);
define('SWOOLE_ERROR_SOCKET_POLL_TIMEOUT', 6002);
define('SWOOLE_ERROR_SOCKET_NOT_EXISTS', 6003); // @since 6.1.0
define('SWOOLE_ERROR_SOCKS5_UNSUPPORT_VERSION', 7001);
define('SWOOLE_ERROR_SOCKS5_UNSUPPORT_METHOD', 7002);
define('SWOOLE_ERROR_SOCKS5_AUTH_FAILED', 7003);
define('SWOOLE_ERROR_SOCKS5_SERVER_ERROR', 7004);
define('SWOOLE_ERROR_SOCKS5_HANDSHAKE_FAILED', 7005);
define('SWOOLE_ERROR_SOCKS5_CONNECT_FAILED', 7006); // @since 6.1.0
define('SWOOLE_ERROR_HTTP_PROXY_HANDSHAKE_ERROR', 7101);
define('SWOOLE_ERROR_HTTP_INVALID_PROTOCOL', 7102);
define('SWOOLE_ERROR_HTTP_PROXY_HANDSHAKE_FAILED', 7103);
define('SWOOLE_ERROR_HTTP_PROXY_BAD_RESPONSE', 7104);
define('SWOOLE_ERROR_HTTP_CONFLICT_HEADER', 7105); // @since v5.0.3
define('SWOOLE_ERROR_HTTP_CONTEXT_UNAVAILABLE', 7106); // @since v5.1.2
define('SWOOLE_ERROR_HTTP_COOKIE_UNAVAILABLE', 7107); // @since v6.0.0
define('SWOOLE_ERROR_WEBSOCKET_BAD_CLIENT', 8501);
define('SWOOLE_ERROR_WEBSOCKET_BAD_OPCODE', 8502);
define('SWOOLE_ERROR_WEBSOCKET_UNCONNECTED', 8503);
define('SWOOLE_ERROR_WEBSOCKET_HANDSHAKE_FAILED', 8504);
define('SWOOLE_ERROR_WEBSOCKET_PACK_FAILED', 8505);
define('SWOOLE_ERROR_WEBSOCKET_UNPACK_FAILED', 8506);
define('SWOOLE_ERROR_WEBSOCKET_INCOMPLETE_PACKET', 8507);
define('SWOOLE_ERROR_SERVER_MUST_CREATED_BEFORE_CLIENT', 9001);
define('SWOOLE_ERROR_SERVER_TOO_MANY_SOCKET', 9002);
define('SWOOLE_ERROR_SERVER_WORKER_TERMINATED', 9003);
define('SWOOLE_ERROR_SERVER_INVALID_LISTEN_PORT', 9004);
define('SWOOLE_ERROR_SERVER_TOO_MANY_LISTEN_PORT', 9005);
define('SWOOLE_ERROR_SERVER_PIPE_BUFFER_FULL', 9006);
define('SWOOLE_ERROR_SERVER_NO_IDLE_WORKER', 9007);
define('SWOOLE_ERROR_SERVER_ONLY_START_ONE', 9008);
define('SWOOLE_ERROR_SERVER_SEND_IN_MASTER', 9009);
define('SWOOLE_ERROR_SERVER_INVALID_REQUEST', 9010);
define('SWOOLE_ERROR_SERVER_CONNECT_FAIL', 9011);
define('SWOOLE_ERROR_SERVER_INVALID_COMMAND', 9012);
define('SWOOLE_ERROR_SERVER_IS_NOT_REGULAR_FILE', 9013);
define('SWOOLE_ERROR_SERVER_SEND_TO_WOKER_TIMEOUT', 9014);
define('SWOOLE_ERROR_SERVER_INVALID_CALLBACK', 9015); // @since v6.0.0
define('SWOOLE_ERROR_SERVER_UNRELATED_THREAD', 9016); // @since v6.0.0
define('SWOOLE_ERROR_SERVER_WORKER_EXIT_TIMEOUT', 9101);
define('SWOOLE_ERROR_SERVER_WORKER_ABNORMAL_PIPE_DATA', 9102);
define('SWOOLE_ERROR_SERVER_WORKER_UNPROCESSED_DATA', 9103);
define('SWOOLE_ERROR_CO_OUT_OF_COROUTINE', 10001);
define('SWOOLE_ERROR_CO_HAS_BEEN_BOUND', 10002);
define('SWOOLE_ERROR_CO_HAS_BEEN_DISCARDED', 10003);
define('SWOOLE_ERROR_CO_MUTEX_DOUBLE_UNLOCK', 10004);
define('SWOOLE_ERROR_CO_BLOCK_OBJECT_LOCKED', 10005);
define('SWOOLE_ERROR_CO_BLOCK_OBJECT_WAITING', 10006);
define('SWOOLE_ERROR_CO_YIELD_FAILED', 10007);
define('SWOOLE_ERROR_CO_GETCONTEXT_FAILED', 10008);
define('SWOOLE_ERROR_CO_SWAPCONTEXT_FAILED', 10009);
define('SWOOLE_ERROR_CO_MAKECONTEXT_FAILED', 10010);
define('SWOOLE_ERROR_CO_IOCPINIT_FAILED', 10011);
define('SWOOLE_ERROR_CO_PROTECT_STACK_FAILED', 10012);
define('SWOOLE_ERROR_CO_STD_THREAD_LINK_ERROR', 10013);
define('SWOOLE_ERROR_CO_DISABLED_MULTI_THREAD', 10014);
define('SWOOLE_ERROR_CO_CANNOT_CANCEL', 10015);
define('SWOOLE_ERROR_CO_NOT_EXISTS', 10016);
define('SWOOLE_ERROR_CO_CANCELED', 10017);
define('SWOOLE_ERROR_CO_TIMEDOUT', 10018);
/*
 * Failed to close the socket since the socket is currently held by other coroutine(s).
 *
 * @since 5.0.2
 */
define('SWOOLE_ERROR_CO_SOCKET_CLOSE_WAIT', 10019);

// Trace log types (server related).
define('SWOOLE_TRACE_SERVER', 2); // 2^1
define('SWOOLE_TRACE_CLIENT', 4); // 2^2
define('SWOOLE_TRACE_BUFFER', 8); // 2^3
define('SWOOLE_TRACE_CONN', 16); // 2^4
define('SWOOLE_TRACE_EVENT', 32); // 2^5
define('SWOOLE_TRACE_WORKER', 64); // 2^6
define('SWOOLE_TRACE_MEMORY', 128); // 2^7
define('SWOOLE_TRACE_REACTOR', 256); // 2^8
define('SWOOLE_TRACE_PHP', 512); // 2^9
define('SWOOLE_TRACE_HTTP', 1024); // 2^10
define('SWOOLE_TRACE_HTTP2', 2048); // 2^11
define('SWOOLE_TRACE_EOF_PROTOCOL', 4096); // 2^12
define('SWOOLE_TRACE_LENGTH_PROTOCOL', 8192); // 2^13
define('SWOOLE_TRACE_CLOSE', 16384); // 2^14
define('SWOOLE_TRACE_WEBSOCKET', 32768); // 2^15
// Trace log types (client related).
define('SWOOLE_TRACE_REDIS_CLIENT', 65536); // 2^16
define('SWOOLE_TRACE_MYSQL_CLIENT', 131072); // 2^17
define('SWOOLE_TRACE_HTTP_CLIENT', 262144); // 2^18
define('SWOOLE_TRACE_AIO', 524288); // 2^19
define('SWOOLE_TRACE_SSL', 1048576); // 2^20
define('SWOOLE_TRACE_NORMAL', 2097152); // 2^21
// Trace log types (coroutine related).
define('SWOOLE_TRACE_CHANNEL', 4194304); // 2^22
define('SWOOLE_TRACE_TIMER', 8388608); // 2^23
define('SWOOLE_TRACE_SOCKET', 16777216); // 2^24
define('SWOOLE_TRACE_COROUTINE', 33554432); // 2^25
define('SWOOLE_TRACE_CONTEXT', 67108864); // 2^26
define('SWOOLE_TRACE_CO_HTTP_SERVER', 134217728); // 2^27
define('SWOOLE_TRACE_TABLE', 268435456); // 2^28
define('SWOOLE_TRACE_CO_CURL', 536870912); // 2^29
define('SWOOLE_TRACE_CARES', 1073741824); // 2^30
/*
 * Constant SWOOLE_TRACE_ZLIB is added in Swoole 4.8.13 and 5.0.2.
 *
 * @since 4.8.13 and 5.0.2
 */
define('SWOOLE_TRACE_ZLIB', 2147483648); // 2^31
define('SWOOLE_TRACE_CO_PGSQL', 4294967296); // 2^32; @since 5.1.0
define('SWOOLE_TRACE_CO_ODBC', 8589934592); // 2^33; @since 5.1.0
define('SWOOLE_TRACE_CO_ORACLE', 17179869184); // 2^34; @since 5.1.0
define('SWOOLE_TRACE_CO_SQLITE', 34359738368); // 2^35; @since 5.1.2
define('SWOOLE_TRACE_CO_FIREBIRD', 68719476736); // 2^36; @since 6.2.0
define('SWOOLE_TRACE_CO_SSH2', 137438953472); // 2^37; @since 6.2.0
/*
 * Trace log type for threads.
 *
 * Note: the value of this constant changed in Swoole 6.2.0. In Swoole 6.1.x it was 68719476736 (2^36); since Swoole
 * 6.2.0 that value belongs to SWOOLE_TRACE_CO_FIREBIRD, and SWOOLE_TRACE_THREAD is 1099511627776 (2^40) instead.
 *
 * @since 6.1.0
 */
define('SWOOLE_TRACE_THREAD', 1099511627776); // 2^40
define('SWOOLE_TRACE_ALL', 9223372036854775807); // 2^63 - 1

// Log levels.
define('SWOOLE_LOG_DEBUG', 0);
define('SWOOLE_LOG_TRACE', 1);
define('SWOOLE_LOG_INFO', 2);
define('SWOOLE_LOG_NOTICE', 3);
define('SWOOLE_LOG_WARNING', 4);
define('SWOOLE_LOG_ERROR', 5);
define('SWOOLE_LOG_NONE', 6);

// Log rotation intervals.
define('SWOOLE_LOG_ROTATION_SINGLE', 0);
define('SWOOLE_LOG_ROTATION_MONTHLY', 1);
define('SWOOLE_LOG_ROTATION_DAILY', 2);
define('SWOOLE_LOG_ROTATION_HOURLY', 3);
define('SWOOLE_LOG_ROTATION_EVERY_MINUTE', 4);

/*
 * Constants in this section are IPC modes.
 */
define('SWOOLE_IPC_NONE', 0);
define('SWOOLE_IPC_UNIXSOCK', 1); // IPC socket (aka Unix domain socket).
define('SWOOLE_IPC_MSGQUEUE', 2); // IPC using message queues.
define('SWOOLE_IPC_SOCKET', 3); // Network socket.

/*
 * Constants in this section are task IPC modes, used as value of server setting "task_ipc_mode" to define how worker
 * processes deliver tasks to task workers.
 *
 * There are 4 task IPC modes, ranged from 1 to 4, but only 3 of them have a matching PHP constant:
 *   - 1 (SWOOLE_IPC_UNSOCK): the default mode; tasks are delivered over Unix domain sockets.
 *   - 2 (SWOOLE_IPC_MSGQUEUE): tasks are delivered over a System V message queue, with each task addressed to one
 *     specific task worker chosen by the dispatcher.
 *   - 3 (SWOOLE_IPC_PREEMPTIVE): tasks are delivered over the very same System V message queue used in mode 2, except
 *     that tasks are not addressed to any specific task worker; instead, whichever task worker becomes idle first
 *     takes the next task off the queue.
 *   - 4: tasks are delivered over a stream socket (a Unix domain socket of type SOCK_STREAM, listening on file
 *     /tmp/swoole.task.<master process id>.sock) instead of a message queue. This mode has no PHP constant defined
 *     for it; the numeric value 4 has to be used directly.
 *
 * Note that constant SWOOLE_IPC_PREEMPTIVE happens to share the value 3 with constant SWOOLE_IPC_SOCKET defined
 * above, but the two belong to different sets of constants and are not interchangeable.
 *
 * The two message-queue-based modes (2 and 3) cannot be used together with server setting "task_enable_coroutine".
 * Also, since Swoole 6.1.3, using either of them on a system where System V message queues are not available (e.g.,
 * when Swoole was built on a platform without that feature) makes method \Swoole\Server::set() raise a fatal error,
 * instead of failing later at runtime.
 *
 * @see SWOOLE_IPC_MSGQUEUE
 * @see \Swoole\Server::set()
 */
define('SWOOLE_IPC_UNSOCK', 1); // Default.
define('SWOOLE_IPC_PREEMPTIVE', 3);

/*
 * Maximum number of iovec structures that one process has available for use with readv() or writev().
 *
 * Note that value of this constant varies across different operating systems.
 *
 * @see https://www.gnu.org/software/libc/manual/html_node/Scatter_002dGather.html Fast Scatter-Gather I/O
 */
define('SWOOLE_IOV_MAX', 1024);

/*
 * Working modes for the io_uring engine that backs Swoole's asynchronous file operations.
 *
 * They are used as the value of the "iouring_flag" option of function swoole_async_set(), which selects how the
 * io_uring instance is set up to pick up new I/O requests:
 *   - SWOOLE_IOURING_DEFAULT: the default mode; the kernel is told about newly queued requests through a system call.
 *   - SWOOLE_IOURING_SQPOLL: a dedicated kernel thread watches the request queue on its own, so requests can usually
 *     be submitted without a system call, at the cost of keeping that thread running. Its value mirrors the kernel's
 *     IORING_SETUP_SQPOLL setup flag.
 *
 * These two constants are available only when Swoole is installed with the "--enable-iouring" configuration option
 * included (which additionally requires the liburing library to be present).
 *
 * @see swoole_async_set()
 * @see https://man7.org/linux/man-pages/man2/io_uring_setup.2.html io_uring_setup(2)
 * @since v6.0.0
 */
#ifdef SW_USE_IOURING
define('SWOOLE_IOURING_DEFAULT', 0);
define('SWOOLE_IOURING_SQPOLL', 2); // Mirrors the kernel's IORING_SETUP_SQPOLL flag.
#endif

/*
 * Types of supported locks in Swoole.
 *
 * @see \Swoole\Lock
 */
#ifdef HAVE_RWLOCK
define('SWOOLE_RWLOCK', 1); # Supported only if read-write lock is included in the POSIX thread (pthread) libraries.
#endif
define('SWOOLE_MUTEX', 3);
#ifdef HAVE_SPINLOCK
define('SWOOLE_SPINLOCK', 5); # Supported only if the Spin Locks option is provided in the POSIX thread (pthread) libraries.
#endif

/*
 * Following SIG_* and PRIO_* constants are set only when PHP extension pcntl (to support Process Control) is not
 * installed.
 *
 * Most constants here are the same as those defined in PHP extension pcntl, as you can see from the following links:
 *   - https://www.php.net/manual/en/pcntl.constants.php
 *   - https://github.com/php/php-src/blob/php-8.1.12/ext/pcntl/pcntl.c#L106
 *
 * Note that values of these constants are not always the same in different operating systems. The values shown here
 * is for Linux only.
 */
// SIG_* constants. Please see your systems signal(7) man page for details of the default behavior of these signals.
define('SIG_IGN', 1);
define('SIGHUP', 1);
define('SIGINT', 2);
define('SIGQUIT', 3);
define('SIGILL', 4);
define('SIGTRAP', 5);
define('SIGABRT', 6);
define('SIGBUS', 7);
define('SIGFPE', 8);
define('SIGKILL', 9);
define('SIGUSR1', 10);
define('SIGSEGV', 11);
define('SIGUSR2', 12);
define('SIGPIPE', 13);
define('SIGALRM', 14);
define('SIGTERM', 15);
#ifdef SIGSTKFLT
define('SIGSTKFLT', 16);
#endif
define('SIGCHLD', 17);
define('SIGCONT', 18);
define('SIGSTOP', 19);
define('SIGTSTP', 20);
define('SIGTTIN', 21);
define('SIGTTOU', 22);
define('SIGURG', 23);
define('SIGXCPU', 24);
define('SIGXFSZ', 25);
define('SIGVTALRM', 26);
define('SIGPROF', 27);
define('SIGWINCH', 28);
define('SIGIO', 29);
#ifdef SIGPWR
define('SIGPWR', 30);
#endif
#ifdef SIGSYS
define('SIGSYS', 31);
#endif
/*
 * PRIO_* constants. They are used to get/set process priority.
 *
 * Please see your systems getpriority(2) or setpriority(2) man page for details of these constants.
 *
 * @see \Swoole\Process::getPriority()
 * @see \Swoole\Process::setPriority()
 */
define('PRIO_PROCESS', 0);
define('PRIO_PGRP', 1);
define('PRIO_USER', 2);

/*
 * Following socket-related constants (AF_*, SOCK_*, MSG_*, SO_*, SOL_*, SOMAXCONN, TCP_NODELAY, MCAST_*,
 * IP_MULTICAST_*, IPV6_*, IPPROTO_*, AI_*, and most SOCKET_E* constants) are set only when PHP extension sockets (to
 * support low-level socket communication) is not installed, so that socket-related code (e.g., code working with
 * class \Swoole\Coroutine\Socket) keeps working without that extension.
 *
 * The constants are the same as those defined in PHP extension sockets, as you can see from the following link:
 *   - https://www.php.net/manual/en/sockets.constants.php
 *
 * Note that values of these constants are not always the same in different operating systems. The values shown here
 * are for Linux only. A few constants of PHP extension sockets that exist only on other operating systems (MSG_EOF,
 * SO_FAMILY, SO_LABEL, SO_PEERLABEL, SO_LISTENQLIMIT, SO_LISTENQLEN, and SO_USER_COOKIE) are not listed here.
 *
 * @see \Swoole\Coroutine\Socket
 */
// Address families. They specify the kind of addresses a socket communicates with.
define('AF_UNIX', 1); // Local communication between processes on the same machine (Unix domain sockets).
define('AF_INET', 2); // IPv4 Internet protocols.
define('AF_INET6', 10); // IPv6 Internet protocols.
// Socket types. They specify the communication semantics of a socket.
define('SOCK_STREAM', 1); // Reliable, connection-based byte stream (used by TCP).
define('SOCK_DGRAM', 2); // Connectionless datagrams of a fixed maximum length (used by UDP).
define('SOCK_RAW', 3); // Raw network protocol access.
define('SOCK_RDM', 4); // Reliably-delivered datagrams, without guaranteed ordering.
define('SOCK_SEQPACKET', 5); // Reliable, connection-based, sequenced datagrams of a fixed maximum length.
// Message flags. They modify the behavior of a single send or receive operation on a socket.
define('MSG_OOB', 1); // Send or receive out-of-band (urgent) data.
define('MSG_PEEK', 2); // Peek at the incoming data without removing it from the receive queue.
define('MSG_DONTROUTE', 4); // Send without following the normal routing table (directly reachable hosts only).
define('MSG_CTRUNC', 8); // Set on receive when some control (ancillary) data was discarded for lack of buffer space.
define('MSG_TRUNC', 32); // Set on receive when the datagram was larger than the buffer and got truncated.
define('MSG_WAITALL', 256); // Block until the full amount of requested data has been received.
#ifdef MSG_EOR
define('MSG_EOR', 128); // Mark the end of a record.
#endif
#ifdef MSG_DONTWAIT
define('MSG_DONTWAIT', 64); // Perform this one operation in non-blocking mode.
#endif
#ifdef MSG_CONFIRM
define('MSG_CONFIRM', 2048); // Tell the link layer that the peer replied, so it does not need to re-probe it.
#endif
#ifdef MSG_ERRQUEUE
define('MSG_ERRQUEUE', 8192); // Receive queued errors from the socket's error queue instead of regular data.
#endif
#ifdef MSG_NOSIGNAL
define('MSG_NOSIGNAL', 16384); // Do not raise the SIGPIPE signal when the other end has closed the connection.
#endif
#ifdef MSG_MORE
define('MSG_MORE', 32768); // The caller has more data to send; the kernel may combine the pieces into one packet.
#endif
#ifdef MSG_WAITFORONE
define('MSG_WAITFORONE', 65536); // When receiving multiple messages, return as soon as at least one is available.
#endif
#ifdef MSG_CMSG_CLOEXEC
define('MSG_CMSG_CLOEXEC', 1073741824); // Set the close-on-exec flag on file descriptors received over the socket.
#endif
/*
 * Socket options. They are read with socket_get_option() and changed with socket_set_option() (or, in Swoole, with
 * methods \Swoole\Coroutine\Socket::getOption() and \Swoole\Coroutine\Socket::setOption()).
 *
 * @see https://man7.org/linux/man-pages/man7/socket.7.html socket(7)
 * @see \Swoole\Coroutine\Socket::getOption()
 * @see \Swoole\Coroutine\Socket::setOption()
 */
define('SO_DEBUG', 1); // Enable protocol-level debugging output.
define('SO_REUSEADDR', 2); // Allow reusing a local address that is in the TIME_WAIT state.
define('SO_TYPE', 3); // The type of the socket (e.g., SOCK_STREAM); read-only.
define('SO_ERROR', 4); // The pending error on the socket, cleared once read; read-only.
define('SO_DONTROUTE', 5); // Send without following the normal routing table (directly reachable hosts only).
define('SO_BROADCAST', 6); // Allow sending datagrams to broadcast addresses.
define('SO_SNDBUF', 7); // Size of the send buffer, in bytes.
define('SO_RCVBUF', 8); // Size of the receive buffer, in bytes.
define('SO_KEEPALIVE', 9); // Send keep-alive probes on an idle connection.
define('SO_OOBINLINE', 10); // Deliver out-of-band data inline with regular data.
define('SO_LINGER', 13); // Whether (and how long) closing the socket blocks until unsent data is transmitted.
#ifdef SO_REUSEPORT
define('SO_REUSEPORT', 15); // Allow multiple sockets to bind to exactly the same address and port.
#endif
define('SO_RCVLOWAT', 18); // Minimum number of bytes in the receive buffer before a read returns data.
define('SO_SNDLOWAT', 19); // Minimum number of bytes available in the send buffer before a write proceeds.
define('SO_RCVTIMEO', 20); // Timeout for blocking receive operations.
define('SO_SNDTIMEO', 21); // Timeout for blocking send operations.
#ifdef SO_BINDTODEVICE
define('SO_BINDTODEVICE', 25); // Bind the socket to a specific network interface (e.g., "eth0").
#endif
define('SOL_SOCKET', 1); // Option level for socket-level options (the SO_* options above).
define('SOMAXCONN', 4096); // Maximum length the queue of pending connections may grow to.
#ifdef TCP_NODELAY
define('TCP_NODELAY', 1); // Disable Nagle's algorithm: send small pieces of data right away instead of batching them.
#endif
/*
 * Multicast options. They manage memberships and behavior of sockets in IP multicast groups.
 *
 * The MCAST_* constants are option names used together with option level IPPROTO_IP (for IPv4) or IPPROTO_IPV6 (for
 * IPv6); the IP_MULTICAST_* option names work at level IPPROTO_IP only, and the IPV6_MULTICAST_* ones at level
 * IPPROTO_IPV6 only.
 */
define('MCAST_JOIN_GROUP', 42); // Join a multicast group.
#ifdef HAS_MCAST_EXT
define('MCAST_BLOCK_SOURCE', 43); // Stop receiving data sent to the group from a specific source address.
define('MCAST_UNBLOCK_SOURCE', 44); // Start receiving again data sent to the group from a previously blocked source.
#endif
define('MCAST_LEAVE_GROUP', 45); // Leave a multicast group.
#ifdef HAS_MCAST_EXT
define('MCAST_JOIN_SOURCE_GROUP', 46); // Receive data sent to the group only from a specific source address.
define('MCAST_LEAVE_SOURCE_GROUP', 47); // Stop receiving data sent to the group from a specific source address.
#endif
define('IP_MULTICAST_IF', 32); // The outgoing network interface for IPv4 multicast packets.
define('IP_MULTICAST_TTL', 33); // Time-to-live of outgoing IPv4 multicast packets.
define('IP_MULTICAST_LOOP', 34); // Whether IPv4 multicast packets sent are looped back to the local sockets.
define('IPV6_MULTICAST_IF', 17); // The outgoing network interface for IPv6 multicast packets.
define('IPV6_MULTICAST_HOPS', 18); // Hop limit of outgoing IPv6 multicast packets.
define('IPV6_MULTICAST_LOOP', 19); // Whether IPv6 multicast packets sent are looped back to the local sockets.
#ifdef IPV6_V6ONLY
define('IPV6_V6ONLY', 26); // Restrict an AF_INET6 socket to IPv6 communication only.
#endif
/*
 * Socket error codes. They are operating system error numbers (as defined in errno(3)) prefixed with "SOCKET_", and
 * can be checked against the error code of a failed socket operation (e.g., against property
 * \Swoole\Coroutine\Socket::$errCode).
 *
 * Constant SOCKET_ECANCELED, defined near the end of this file, belongs to the same family but is defined by Swoole
 * even when PHP extension sockets is installed.
 *
 * @see https://man7.org/linux/man-pages/man3/errno.3.html errno(3)
 * @see \Swoole\Coroutine\Socket::$errCode
 * @see SOCKET_ECANCELED
 */
define('SOCKET_EPERM', 1); // Operation not permitted.
define('SOCKET_ENOENT', 2); // No such file or directory.
define('SOCKET_EINTR', 4); // Interrupted system call.
define('SOCKET_EIO', 5); // I/O error.
define('SOCKET_ENXIO', 6); // No such device or address.
define('SOCKET_E2BIG', 7); // Argument list too long.
define('SOCKET_EBADF', 9); // Bad file descriptor.
define('SOCKET_EAGAIN', 11); // Try again: the operation would block.
define('SOCKET_ENOMEM', 12); // Out of memory.
define('SOCKET_EACCES', 13); // Permission denied.
define('SOCKET_EFAULT', 14); // Bad address.
define('SOCKET_ENOTBLK', 15); // Block device required.
define('SOCKET_EBUSY', 16); // Device or resource busy.
define('SOCKET_EEXIST', 17); // File exists.
define('SOCKET_EXDEV', 18); // Cross-device link.
define('SOCKET_ENODEV', 19); // No such device.
define('SOCKET_ENOTDIR', 20); // Not a directory.
define('SOCKET_EISDIR', 21); // Is a directory.
define('SOCKET_EINVAL', 22); // Invalid argument.
define('SOCKET_ENFILE', 23); // Too many open files in the system.
define('SOCKET_EMFILE', 24); // Too many open files in the process.
define('SOCKET_ENOTTY', 25); // Inappropriate I/O control operation.
define('SOCKET_ENOSPC', 28); // No space left on device.
define('SOCKET_ESPIPE', 29); // Illegal seek.
define('SOCKET_EROFS', 30); // Read-only file system.
define('SOCKET_EMLINK', 31); // Too many links.
define('SOCKET_EPIPE', 32); // Broken pipe.
define('SOCKET_ENAMETOOLONG', 36); // File name too long.
define('SOCKET_ENOLCK', 37); // No locks available.
define('SOCKET_ENOSYS', 38); // Function not implemented.
define('SOCKET_ENOTEMPTY', 39); // Directory not empty.
define('SOCKET_ELOOP', 40); // Too many levels of symbolic links.
define('SOCKET_EWOULDBLOCK', 11); // Operation would block; same value as SOCKET_EAGAIN on Linux.
define('SOCKET_ENOMSG', 42); // No message of the desired type.
define('SOCKET_EIDRM', 43); // Identifier removed.
define('SOCKET_ECHRNG', 44); // Channel number out of range.
define('SOCKET_EL2NSYNC', 45); // Level 2 not synchronized.
define('SOCKET_EL3HLT', 46); // Level 3 halted.
define('SOCKET_EL3RST', 47); // Level 3 reset.
define('SOCKET_ELNRNG', 48); // Link number out of range.
define('SOCKET_EUNATCH', 49); // Protocol driver not attached.
define('SOCKET_ENOCSI', 50); // No CSI structure available.
define('SOCKET_EL2HLT', 51); // Level 2 halted.
define('SOCKET_EBADE', 52); // Invalid exchange.
define('SOCKET_EBADR', 53); // Invalid request descriptor.
define('SOCKET_EXFULL', 54); // Exchange full.
define('SOCKET_ENOANO', 55); // No anode.
define('SOCKET_EBADRQC', 56); // Invalid request code.
define('SOCKET_EBADSLT', 57); // Invalid slot.
define('SOCKET_ENOSTR', 60); // Device not a stream.
define('SOCKET_ENODATA', 61); // No data available.
define('SOCKET_ETIME', 62); // Timer expired.
define('SOCKET_ENOSR', 63); // Out of stream resources.
define('SOCKET_ENONET', 64); // Machine is not on the network.
define('SOCKET_EREMOTE', 66); // Object is remote.
define('SOCKET_ENOLINK', 67); // Link has been severed.
define('SOCKET_EADV', 68); // Advertise error.
define('SOCKET_ESRMNT', 69); // Srmount error.
define('SOCKET_ECOMM', 70); // Communication error on send.
define('SOCKET_EPROTO', 71); // Protocol error.
define('SOCKET_EMULTIHOP', 72); // Multihop attempted.
define('SOCKET_EBADMSG', 74); // Bad message.
define('SOCKET_ENOTUNIQ', 76); // Name not unique on network.
define('SOCKET_EBADFD', 77); // File descriptor in bad state.
define('SOCKET_EREMCHG', 78); // Remote address changed.
define('SOCKET_ERESTART', 85); // Interrupted system call should be restarted.
define('SOCKET_ESTRPIPE', 86); // Streams pipe error.
define('SOCKET_EUSERS', 87); // Too many users.
define('SOCKET_ENOTSOCK', 88); // The file descriptor is not a socket.
define('SOCKET_EDESTADDRREQ', 89); // Destination address required.
define('SOCKET_EMSGSIZE', 90); // Message too long.
define('SOCKET_EPROTOTYPE', 91); // Protocol wrong type for socket.
define('SOCKET_ENOPROTOOPT', 92); // Protocol option not available.
define('SOCKET_EPROTONOSUPPORT', 93); // Protocol not supported.
define('SOCKET_ESOCKTNOSUPPORT', 94); // Socket type not supported.
define('SOCKET_EOPNOTSUPP', 95); // Operation not supported on the socket.
define('SOCKET_EPFNOSUPPORT', 96); // Protocol family not supported.
define('SOCKET_EAFNOSUPPORT', 97); // Address family not supported by protocol.
define('SOCKET_EADDRINUSE', 98); // Address already in use.
define('SOCKET_EADDRNOTAVAIL', 99); // Cannot assign requested address.
define('SOCKET_ENETDOWN', 100); // Network is down.
define('SOCKET_ENETUNREACH', 101); // Network is unreachable.
define('SOCKET_ENETRESET', 102); // Network dropped connection because of reset.
define('SOCKET_ECONNABORTED', 103); // Software caused connection abort.
define('SOCKET_ECONNRESET', 104); // Connection reset by peer.
define('SOCKET_ENOBUFS', 105); // No buffer space available.
define('SOCKET_EISCONN', 106); // The socket is already connected.
define('SOCKET_ENOTCONN', 107); // The socket is not connected.
define('SOCKET_ESHUTDOWN', 108); // Cannot send after socket shutdown.
define('SOCKET_ETOOMANYREFS', 109); // Too many references: cannot splice.
define('SOCKET_ETIMEDOUT', 110); // Connection timed out.
define('SOCKET_ECONNREFUSED', 111); // Connection refused.
define('SOCKET_EHOSTDOWN', 112); // Host is down.
define('SOCKET_EHOSTUNREACH', 113); // No route to host.
define('SOCKET_EALREADY', 114); // Operation already in progress.
define('SOCKET_EINPROGRESS', 115); // Operation now in progress.
define('SOCKET_EISNAM', 120); // Is a named type file.
define('SOCKET_EREMOTEIO', 121); // Remote I/O error.
define('SOCKET_EDQUOT', 122); // Disk quota exceeded.
define('SOCKET_ENOMEDIUM', 123); // No medium found.
define('SOCKET_EMEDIUMTYPE', 124); // Wrong medium type.
// Protocol levels/numbers, to tell which protocol layer a socket option (or a new socket) applies to.
define('IPPROTO_IP', 0); // Option level for IPv4-level options.
define('IPPROTO_IPV6', 41); // Option level for IPv6-level options.
define('SOL_TCP', 6); // Option level for TCP-level options.
define('SOL_UDP', 17); // Option level for UDP-level options.
define('IPV6_UNICAST_HOPS', 16); // Socket option: hop limit of outgoing IPv6 unicast packets.
/*
 * Address-info flags. They adjust how host names and service names are resolved into socket addresses (e.g., by
 * function socket_addrinfo_lookup() of PHP extension sockets).
 *
 * @see https://man7.org/linux/man-pages/man3/getaddrinfo.3.html getaddrinfo(3)
 */
define('AI_PASSIVE', 1); // Resolve to an address suitable for binding a listening socket.
define('AI_CANONNAME', 2); // Also return the canonical name of the host.
define('AI_NUMERICHOST', 4); // The host must be a numeric address string; no name lookup is performed.
#ifdef AI_V4MAPPED
define('AI_V4MAPPED', 8); // If no IPv6 addresses are found, return IPv4 addresses mapped into IPv6 format.
#endif
#ifdef AI_ALL
define('AI_ALL', 16); // Together with AI_V4MAPPED, return both IPv6 and mapped IPv4 addresses.
#endif
define('AI_ADDRCONFIG', 32); // Return addresses of a family only when the system has an address of that family configured.
#ifdef AI_IDN
define('AI_IDN', 64); // Convert internationalized domain names to their ASCII form before resolving.
define('AI_CANONIDN', 128); // Convert the returned canonical name back from ASCII to its internationalized form.
#endif
#ifdef AI_NUMERICSERV
define('AI_NUMERICSERV', 1024); // The service must be given as a numeric port string; no service name lookup is performed.
#endif

define('SWOOLE_MSGQUEUE_ORIENT', 1); // @since v5.0.3
define('SWOOLE_MSGQUEUE_BALANCE', 2); // @since v5.0.3

/*
 * Coroutine-related constants.
 */
/*
 * Maximum number of coroutines that can be created by default.
 *
 * The number can be overridden by explicitly setting one of the following two runtime options:
 *   - \Swoole\Constant::OPTION_MAX_CORO_NUM
 *   - \Swoole\Constant::OPTION_MAX_COROUTINE
 */
define('SWOOLE_DEFAULT_MAX_CORO_NUM', 100000);
define('SWOOLE_CORO_MAX_NUM_LIMIT', PHP_INT_MAX); // Not used anywhere.
// States of a coroutine. There are four states: SWOOLE_CORO_INIT, SWOOLE_CORO_WAITING, SWOOLE_CORO_RUNNING, and SWOOLE_CORO_END.
define('SWOOLE_CORO_INIT', 0);
define('SWOOLE_CORO_WAITING', 1);
define('SWOOLE_CORO_RUNNING', 2);
define('SWOOLE_CORO_END', 3);

/*
 * Exit flags.
 *
 * When exit() is called in Swoole illegally, Swoole throws out a \Swoole\ExitException exception, with exit flags set
 * on property $flags.
 *
 * @see \Swoole\ExitException::$flags
 */
define('SWOOLE_EXIT_IN_COROUTINE', 2); // exit() is called inside a coroutine.
define('SWOOLE_EXIT_IN_SERVER', 4); // exit() is called after Swoole server is started.

/*
 * Error codes of channels. They are used in method \Swoole\Coroutine\Channel::push() and \Swoole\Coroutine\Channel::pop() only.
 *
 * @see \Swoole\Coroutine\Channel::push()
 * @see \Swoole\Coroutine\Channel::pop()
 */
define('SWOOLE_CHANNEL_OK', 0);
define('SWOOLE_CHANNEL_TIMEOUT', -1);
define('SWOOLE_CHANNEL_CLOSED', -2);
define('SWOOLE_CHANNEL_CANCELED', -3);

/*
 * Runtime hook flags.
 */
define('SWOOLE_HOOK_TCP', 2); // 2^1
define('SWOOLE_HOOK_UDP', 4); // 2^2
define('SWOOLE_HOOK_UNIX', 8); // 2^3
define('SWOOLE_HOOK_UDG', 16); // 2^4
define('SWOOLE_HOOK_SSL', 32); // 2^5
define('SWOOLE_HOOK_TLS', 64); // 2^6
/*
 * Runtime hook flag SWOOLE_HOOK_STREAM_FUNCTION makes the following PHP functions coroutine-friendly:
 *   - stream_select()
 *   - stream_socket_pair()
 */
define('SWOOLE_HOOK_STREAM_FUNCTION', 128);  // 2^7
/*
 * Runtime hook flag SWOOLE_HOOK_STREAM_SELECT is the former name of SWOOLE_HOOK_STREAM_FUNCTION, kept around only so
 * that older code keeps working. It has exactly the same value as SWOOLE_HOOK_STREAM_FUNCTION, so the two can be used
 * interchangeably.
 *
 * @deprecated 4.4.0 Use constant SWOOLE_HOOK_STREAM_FUNCTION instead.
 * @see SWOOLE_HOOK_STREAM_FUNCTION
 */
define('SWOOLE_HOOK_STREAM_SELECT', SWOOLE_HOOK_STREAM_FUNCTION);
/*
 * When enabled, runtime hook flag SWOOLE_HOOK_FILE replaces the plain files wrapper from PHP with the one from Swoole,
 * making blocking file system operations on local files coroutine-friendly. The whole wrapper is replaced, which
 * covers:
 *   - opening, reading and writing files: fopen(), fread(), fgets(), fgetc(), fwrite(), fputs(), fseek(), ftell(),
 *     feof(), fflush(), flock(), fclose(), file(), readfile(), file_get_contents(), file_put_contents(), copy(), and
 *     class \SplFileObject.
 *   - reading file information: stat(), lstat(), file_exists(), is_file(), is_dir(), is_readable(), is_writable(),
 *     filesize(), filemtime(), and the other file information functions.
 *   - reading directories: opendir(), readdir(), closedir(), scandir(), and class \DirectoryIterator.
 *   - modifying the file system: unlink(), rename(), mkdir(), rmdir(), touch(), chmod(), chown(), and chgrp().
 *
 * Files loaded through include, include_once, require, and require_once are deliberately left out; they are always
 * read using the original blocking implementation from PHP.
 *
 * By default the underlying file operations are carried out in a thread pool (function swoole_async_set() is used to
 * size that pool), or through io_uring when Swoole is installed with option "--enable-iouring" included.
 *
 * Since Swoole 6.1.2, the same coroutine-friendly file operations can also be requested for one specific file at a
 * time, without enabling this hook flag globally: prefix the file path with the "async.file://" stream protocol
 * (registered by Swoole), e.g.,
 *
 * ```php
 * $content = file_get_contents('async.file:///path/to/file.txt');
 * ```
 *
 * @see swoole_async_set()
 * @see SWOOLE_HOOK_STDIO
 */
define('SWOOLE_HOOK_FILE', 256); // 2^8
/*
 * Runtime hook flag SWOOLE_HOOK_SLEEP makes the following PHP functions coroutine-friendly:
 *   - sleep()
 *   - usleep()
 *   - time_nanosleep()
 *   - time_sleep_until()
 */
define('SWOOLE_HOOK_SLEEP', 512); // 2^9
/*
 * Runtime hook flag SWOOLE_HOOK_PROC makes the following PHP functions coroutine-friendly:
 *   - proc_open()
 *   - proc_close()
 *   - proc_get_status()
 *   - proc_terminate()
 */
define('SWOOLE_HOOK_PROC', 1024); // 2^10
/*
 * Runtime hook flag SWOOLE_HOOK_CURL makes the following PHP functions coroutine-friendly by replacing them internally
 * with functions from Swoole Library:
 *   - curl_init(): replaced with function swoole_curl_init().
 *   - curl_setopt(): replaced with function swoole_curl_setopt().
 *   - curl_setopt_array(): replaced with function swoole_curl_setopt_array().
 *   - curl_exec(): replaced with function swoole_curl_exec().
 *   - curl_getinfo(): replaced with function swoole_curl_getinfo().
 *   - curl_errno(): replaced with function swoole_curl_errno().
 *   - curl_error(): replaced with function swoole_curl_error().
 *   - curl_reset(): replaced with function swoole_curl_reset().
 *   - curl_close(): replaced with function swoole_curl_close().
 *   - curl_multi_getcontent(): replaced with function swoole_curl_multi_getcontent().
 *
 * It's not recommended to use this flag since it doesn't fully support all the features of the original PHP cURL
 * extension. Please use flag SWOOLE_HOOK_NATIVE_CURL instead.
 */
define('SWOOLE_HOOK_CURL', 2048); // 2^11
/*
 * Runtime hook flag SWOOLE_HOOK_NATIVE_CURL makes the following PHP functions coroutine-friendly:
 *   - curl_close()
 *   - curl_copy_handle()
 *   - curl_errno()
 *   - curl_error()
 *   - curl_exec()
 *   - curl_getinfo()
 *   - curl_init()
 *   - curl_setopt()
 *   - curl_setopt_array()
 *   - curl_reset()
 *   - curl_pause()
 *   - curl_escape()
 *   - curl_unescape()
 *   - curl_multi_init()
 *   - curl_multi_add_handle()
 *   - curl_multi_exec()
 *   - curl_multi_errno()
 *   - curl_multi_select()
 *   - curl_multi_setopt()
 *   - curl_multi_getcontent()
 *   - curl_multi_info_read()
 *   - curl_multi_remove_handle()
 *   - curl_multi_close()
 *
 * Runtime hook flag SWOOLE_HOOK_NATIVE_CURL can be enabled only when Swoole is installed with option "--enable-swoole-curl"
 * included. It's recommended to use this flag instead of flag SWOOLE_HOOK_CURL.
 */
define('SWOOLE_HOOK_NATIVE_CURL', 4096); // 2^12
/*
 * Runtime hook flag SWOOLE_HOOK_SOCKETS makes the following PHP functions coroutine-friendly by replacing them
 * internally with functions from Swoole Library:
 *   - socket_create(): replaced with function swoole_socket_create().
 *   - socket_create_listen(): replaced with function swoole_socket_create_listen().
 *   - socket_create_pair(): replaced with function swoole_socket_create_pair().
 *   - socket_connect(): replaced with function swoole_socket_connect().
 *   - socket_write(): replaced with function swoole_socket_write().
 *   - socket_read(): replaced with function swoole_socket_read().
 *   - socket_send(): replaced with function swoole_socket_send().
 *   - socket_recv(): replaced with function swoole_socket_recv().
 *   - socket_sendto(): replaced with function swoole_socket_sendto().
 *   - socket_recvfrom(): replaced with function swoole_socket_recvfrom().
 *   - socket_bind(): replaced with function swoole_socket_bind().
 *   - socket_listen(): replaced with function swoole_socket_listen().
 *   - socket_accept(): replaced with function swoole_socket_accept().
 *   - socket_getpeername(): replaced with function swoole_socket_getpeername().
 *   - socket_getsockname(): replaced with function swoole_socket_getsockname().
 *   - socket_getopt(): replaced with function swoole_socket_getopt().
 *   - socket_get_option(): replaced with function swoole_socket_get_option().
 *   - socket_setopt(): replaced with function swoole_socket_setopt().
 *   - socket_set_option(): replaced with function swoole_socket_set_option().
 *   - socket_set_block(): replaced with function swoole_socket_set_block().
 *   - socket_set_nonblock(): replaced with function swoole_socket_set_nonblock().
 *   - socket_shutdown(): replaced with function swoole_socket_shutdown().
 *   - socket_close(): replaced with function swoole_socket_close().
 *   - socket_clear_error(): replaced with function swoole_socket_clear_error().
 *   - socket_last_error(): replaced with function swoole_socket_last_error().
 *   - socket_import_stream(): replaced with function swoole_socket_import_stream().
 *
 * When enabled, it also makes class \Swoole\Coroutine\Socket a child class of built-in PHP class \Socket.
 *
 * The functions listed above come from the PHP "sockets" extension, so this hook has no effect unless that extension
 * is loaded. Since Swoole 6.1.6, this flag is silently dropped from the requested hook flags when the "sockets"
 * extension is not loaded (e.g., passing SWOOLE_HOOK_ALL then behaves like SWOOLE_HOOK_ALL without SWOOLE_HOOK_SOCKETS).
 *
 * @see \Swoole\Coroutine\Socket
 * @see \Socket
 * @see \Swoole\Runtime::setHookFlags()
 */
define('SWOOLE_HOOK_SOCKETS', 16384); // 2^14
/*
 * When enabled, runtime hook flag SWOOLE_HOOK_STDIO replaces the standard I/O stream operations in PHP with those
 * from Swoole, making reads and writes on the following streams coroutine-friendly:
 *   - STDIN, STDOUT, and STDERR, together with their php://stdin, php://stdout, and php://stderr equivalents.
 *   - the pipes returned by popen() and proc_open().
 *
 * A read or write only yields the current coroutine when the underlying file descriptor is pollable (a pipe, a
 * socket, or a character device such as a terminal); on a regular file it falls back to a blocking read or write.
 *
 * This flag is separate from SWOOLE_HOOK_FILE and does not overlap with it: SWOOLE_HOOK_FILE replaces the wrapper
 * used to reach files on the file system, while SWOOLE_HOOK_STDIO replaces the operations used on streams that PHP
 * itself opens from a file descriptor. Either flag can be enabled without the other.
 *
 * @see SWOOLE_HOOK_FILE
 */
define('SWOOLE_HOOK_STDIO', 32768); // 2^15
/*
 * Runtime hook flag SWOOLE_HOOK_PDO_PGSQL makes the PDO_PGSQL driver coroutine-friendly. This flag is available only
 * when Swoole is installed with option "--enable-swoole-pgsql" included.
 *
 * @since 5.1.0
 */
define('SWOOLE_HOOK_PDO_PGSQL', 65536); // 2^16
/*
 * Runtime hook flag SWOOLE_HOOK_PDO_ODBC makes the PDO_ODBC driver coroutine-friendly. This flag is available only when
 * Swoole is installed with option "--with-swoole-odbc" included.
 *
 * @since 5.1.0
 */
define('SWOOLE_HOOK_PDO_ODBC', 131072); // 2^17
/*
 * Runtime hook flag SWOOLE_HOOK_PDO_ORACLE makes the PDO_OCI driver coroutine-friendly. This flag is available only
 * when Swoole is installed with option "--with-swoole-oracle" included.
 *
 * @since 5.1.0
 */
define('SWOOLE_HOOK_PDO_ORACLE', 262144); // 2^18
/*
 * Runtime hook flag SWOOLE_HOOK_PDO_SQLITE makes the PDO_SQLITE driver coroutine-friendly. This flag is available only
 * when Swoole is installed with option "--enable-swoole-sqlite" included.
 *
 * @since 5.1.0
 */
define('SWOOLE_HOOK_PDO_SQLITE', 524288); // 2^19
/*
 * Runtime hook flag SWOOLE_HOOK_PDO_FIREBIRD makes the PDO_FIREBIRD driver coroutine-friendly. This flag is available
 * only when Swoole is installed with option "--with-swoole-firebird" included.
 *
 * @since 6.2.0
 */
define('SWOOLE_HOOK_PDO_FIREBIRD', 1048576); // 2^20
/*
 * Runtime hook flag SWOOLE_HOOK_NET_FUNCTION makes the following networking-related PHP functions coroutine-friendly
 * by replacing them internally:
 *   - gethostbyname(): replaced with method Swoole\Coroutine::gethostbyname().
 *   - gethostbynamel(): replaced with function swoole_gethostbynamel() from Swoole Library.
 *   - gethostbyaddr(): replaced with function swoole_gethostbyaddr() from Swoole Library.
 *   - mail(): replaced with function swoole_mail() from Swoole Library.
 *   - dns_check_record() and checkdnsrr(): replaced with functions swoole_dns_check_record() and swoole_checkdnsrr()
 *     from Swoole Library.
 *   - dns_get_mx() and getmxrr(): replaced with functions swoole_dns_get_mx() and swoole_getmxrr() from Swoole Library.
 *   - dns_get_record(): replaced with function swoole_dns_get_record() from Swoole Library.
 *
 * Most of the replacement functions above don't perform the work in the current process; they forward the call to a
 * small helper server that Swoole Library starts on demand (using class Swoole\RemoteObject\Server), so that the
 * original blocking implementation runs elsewhere while the current coroutine only waits for the result.
 *
 * Before Swoole 6.2.0, the gethostbyname() replacement was part of the (now removed) runtime hook flag
 * SWOOLE_HOOK_BLOCKING_FUNCTION; the exec() and shell_exec() replacements that flag also provided were dropped in
 * Swoole 6.2.0 and are no longer available through any hook flag.
 *
 * This flag only takes effect when Swoole Library is enabled (ini option "swoole.enable_library", on by default); it
 * is silently dropped from the requested hook flags otherwise.
 *
 * @since 6.2.0
 * @see \Swoole\Coroutine::gethostbyname()
 */
define('SWOOLE_HOOK_NET_FUNCTION', 2097152); // 2^21
/*
 * Runtime hook flag SWOOLE_HOOK_MONGODB makes MongoDB operations coroutine-friendly. When enabled, it registers class
 * Swoole\MongoDB\Client (from Swoole Library) under the alias "MongoDB\Client", unless a class with that name already
 * exists. The Swoole\MongoDB\Client class is a proxy: it forwards MongoDB operations to a small helper server that
 * Swoole Library starts on demand (using class Swoole\RemoteObject\Server), so that the blocking MongoDB driver runs
 * elsewhere while the current coroutine only waits for the result.
 *
 * Unlike most other hook flags, this flag is NOT included in SWOOLE_HOOK_ALL; it must be enabled explicitly.
 *
 * This flag only takes effect when Swoole Library is enabled (ini option "swoole.enable_library", on by default); it
 * is silently dropped from the requested hook flags otherwise.
 *
 * @since 6.2.0
 */
define('SWOOLE_HOOK_MONGODB', 4194304); // 2^22
/*
 * There are two different hook flags for PHP's cURL functions:
 *   - SWOOLE_HOOK_CURL: Implemented by replacing PHP's cURL functions internally with swoole_curl_*() functions from Swoole Library.
 *   - SWOOLE_HOOK_NATIVE_CURL (recommended): Implemented using libcurl (the curl library).
 *
 * Only one of the two runtime hook flags can be enabled at a time. SWOOLE_HOOK_NATIVE_CURL can be enabled only when
 * Swoole is installed with option "--enable-swoole-curl" included.
 * When Swoole is installed with option "--enable-swoole-curl" included, SWOOLE_HOOK_ALL also enables SWOOLE_HOOK_NATIVE_CURL;
 * otherwise, it enables SWOOLE_HOOK_CURL.
 *
 * Since Swoole 6.2.0, SWOOLE_HOOK_ALL also excludes SWOOLE_HOOK_MONGODB, which must be enabled explicitly.
 *
 * Class Swoole\Coroutine\Curl\Exception is defined only when option "--enable-swoole-curl" is included during installation.
 *
 * @see SWOOLE_HOOK_MONGODB
 */
if (class_exists(Swoole\Coroutine\Curl\Exception::class)) { // When Swoole is installed with option "--enable-swoole-curl" included.
    define('SWOOLE_HOOK_ALL', 0x7FFFFFFF & ~SWOOLE_HOOK_CURL & ~SWOOLE_HOOK_MONGODB);
} else {
    define('SWOOLE_HOOK_ALL', 0x7FFFFFFF & ~SWOOLE_HOOK_NATIVE_CURL & ~SWOOLE_HOOK_MONGODB);
}

/*
 * An asynchronous socket operation was canceled before it completed. The value varies among different systems; the
 * value shown here is for Linux.
 *
 * Unlike the other SOCKET_E* constants defined earlier in this file, this constant is defined by Swoole even when PHP
 * extension sockets is installed, since that extension does not define it.
 *
 * A typical use case of this constant can be found in class Swoole\Coroutine\Server.
 *
 * @see Swoole\Coroutine\Server::start()
 */
define('SOCKET_ECANCELED', 125);

/*
 * A TCP-level socket option (used with option level SOL_TCP) to read detailed state information about a TCP
 * connection, e.g., through method \Swoole\Coroutine\Socket::getOption(). The value varies among different systems;
 * the value shown here is for Linux.
 *
 * Like SOCKET_ECANCELED, this constant is defined by Swoole even when PHP extension sockets is installed, since that
 * extension does not define it.
 *
 * @see https://man7.org/linux/man-pages/man7/tcp.7.html tcp(7)
 * @see \Swoole\Coroutine\Socket::getOption()
 */
define('TCP_INFO', 11); // @since v6.0.0

/*
 * Constants in this section are used in Swoole servers.
 */

// Server modes. For details, please check documentation on property \Swoole\Server::$mode.
define('SWOOLE_BASE', 1);
define('SWOOLE_PROCESS', 2);
// Constant SWOOLE_THREAD is available only when PHP is compiled with Zend Thread Safety (ZTS) enabled and Swoole is
// installed with the "--enable-swoole-thread" configuration option.
define('SWOOLE_THREAD', 3); // @since v6.0.0

// Types of processes in Swoole server that handle commands.
define('SWOOLE_SERVER_COMMAND_MASTER', 2); // 2^1
define('SWOOLE_SERVER_COMMAND_REACTOR_THREAD', 4); // 2^2
define('SWOOLE_SERVER_COMMAND_EVENT_WORKER', 8); // 2^3
define('SWOOLE_SERVER_COMMAND_WORKER', SWOOLE_SERVER_COMMAND_EVENT_WORKER); // 2^3
define('SWOOLE_SERVER_COMMAND_TASK_WORKER', 16); // 2^4
define('SWOOLE_SERVER_COMMAND_MANAGER', 32); // 2^5
// Dispatch modes in Swoole server. They define how the server dispatches requests to worker processes.
define('SWOOLE_DISPATCH_ROUND', 1);
define('SWOOLE_DISPATCH_FDMOD', 2);
define('SWOOLE_DISPATCH_IDLE_WORKER', 3);
define('SWOOLE_DISPATCH_IPMOD', 4);
define('SWOOLE_DISPATCH_UIDMOD', 5);
define('SWOOLE_DISPATCH_USERFUNC', 6);
/*
 * The dispatch mode this constant used to select was dropped from Swoole in version 5.0.3; only the constant itself is
 * still defined, so that older code referring to it keeps working. Setting it as the server's "dispatch_mode" option no
 * longer has a dispatch mode of its own behind it, and the server falls back to handing each request to whichever
 * worker process is idle, i.e., it behaves the same as SWOOLE_DISPATCH_IDLE_WORKER.
 *
 * @deprecated 5.0.3 Use constant SWOOLE_DISPATCH_IDLE_WORKER (or another dispatch mode that suits the server) instead.
 * @see SWOOLE_DISPATCH_IDLE_WORKER
 */
define('SWOOLE_DISPATCH_STREAM', 7);
define('SWOOLE_DISPATCH_CO_CONN_LB', 8);
define('SWOOLE_DISPATCH_CO_REQ_LB', 9);
define('SWOOLE_DISPATCH_CONCURRENT_LB', 10);
// Results when dispatching a request to a worker process in Swoole server.
define('SWOOLE_DISPATCH_RESULT_DISCARD_PACKET', -1);
define('SWOOLE_DISPATCH_RESULT_CLOSE_CONNECTION', -2);
define('SWOOLE_DISPATCH_RESULT_USERFUNC_FALLBACK', -3);
// Task flags.
define('SWOOLE_TASK_TMPFILE', 1); // 2^0
define('SWOOLE_TASK_SERIALIZE', 2); // 2^1
define('SWOOLE_TASK_NONBLOCK', 4); // 2^2
define('SWOOLE_TASK_CALLBACK', 8); // 2^3
define('SWOOLE_TASK_WAITALL', 16); // 2^4
define('SWOOLE_TASK_COROUTINE', 32); // 2^5
define('SWOOLE_TASK_PEEK', 64); // 2^6
define('SWOOLE_TASK_NOREPLY', 128); // 2^7
// Statuses of worker processes in Swoole server.
define('SWOOLE_WORKER_BUSY', 1);
define('SWOOLE_WORKER_IDLE', 2);
define('SWOOLE_WORKER_EXIT', 3);

/*
 * Status code of the last operation in class \Swoole\Coroutine\Http\Client.
 *
 * @see \Swoole\Coroutine\Http\Client
 * @see \Swoole\Coroutine\Http\Client::$statusCode
 */
define('SWOOLE_HTTP_CLIENT_ESTATUS_CONNECT_FAILED', -1);
define('SWOOLE_HTTP_CLIENT_ESTATUS_REQUEST_TIMEOUT', -2);
define('SWOOLE_HTTP_CLIENT_ESTATUS_SERVER_RESET', -3);
define('SWOOLE_HTTP_CLIENT_ESTATUS_SEND_FAILED', -4);

// HTTP 2 frame types.
// @see https://datatracker.ietf.org/doc/html/rfc7540#section-6 Frame Definitions
define('SWOOLE_HTTP2_TYPE_DATA', 0);
define('SWOOLE_HTTP2_TYPE_HEADERS', 1);
define('SWOOLE_HTTP2_TYPE_PRIORITY', 2);
define('SWOOLE_HTTP2_TYPE_RST_STREAM', 3);
define('SWOOLE_HTTP2_TYPE_SETTINGS', 4);
define('SWOOLE_HTTP2_TYPE_PUSH_PROMISE', 5);
define('SWOOLE_HTTP2_TYPE_PING', 6);
define('SWOOLE_HTTP2_TYPE_GOAWAY', 7);
define('SWOOLE_HTTP2_TYPE_WINDOW_UPDATE', 8);
define('SWOOLE_HTTP2_TYPE_CONTINUATION', 9);

// HTTP 2 error codes.
// @see https://datatracker.ietf.org/doc/html/rfc7540#section-7 Error Codes
define('SWOOLE_HTTP2_ERROR_NO_ERROR', 0);
define('SWOOLE_HTTP2_ERROR_PROTOCOL_ERROR', 1);
define('SWOOLE_HTTP2_ERROR_INTERNAL_ERROR', 2);
define('SWOOLE_HTTP2_ERROR_FLOW_CONTROL_ERROR', 3);
define('SWOOLE_HTTP2_ERROR_SETTINGS_TIMEOUT', 4);
define('SWOOLE_HTTP2_ERROR_STREAM_CLOSED', 5);
define('SWOOLE_HTTP2_ERROR_FRAME_SIZE_ERROR', 6);
define('SWOOLE_HTTP2_ERROR_REFUSED_STREAM', 7);
define('SWOOLE_HTTP2_ERROR_CANCEL', 8);
define('SWOOLE_HTTP2_ERROR_COMPRESSION_ERROR', 9);
define('SWOOLE_HTTP2_ERROR_CONNECT_ERROR', 10);
define('SWOOLE_HTTP2_ERROR_ENHANCE_YOUR_CALM', 11);
define('SWOOLE_HTTP2_ERROR_INADEQUATE_SECURITY', 12);
define('SWOOLE_HTTP2_ERROR_HTTP_1_1_REQUIRED', 13); // Added in Swoole 5.0.1.

// WebSocket flags.
define('SWOOLE_WEBSOCKET_FLAG_FIN', 1);
define('SWOOLE_WEBSOCKET_FLAG_RSV1', 4);
define('SWOOLE_WEBSOCKET_FLAG_RSV2', 8);
define('SWOOLE_WEBSOCKET_FLAG_RSV3', 16);
define('SWOOLE_WEBSOCKET_FLAG_MASK', 32);
define('SWOOLE_WEBSOCKET_FLAG_COMPRESS', 2); // Used to indicate if a frame is compressed or not.

/*
 * WebSocket connection status. They are used as value of field "websocket_status" in the array returned from method
 * \Swoole\Server::getClientInfo().
 *
 * @see \Swoole\Server::getClientInfo()
 * @see \Swoole\Server::connection_info()
 */
define('SWOOLE_WEBSOCKET_STATUS_CONNECTION', 1);
define('SWOOLE_WEBSOCKET_STATUS_HANDSHAKE', 2);
define('SWOOLE_WEBSOCKET_STATUS_ACTIVE', 3);
define('SWOOLE_WEBSOCKET_STATUS_CLOSING', 4);
/*
 * Next six constants are kept for backward compatibility.
 *
 * The last one means the handshake between the client and the server failed, so the connection never became a working
 * WebSocket connection. Unlike the other five, it has no counterpart carrying the "SWOOLE_" prefix.
 */
define('WEBSOCKET_STATUS_CONNECTION', SWOOLE_WEBSOCKET_STATUS_CONNECTION);
define('WEBSOCKET_STATUS_HANDSHAKE', SWOOLE_WEBSOCKET_STATUS_HANDSHAKE);
define('WEBSOCKET_STATUS_FRAME', SWOOLE_WEBSOCKET_STATUS_ACTIVE);
define('WEBSOCKET_STATUS_ACTIVE', SWOOLE_WEBSOCKET_STATUS_ACTIVE);
define('WEBSOCKET_STATUS_CLOSING', SWOOLE_WEBSOCKET_STATUS_CLOSING);
define('WEBSOCKET_STATUS_HANDSHAKE_FAILED', 5); // @since 6.1.0

// WebSocket opcodes.
// @see https://datatracker.ietf.org/doc/html/rfc6455#section-11.8 WebSocket Opcode Registry
define('SWOOLE_WEBSOCKET_OPCODE_CONTINUATION', 0);
define('SWOOLE_WEBSOCKET_OPCODE_TEXT', 1);
define('SWOOLE_WEBSOCKET_OPCODE_BINARY', 2);
define('SWOOLE_WEBSOCKET_OPCODE_CLOSE', 8);
define('SWOOLE_WEBSOCKET_OPCODE_PING', 9);
define('SWOOLE_WEBSOCKET_OPCODE_PONG', 10);
// Next six constants are kept for backward compatibility.
define('WEBSOCKET_OPCODE_CONTINUATION', SWOOLE_WEBSOCKET_OPCODE_CONTINUATION);
define('WEBSOCKET_OPCODE_TEXT', SWOOLE_WEBSOCKET_OPCODE_TEXT);
define('WEBSOCKET_OPCODE_BINARY', SWOOLE_WEBSOCKET_OPCODE_BINARY);
define('WEBSOCKET_OPCODE_CLOSE', SWOOLE_WEBSOCKET_OPCODE_CLOSE);
define('WEBSOCKET_OPCODE_PING', SWOOLE_WEBSOCKET_OPCODE_PING);
define('WEBSOCKET_OPCODE_PONG', SWOOLE_WEBSOCKET_OPCODE_PONG);

// WebSocket status codes.
// @see https://datatracker.ietf.org/doc/html/rfc6455#section-7.4.1 Status Code Definitions
define('SWOOLE_WEBSOCKET_CLOSE_NORMAL', 1000);
define('SWOOLE_WEBSOCKET_CLOSE_GOING_AWAY', 1001);
define('SWOOLE_WEBSOCKET_CLOSE_PROTOCOL_ERROR', 1002);
define('SWOOLE_WEBSOCKET_CLOSE_DATA_ERROR', 1003);
define('SWOOLE_WEBSOCKET_CLOSE_STATUS_ERROR', 1005);
define('SWOOLE_WEBSOCKET_CLOSE_ABNORMAL', 1006);
define('SWOOLE_WEBSOCKET_CLOSE_MESSAGE_ERROR', 1007);
define('SWOOLE_WEBSOCKET_CLOSE_POLICY_ERROR', 1008);
define('SWOOLE_WEBSOCKET_CLOSE_MESSAGE_TOO_BIG', 1009);
define('SWOOLE_WEBSOCKET_CLOSE_EXTENSION_MISSING', 1010);
define('SWOOLE_WEBSOCKET_CLOSE_SERVER_ERROR', 1011);
define('SWOOLE_WEBSOCKET_CLOSE_CLOSE_SERVICE_RESTART', 1012); // @since v5.1.2
define('SWOOLE_WEBSOCKET_CLOSE_TRY_AGAIN_LATER', 1013); // @since v5.1.2
define('SWOOLE_WEBSOCKET_CLOSE_BAD_GATEWAY', 1014); // @since v5.1.2
define('SWOOLE_WEBSOCKET_CLOSE_TLS', 1015);
// Next twelve constants are kept for backward compatibility.
define('WEBSOCKET_CLOSE_NORMAL', SWOOLE_WEBSOCKET_CLOSE_NORMAL);
define('WEBSOCKET_CLOSE_GOING_AWAY', SWOOLE_WEBSOCKET_CLOSE_GOING_AWAY);
define('WEBSOCKET_CLOSE_PROTOCOL_ERROR', SWOOLE_WEBSOCKET_CLOSE_PROTOCOL_ERROR);
define('WEBSOCKET_CLOSE_DATA_ERROR', SWOOLE_WEBSOCKET_CLOSE_DATA_ERROR);
define('WEBSOCKET_CLOSE_STATUS_ERROR', SWOOLE_WEBSOCKET_CLOSE_STATUS_ERROR);
define('WEBSOCKET_CLOSE_ABNORMAL', SWOOLE_WEBSOCKET_CLOSE_ABNORMAL);
define('WEBSOCKET_CLOSE_MESSAGE_ERROR', SWOOLE_WEBSOCKET_CLOSE_MESSAGE_ERROR);
define('WEBSOCKET_CLOSE_POLICY_ERROR', SWOOLE_WEBSOCKET_CLOSE_POLICY_ERROR);
define('WEBSOCKET_CLOSE_MESSAGE_TOO_BIG', SWOOLE_WEBSOCKET_CLOSE_MESSAGE_TOO_BIG);
define('WEBSOCKET_CLOSE_EXTENSION_MISSING', SWOOLE_WEBSOCKET_CLOSE_EXTENSION_MISSING);
define('WEBSOCKET_CLOSE_SERVER_ERROR', SWOOLE_WEBSOCKET_CLOSE_SERVER_ERROR);
define('WEBSOCKET_CLOSE_CLOSE_SERVICE_RESTART', SWOOLE_WEBSOCKET_CLOSE_CLOSE_SERVICE_RESTART); // @since v5.1.2
define('WEBSOCKET_CLOSE_TRY_AGAIN_LATER', SWOOLE_WEBSOCKET_CLOSE_TRY_AGAIN_LATER); // @since v5.1.2
define('WEBSOCKET_CLOSE_BAD_GATEWAY', SWOOLE_WEBSOCKET_CLOSE_BAD_GATEWAY); // @since v5.1.2
define('WEBSOCKET_CLOSE_TLS', SWOOLE_WEBSOCKET_CLOSE_TLS);

/*
 * The minimum number of milliseconds that can be used for time-related operations (e.g., timeout, time intervals, etc)
 * in Swoole.
 */
define('SWOOLE_TIMER_MIN_MS', 1);
/*
 * The minimum number of seconds that can be used for time-related operations (e.g., timeout, time intervals, etc) in
 * Swoole.
 */
define('SWOOLE_TIMER_MIN_SEC', 0.001);
/*
 * The maximum number of milliseconds that can be used for time-related operations (e.g., timeout, time intervals, etc)
 * in Swoole. It equals to the maximum signed long integer that the system can hold, and it varies among different systems.
 */
define('SWOOLE_TIMER_MAX_MS', 9223372036854775807);
/*
 * The maximum number of seconds that can be used for time-related operations (e.g., timeout, time intervals, etc) in
 * Swoole. It equals to `(float) SWOOLE_TIMER_MAX_MS / 1000`.
 */
define('SWOOLE_TIMER_MAX_SEC', (float) (SWOOLE_TIMER_MAX_MS / 1000));

/*
 * Constants in this section are for SSL/TLS support. Before Swoole 6.2.0, they were available only when Swoole was
 * installed with configuration option "--enable-openssl" included; since Swoole 6.2.0, that option is gone and
 * OpenSSL support is always built in, so these constants are always available (except for the ones tied to a
 * specific SSL/TLS protocol version, which still depend on the OpenSSL library Swoole was compiled against).
 */
define('SWOOLE_SSL', 512); // 2^9
define('SWOOLE_SSLv3_METHOD', 1);
define('SWOOLE_SSLv3_SERVER_METHOD', 2);
define('SWOOLE_SSLv3_CLIENT_METHOD', 3);
define('SWOOLE_TLSv1_METHOD', 6);
define('SWOOLE_TLSv1_SERVER_METHOD', 7);
define('SWOOLE_TLSv1_CLIENT_METHOD', 8);

#ifdef TLS1_1_VERSION
define('SWOOLE_TLSv1_1_METHOD', 9);
define('SWOOLE_TLSv1_1_SERVER_METHOD', 10);
define('SWOOLE_TLSv1_1_CLIENT_METHOD', 11);
#endif

#ifdef TLS1_2_VERSION
define('SWOOLE_TLSv1_2_METHOD', 12);
define('SWOOLE_TLSv1_2_SERVER_METHOD', 13);
define('SWOOLE_TLSv1_2_CLIENT_METHOD', 14);
#endif

#ifdef SW_SUPPORT_DTLS
define('SWOOLE_DTLS_SERVER_METHOD', 16);
define('SWOOLE_DTLS_CLIENT_METHOD', 15);
#endif

define('SWOOLE_SSLv23_METHOD', 0);
define('SWOOLE_SSLv23_SERVER_METHOD', 4);
define('SWOOLE_SSLv23_CLIENT_METHOD', 5);
define('SWOOLE_TLS_METHOD', 0);
define('SWOOLE_TLS_SERVER_METHOD', 4);
define('SWOOLE_TLS_CLIENT_METHOD', 5);

define('SWOOLE_SSL_SSLv2', 2);

#ifdef HAVE_SSL3
define('SWOOLE_SSL_SSLv3', 4);
#endif

define('SWOOLE_SSL_TLSv1', 8);

#ifdef TLS1_1_VERSION
define('SWOOLE_SSL_TLSv1_1', 16);
#endif

#ifdef TLS1_2_VERSION
define('SWOOLE_SSL_TLSv1_2', 32);
#endif

#ifdef TLS1_3_VERSION
define('SWOOLE_SSL_TLSv1_3', 64);
#endif

#ifdef SW_SUPPORT_DTLS
define('SWOOLE_SSL_DTLS', 128);
#endif
