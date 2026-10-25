<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole;

use Swoole\Coroutine\Channel;

class ConnectionPool
{
    public const DEFAULT_SIZE = 64;

    protected ?Channel $pool;

    /** @var callable */
    protected $constructor;

    protected int $size;

    protected int $num = 0;

    public function __construct(callable $constructor, int $size = self::DEFAULT_SIZE, protected ?string $proxy = null)
    {
        $this->pool        = new Channel($this->size = $size);
        $this->constructor = $constructor;
    }

    public function fill(): void
    {
        if ($this->pool === null) {
            // A closed pool has nowhere to keep the connections: they would be made, counted and dropped.
            return;
        }
        while ($this->size > $this->num) {
            $this->make();
        }
    }

    /**
     * Get a connection from the pool.
     *
     * @param float $timeout the number of seconds to wait for a connection; 0 or less waits with no time limit
     * @return mixed|false Returns a connection object from the pool, or false if no connection is available before the
     *                     timeout is reached, the pool is closed while waiting, or the waiting coroutine is canceled.
     */
    public function get(float $timeout = -1)
    {
        if ($this->pool === null) {
            throw new \RuntimeException('Pool has been closed');
        }
        if ($this->pool->isEmpty() && $this->num < $this->size) {
            $this->make();
        }
        return $this->pool->pop($timeout);
    }

    public function put($connection): void
    {
        if ($this->pool === null) {
            return;
        }
        if ($connection !== null) {
            $this->pool->push($connection);
        } else {
            /* connection broken */
            $this->num -= 1;
            $this->make();
        }
    }

    public function close(): void
    {
        if ($this->pool === null) {
            return;
        }
        $this->pool->close();
        $this->pool = null;
        $this->num  = 0;
    }

    protected function make(): void
    {
        $this->num++;
        try {
            if ($this->proxy) {
                $connection = new $this->proxy($this->constructor);
            } else {
                $constructor = $this->constructor;
                $connection  = $constructor();
            }
        } catch (\Throwable $throwable) {
            $this->num--;
            throw $throwable;
        }
        $this->put($connection);
    }
}
