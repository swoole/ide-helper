<?php
declare(strict_types=1);

namespace Swoole\Database;

use mysqli;
use Swoole\ConnectionPool;

/**
 * @method mysqli|MysqliProxy get()
 * @method void put(mysqli|MysqliProxy $connection)
 */
class MysqliPool extends ConnectionPool
{
    /** @var MysqliConfig */
    protected $config;

    public function __construct(MysqliConfig $config, int $size = self::DEFAULT_SIZE)
    {
        $this->config = $config;
        parent::__construct(function () {
            $mysqli = new mysqli(
                $this->config->getHost(),
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getDbname(),
                $this->config->getPort(),
                $this->config->getUnixSocket()
            );
            if ($mysqli->connect_errno) {
                throw new MysqliException($mysqli->connect_errno, $mysqli->connect_errno);
            }
            foreach ($this->config->getOptions() as $option => $value) {
                $mysqli->set_opt($option, $value);
            }
            return $mysqli;
        }, $size, MysqliProxy::class);
    }
}
