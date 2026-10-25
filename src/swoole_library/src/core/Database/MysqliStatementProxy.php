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

class MysqliStatementProxy extends ObjectProxy
{
    /**
     * The methods that are run again on a fresh connection after a lost one. fetch() is not one of them: it reads
     * the result of an execute() that went down with the connection, and running it on a statement that was
     * prepared again but never executed fails with "Commands out of sync" in place of the lost connection.
     */
    public const IO_METHOD_REGEX = '/^(close|execute|prepare)$/i';

    /** @var \mysqli_stmt */
    protected $__object;

    protected ?string $queryString;

    protected array $attrSetContext = [];

    protected array $bindParamContext;

    protected array $bindResultContext;

    protected MysqliProxy $parent;

    protected int $parentRound;

    public function __construct(\mysqli_stmt $object, ?string $queryString, MysqliProxy $parent)
    {
        parent::__construct($object);
        $this->queryString = $queryString;
        $this->parent      = $parent;
        $this->parentRound = $parent->getRound();
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
                    if (in_array($errno, $this->parent::IO_ERRORS, true)) {
                        // False from fetch(), get_result(), store_result() and the like can mean there is nothing to
                        // return; with a lost-connection errno it means the connection is gone, and that is reported.
                        throw new MysqliException($this->__object->error, $errno);
                    }
                    break;
                }
                /* no more chances or non-IO failures */
                if (!in_array($errno, $this->parent::IO_ERRORS, true) || ($n === 0)) {
                    if ($exception) {
                        throw $exception;
                    }
                    throw new MysqliException($this->__object->error, $errno);
                }
                if ($this->parent->inTransaction()) {
                    // The transaction died with the connection; see MysqliProxy::__call() for why this is not retried.
                    $this->parent->reset();
                    if ($exception) {
                        throw $exception;
                    }
                    throw new MysqliException($this->__object->error, $errno);
                }
                if ($this->parent->getRound() === $this->parentRound) {
                    /* if not equal, parent has reconnected */
                    $this->parent->reconnect();
                }
                $this->parentRound = $this->parent->getRound();
                $parent            = $this->parent->__getObject();
                $statement         = $this->queryString ? @$parent->prepare($this->queryString) : @$parent->stmt_init();
                if ($statement === false) {
                    throw new MysqliException($parent->error, $parent->errno);
                }
                $this->__object = $statement;
                if (!empty($this->bindParamContext)) {
                    $this->__object->bind_param($this->bindParamContext[0], ...$this->bindParamContext[1]);
                }
                if (!empty($this->bindResultContext)) {
                    $this->__object->bind_result(...$this->bindResultContext);
                }
                foreach ($this->attrSetContext as $attr => $value) {
                    $this->__object->attr_set($attr, $value);
                }
                continue;
            }
            if (strcasecmp($name, 'prepare') === 0) {
                // By position or by name: mysqli_stmt::prepare(string $query).
                $this->queryString = $arguments[0] ?? $arguments['query'] ?? null;
            }
            break;
        }
        /* @noinspection PhpUndefinedVariableInspection */
        return $ret;
    }

    public function attr_set($attr, $mode): bool
    {
        $this->attrSetContext[$attr] = $mode;
        return $this->__object->attr_set($attr, $mode);
    }

    public function bind_param($types, &...$arguments): bool
    {
        $this->bindParamContext = [$types, $arguments];
        return $this->__object->bind_param($types, ...$arguments);
    }

    public function bind_result(&...$arguments): bool
    {
        $this->bindResultContext = $arguments;
        return $this->__object->bind_result(...$arguments);
    }
}
