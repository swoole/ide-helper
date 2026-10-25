<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Server;

use Swoole\Constant;
use Swoole\Coroutine;
use Swoole\Server;
use Swoole\Timer;

class Helper
{
    public const STATS_TIMER_INTERVAL_TIME = 1000;

    public const GLOBAL_OPTIONS = [
        Constant::OPTION_DEBUG_MODE                   => true,
        Constant::OPTION_TRACE_FLAGS                  => true,
        Constant::OPTION_LOG_FILE                     => true,
        Constant::OPTION_LOG_LEVEL                    => true,
        Constant::OPTION_LOG_DATE_FORMAT              => true,
        Constant::OPTION_LOG_DATE_WITH_MICROSECONDS   => true,
        Constant::OPTION_LOG_ROTATION                 => true,
        Constant::OPTION_DISPLAY_ERRORS               => true,
        Constant::OPTION_DNS_SERVER                   => true,
        Constant::OPTION_SOCKET_DNS_TIMEOUT           => true,
        Constant::OPTION_SOCKET_CONNECT_TIMEOUT       => true,
        Constant::OPTION_SOCKET_WRITE_TIMEOUT         => true,
        Constant::OPTION_SOCKET_SEND_TIMEOUT          => true,
        Constant::OPTION_SOCKET_READ_TIMEOUT          => true,
        Constant::OPTION_SOCKET_RECV_TIMEOUT          => true,
        Constant::OPTION_SOCKET_BUFFER_SIZE           => true,
        Constant::OPTION_SOCKET_TIMEOUT               => true,
        Constant::OPTION_HTTP2_HEADER_TABLE_SIZE      => true,
        Constant::OPTION_HTTP2_ENABLE_PUSH            => true,
        Constant::OPTION_HTTP2_MAX_CONCURRENT_STREAMS => true,
        Constant::OPTION_HTTP2_INIT_WINDOW_SIZE       => true,
        Constant::OPTION_HTTP2_MAX_FRAME_SIZE         => true,
        Constant::OPTION_HTTP2_MAX_HEADER_LIST_SIZE   => true,
        Constant::OPTION_HTTP2_MAX_HEADERS            => true,
    ];

