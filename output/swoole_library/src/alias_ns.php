<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Coroutine {
    function run(callable $fn, ...$args)
    {
        $s = new Scheduler();
        $s->add($fn, ...$args);
        return $s->start();
    }
}

namespace Co {
    if (SWOOLE_USE_SHORTNAME) {
        function run(callable $fn, ...$args)
        {
            return \Swoole\Coroutine\Run($fn, ...$args);
        }
    }
}
