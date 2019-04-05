<?php

class_alias(Swoole\Coroutine\Channel::class, co\channel::class);
class_alias(Swoole\Coroutine\Client::class, co\client::class);
class_alias(Swoole\Coroutine\Context::class, co\context::class);
class_alias(Swoole\Coroutine\Http2\Client::class, co\http2\client::class);
class_alias(Swoole\Coroutine\Http\Client::class, co\http\client::class);
class_alias(Swoole\Coroutine\Http\Client\Exception::class, co\http\client\exception::class);
class_alias(Swoole\Coroutine\Iterator::class, co\iterator::class);
class_alias(Swoole\Coroutine\Mysql::class, co\mysql::class);
class_alias(Swoole\Coroutine\Mysql\Exception::class, co\mysql\exception::class);
class_alias(Swoole\Coroutine\Mysql\Statement::class, co\mysql\statement::class);
class_alias(Swoole\Coroutine\Redis::class, co\redis::class);
class_alias(Swoole\Coroutine\Socket::class, co\socket::class);
class_alias(Swoole\Coroutine\Socket\Exception::class, co\socket\exception::class);

class_alias(Swoole\Atomic::class, 'swoole_atomic');
class_alias(Swoole\Atomic\Long::class, 'swoole_atomic_long');
class_alias(Swoole\Buffer::class, 'swoole_buffer');
class_alias(Swoole\Client::class, 'swoole_client');
class_alias(Swoole\Connection\Iterator::class, 'swoole_connection_iterator');
class_alias(Swoole\Coroutine::class, 'co');
class_alias(Swoole\Coroutine\Channel::class, 'chan');
class_alias(Swoole\Event::class, 'swoole_event');
class_alias(Swoole\Exception::class, 'swoole_exception');
class_alias(Swoole\Http2\Request::class, 'swoole_http2_request');
class_alias(Swoole\Http2\Response::class, 'swoole_http2_response');
class_alias(Swoole\Http\Request::class, 'swoole_http_request');
class_alias(Swoole\Http\Response::class, 'swoole_http_response');
class_alias(Swoole\Http\Server::class, 'swoole_http_server');
class_alias(Swoole\Lock::class, 'swoole_lock');
class_alias(Swoole\Process::class, 'swoole_process');
class_alias(Swoole\Process\Pool::class, 'swoole_process_pool');
class_alias(Swoole\Redis\Server::class, 'swoole_redis_server');
class_alias(Swoole\Runtime::class, 'swoole_runtime');
class_alias(Swoole\Serialize::class, 'swoole_serialize');
class_alias(Swoole\Server::class, 'swoole_server');
class_alias(Swoole\Server\Port::class, 'swoole_server_port');
class_alias(Swoole\Server\Task::class, 'swoole_server_task');
class_alias(Swoole\Table::class, 'swoole_table');
class_alias(Swoole\Table\Row::class, 'swoole_table_row');
class_alias(Swoole\Timer::class, 'swoole_timer');
class_alias(Swoole\Websocket\Closeframe::class, 'swoole_websocket_closeframe');
class_alias(Swoole\Websocket\Frame::class, 'swoole_websocket_frame');
class_alias(Swoole\Websocket\Server::class, 'swoole_websocket_server');

