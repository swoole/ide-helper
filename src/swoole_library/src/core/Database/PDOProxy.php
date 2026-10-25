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
 * @method \PDO __getObject()
 */
class PDOProxy extends ObjectProxy
{
    /** @var \PDO */
    protected $__object;

    protected array $setAttributeContext = [];

    /** @var callable */
    protected $constructor;

    protected int $round = 0;

    /**
     * The number of transactions started through beginTransaction() and not ended through commit() or rollBack().
     *
     * It is what inTransaction() reports. Whether a call may reconnect is decided from $openTransaction, which also
     * covers a transaction started by hand.
     */
    protected int $inTransaction = 0;

    /**
     * Whether the connection is inside a transaction, as PDO reported it right after the last call that reached the
     * server and could start or end one: exec(), query(), beginTransaction(), commit() and rollBack() of the proxy,
     * and execute() of its statements. It decides whether a call that runs into a lost connection may reconnect.
     *
     * PDO is not asked before the call: on PostgreSQL a connection found dead by any call, a destructor included,
     * is reported as inside a transaction from then on, which says nothing about the transaction before it died.
     */
    protected bool $openTransaction = false;

    /**
     * Whether the connection was lost and not replaced yet: a lost connection reported inside a transaction, which
     * is not retried, or a reconnect that failed. PDO keeps reporting such a connection as inside a transaction, so
     * the state PDO reports cannot tell it; the next call reconnects first.
     */
    protected bool $lost = false;

    public function __construct(callable $constructor)
    {
        parent::__construct($constructor());
        $this->__object->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->constructor = $constructor;
    }

    public function __call(string $name, array $arguments)
    {
        if ($this->lost) {
            if (strcasecmp($name, 'rollBack') === 0) {
                // The transaction died with the connection, and the server has rolled it back. Nothing to send.
                return true;
            }
            $this->reconnect();
        }

        // The calls that can start or end a transaction, by hand as well: exec('BEGIN') and query('COMMIT') included.
        $changesTransaction = in_array(strtolower($name), ['exec', 'query', 'begintransaction', 'commit', 'rollback'], true);
        try {
            $ret = $this->__object->{$name}(...$arguments);
        } catch (\PDOException $e) {
            if (!DetectsLostConnections::causedByLostConnection($e)) {
                if ($changesTransaction) {
                    // The server answered, so the state PDO reports is the real one.
                    $this->openTransaction = $this->__object->inTransaction();
                }
                throw $e;
            }
            if ($this->openTransaction) {
                // The transaction died with the connection. The caller is told, and the next call reconnects.
                $this->markAsLost();
                throw $e;
            }
            $this->reconnect();
            $ret = $this->__object->{$name}(...$arguments);
        }
        if ($changesTransaction) {
            $this->openTransaction = $this->__object->inTransaction();
        }

        if (strcasecmp($name, 'beginTransaction') === 0) {
            $this->inTransaction++;
        }

        if ((strcasecmp($name, 'commit') === 0 || strcasecmp($name, 'rollback') === 0) && $this->inTransaction > 0) {
            $this->inTransaction--;
        }

        // Not a statement but false when the call failed and the error mode is not the exception one.
        if ($ret instanceof \PDOStatement && (strcasecmp($name, 'prepare') === 0 || strcasecmp($name, 'query') === 0)) {
            $ret = new PDOStatementProxy($ret, $this);
        }

        return $ret;
    }

    public function getRound(): int
    {
        return $this->round;
    }

    public function reconnect(): void
    {
        // Stays set when the constructor throws, e.g. while the server restarts: the next call tries again.
        $this->lost  = true;
        $constructor = $this->constructor;
        parent::__construct($constructor());
        $this->lost            = false;
        $this->openTransaction = false;
        $this->__object->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->round++;
        /* restore context */
        foreach ($this->setAttributeContext as $attribute => $value) {
            $this->__object->setAttribute($attribute, $value);
        }
    }

    public function setAttribute(int $attribute, $value): bool
    {
        $this->setAttributeContext[$attribute] = $value;
        return $this->__object->setAttribute($attribute, $value);
    }

    public function inTransaction(): bool
    {
        return $this->inTransaction > 0;
    }

    public function reset(): void
    {
        $this->inTransaction   = 0;
        $this->openTransaction = false;
    }

    /**
     * Whether the connection is inside a transaction, begun with beginTransaction() or by hand, as PDO reported it
     * after the last call through the proxy or one of its statements that could start or end one.
     *
     * @internal
     */
    public function hasOpenTransaction(): bool
    {
        return $this->openTransaction;
    }

    /**
     * Records the transaction state PDO reports now. Called by a statement of the proxy after a call that reached the
     * server and could start or end a transaction, e.g. prepare('BEGIN')->execute().
     *
     * @internal
     */
    public function recordTransactionState(): void
    {
        if (!$this->lost) {
            $this->openTransaction = $this->__object->inTransaction();
        }
    }

    /**
     * Whether the connection was lost and not replaced yet; the next call reconnects first.
     *
     * @internal
     */
    public function isLost(): bool
    {
        return $this->lost;
    }

    /**
     * Records that the connection was lost inside a transaction, which went down with it: the next call reconnects
     * first. Called by the proxy, and by a statement of the connection that reports a lost connection.
     *
     * @internal
     */
    public function markAsLost(): void
    {
        $this->lost            = true;
        $this->inTransaction   = 0;
        $this->openTransaction = false;
    }
}
