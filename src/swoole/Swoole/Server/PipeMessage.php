<?php

declare(strict_types=1);

namespace Swoole\Server;

/**
 * When method \Swoole\Server::sendMessage() is called to send a message to another worker process, an onPipeMessage
 * event is triggered in the target worker process.
 *
 * A PipeMessage object is passed to the onPipeMessage callback as the second argument when option
 * \Swoole\Constant::OPTION_EVENT_OBJECT is enabled on the server. Otherwise, the ID of the source worker process and
 * the message data are passed to the callback as two separate arguments. e.g.,
 * ```php
 * $server = new \Swoole\Server('127.0.0.1', 9501);
 * $server->set([\Swoole\Constant::OPTION_EVENT_OBJECT => true]);
 *
 * $server->on('pipeMessage', function (\Swoole\Server $server, \Swoole\Server\PipeMessage $message) {
 *     var_dump($message->source_worker_id, $message->data);
 * });
 *
 * $server->start();
 * ```
 *
 * @see \Swoole\Constant::OPTION_EVENT_OBJECT
 * @see \Swoole\Server::sendMessage()
 */
class PipeMessage
{
    /**
     * The ID of the worker process that sent the message.
     *
     * @see PipeMessage::$worker_id
     */
    public int $source_worker_id = 0;

    /**
     * The ID of the worker process that sent the message.
     *
     * This value is identical to property $this->source_worker_id. Both properties are retained for backward compatibility.
     *
     * @since 6.0.0 This property was accessible as a dynamic property in versions prior to Swoole 6.0.0, but it has been explicitly declared as of Swoole 6.0.0.
     * @see PipeMessage::$source_worker_id
     */
    public int $worker_id = 0;

    /**
     * The time when the message was dispatched.
     *
     * The value is in the same format as the return value of PHP function `microtime(true)`. i.e., the value is a float
     * representing the time in seconds since the Unix epoch accurate to the nearest microsecond.
     */
    public float $dispatch_time = 0;

    /**
     * The message data, exactly as it was passed to method \Swoole\Server::sendMessage().
     *
     * Strings are transferred as-is; values of any other type are serialized before being sent and unserialized before
     * being assigned to this property. Therefore, the message data must be serializable.
     *
     * @see \Swoole\Server::sendMessage()
     */
    public mixed $data;
}
