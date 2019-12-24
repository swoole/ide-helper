<?php
/** @noinspection PhpComposerExtensionStubsInspection */

namespace Swoole;

class MultibyteStringObject extends StringObject
{
    /**
     * @return int
     */
    public function length(): int
    {
        return mb_strlen($this->string);
    }

    /**
     * @param string $needle
     * @param int $offset
     * @return bool|int
     */
    public function indexOf(string $needle, int $offset = 0)
    {
        return mb_strpos($this->string, $needle, $offset);
    }

    /**
     * @param string $needle
     * @param int $offset
     * @return bool|int
     */
    public function lastIndexOf(string $needle, int $offset = 0)
    {
        return mb_strrpos($this->string, $needle, $offset);
    }

    /**
     * @param string $needle
     * @param int $offset
     * @return bool|int
     */
    public function pos(string $needle, int $offset = 0)
    {
        return mb_strpos($this->string, $needle, $offset);
    }

    /**
     * @param string $needle
     * @param int $offset
     * @return bool|int
     */
    public function rpos(string $needle, int $offset = 0)
    {
        return mb_strrpos($this->string, $needle, $offset);
    }

    /**
     * @param string $needle
     * @return bool|int
     */
    public function ipos(string $needle)
    {
        return mb_stripos($this->string, $needle);
    }

    /**
     * @param int $offset
     * @param mixed ...$length
     * @return static
     */
    public function substr(int $offset, ...$length)
    {
        return new static(mb_substr($this->string, $offset, ...$length));
    }

    /**
     * @param int $splitLength
     * @return ArrayObject
     */
    public function chunk($splitLength = 1): ArrayObject
    {
        return static::detectArrayType(mb_split($this->string, $splitLength));
    }
}
