<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\StubGenerators;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class SwooleOrm
 *
 * @package Swoole\IDEHelper\StubGenerators
 */
class SwooleOrm extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE_ORM;

        return $this;
    }
}
