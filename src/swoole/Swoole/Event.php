<?php

declare(strict_types=1);

namespace Swoole;

/**
 * The Event class gives direct access to the event loop of the current process, allowing sockets, streams, and other
 * file descriptors to be watched for readability and/or writability, and callback functions to be scheduled on the
 * event loop.
 *
 * All methods of this class are static. Objects of this class can't be instantiated; trying to instantiate one
 * results in an \Error being thrown.
 */
class Event
{
    /**
     * Add a file descriptor to the event loop and watch it for readability and/or writability.
     *
     * The event loop of the process is created implicitly when this method is called, if it doesn't exist yet.
     *
     * @param mixed $fd The descriptor to watch: an int file descriptor, a stream or socket resource, or an object of
     *                  class \Swoole\Coroutine\Socket, \Swoole\Client, or \Swoole\Process (in which case the pipe of
     *                  the process is watched).
     * @param callable|null $read_callback Called with $fd as its only argument when $fd becomes readable. Required
     *                                     when $events includes SWOOLE_EVENT_READ.
     * @param callable|null $write_callback Called with $fd as its only argument when $fd becomes writable. Required
     *                                      when $events includes SWOOLE_EVENT_WRITE.
     * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
     * @return int|false Returns the file descriptor being watched on success, or false on failure (e.g., an
     *                   unrecognized $fd, a descriptor that is already being watched, an invalid $events value, or a
     *                   missing callback for one of the events in $events); an E_WARNING level error is thrown out as
     *                   well when the method fails.
     * @alias This method has an alias function \swoole_event_add().
     * @see \swoole_event_add()
     * @see \Swoole\Event::set()
     * @see \Swoole\Event::del()
     */
    public static function add(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = SWOOLE_EVENT_READ): int|false
    {
    }

    /**
     * Remove a file descriptor from the event loop, along with the callback functions registered for it.
     *
     * @param mixed $fd The descriptor to stop watching. It accepts the same types of values as method
     *                  \Swoole\Event::add() does.
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when the
     *              event loop doesn't exist or when $fd is unrecognized; it returns false without an error when $fd
     *              is not being watched.
     * @alias This method has an alias function \swoole_event_del().
     * @see \swoole_event_del()
     * @see \Swoole\Event::add()
     */
    public static function del(mixed $fd): bool
    {
    }

    /**
     * Update the callback functions and/or the watched events of a file descriptor that has been added to the event
     * loop.
     *
     * Only the callback functions passed in are replaced: when null is passed for $read_callback or $write_callback,
     * the corresponding callback registered before is kept. The set of watched events, however, is replaced with
     * $events as a whole.
     *
     * @param mixed $fd The descriptor being watched. It accepts the same types of values as method
     *                  \Swoole\Event::add() does.
     * @param callable|null $read_callback Called with $fd as its only argument when $fd becomes readable. When null
     *                                     is passed, the read callback registered before remains in use.
     * @param callable|null $write_callback Called with $fd as its only argument when $fd becomes writable. When null
     *                                      is passed, the write callback registered before remains in use.
     * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when the
     *              event loop doesn't exist, when $fd is unrecognized or not being watched, or when no callback is
     *              available for one of the events in $events.
     * @alias This method has an alias function \swoole_event_set().
     * @see \swoole_event_set()
     * @see \Swoole\Event::add()
     */
    public static function set(mixed $fd, ?callable $read_callback = null, ?callable $write_callback = null, int $events = 0): bool
    {
    }

    /**
     * Check if a file descriptor is being watched in the event loop for any of the given events.
     *
     * @param mixed $fd The descriptor to check. It accepts the same types of values as method \Swoole\Event::add()
     *                  does.
     * @param int $events a SWOOLE_EVENT_READ or SWOOLE_EVENT_WRITE event, or both (SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE).
     * @return bool Returns true if the descriptor is being watched for at least one of the events in $events;
     *              returns false otherwise, including when the event loop doesn't exist or when $fd is unrecognized.
     * @alias This method has an alias function \swoole_event_isset().
     * @see \swoole_event_isset()
     * @see \Swoole\Event::add()
     */
    public static function isset(mixed $fd, int $events = SWOOLE_EVENT_READ | SWOOLE_EVENT_WRITE): bool
    {
    }

