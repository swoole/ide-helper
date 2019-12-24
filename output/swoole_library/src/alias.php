<?php
if (SWOOLE_USE_SHORTNAME) {
    class_alias(Swoole\Coroutine\WaitGroup::class, Co\WaitGroup::class, true);
    class_alias(Swoole\Coroutine\Server::class, Co\Server::class, true);
}
