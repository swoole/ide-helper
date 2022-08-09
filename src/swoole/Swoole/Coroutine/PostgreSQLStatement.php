<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This class is available when Swoole is installed with option "--enable-swoole-pgsql" included.
 *
 * @since 5.0.0
 */
class PostgreSQLStatement
{
    public $error;

    public $errCode = 0;

    public $resultStatus = 0;

    public $resultDiag;

    public $notices;

    public function execute(array $params = []): bool
    {
    }

    public function fetchAll(int $result_type = SW_PGSQL_ASSOC): array|false
    {
    }

    public function affectedRows(): int
    {
    }

    public function numRows(): int
    {
    }

    public function fieldCount(): int
    {
    }

    public function fetchObject(?int $row = 0, ?string $class_name = null, array $ctor_params = []): object|false
    {
    }

    public function fetchAssoc(?int $row = 0, int $result_type = SW_PGSQL_ASSOC): array|false
    {
    }

    public function fetchArray(?int $row = 0, int $result_type = SW_PGSQL_BOTH): array|false
    {
    }

    public function fetchRow(?int $row = 0, int $result_type = SW_PGSQL_NUM): array|false
    {
    }
}
