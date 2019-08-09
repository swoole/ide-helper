<?php

namespace Swoole\IDEHelper\Extensions;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class Swoole
 *
 * @package Swoole\IDEHelper\Extensions
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
