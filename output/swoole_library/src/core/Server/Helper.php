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

use Swoole\Server;
use Swoole\Timer;

class Helper
{
    const STATS_TIMER_INTERVAL_TIME = 1000;

    const GLOBAL_OPTIONS = [
        'debug_mode' => true,
        'trace_flags' => true,
        'log_file' => true,
        'log_level' => true,
        'log_date_format' => true,
        'log_date_with_microseconds' => true,
        'log_rotation' => true,
        'display_errors' => true,
        'dns_server' => true,
        'socket_dns_timeout' => true,
        'socket_connect_timeout' => true,
        'socket_write_timeout' => true,
        'socket_send_timeout' => true,
        'socket_read_timeout' => true,
        'socket_recv_timeout' => true,
        'socket_buffer_size' => true,
        'socket_timeout' => true,
    ];

    const SERVER_OPTIONS = [
        'chroot' => true,
        'user' => true,
        'group' => true,
        'daemonize' => true,
        'pid_file' => true,
        'reactor_num' => true,
        'single_thread' => true,
        'worker_num' => true,
        'max_wait_time' => true,
        'max_queued_bytes' => true,
        'enable_coroutine' => true,
        'max_coro_num' => true,
        'max_coroutine' => true,
        'hook_flags' => true,
        'send_timeout' => true,
        'dispatch_mode' => true,
        'send_yield' => true,
        'dispatch_func' => true,
        'discard_timeout_request' => true,
        'enable_unsafe_event' => true,
        'enable_delay_receive' => true,
        'enable_reuse_port' => true,
        'task_use_object' => true,
        'task_object' => true,
        'event_object' => true,
        'task_enable_coroutine' => true,
        'task_worker_num' => true,
        'task_ipc_mode' => true,
        'task_tmpdir' => true,
        'task_max_request' => true,
        'task_max_request_grace' => true,
        'max_connection' => true,
        'max_conn' => true,
        'start_session_id' => true,
        'heartbeat_check_interval' => true,
        'heartbeat_idle_time' => true,
        'max_request' => true,
        'max_request_grace' => true,
        'reload_async' => true,
        'open_cpu_affinity' => true,
        'cpu_affinity_ignore' => true,
        'http_parse_cookie' => true,
        'http_parse_post' => true,
        'http_parse_files' => true,
        'http_compression' => true,
        'http_compression_level' => true,
        'http_gzip_level' => true,
        'websocket_compression' => true,
        'upload_tmp_dir' => true,
        'enable_static_handler' => true,
        'document_root' => true,
        'http_autoindex' => true,
        'http_index_files' => true,
        'static_handler_locations' => true,
        'input_buffer_size' => true,
        'buffer_input_size' => true,
        'output_buffer_size' => true,
        'buffer_output_size' => true,
        'message_queue_key' => true,
    ];

    const PORT_OPTIONS = [
        'ssl_cert_file' => true,
        'ssl_key_file' => true,
        'backlog' => true,
        'socket_buffer_size' => true,
        'kernel_socket_recv_buffer_size' => true,
        'kernel_socket_send_buffer_size' => true,
        'buffer_high_watermark' => true,
        'buffer_low_watermark' => true,
        'open_tcp_nodelay' => true,
        'tcp_defer_accept' => true,
        'open_tcp_keepalive' => true,
        'open_eof_check' => true,
        'open_eof_split' => true,
        'package_eof' => true,
        'open_http_protocol' => true,
        'open_websocket_protocol' => true,
        'websocket_subprotocol' => true,
        'open_websocket_close_frame' => true,
        'open_websocket_ping_frame' => true,
        'open_websocket_pong_frame' => true,
        'open_http2_protocol' => true,
        'open_mqtt_protocol' => true,
        'open_redis_protocol' => true,
        'max_idle_time' => true,
        'tcp_keepidle' => true,
        'tcp_keepinterval' => true,
        'tcp_keepcount' => true,
        'tcp_user_timeout' => true,
        'tcp_fastopen' => true,
        'open_length_check' => true,
        'package_length_type' => true,
        'package_length_offset' => true,
        'package_body_offset' => true,
        'package_body_start' => true,
        'package_length_func' => true,
        'package_max_length' => true,
        'ssl_compress' => true,
        'ssl_protocols' => true,
        'ssl_verify_peer' => true,
        'ssl_allow_self_signed' => true,
        'ssl_client_cert_file' => true,
        'ssl_verify_depth' => true,
        'ssl_prefer_server_ciphers' => true,
        'ssl_ciphers' => true,
        'ssl_ecdh_curve' => true,
        'ssl_dhparam' => true,
        'ssl_sni_certs' => true,
    ];

    const HELPER_OPTIONS = [
        'stats_file' => true,
    ];

    public static function checkOptions(array $input_options)
    {
        $const_options = self::GLOBAL_OPTIONS + self::SERVER_OPTIONS + self::PORT_OPTIONS + self::HELPER_OPTIONS;

        foreach ($input_options as $k => $v) {
            if (!array_key_exists(strtolower($k), $const_options)) {
                //TODO throw exception
                trigger_error("unsupported option [{$k}]", E_USER_WARNING);
                debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            }
        }
    }

    public static function onWorkerStart(Server $server, int $workerId)
    {
        if (!empty($server->setting['stats_file']) and $workerId == 0) {
            $server->stats_timer = Timer::tick(self::STATS_TIMER_INTERVAL_TIME, function () use ($server) {
                $stats = $server->stats();
                $lines = [];
                foreach ($stats as $k => $v) {
                    $lines[] = "{$k}: {$v}";
                }
                $out = implode("\n", $lines);
                file_put_contents($server->setting['stats_file'], $out);
            });
        }
    }

    public static function onWorkerExit(Server $server, int $workerId)
    {
        if ($server->stats_timer) {
            Timer::clear($server->stats_timer);
            $server->stats_timer = null;
        }
    }

    public static function onWorkerStop(Server $server, int $workerId)
    {
    }
}
