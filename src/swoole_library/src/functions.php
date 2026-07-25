<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

if (PHP_VERSION_ID < 80100) { // @phpstan-ignore smaller.alwaysFalse
    throw new RuntimeException('require PHP version 8.1 or later');
}

if (SWOOLE_USE_SHORTNAME) { // @phpstan-ignore if.alwaysTrue
    function _string(string $string = ''): Swoole\StringObject
    {
        return new Swoole\StringObject($string);
    }

    function _mbstring(string $string = ''): Swoole\MultibyteStringObject
    {
        return new Swoole\MultibyteStringObject($string);
    }

    function _array(array $array = []): Swoole\ArrayObject
    {
        return new Swoole\ArrayObject($array);
    }
}

class SwooleLibrary
{
    /**
     * @var array<string, mixed>
     */
    public static array $options = [];

    public static bool $remote_object_server_initiated = false;

    public static string $remote_object_server_socket_file = '';
}

/**
 * @param array<string, mixed> $options
 */
function swoole_library_set_options(array $options): void
{
    SwooleLibrary::$options = $options;
}

function swoole_library_get_options(): array
{
    return SwooleLibrary::$options;
}

function swoole_library_set_option(string $key, mixed $value): void
{
    SwooleLibrary::$options[$key] = $value;
}

function swoole_library_get_option(string $key): mixed
{
    return SwooleLibrary::$options[$key] ?? null;
}

function swoole_string(string $string = ''): Swoole\StringObject
{
    return new Swoole\StringObject($string);
}

function swoole_mbstring(string $string = ''): Swoole\MultibyteStringObject
{
    return new Swoole\MultibyteStringObject($string);
}

function swoole_array(array $array = []): Swoole\ArrayObject
{
    return new Swoole\ArrayObject($array);
}

function swoole_table(int $size, string $fields): Swoole\Table
{
    $_fields = swoole_string($fields)->trim()->split(',');

    $table = new Swoole\Table($size, 0.25);

    foreach ($_fields as $f) {
        $_f   = swoole_string($f)->trim()->split(':');
        $name = $_f->get(0)->trim()->toString();
        $type = $_f->get(1)->trim();

        switch ($type) {
            case 'i':
            case 'int':
                $table->column($name, Swoole\Table::TYPE_INT);
                break;
            case 'f':
            case 'float':
                $table->column($name, Swoole\Table::TYPE_FLOAT);
                break;
            case 's':
            case 'string':
                if ($_f->count() < 3) {
                    throw new RuntimeException('need to give string length');
                }
                $length = (int) $_f->get(2)->trim()->toString();
                if ($length <= 0) {
                    throw new RuntimeException("invalid string length[{$length}]");
                }
                $table->column($name, Swoole\Table::TYPE_STRING, $length);
                break;
            default:
                throw new RuntimeException("unknown field type[{$type}]");
        }
    }

    if (!$table->create()) {
        throw new RuntimeException('failed to create table');
    }

    return $table;
}

function swoole_array_list(...$arrray): Swoole\ArrayObject
{
    return new Swoole\ArrayObject($arrray);
}

function swoole_array_default_value(array $array, $key, $default_value = null)
{
    return array_key_exists($key, $array) ? $array[$key] : $default_value;
}

function swoole_is_in_container(): bool
{
    $mountinfo = file_get_contents('/proc/self/mountinfo');
    return strpos($mountinfo, 'kubepods') > 0 || strpos($mountinfo, 'docker') > 0;
}

function swoole_container_cpu_num(): int
{
    $swoole_cpu_num = intval(getenv('SWOOLE_CPU_NUM'));
    if ($swoole_cpu_num > 0) {
        return $swoole_cpu_num;
    }
    if (!swoole_is_in_container()) {
        return swoole_cpu_num();
    }
    // cgroup v2
    $cpu_max = '/sys/fs/cgroup/cpu.max';
    if (file_exists($cpu_max)) {
        $cpu_max  = file_get_contents($cpu_max);
        $fields   = explode($cpu_max, ' ');
        $quota_us = $fields[0];
        if ($quota_us === 'max') { // @phpstan-ignore identical.alwaysFalse
            return swoole_cpu_num();
        }
        $period_us = $fields[1] ?? 100000;
    } else {
        $quota_us  = file_get_contents('/sys/fs/cgroup/cpu,cpuacct/cpu.cfs_quota_us');
        $period_us = file_get_contents('/sys/fs/cgroup/cpu,cpuacct/cpu.cfs_period_us');
    }
    $cpu_num = floatval($quota_us) / floatval($period_us);
    if ($cpu_num < 1) {
        return swoole_cpu_num();
    }
    return intval(floor($cpu_num));
}

