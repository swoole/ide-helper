<?php

declare(strict_types=1);

/**
 * Alias classes listed below are available only when directive "swoole.use_shortname" is not explicitly turned off.
 */
class_alias(Swoole\Coroutine\Channel::class, Co\Channel::class);
class_alias(Swoole\Coroutine\Client::class, Co\Client::class);
class_alias(Swoole\Coroutine\Context::class, Co\Context::class);
class_alias(Swoole\Coroutine\Curl\Exception::class, Co\Curl\Exception::class);
class_alias(Swoole\Coroutine\Http2\Client::class, Co\Http2\Client::class);
class_alias(Swoole\Coroutine\Http2\Client\Exception::class, Co\Http2\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Client::class, Co\Http\Client::class);
class_alias(Swoole\Coroutine\Http\Client\Exception::class, Co\Http\Client\Exception::class);
class_alias(Swoole\Coroutine\Http\Server::class, Co\Http\Server::class);
class_alias(Swoole\Coroutine\Iterator::class, Co\Iterator::class);
class_alias(Swoole\Coroutine\MySQL::class, Co\MySQL::class);
class_alias(Swoole\Coroutine\MySQL\Exception::class, Co\MySQL\Exception::class);
class_alias(Swoole\Coroutine\MySQL\Statement::class, Co\MySQL\Statement::class);
class_alias(Swoole\Coroutine\PostgreSQL::class, Co\PostgreSQL::class);
class_alias(Swoole\Coroutine\Redis::class, Co\Redis::class);
class_alias(Swoole\Coroutine\Scheduler::class, Co\Scheduler::class);
class_alias(Swoole\Coroutine\Socket::class, Co\Socket::class);
class_alias(Swoole\Coroutine\Socket\Exception::class, Co\Socket\Exception::class);
class_alias(Swoole\Coroutine\System::class, Co\System::class);

class_alias(Swoole\Coroutine::class, co::class);
class_alias(Swoole\Coroutine\Channel::class, chan::class);
