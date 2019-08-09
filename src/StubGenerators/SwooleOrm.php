<?php

namespace Swoole\IDEHelper\Extensions;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class SwooleOrm
 *
 * @package Swoole\IDEHelper\Extensions
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
