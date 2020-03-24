<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\Rules;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Exception;

/**
 * Class NamespaceRule
 *
 * @package Swoole\IDEHelper\Rules
 */
abstract class AbstractRule
{
    /**
     * @var AbstractStubGenerator
     */
    protected $generator;

    /**
     * AbstractRule constructor.
     *
     * @param AbstractStubGenerator $generator
     */
    public function __construct(AbstractStubGenerator $generator)
    {
        $this->setGenerator($generator);
    }

    /**
     * @param mixed ...$params
     */
    public function validate(...$params): void
    {
        if (in_array($this->getGenerator()->getExtension(), $this->getEnabledExtensions())) {
            $this->validateWith(...$params);
        }
    }

    /**
     * @return AbstractStubGenerator
     */
    protected function getGenerator(): AbstractStubGenerator
    {
        return $this->generator;
    }

    /**
     * @param AbstractStubGenerator $generator
     * @return $this
     */
    protected function setGenerator(AbstractStubGenerator $generator): self
    {
        $this->generator = $generator;

        return $this;
    }

    /**
     * @param mixed ...$params
     * @throws Exception
     */
    abstract protected function validateWith(...$params): void;

    /**
     * @return array
     */
    abstract protected function getEnabledExtensions(): array;
}
