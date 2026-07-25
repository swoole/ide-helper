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
     * @param string $name The name of the cookie. It must not be empty, and must not contain the character "=" or
     *                     illegal characters (control characters and the characters ",", ";", " ", "\t", "\r", "\n",
     *                     "\013", and "\014"); otherwise, serializing the cookie fails.
     * @return Cookie The same object, for method chaining.
     */
    public function withName(string $name): Cookie
    {
    }

    /**
     * Set the value of the cookie.
     *
     * @param string $value The value of the cookie. When an empty string is given, the cookie is marked as deleted
     *                      (expired immediately) when serialized.
     *                      Although Swoole declares this parameter as optional (with an empty string as the default
     *                      value), it is actually required: calling the method without it fails at runtime.
     * @return Cookie The same object, for method chaining.
     */
    public function withValue(string $value): Cookie
    {
    }

    /**
     * Set when the cookie expires, as a Unix timestamp. 0 (the default) makes it a session cookie that is discarded
     * when the browser is closed.
     *
     * @param int $expires When the cookie expires, as a Unix timestamp. The expiration year must not be greater than
     *                     9999; otherwise, serializing the cookie fails.
     * @return Cookie The same object, for method chaining.
     */
    public function withExpires(int $expires = 0): Cookie
    {
    }

    /**
     * Set the path on the server the cookie applies to.
     *
     * @param string $path The path. It must not contain illegal characters (control characters and the characters ",",
     *                     ";", " ", "\t", "\r", "\n", "\013", and "\014"); otherwise, serializing the cookie fails.
     *                     Although Swoole declares this parameter as optional (with "/" as the default value), it is
     *                     actually required: calling the method without it fails at runtime.
     * @return Cookie The same object, for method chaining.
     */
    public function withPath(string $path): Cookie
    {
    }

    /**
     * Set the domain the cookie applies to.
     *
     * @param string $domain The domain. It must not contain illegal characters (control characters and the characters
     *                       ",", ";", " ", "\t", "\r", "\n", "\013", and "\014"); otherwise, serializing the cookie
     *                       fails.
     *                       Although Swoole declares this parameter as optional (with an empty string as the default
     *                       value), it is actually required: calling the method without it fails at runtime.
     * @return Cookie The same object, for method chaining.
     */
    public function withDomain(string $domain): Cookie
    {
    }

    /**
     * Set whether the cookie should only be sent over HTTPS connections.
     *
     * @param bool $secure Whether the cookie should only be sent over HTTPS connections.
     * @return Cookie The same object, for method chaining.
     */
    public function withSecure(bool $secure = false): Cookie
    {
    }

    /**
     * Set whether the cookie should be inaccessible to client-side JavaScript (i.e., the "HttpOnly" attribute).
     *
     * @param bool $httpOnly Whether to include the "HttpOnly" attribute.
     * @return Cookie The same object, for method chaining.
     */
    public function withHttpOnly(bool $httpOnly = false): Cookie
    {
    }

    /**
     * Set the "SameSite" attribute of the cookie, which controls whether the cookie is sent with cross-site requests.
     *
     * @param string $sameSite One of "Strict", "Lax", or "None". An empty string omits the attribute.
     *                         Although Swoole declares this parameter as optional (with an empty string as the default
     *                         value), it is actually required: calling the method without it fails at runtime.
     * @return Cookie The same object, for method chaining.
     */
    public function withSameSite(string $sameSite): Cookie
    {
    }

    /**
     * Set the "Priority" attribute of the cookie.
     *
     * @param string $priority One of "Low", "Medium", or "High". An empty string omits the attribute.
     *                         Although Swoole declares this parameter as optional (with an empty string as the default
     *                         value), it is actually required: calling the method without it fails at runtime.
     * @return Cookie The same object, for method chaining.
     */
    public function withPriority(string $priority): Cookie
    {
    }

    /**
     * Set the "Partitioned" attribute of the cookie, opting it into partitioned storage (CHIPS).
     *
     * @param bool $partitioned Whether to include the "Partitioned" attribute.
     * @return Cookie The same object, for method chaining.
     */
    public function withPartitioned(bool $partitioned = false): Cookie
    {
    }

    /**
     * Serialize the cookie into the value of a "Set-Cookie" header.
     *
     * Note that prior to Swoole 6.1.7, when the cookie had an empty value (i.e., a deletion cookie meant to make the
     * browser drop the cookie right away), the serialized string left out the path, domain, secure, HttpOnly,
     * SameSite, Priority, and Partitioned attributes; this was fixed in Swoole 6.1.7. The fix matters because a
     * browser only removes a cookie when the path and domain of the deletion cookie match those the cookie was
     * originally set with.
     *
     * @return string|false Return the serialized cookie string; return FALSE when serialization fails — because the
     *                      cookie has no name, an attribute (name, value, path, or domain) contains illegal
     *                      characters, or the expiration year is greater than 9999 — in which case the object is also
     *                      reset back to its default state.
     * @see \Swoole\Http\Cookie::reset()
     */
    public function toString(): string|false
    {
    }

    /**
     * Return all the attributes of the cookie as an associative array.
     *
     * @return array An associative array with the following keys: "name", "value", "path", "domain", "sameSite", and
     *               "priority" (strings; empty when not set), "encode", "secure", "httpOnly", and "partitioned"
     *               (booleans), and "expires" (integer, a Unix timestamp).
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
