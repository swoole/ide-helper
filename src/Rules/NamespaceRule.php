<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\Rules;

use Swoole\IDEHelper\Constant;
use Swoole\IDEHelper\Exception;

/**
 * Class NamespaceRule
 *
 * @package Swoole\IDEHelper\Rules
 */
class NamespaceRule extends AbstractRule
{
    /**
     * @inheritDoc
     */
    protected function validateWith(...$params): void
    {
        if (strcasecmp(explode('\\', $params[0])[0], $this->getGenerator()->getExtension()) !== 0) {
            throw new Exception(
                "Class $params[0] should be under namespace \\{$this->getGenerator()->getExtension()} but not."
            );
        }
    }

    /**
     * @inheritDoc
     */
    protected function getEnabledExtensions(): array
    {
        return [
            Constant::EXT_SWOOLE,
        ];
    }
}
