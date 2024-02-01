<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole;

class MultibyteStringObject extends StringObject
{
    public function length(): int
    {
        return mb_strlen($this->string);
    }

    public function indexOf(string $needle, int $offset = 0, ?string $encoding = null): false|int
    {
        return mb_strpos($this->string, $needle, $offset, $encoding);
    }

    public function lastIndexOf(string $needle, int $offset = 0, ?string $encoding = null): false|int
    {
        return mb_strrpos($this->string, $needle, $offset, $encoding);
    }

    public function pos(string $needle, int $offset = 0, ?string $encoding = null): false|int
    {
        return mb_strpos($this->string, $needle, $offset, $encoding);
    }

    public function rpos(string $needle, int $offset = 0, ?string $encoding = null): false|int
    {
        return mb_strrpos($this->string, $needle, $offset, $encoding);
    }

    public function ipos(string $needle, int $offset = 0, ?string $encoding = null): int|false
    {
        return mb_stripos($this->string, $needle, $offset, $encoding);
    }

    /**
     * @todo First parameter will be renamed to $start in Swoole 5.2+.
     * @todo This method will be refactored and marked as final in Swoole 5.2+.
     *       1. It should use keyword self instead of static.
     *       2. Don't use function func_get_args().
     */
    public function substr(int $offset, ?int $length = null, ?string $encoding = null): static
    {
        return new static(mb_substr($this->string, ...func_get_args())); // @phpstan-ignore new.static
    }

    /**
     * @todo This method is not implemented correctly.
     */
    public function chunk(int $splitLength = 1, ?int $limit = null): ArrayObject
    {
        return static::detectArrayType(mb_split($this->string, ...func_get_args()));
    }
}
