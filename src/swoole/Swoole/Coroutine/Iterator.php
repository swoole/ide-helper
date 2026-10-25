<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * An iterator that can be used to iterate over the IDs of all the running coroutines within the process.
 *
 * In Swoole, this class is only used for \Swoole\Coroutine::list() and \Swoole\Coroutine::listCoroutines(), where the
 * return value is an instance of this class. e.g.,
 * ```php
 * foreach (\Swoole\Coroutine::list() as $cid) {
 *   var_dump(\Swoole\Coroutine::getBackTrace($cid));
 * };
 * ```
 *
 * The class extends PHP class \ArrayIterator without adding or changing anything, so it's safe to treat it as a plain
 * \ArrayIterator.
 *
 * @see \Swoole\Coroutine::list()
 * @see \Swoole\Coroutine::listCoroutines()
 * @see https://www.php.net/ArrayIterator
 * @see \Co\Iterator
 * @alias This class has an alias of "\Co\Iterator" when directive "swoole.use_shortname" is not explicitly turned off.
 */
class Iterator extends \ArrayIterator
{
}
