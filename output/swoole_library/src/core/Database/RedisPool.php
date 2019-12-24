<?php
declare(strict_types=1);

namespace Swoole\Database;

use Redis;
use Swoole\ConnectionPool;

/**
 * @method Redis get()
 * @method void put(Redis $connection)
 */
class RedisPool extends ConnectionPool
{
    /** @var RedisConfig */
    protected $config;

    public function __construct(RedisConfig $config, int $size = self::DEFAULT_SIZE)
    {
        $this->config = $config;
        parent::__construct(function () {
            $redis = new Redis;
            $redis->connect(
                $this->config->getHost(),
                $this->config->getPort(),
                $this->config->getTimeout(),
                $this->config->getReserved(),
                $this->config->getRetryInterval(),
                $this->config->getReadTimeout()
            );
            if ($this->config->getAuth()) {
                $redis->auth($this->config->getAuth());
            }
            if ($this->config->getDbIndex() !== 0) {
                $redis->select($this->config->getDbIndex());
            }
            return $redis;
        }, $size);
    }
}
