<?php

declare(strict_types=1);

namespace Swoole\Http;

/**
 * A builder object for an HTTP response cookie.
 *
 * Instead of passing a long list of positional arguments to \Swoole\Http\Response::cookie(), you can configure a cookie
 * step by step with the fluent with*() methods below, then hand the resulting object to
 * \Swoole\Http\Response::cookie() (or setCookie()/rawcookie()/setRawCookie()). Every with*() method mutates the object
 * in place and returns the same object, so calls can be chained. e.g.,
 * ```php
 * $cookie = (new \Swoole\Http\Cookie())
 *     ->withName('session_id')
 *     ->withValue('abc123')
 *     ->withExpires(time() + 3600)
 *     ->withPath('/')
 *     ->withHttpOnly(true)
 *     ->withSameSite('Lax');
 * $response->cookie($cookie);
 * ```
 *
 * @not-serializable Objects of this class cannot be serialized.
 * @see \Swoole\Http\Response::cookie()
 * @see \Swoole\Http\Response::setCookie()
 * @see \Swoole\Http\Response::rawcookie()
 * @see \Swoole\Http\Response::setRawCookie()
 * @since 6.0.0
 */
class Cookie
{
    /**
     * @param bool $encode Whether the cookie value should be urlencoded when the cookie is serialized. Passing FALSE
     *                     keeps the value verbatim, matching the behavior of \Swoole\Http\Response::rawcookie().
     */
    public function __construct(bool $encode = true)
    {
    }

    /**
     * Set the name of the cookie.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withName(string $name): Cookie
    {
    }

    /**
     * Set the value of the cookie.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withValue(string $value = ''): Cookie
    {
    }

    /**
     * Set when the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie that is discarded
     * when the browser is closed.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withExpires(int $expires = 0): Cookie
    {
    }

    /**
     * Set the path on the server the cookie applies to.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withPath(string $path = '/'): Cookie
    {
    }

    /**
     * Set the domain the cookie applies to.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withDomain(string $domain = ''): Cookie
    {
    }

    /**
     * Set whether the cookie should only be sent over HTTPS connections.
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withSecure(bool $secure = false): Cookie
    {
    }

    /**
     * Set whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly" attribute).
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withHttpOnly(bool $httpOnly = false): Cookie
    {
    }

    /**
     * Set the "SameSite" attribute of the cookie, which controls whether the cookie is sent with cross-site requests.
     *
     * @param string $sameSite One of "Strict", "Lax", or "None". An empty string (the default) omits the attribute.
     * @return Cookie The same object, for method chaining.
     */
    public function withSameSite(string $sameSite = ''): Cookie
    {
    }

    /**
     * Set the "Priority" attribute of the cookie.
     *
     * @param string $priority One of "Low", "Medium", or "High". An empty string (the default) omits the attribute.
     * @return Cookie The same object, for method chaining.
     */
    public function withPriority(string $priority = ''): Cookie
    {
    }

    /**
     * Set the "Partitioned" attribute of the cookie, opting it into partitioned storage (CHIPS).
     *
     * @return Cookie The same object, for method chaining.
     */
    public function withPartitioned(bool $partitioned = false): Cookie
    {
    }

    /**
     * Serialize the cookie into the value of a "Set-Cookie" header.
     *
     * @return string|false Return the serialized cookie string; return FALSE when the cookie has no name, in which case
     *                      the object is also reset back to its default state.
     * @see \Swoole\Http\Cookie::reset()
     */
    public function toString(): string|false
    {
    }

    /**
     * Return all the attributes of the cookie as an associative array.
     */
    public function toArray(): array
    {
    }

    /**
     * Reset all the attributes of the cookie back to their default values.
     */
    public function reset(): void
    {
    }
}
