<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\StubGenerators;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class SwoolePostgresql
 *
 * @package Swoole\IDEHelper\StubGenerators
 */
class SwoolePostgresql extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE_POSTGRESQL;

        return $this;
    }
}
