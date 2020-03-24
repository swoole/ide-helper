<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\StubGenerators;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class Swoole
 *
 * @package Swoole\IDEHelper\StubGenerators
 */
class Swoole extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE;

        return $this;
    }
}
