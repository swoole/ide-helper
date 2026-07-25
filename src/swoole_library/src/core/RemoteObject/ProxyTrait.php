<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\RemoteObject;

use Swoole\RemoteObject;

trait ProxyTrait
{
    public function __call(string $method, array $args)
    {
        return $this->getObject()->{$method}(...$args);
    }

    public function __get(string $property)
    {
        return $this->getObject()->{$property};
    }

    public function __set(string $property, mixed $value)
    {
        $this->getObject()->{$property} = $value;
    }

    public function __toString(): string
    {
        return $this->getObject()->__toString();
    }

    public function __invoke(...$args)
    {
        return $this->getObject()->__invoke(...$args);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getObject()->offsetGet($offset);
    }

    /**
     * @throws Exception
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->getObject()->offsetSet($offset, $value);
    }

    /**
     * @throws Exception
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->getObject()->offsetUnset($offset);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->getObject()->offsetExists($offset);
    }

    public function current(): mixed
    {
        return $this->getObject()->current();
    }

    public function next(): void
    {
        $this->getObject()->next();
    }

    public function key(): mixed
    {
        return $this->getObject()->key();
    }

    public function valid(): bool
    {
        return $this->getObject()->valid();
    }

    public function rewind(): void
    {
        $this->getObject()->rewind();
    }

    public function count(): int
    {
        return $this->getObject()->count();
    }

    abstract protected function getObject(): RemoteObject;
}
