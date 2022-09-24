<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

/**
 * This class works the same as PHP class \ArrayObject.
 *
 * @alias It's safe to assume that this class is an alias of PHP class \ArrayObject.
 * @see https://www.php.net/ArrayObject
 *
 * @alias This class has an alias of "\Co\Context" when directive "swoole.use_shortname" is not explicitly turned off.
 * @see \Co\Context
 */
class Context extends \ArrayObject
{
    public const STD_PROP_LIST = 1;

    public const ARRAY_AS_PROPS = 2;
}
