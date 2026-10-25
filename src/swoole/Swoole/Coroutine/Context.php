<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * The Context object of a coroutine is a key-value storage. It is used to store custom data for the coroutine.
 *
 * Each coroutine has a unique Context object automatically associated with it. The Context object of a coroutine can be
 * accessed by calling method `\Swoole\Coroutine::getContext()`; the object can be accessed from anywhere of current
 * process, as long as the associated coroutine still exists.
 *
 * The Context object will be automatically destroyed when the coroutine finishes execution and gets destroyed.
 *
 * The class extends PHP class \ArrayObject without adding or changing anything, so it's safe to treat it as a plain
 * \ArrayObject.
 *
 * @see https://www.php.net/ArrayObject
 * @see \Co\Context
 * @see \Swoole\Coroutine::getContext()
 * @alias This class has an alias of "\Co\Context" when directive "swoole.use_shortname" is not explicitly turned off.
 */
class Context extends \ArrayObject
{
}
