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
use Swoole\ObjectProxy;

class MysqliProxy extends ObjectProxy
{
    public const IO_ERRORS = [
        2002, // MYSQLND_CR_CONNECTION_ERROR
        2006, // MYSQLND_CR_SERVER_GONE_ERROR
        2013, // MYSQLND_CR_SERVER_LOST
    ];

    /** @var mysqli */
    protected $__object;

    /** @var string */
    protected $charsetContext;

    /** @var null|array */
    protected $setOptContext;

    /** @var null|array */
    protected $changeUserContext;

    /** @var callable */
    protected $constructor;

    /** @var int */
    protected $round = 0;

    public function __construct(callable $constructor)
    {
        parent::__construct($constructor());
        $this->constructor = $constructor;
    }

    public function __call(string $name, array $arguments)
    {
        for ($n = 3; $n--;) {
            $this->__object->errno = 0;
            $ret = @$this->__object->{$name}(...$arguments);
            if ($ret === false) {
                /* no error */
                if ($this->__object->errno === 0) {
                    break;
                }
                /* no more chances or non-IO failures */
                if (
                    !in_array($this->__object->errno, static::IO_ERRORS, true) ||
                    $n === 0
                ) {
                    throw new MysqliException($this->__object->error, $this->__object->errno);
                }
                $this->reconnect();
                continue;
            }
            if (strcasecmp($name, 'prepare') === 0) {
                $ret = new MysqliStatementProxy($ret, $arguments[0], $this);
            } elseif (strcasecmp($name, 'stmt_init') === 0) {
                $ret = new MysqliStatementProxy($ret, null, $this);
            }
            break;
        }
        /* @noinspection PhpUndefinedVariableInspection */
        return $ret;
    }

    public function getRound(): int
    {
        return $this->round;
    }

    public function reconnect(): void
    {
        $constructor = $this->constructor;
        parent::__construct($constructor());
        $this->round++;
        /* restore context */
        if ($this->charsetContext) {
            $this->__object->set_charset($this->charsetContext);
        }
        if ($this->setOptContext) {
            foreach ($this->setOptContext as $opt => $val) {
                $this->__object->set_opt($opt, $val);
            }
        }
        if ($this->changeUserContext) {
            $this->__object->change_user(...$this->changeUserContext);
        }
    }

    public function set_opt($option, $value): void
    {
        $this->setOptContext[$option] = $value;
        $this->__object->set_opt($option, $value);
    }

    public function set_charset(string $charset): bool
    {
        $this->charsetContext = $charset;
        return $this->__object->set_charset($charset);
    }

    public function change_user(string $user, string $password, string $database): bool
    {
        $this->changeUserContext = [$user, $password, $database];
        return $this->__object->change_user($user, $password, $database);
    }
}