function swoole_init_default_remote_object_server(): void
{
    $dir = swoole_library_get_option('default_remote_object_server_dir');
    if (empty($dir)) {
        $home = getenv('HOME') ?: sys_get_temp_dir();
        $dir  = $home . '/.swoole';
        swoole_library_set_option('default_remote_object_server_dir', $dir);
    }

    $pid_file = $dir . '/remote-object-server.pid';

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    } else {
        if (is_file($pid_file)
            and posix_kill(intval(file_get_contents($pid_file)), 0)) {
            return;
        }
    }

    $options = swoole_library_get_option('default_remote_object_server_options');
    if (!$options) {
        $worker_num = swoole_library_get_option('default_remote_object_server_worker_num') ?: 128;
        $options    = [
            'worker_num'  => $worker_num,
            'server_mode' => defined('SWOOLE_THREAD') ? SWOOLE_THREAD : SWOOLE_BASE,
        ];
    }

    $php_file                    = $dir . '/remote-object-server.php';
    $socket_file                 = $dir . '/remote-object-server.sock';
    $log_file                    = $dir . '/remote-object-server.log';
    $lock_file                   = $dir . '/remote-object-server.lock';

    $wait_ready_fn = function () use ($socket_file) {
        // wait for remote object server ready
        while (true) {
            if (posix_access($socket_file, POSIX_R_OK)) {
                break;
            }
            usleep(500000);
        }
    };

    $lock_handle = fopen($lock_file, 'c');
    if (!$lock_handle) {
        throw new RuntimeException("failed to open lock file[{$lock_file}]");
    }
    // If the lock was not acquired, it indicates that another process is trying to start the remote object server.
    // In this case, the service should be skipped from starting and proceed to the ready wait detection branch.
    if (!flock($lock_handle, LOCK_EX | LOCK_NB)) {
        fclose($lock_handle);
        $wait_ready_fn();
        return;
    }

    $options['enable_coroutine'] = false;
    $options['bootstrap']        = $php_file;
    $options['pid_file']         = $pid_file;
    $options['log_file']         = $log_file;
    $options['daemonize']        = true;
    $options['socket_type']      = SWOOLE_SOCK_UNIX_STREAM;

    $rv = file_put_contents($php_file, '<?php' .
        "\nif (is_file(__DIR__ . '/vendor/autoload.php')) { require __DIR__ . '/vendor/autoload.php'; }" .
        "\nif (is_file(__DIR__ . '/bootstrap.php')) { require __DIR__ . '/bootstrap.php'; }" .
        "\n" .
        "\n(new Swoole\\RemoteObject\\Server("
        . "'{$socket_file}', 0, "
        . var_export($options, true) .
        "))->start();\n");
    if (!$rv) {
        throw new RuntimeException("failed to write php file[{$php_file}]");
    }

    $php_bin = PHP_BINARY;
    if (posix_access($socket_file, POSIX_R_OK)) {
        unlink($socket_file);
    }

    $hook_flags = Swoole\Runtime::getHookFlags();
    // Having enabled the MongoDB hook, you need to install the MongoDB PHP library through Composer.
    if (defined('SWOOLE_HOOK_MONGODB') and $hook_flags & SWOOLE_HOOK_MONGODB and !is_dir($dir . '/vendor/mongodb/mongodb')) {
        system("cd {$dir} && composer require mongodb/mongodb");
    }

    // start server
    $proc = proc_open("{$php_bin} {$php_file}", [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['pipe', 'w'],
    ], $pipes);
    if ($proc === false) {
        throw new RuntimeException('failed to start remote object server');
    }
    $rc = proc_close($proc);
    if ($rc !== 0) {
        $output = stream_get_contents($pipes[1]) . stream_get_contents($pipes[2]);
        throw new RuntimeException("failed to start remote object server: exit code {$rc}, output: " . $output);
    }

    $wait_ready_fn();
    flock($lock_handle, LOCK_UN);
    fclose($lock_handle);
}

function swoole_get_default_remote_object_client(): Swoole\RemoteObject\Client
{
    if (!SwooleLibrary::$remote_object_server_initiated) {
        SwooleLibrary::$remote_object_server_initiated = true;
        swoole_init_default_remote_object_server();
    }
    if (!SwooleLibrary::$remote_object_server_socket_file) {
        $dir = swoole_library_get_option('default_remote_object_server_dir');
        if (empty($dir)) {
            $home = getenv('HOME') ?: sys_get_temp_dir();
            $dir  = $home . '/.swoole';
        }
        SwooleLibrary::$remote_object_server_socket_file = 'unix://' . $dir . '/remote-object-server.sock';
    }
    return new Swoole\RemoteObject\Client(SwooleLibrary::$remote_object_server_socket_file);
}