    public const SERVER_OPTIONS = [
        Constant::OPTION_CHROOT                      => true,
        Constant::OPTION_USER                        => true,
        Constant::OPTION_GROUP                       => true,
        Constant::OPTION_DAEMONIZE                   => true,
        Constant::OPTION_PID_FILE                    => true,
        Constant::OPTION_REACTOR_NUM                 => true,
        Constant::OPTION_SINGLE_THREAD               => true,
        Constant::OPTION_WORKER_NUM                  => true,
        Constant::OPTION_MAX_WAIT_TIME               => true,
        Constant::OPTION_MAX_QUEUED_BYTES            => true,
        Constant::OPTION_MAX_CONCURRENCY             => true,
        Constant::OPTION_WORKER_MAX_CONCURRENCY      => true,
        Constant::OPTION_ENABLE_COROUTINE            => true,
        Constant::OPTION_SEND_TIMEOUT                => true,
        Constant::OPTION_DISPATCH_MODE               => true,
        Constant::OPTION_SEND_YIELD                  => true,
        Constant::OPTION_DISPATCH_FUNC               => true,
        Constant::OPTION_DISCARD_TIMEOUT_REQUEST     => true,
        Constant::OPTION_ENABLE_UNSAFE_EVENT         => true,
        Constant::OPTION_ENABLE_DELAY_RECEIVE        => true,
        Constant::OPTION_ENABLE_REUSE_PORT           => true,
        Constant::OPTION_TASK_USE_OBJECT             => true,
        Constant::OPTION_TASK_OBJECT                 => true,
        Constant::OPTION_EVENT_OBJECT                => true,
        Constant::OPTION_TASK_ENABLE_COROUTINE       => true,
        Constant::OPTION_TASK_WORKER_NUM             => true,
        Constant::OPTION_TASK_IPC_MODE               => true,
        Constant::OPTION_TASK_TMPDIR                 => true,
        Constant::OPTION_TASK_MAX_REQUEST            => true,
        Constant::OPTION_TASK_MAX_REQUEST_GRACE      => true,
        Constant::OPTION_MAX_CONNECTION              => true,
        Constant::OPTION_MAX_CONN                    => true,
        Constant::OPTION_START_SESSION_ID            => true,
        Constant::OPTION_HEARTBEAT_CHECK_INTERVAL    => true,
        Constant::OPTION_HEARTBEAT_IDLE_TIME         => true,
        Constant::OPTION_MAX_REQUEST                 => true,
        Constant::OPTION_MAX_REQUEST_GRACE           => true,
        Constant::OPTION_RELOAD_ASYNC                => true,
        Constant::OPTION_OPEN_CPU_AFFINITY           => true,
        Constant::OPTION_CPU_AFFINITY_IGNORE         => true,
        Constant::OPTION_HTTP_PARSE_COOKIE           => true,
        Constant::OPTION_HTTP_PARSE_POST             => true,
        Constant::OPTION_HTTP_PARSE_FILES            => true,
        Constant::OPTION_HTTP_COMPRESSION            => true,
        Constant::OPTION_HTTP_COMPRESSION_LEVEL      => true,
        Constant::OPTION_COMPRESSION_LEVEL           => true,
        Constant::OPTION_HTTP_GZIP_LEVEL             => true,
        Constant::OPTION_HTTP_COMPRESSION_MIN_LENGTH => true,
        Constant::OPTION_COMPRESSION_MIN_LENGTH      => true,
        Constant::OPTION_WEBSOCKET_COMPRESSION       => true,
        Constant::OPTION_UPLOAD_TMP_DIR              => true,
        Constant::OPTION_UPLOAD_MAX_FILESIZE         => true,
        Constant::OPTION_ENABLE_STATIC_HANDLER       => true,
        Constant::OPTION_DOCUMENT_ROOT               => true,
        Constant::OPTION_HTTP_AUTOINDEX              => true,
        Constant::OPTION_HTTP_INDEX_FILES            => true,
        Constant::OPTION_HTTP_COMPRESSION_TYPES      => true,
        Constant::OPTION_COMPRESSION_TYPES           => true,
        Constant::OPTION_STATIC_HANDLER_LOCATIONS    => true,
        Constant::OPTION_INPUT_BUFFER_SIZE           => true,
        Constant::OPTION_BUFFER_INPUT_SIZE           => true,
        Constant::OPTION_OUTPUT_BUFFER_SIZE          => true,
        Constant::OPTION_BUFFER_OUTPUT_SIZE          => true,
        Constant::OPTION_MESSAGE_QUEUE_KEY           => true,
        Constant::OPTION_BOOTSTRAP                   => true,
        Constant::OPTION_INIT_ARGUMENTS              => true,
        Constant::OPTION_URL_REWRITE_RULES           => true,
    ];

