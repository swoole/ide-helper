<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\MongoDB;

use Swoole\RemoteObject;
use Swoole\RemoteObject\ProxyTrait;

class Client
{
    use ProxyTrait;

    public const DEFAULT_URI = 'mongodb://127.0.0.1/';

    protected RemoteObject $client;

    public function __construct(?string $uri = self::DEFAULT_URI, array $uriOptions = [], array $driverOptions = [])
    {
        $remoteObjectClient = swoole_library_get_option('mongodb_remote_object_client');
        if ($remoteObjectClient === null) {
            $remoteObjectClient = swoole_get_default_remote_object_client();
        }
        $this->client = $remoteObjectClient->create(\MongoDB\Client::class, $uri, $uriOptions, $driverOptions);
    }

    protected function getObject(): RemoteObject
    {
        return $this->client;
    }
}
