<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This class works the same as PHP class \ArrayIterator.
 *
 * @alias It's safe to assume that this class is an alias of PHP class \ArrayIterator.
 * @see https://www.php.net/ArrayIterator
 *
 * @alias This class has an alias of "\Co\Iterator" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Iterator
 */
class Iterator extends \ArrayIterator
{
    public const STD_PROP_LIST = 1;

    public const ARRAY_AS_PROPS = 2;
}