    public const PORT_OPTIONS = [
        Constant::OPTION_SSL_CERT_FILE                  => true,
        Constant::OPTION_SSL_KEY_FILE                   => true,
        Constant::OPTION_BACKLOG                        => true,
        Constant::OPTION_SOCKET_BUFFER_SIZE             => true,
        Constant::OPTION_KERNEL_SOCKET_RECV_BUFFER_SIZE => true,
        Constant::OPTION_KERNEL_SOCKET_SEND_BUFFER_SIZE => true,
        Constant::OPTION_HEARTBEAT_IDLE_TIME            => true,
        Constant::OPTION_BUFFER_HIGH_WATERMARK          => true,
        Constant::OPTION_BUFFER_LOW_WATERMARK           => true,
        Constant::OPTION_OPEN_TCP_NODELAY               => true,
        Constant::OPTION_TCP_DEFER_ACCEPT               => true,
        Constant::OPTION_OPEN_TCP_KEEPALIVE             => true,
        Constant::OPTION_OPEN_EOF_CHECK                 => true,
        Constant::OPTION_OPEN_EOF_SPLIT                 => true,
        Constant::OPTION_PACKAGE_EOF                    => true,
        Constant::OPTION_OPEN_HTTP_PROTOCOL             => true,
        Constant::OPTION_OPEN_WEBSOCKET_PROTOCOL        => true,
        Constant::OPTION_WEBSOCKET_SUBPROTOCOL          => true,
        Constant::OPTION_OPEN_WEBSOCKET_CLOSE_FRAME     => true,
        Constant::OPTION_OPEN_WEBSOCKET_PING_FRAME      => true,
        Constant::OPTION_OPEN_WEBSOCKET_PONG_FRAME      => true,
        Constant::OPTION_OPEN_HTTP2_PROTOCOL            => true,
        Constant::OPTION_OPEN_MQTT_PROTOCOL             => true,
        Constant::OPTION_OPEN_REDIS_PROTOCOL            => true,
        Constant::OPTION_MAX_IDLE_TIME                  => true,
        Constant::OPTION_TCP_KEEPIDLE                   => true,
        Constant::OPTION_TCP_KEEPINTERVAL               => true,
        Constant::OPTION_TCP_KEEPCOUNT                  => true,
        Constant::OPTION_TCP_USER_TIMEOUT               => true,
        Constant::OPTION_TCP_FASTOPEN                   => true,
        Constant::OPTION_OPEN_LENGTH_CHECK              => true,
        Constant::OPTION_PACKAGE_LENGTH_TYPE            => true,
        Constant::OPTION_PACKAGE_LENGTH_OFFSET          => true,
        Constant::OPTION_PACKAGE_BODY_OFFSET            => true,
        Constant::OPTION_PACKAGE_BODY_START             => true,
        Constant::OPTION_PACKAGE_LENGTH_FUNC            => true,
        Constant::OPTION_PACKAGE_MAX_LENGTH             => true,
        Constant::OPTION_SSL_COMPRESS                   => true,
        Constant::OPTION_SSL_PROTOCOLS                  => true,
        Constant::OPTION_SSL_VERIFY_PEER                => true,
        Constant::OPTION_SSL_ALLOW_SELF_SIGNED          => true,
        Constant::OPTION_SSL_CLIENT_CERT_FILE           => true,
        Constant::OPTION_SSL_CAFILE                     => true,
        Constant::OPTION_SSL_CAPATH                     => true,
        Constant::OPTION_SSL_VERIFY_DEPTH               => true,
        Constant::OPTION_SSL_PREFER_SERVER_CIPHERS      => true,
        Constant::OPTION_SSL_CIPHERS                    => true,
        Constant::OPTION_SSL_ECDH_CURVE                 => true,
        Constant::OPTION_SSL_DHPARAM                    => true,
        Constant::OPTION_SSL_SNI_CERTS                  => true,
    ];

    public const AIO_OPTIONS = [
        Constant::OPTION_AIO_CORE_WORKER_NUM    => true,
        Constant::OPTION_AIO_WORKER_NUM         => true,
        Constant::OPTION_AIO_MAX_WAIT_TIME      => true,
        Constant::OPTION_AIO_MAX_IDLE_TIME      => true,
        Constant::OPTION_IOURING_ENTRIES        => true,
        Constant::OPTION_IOURING_WORKERS        => true,
        Constant::OPTION_IOURING_FLAG           => true,
        Constant::OPTION_ENABLE_SIGNALFD        => true,
        Constant::OPTION_WAIT_SIGNAL            => true,
        Constant::OPTION_DNS_CACHE_REFRESH_TIME => true,
        Constant::OPTION_THREAD_NUM             => true,
        Constant::OPTION_MIN_THREAD_NUM         => true,
        Constant::OPTION_MAX_THREAD_NUM         => true,
        Constant::OPTION_SOCKET_DONTWAIT        => true,
        Constant::OPTION_DNS_LOOKUP_RANDOM      => true,
        Constant::OPTION_USE_ASYNC_RESOLVER     => true,
        Constant::OPTION_ENABLE_COROUTINE       => true,
    ];

