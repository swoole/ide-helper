<?php

namespace Swoole\IDEHelper\Extensions;

use Swoole\IDEHelper\AbstractStubGenerator;

class Swoole extends AbstractStubGenerator
{
    /**
     * @inheritDoc
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = 'swoole';

        return $this;
    }
}
