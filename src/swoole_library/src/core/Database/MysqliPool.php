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

use mysqli;
use Swoole\ConnectionPool;

/**
 * @method \mysqli|MysqliProxy get()
 * @method void put(mysqli|MysqliProxy $connection)
 */
class MysqliPool extends ConnectionPool
{
    public function __construct(protected MysqliConfig $config, int $size = self::DEFAULT_SIZE)
    {
        parent::__construct(function () {
            $mysqli = new \mysqli();
            foreach ($this->config->getOptions() as $option => $value) {
                $mysqli->set_opt($option, $value);
            }
            $mysqli->real_connect(
                $this->config->getHost(),
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getDbname(),
                $this->config->getPort(),
                $this->config->getUnixSocket()
            );
            if ($mysqli->connect_errno) {
                throw new MysqliException($mysqli->connect_error, $mysqli->connect_errno);
            }
            $mysqli->set_charset($this->config->getCharset());
            return $mysqli;
        }, $size, MysqliProxy::class);
    }

    /**
     * Get a mysqli connection from the pool, wrapped in a MysqliProxy. The proxy's transaction tracking is reset,
     * as PDOPool does, so that a connection put back in the middle of a transaction does not keep the next
     * borrower from reconnecting when the connection is lost.
     *
     * @param float $timeout the number of seconds to wait for a connection; 0 or less waits with no time limit
     * @return MysqliProxy|false Returns a MysqliProxy object from the pool, or false if the pool is full and the timeout is reached.
     */
    public function get(float $timeout = -1)
    {
        /* @var MysqliProxy|false $mysqli */
        $mysqli = parent::get($timeout);
        if ($mysqli === false) {
            return false;
        }

        $mysqli->reset();

        return $mysqli;
    }
}
