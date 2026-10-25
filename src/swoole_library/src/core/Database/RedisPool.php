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

use Redis;
use Swoole\ConnectionPool;

/**
 * @method \Redis get(float $timeout = -1)
 * @method void put(Redis $connection)
 */
class RedisPool extends ConnectionPool
{
    public function __construct(protected RedisConfig $config, int $size = self::DEFAULT_SIZE)
    {
        parent::__construct(function () {
            $redis = new \Redis();
            // Every argument is passed, in the position phpredis defines for it: leaving one out shifts the ones
            // after it into the wrong parameters (a read timeout became the connect timeout, a retry interval
            // landed in the persistent id). The zero defaults mean "unset" to phpredis, as they do to the config.
            $redis->connect(
                $this->config->getHost(),
                $this->config->getPort(),
                $this->config->getTimeout(),
                null, // persistent_id: a pooled connection is never persistent
                $this->config->getRetryInterval(),
                $this->config->getReadTimeout()
            );
            if ($this->config->getAuth()) {
                $redis->auth($this->config->getAuth());
            }
            if ($this->config->getDbIndex() !== 0) {
                $redis->select($this->config->getDbIndex());
            }

            /* Set Redis options. */
            foreach ($this->config->getOptions() as $key => $value) {
                $redis->setOption($key, $value);
            }

            return $redis;
        }, $size);
    }
}
