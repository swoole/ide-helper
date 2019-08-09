<?php

namespace Swoole\IDEHelper\Extensions;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;

/**
 * Class SwooleSerialize
 *
 * @package Swoole\IDEHelper\Extensions
 */
class SwooleSerialize extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE_SERIALIZE;

        return $this;
    }
}
