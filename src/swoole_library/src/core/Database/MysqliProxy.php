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

/**
 * @method \mysqli __getObject()
 */
class MysqliProxy extends ObjectProxy
{
    public const IO_METHOD_REGEX = '/^(autocommit|begin_transaction|change_user|close|commit|execute_query|kill|multi_query|ping|prepare|query|real_connect|real_query|reap_async_query|refresh|release_savepoint|rollback|savepoint|select_db|send_query|set_charset|ssl_set)$/i';

    public const IO_ERRORS = [
        2002, // MYSQLND_CR_CONNECTION_ERROR
        2006, // MYSQLND_CR_SERVER_GONE_ERROR
        2013, // MYSQLND_CR_SERVER_LOST
    ];

    /** @var \mysqli */
    protected $__object;

    protected string $charsetContext;

    protected array $setOptContext = [];

    protected array $changeUserContext;

    /** @var callable */
    protected $constructor;

    protected int $round = 0;

    /**
     * Whether a transaction was started with begin_transaction() and not yet ended with commit() or rollback().
     */
    protected bool $inTransaction = false;

    /**
     * Whether autocommit was turned off with autocommit(false): every statement then runs inside an implicit
     * transaction, and commit() or rollback() only ends the current one, so the connection counts as in a
     * transaction until autocommit(true).
     */
    protected bool $autocommitDisabled = false;

    public function __construct(callable $constructor)
    {
        parent::__construct($constructor());
        $this->constructor = $constructor;
    }

    public function __call(string $name, array $arguments)
    {
        for ($n = 3; $n--;) {
            // Under the default report mode (MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT since PHP 8.1) a failure
            // throws a mysqli_sql_exception instead of returning false; both forms are handled the same way below.
            $exception = null;
            try {
                $ret = @$this->__object->{$name}(...$arguments);
            } catch (\mysqli_sql_exception $exception) {
                $ret = false;
            }
            if ($ret === false) {
                $errno = $exception ? $exception->getCode() : $this->__object->errno;
                /* non-IO method */
                if (!preg_match(static::IO_METHOD_REGEX, $name)) {
                    if ($exception) {
                        throw $exception;
                    }
                    if (in_array($errno, static::IO_ERRORS, true)) {
                        // A method outside the retry list, e.g. store_result(), next_result() or stat(), can return
                        // false with no error at all, but false with a lost-connection errno is the connection going
                        // away, which is reported rather than passed through as if there were nothing to return.
                        // Only the retry is limited to methods that run the statement from the start.
                        throw new MysqliException($this->__object->error, $errno);
                    }
                    break;
                }
                /* no more chances or non-IO failures */
                if (!in_array($errno, static::IO_ERRORS, true) || ($n === 0)) {
                    if ($exception) {
                        throw $exception;
                    }
                    throw new MysqliException($this->__object->error, $errno);
                }
                if ($this->inTransaction()) {
                    // The transaction died with the connection. Reconnecting and re-running this one call would
                    // silently drop what ran before it in the transaction, and run this call, and the commit(), on
                    // a fresh connection outside of any transaction. The caller has to see the lost connection and
                    // redo the whole unit of work; the next call, outside the transaction, reconnects as usual.
                    $this->reset();
                    if ($exception) {
                        throw $exception;
                    }
                    throw new MysqliException($this->__object->error, $errno);
                }
                $this->reconnect();
                continue;
            }
            if (strcasecmp($name, 'prepare') === 0) {
                // By position or by name: mysqli::prepare(string $query).
                $ret = new MysqliStatementProxy($ret, $arguments[0] ?? $arguments['query'] ?? null, $this);
            } elseif (strcasecmp($name, 'stmt_init') === 0) {
                $ret = new MysqliStatementProxy($ret, null, $this);
            } elseif (strcasecmp($name, 'begin_transaction') === 0) {
                $this->inTransaction = true;
            } elseif (strcasecmp($name, 'commit') === 0 || strcasecmp($name, 'rollback') === 0) {
                $this->inTransaction = false;
            } elseif (strcasecmp($name, 'autocommit') === 0) {
                // By position or by name: mysqli::autocommit(bool $enable).
                $this->autocommitDisabled = !($arguments[0] ?? $arguments['enable'] ?? true);
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
        $this->reset();
        /* restore context */
        if (!empty($this->charsetContext)) {
            $this->__object->set_charset($this->charsetContext);
        }
        foreach ($this->setOptContext as $opt => $val) {
            $this->__object->set_opt($opt, $val);
        }
        if (!empty($this->changeUserContext)) {
            $this->__object->change_user(...$this->changeUserContext);
        }
    }

    /**
     * Whether the connection is inside a transaction: one started with begin_transaction(), or the implicit one
     * that runs while autocommit is turned off with autocommit(false). A transaction started by hand, with
     * query('START TRANSACTION') or query('SET autocommit=0'), is not seen here, the same limitation PDO's
     * inTransaction() has. A lost connection inside a transaction is reported instead of reconnected.
     */
    public function inTransaction(): bool
    {
        return $this->inTransaction || $this->autocommitDisabled;
    }

    /**
     * Forgets the transaction state tracked by inTransaction(): after a reconnect, when the transaction died with
     * the connection, and when the pool hands the connection out.
     */
    public function reset(): void
    {
        $this->inTransaction      = false;
        $this->autocommitDisabled = false;
    }

    public function options(int $option, $value): bool
    {
        $this->setOptContext[$option] = $value;
        return $this->__object->options($option, $value);
    }

    public function set_opt(int $option, $value): bool
    {
        return $this->options($option, $value);
    }

    public function set_charset(string $charset): bool
    {
        $this->charsetContext = $charset;
        return $this->__object->set_charset($charset);
    }

    public function change_user(string $user, string $password, ?string $database): bool
    {
        $this->changeUserContext = [$user, $password, $database];
        return $this->__object->change_user($user, $password, $database);
    }
}
