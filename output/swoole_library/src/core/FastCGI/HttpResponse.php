<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\FastCGI;

use Swoole\Http\Status;

class HttpResponse extends Response
{
    /** @var int */
    protected $statusCode;

    /** @var string */
    protected $reasonPhrase;

    /** @var array */
    protected $headers = [];

    /** @var array */
    protected $headersMap = [];

    /** @var array */
    protected $setCookieHeaderLines = [];

    public function __construct(array $records = [])
    {
        parent::__construct($records);
        $body = (string) $this->getBody();
        if (strlen($body) === 0) {
            return;
        }
        [$headers, $body] = @explode("\r\n\r\n", $body, 2);
        $headers = explode("\r\n", $headers);
        foreach ($headers as $header) {
            [$name, $value] = @explode(': ', $header, 2);
            if (strcasecmp($name, 'Status') === 0) {
                [$statusCode, $reasonPhrase] = @explode(' ', $value, 2);
            } elseif (strcasecmp($name, 'Set-Cookie') === 0) {
                $this->withSetCookieHeaderLine($value);
            } else {
                $this->withHeader($name, $value);
            }
        }
        $statusCode = (int) ($statusCode ?? Status::OK);
        $reasonPhrase = (string) ($reasonPhrase ?? Status::getReasonPhrase($statusCode));
        $this->withStatusCode($statusCode)->withReasonPhrase($reasonPhrase);
        $this->withBody($body);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function withStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    public function withReasonPhrase(string $reasonPhrase): self
    {
        $this->reasonPhrase = $reasonPhrase;
        return $this;
    }

    public function getHeader(string $name): ?string
    {
        $name = $this->headersMap[strtolower($name)] ?? null;
        return $name ? $this->headers[$name] : null;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function withHeader(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        $this->headersMap[strtolower($name)] = $name;
        return $this;
    }

    public function withHeaders(array $headers): self
    {
        foreach ($headers as $name => $value) {
            $this->withHeader($name, $value);
        }
        return $this;
    }

    public function getSetCookieHeaderLines(): array
    {
        return $this->setCookieHeaderLines;
    }

    public function withSetCookieHeaderLine(string $value): self
    {
        $this->setCookieHeaderLines[] = $value;
        return $this;
    }
}
