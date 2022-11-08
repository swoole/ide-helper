<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This class is available when Swoole is installed with option "--enable-swoole-pgsql" included.
 *
 * @since 5.0.0
 * @not-serializable Objects of this class cannot be serialized.
 * @alias This class has an alias of "\Co\PostgreSQL" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\PostgreSQL
 */
class PostgreSQL
{
    public $error;

    public $errCode = 0;

    public $resultStatus = 0;

    public $resultDiag;

    public $notices;

    public function connect(string $conninfo, float $timeout = 2): bool
    {
    }

    public function query(string $query): PostgreSQLStatement|false
    {
    }

    public function prepare(string $query): PostgreSQLStatement|false
    {
    }

    public function metaData(string $table_name): array|false
    {
    }

    public function escape(string $string): string|false
    {
    }

    public function escapeLiteral(string $string): string|false
    {
    }

    public function escapeIdentifier(string $string): string|false
    {
    }

    /**
     * Create a large object.
     *
     * @return int|false Returns the OID of the new large object, or FALSE when error happens.
     * @since 5.0.1
     */
    public function createLOB(): int|false
    {
    }

    /**
     * Open a large object.
     *
     * @param int $oid The OID of the large object to be opened.
     * @param string $mode The mode to open the large object. It can be "r" for read-only, "w" for write-only, or "rw" for read-write.
     * @return resource|false Returns the large object resource, or FALSE when error happens.
     * @since 5.0.1
     */
    public function openLOB(int $oid, string $mode = 'r')
    {
    }

    /**
     * Delete a large object.
     *
     * @param int $oid The OID of the large object to be deleted.
     * @return bool Returns TRUE on success, or FALSE when error happens.
     * @since 5.0.1
     */
    public function unlinkLOB(int $oid): bool
    {
    }
}
