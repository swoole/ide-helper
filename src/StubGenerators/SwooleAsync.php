<?php

namespace Swoole\IDEHelper\StubGenerators;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class SwooleAsync
 *
 * @package Swoole\IDEHelper\StubGenerators
 */
class SwooleAsync extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE_ASYNC;

        return $this;
    }
}