    public const COROUTINE_OPTIONS = [
        Constant::OPTION_MAX_CORO_NUM                => true,
        Constant::OPTION_MAX_COROUTINE               => true,
        Constant::OPTION_ENABLE_DEADLOCK_CHECK       => true,
        Constant::OPTION_HOOK_FLAGS                  => true,
        Constant::OPTION_ENABLE_PREEMPTIVE_SCHEDULER => true,
        Constant::OPTION_C_STACK_SIZE                => true,
        Constant::OPTION_STACK_SIZE                  => true,
        Constant::OPTION_NAME_RESOLVER               => true,
        Constant::OPTION_DNS_CACHE_EXPIRE            => true,
        Constant::OPTION_DNS_CACHE_CAPACITY          => true,
    ];

    public const HELPER_OPTIONS = [
        Constant::OPTION_STATS_FILE           => true,
        Constant::OPTION_STATS_TIMER_INTERVAL => true,
        Constant::OPTION_ADMIN_SERVER         => true,
    ];

    public static function checkOptions(array $input_options): void
    {
        $const_options = self::GLOBAL_OPTIONS + self::SERVER_OPTIONS + self::PORT_OPTIONS
            + self::AIO_OPTIONS + self::COROUTINE_OPTIONS + self::HELPER_OPTIONS;

        foreach ($input_options as $k => $v) {
            if (!array_key_exists(strtolower($k), $const_options)) {
                // TODO throw exception
                trigger_error("unsupported option [{$k}]", E_USER_WARNING);
                debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            }
        }
    }

    public static function onBeforeStart(Server $server): void
    {
        if (!empty($server->setting[Constant::OPTION_ADMIN_SERVER])) {
            Admin::init($server);
        }
    }

    public static function onBeforeShutdown(Server $server): void
    {
        if (isset($server->admin_server)) {
            $server->admin_server->shutdown();
            $server->admin_server = null;
        }
    }

    public static function onWorkerStart(Server $server, int $workerId): void
    {
        if (!empty($server->setting[Constant::OPTION_STATS_FILE]) and $workerId == 0) {
            $interval_ms = empty($server->setting[Constant::OPTION_STATS_TIMER_INTERVAL]) ? self::STATS_TIMER_INTERVAL_TIME : intval($server->setting[Constant::OPTION_STATS_TIMER_INTERVAL]);

            $server->stats_timer = Timer::tick($interval_ms, function () use ($server) {
                $stats      = $server->stats();
                $stats_file = swoole_string($server->setting[Constant::OPTION_STATS_FILE]);
                if ($stats_file->endsWith('.json')) {
                    $out = json_encode($stats, JSON_THROW_ON_ERROR);
                } elseif ($stats_file->endsWith('.php')) {
                    $out = "<?php\nreturn " . var_export($stats, true) . ";\n";
                } else {
                    $lines = [];
                    foreach ($stats as $k => $v) {
                        $lines[] = "{$k}: {$v}";
                    }
                    $out = implode("\n", $lines);
                }
                file_put_contents($server->setting[Constant::OPTION_STATS_FILE], $out);
            });
        }
    }

    public static function onWorkerExit(Server $server, int $workerId): void
    {
        if ($server->stats_timer) {
            Timer::clear($server->stats_timer);
            $server->stats_timer = null;
        }
    }

    public static function onWorkerStop(Server $server, int $workerId)
    {
    }

    public static function onStart(Server $server): void
    {
        if (!empty($server->setting[Constant::OPTION_ADMIN_SERVER])) {
            Coroutine::create(function () use ($server): void {
                Admin::start($server);
            });
        }
    }

    public static function onShutdown(Server $server)
    {
    }

    public static function onBeforeReload(Server $server)
    {
    }

    public static function onAfterReload(Server $server)
    {
    }

    public static function onManagerStart(Server $server)
    {
    }

    public static function onManagerStop(Server $server)
    {
    }

    public static function onWorkerError(Server $server)
    {
    }
}
