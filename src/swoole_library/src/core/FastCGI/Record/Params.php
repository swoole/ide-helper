<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\FastCGI\Record;

use Swoole\FastCGI;
use Swoole\FastCGI\Record;

/**
 * Params request record
 */
class Params extends Record
{
    /**
     * List of params
     *
     * @var string[]
     * @phpstan-var array<string, string>
     */
    protected array $values = [];

    /**
     * Constructs a param request
     *
     * @phpstan-param array<string, string> $values
     */
    public function __construct(array $values)
    {
        $this->type   = FastCGI::PARAMS;
        $this->values = $values;
        $this->setContentData($this->packPayload());
    }

    /**
     * Returns an associative list of parameters
     *
     * @phpstan-return array<string, string>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * {@inheritdoc}
     * @param static $self
     */
    protected static function unpackPayload(Record $self, string $binaryData): void
    {
        assert($self instanceof self); // @phpstan-ignore function.alreadyNarrowedType,instanceof.alwaysTrue
        // Record::unpack() has already checked that the buffer holds the whole content (and the padding), so every
        // read below is bounded by the content length alone. Decoding by offset, instead of cutting the rest of the
        // buffer off for every pair, keeps the cost linear in the payload size.
        $contentLength = $self->getContentLength();
        $offset        = 0;
        while ($offset < $contentLength) {
            $nameLength  = self::unpackLength($binaryData, $contentLength, $offset);
            $valueLength = self::unpackLength($binaryData, $contentLength, $offset);
            if ($offset + $nameLength + $valueLength > $contentLength) {
                throw new \RuntimeException('Can not unpack data from the binary buffer');
            }
            $self->values[substr($binaryData, $offset, $nameLength)] = substr($binaryData, $offset + $nameLength, $valueLength);
            $offset += $nameLength + $valueLength;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function packPayload(): string
    {
        $payload = '';
        foreach ($this->values as $nameData => $valueData) {
            if ($valueData === null) { // @phpstan-ignore identical.alwaysFalse
                continue;
            }
            $valueData   = (string) $valueData;
            $nameLength  = strlen($nameData);
            $valueLength = strlen($valueData);
            // Each length is one byte up to 127, and four bytes with the top bit set above that. The name and the
            // value follow as they are, so they are appended directly rather than copied through pack("a{n}").
            $payload .= ($nameLength > 127 ? pack('N', $nameLength | 0x80000000) : chr($nameLength))
                . ($valueLength > 127 ? pack('N', $valueLength | 0x80000000) : chr($valueLength))
                . $nameData
                . $valueData;
        }

        return $payload;
    }

    /**
     * Reads the length at $offset, one byte up to 127 or four bytes with the top bit set above that, and moves
     * $offset past it.
     */
    private static function unpackLength(string $binaryData, int $contentLength, int &$offset): int
    {
        if ($offset >= $contentLength) {
            throw new \RuntimeException('Can not unpack data from the binary buffer');
        }
        $length = ord($binaryData[$offset]);
        if ($length >> 7 === 0) {
            $offset++;
            return $length;
        }
        if ($offset + 4 > $contentLength) {
            throw new \RuntimeException('Can not unpack data from the binary buffer');
        }
        /** @phpstan-var false|array{1: int} */
        $payload = unpack('N', $binaryData, $offset);
        if ($payload === false) {
            throw new \RuntimeException('Can not unpack data from the binary buffer');
        }
        $offset += 4;
        return $payload[1] & 0x7FFFFFFF;
    }
}