    /**
     * Run the event loop for a single round: pending events are processed once, and then the method returns.
     *
     * Unlike method \Swoole\Event::wait(), this method doesn't keep the event loop running until there is nothing
     * left to process, and it doesn't destroy the event loop before returning. It's typically used to embed Swoole's
     * event loop into an event loop managed by other code (e.g., that of ReactPHP or Amp).
     *
     * @return bool Returns true after the round is processed; returns false when the event loop doesn't exist.
     * @alias This method has an alias function \swoole_event_dispatch().
     * @see \swoole_event_dispatch()
     * @see \Swoole\Event::wait()
     */
    public static function dispatch(): bool
    {
    }

    /**
     * Defers the execution of the given callback.
     *
     * This function works similarly to statement "setTimeout(callback, 0)" in JavaScript.
     *
     * @param callable $callback The callback to be executed.
     * @return true This method always returns true.
     * @alias This method has an alias function \swoole_event_defer().
     * @see \swoole_event_defer()
     * @see \Swoole\Timer::after() Add a timer that only runs once after the specified number of milliseconds.
     */
    public static function defer(callable $callback): bool
    {
    }

    /**
     * Register a callback function to be executed at the end of each round of the event loop, or, when $before is
     * true, at the beginning of each round.
     *
     * At most one end-of-round callback and one beginning-of-round callback can be registered at a time; registering
     * a new one replaces the one registered before. The callback function is executed without arguments.
     *
     * The event loop of the process is created implicitly when this method is called, if it doesn't exist yet.
     *
     * @param callable|null $callback The callback function. When null is passed, the end-of-round callback registered
     *                                before is removed ($before is ignored in this case).
     * @param bool $before Execute the callback function at the beginning of each round, instead of at the end.
     * @return bool Returns true on success; returns false when $callback is null but there is no callback to remove.
     * @alias This method has an alias function \swoole_event_cycle().
     * @see \swoole_event_cycle()
     */
    public static function cycle(?callable $callback, bool $before = false): bool
    {
    }

    /**
     * Write data to a file descriptor previously added to the event loop with method \Swoole\Event::add().
     *
     * The write is asynchronous: data that can't be written out immediately is put in a write buffer inside the
     * event loop and delivered once the descriptor becomes writable, without blocking the process.
     *
     * @param mixed $fd The descriptor to write to. It accepts the same types of values as method \Swoole\Event::add()
     *                  does, and it must have been added to the event loop already.
     * @param string $data The data to write. It can't be empty.
     * @return bool Returns true on success. It returns false, with an E_WARNING level error thrown out, when $data
     *              is empty, when $fd is unrecognized, or when $fd is not being watched in the event loop; it also
     *              returns false when the write fails.
     * @alias This method has an alias function \swoole_event_write().
     * @see \swoole_event_write()
     * @see \Swoole\Event::add()
     */
    public static function write(mixed $fd, string $data): bool
    {
    }

    /**
     * Run the event loop until there is nothing left to process (no watched descriptors, no timers, no deferred
     * callbacks, etc.), and then destroy it.
     *
     * This method should be called at the end of the script, after all the events have been set up. It does nothing
     * when the event loop doesn't exist, and it can't be called inside a coroutine (a fatal error is triggered in
     * that case).
     *
     * @alias This method has an alias function \swoole_event_wait().
     * @see \swoole_event_wait()
     * @see \Swoole\Event::dispatch()
     * @see \Swoole\Event::exit()
     */
    public static function wait(): void
    {
    }

    /**
     * Run the event loop while the PHP request shuts down.
     *
     * This method is registered as a shutdown function automatically when the event loop is created; it's not meant
     * to be called directly. Running the event loop from a shutdown function this way is deprecated and triggers an
     * E_DEPRECATED error ("Event::wait() in shutdown function is deprecated"). To avoid the error, don't rely on the
     * event loop being run for you at shutdown: either wrap the code in function \Swoole\Coroutine\run(), or call
     * method \Swoole\Event::wait() yourself at the end of the script.
     *
     * @alias This method has an alias function \swoole_event_rshutdown() (since Swoole 6.2.0).
     * @deprecated 4.6.0 Use function \Swoole\Coroutine\run(), or call method \Swoole\Event::wait() explicitly, instead.
     * @see \swoole_event_rshutdown()
     * @see \Swoole\Coroutine\run()
     * @see \Swoole\Event::wait()
     */
    public static function rshutdown(): void
    {
    }

    /**
     * Make the running event loop exit: all the timers created in PHP are cleared, and the event loop stops running
     * even if there are still events to process.
     *
     * This method does nothing when the event loop doesn't exist.
     *
     * @alias This method has an alias function \swoole_event_exit().
     * @see \swoole_event_exit()
     * @see \Swoole\Event::wait()
     */
    public static function exit(): void
    {
    }
}
