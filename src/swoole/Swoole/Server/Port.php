<?php

declare(strict_types=1);

namespace Swoole\Server;

use Closure;
use Socket;

/**
 * @not-serializable Objects of this class cannot be serialized.
 */
class Port
{
    public $host;

    public $port = 0;

    public $type = 0;

    public $sock = -1;

    public $ssl = false;

    public $setting;

    public $connections;

    private $onConnect;

    private $onReceive;

    private $onClose;

    private $onPacket;

    private $onBufferFull;

    private $onBufferEmpty;

    private $onRequest;

    private $onHandShake;

    private $onOpen;

    private $onMessage;

    private $onDisconnect;

    private function __construct()
    {
    }

    public function __destruct()
    {
    }

    public function set(array $settings): void
    {
    }

    public function on(string $event_name, callable $callback): bool
    {
    }

    public function getCallback(string $event_name): ?Closure
    {
    }

    public function getSocket(): Socket|false
    {
    }
}
