<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

namespace Swoole\Coroutine\Http2;

use Swoole\Constant;
use Swoole\Coroutine\Channel;
use Swoole\Http2\Request;
use Swoole\Http2\Response;

use function Swoole\Coroutine\go;

// This file is packed into the Swoole extension and evaluated at startup, where declaring a class
// whose parent is missing is a fatal error; the parent class only exists when the extension is
// compiled with HTTP/2 support (--enable-http2).
if (!class_exists(Client::class, false)) {
    return;
}

/**
 * An HTTP/2 client that multiplexes requests from many coroutines over one shared connection.
 *
 * A single recv-loop coroutine reads every response off the connection and routes it to the
 * requesting coroutine by stream ID. The connection is established on demand and re-established
 * transparently after a teardown (the pre-send health check only verifies the local socket state,
 * not peer liveness); a heartbeat checker closes it after a period without requests.
 *
 * The connection is owned by that machinery: the frame-level API inherited from the base class
 * (recv(), read(), write(), goaway()) is disabled and throws, and send() must not be called
 * directly -- the response to a stream that request() did not register would be parked forever,
 * and the connection could then never idle-close. Use request().
 *
 * Besides the settings understood by the underlying client, set() accepts two options that borrow
 * Swoole\Server's heartbeat vocabulary -- here they govern the client's own outbound connection:
 * - heartbeat_check_interval: seconds between two idle checks (default:
 *   DEFAULT_HEARTBEAT_CHECK_INTERVAL; non-positive values fall back to the default)
 * - heartbeat_idle_time: seconds without a new request after which a connection with no in-flight
 *   requests is closed automatically (default: DEFAULT_HEARTBEAT_IDLE_TIME); a non-positive value
 *   disables idle closing, in which case the connection stays open until close() is called or the
 *   peer closes it
 * Both are read when the heartbeat checker starts; changing them on a client whose checker is
 * already running takes effect only after the next close().
 *
 * Call close() once the client is no longer needed. The recv loop and the heartbeat checker are
 * coroutines of their own, and Swoole\Coroutine\run() returns only after every coroutine has ended:
 * a client left open holds it back until the connection is closed for being idle, which takes up to
 * heartbeat_idle_time plus heartbeat_check_interval seconds, and for as long as the peer keeps the
 * connection open when idle closing is disabled.
 */
final class MultiplexClient extends Client
{
    private const DEFAULT_HEARTBEAT_CHECK_INTERVAL = 3;

    private const DEFAULT_HEARTBEAT_IDLE_TIME = 10;

    /**
     * @var object|null identity token of the currently running recv loop; null when none is running.
     *                  A recv loop whose token no longer matches is stale and must exit without
     *                  closing the client: a newer loop may own the (reconnected) connection already.
     */
    private ?object $recvLoopToken = null;

    /**
     * @var Channel|null used by the heartbeat checker for an interruptible sleep; closed by close()
     *                   to wake the checker up immediately
     */
    private ?Channel $sleepChannel = null;

    /**
     * @var Channel|null present while a coroutine health-checks the connection and starts the shared
     *                   recv loop; other coroutines block on it (until it is closed) before sending
     */
    private ?Channel $startupBarrier = null;

    /**
     * @var array<int, Channel> per-stream channels carrying the responses of in-flight requests
     */
    private array $streamChannels = [];

    /**
     * @var array<int, true> IDs of streams whose requester timed out; the recv loop drops their late
     *                       responses instead of parking them
     */
    private array $abandonedStreams = [];

    /**
     * @var bool guards against spawning more than one heartbeat-checker coroutine
     */
    private bool $heartbeatCheckerRunning = false;

    /**
     * @var int number of request() calls currently in progress -- including connection setup and
     *          sending, where no stream channel exists yet; the heartbeat checker must not close
     *          the connection while one is pending
     */
    private int $pendingRequests = 0;

    /**
     * @var float Unix timestamp of the completion of the most recent request() call, successful or
     *            not; the heartbeat checker measures idleness against it
     */
    private float $lastActiveTime = 0;

    /**
     * Sends a request over the shared connection and waits for its response.
     *
     * Safe to call from any number of coroutines concurrently; the connection is established (or
     * re-established) on demand.
     *
     * @param float $timeout seconds to wait for the response. Non-positive values fall back to the
     *                       client's `timeout` setting; without that setting the wait is unbounded.
     * @return false|Response the response, or false on failure: the connection could not be
     *                        established, sending failed, the wait timed out or was canceled, or
     *                        the connection was closed while waiting. errCode/errMsg describe the
     *                        cause -- best-effort only: they live on the shared client, so read
     *                        them immediately after the false return, before yielding; a
     *                        concurrently failing request may overwrite them.
     */
    public function request(Request $request, float $timeout = -1): false|Response
    {
        if ($timeout <= 0) {
            // The ping check in ensureRecvLoop() only confirms the request could be written out, not
            // that the peer is alive, so an unbounded default wait could hang on a stale connection
            // forever.
            $timeout = (float) ($this->setting[Constant::OPTION_TIMEOUT] ?? -1);
        }
        // The counter -- not the stream-channel registry, which only has an entry once send() has
        // returned -- is what keeps the heartbeat checker from closing the connection while a
        // request is still connecting, sending, or waiting.
        $this->pendingRequests++;
        try {
            if (!$this->ensureRecvLoop()) {
                return false;
            }
            $streamId = $this->send($request);
            if ($streamId === false) {
                return false;
            }
            // The response can arrive before send() returns when send() yields on socket I/O; the
            // recv loop then has registered the stream channel already, with the response buffered
            // in it.
            $chan = $this->streamChannels[$streamId] ?? null;
            if ($chan === null) {
                if ($this->recvLoopToken === null) {
                    // The client was closed while send() yielded, and the flush has already dropped
                    // any response parked for this stream: fail fast instead of waiting out the
                    // timeout on a channel nothing will ever push to.
                    $this->setError(SWOOLE_ERROR_CLIENT_NO_CONNECTION, 'the connection was closed while the request was being sent');
                    return false;
                }
                $chan = $this->openStreamChannel($streamId);
            }
            $data = false;
            try {
                $data = $chan->pop($timeout);
            } finally {
                $this->closeStreamChannel($streamId);
                if ($data === false) {
                    if ($chan->errCode === SWOOLE_CHANNEL_CLOSED) {
                        // Connection teardown: no abandoned-stream marker may be left behind --
                        // stream IDs restart after a reconnect, and a stale marker would drop a
                        // response of the next connection.
                        $this->setError(SWOOLE_ERROR_CLIENT_NO_CONNECTION, 'the connection was closed while waiting for the response');
                    } else {
                        // Timed out or canceled: nobody waits for this stream anymore, but the
                        // connection lives on -- the recv loop must drop the late response instead
                        // of parking it, which would leak the parked channel (and block idle
                        // closing) until the connection closes.
                        $this->abandonedStreams[$streamId] = true;
                        if ($chan->errCode === SWOOLE_CHANNEL_TIMEOUT) {
                            $this->setError(SWOOLE_ERROR_CO_TIMEDOUT, 'the response timed out');
                        } else {
                            $this->setError(SWOOLE_ERROR_CO_CANCELED, 'the wait for the response was canceled');
                        }
                    }
                }
            }

            return $data;
        } finally {
            $this->pendingRequests--;
            // Idleness is measured from the completion of the last request, however it ended.
            $this->lastActiveTime = microtime(true);
        }
    }

    /**
     * Closes the connection, aborting every in-flight request (their request() calls return false)
     * and stopping the recv loop and the heartbeat checker.
     *
     * The client remains usable: the next request() reconnects.
     *
     * @return bool whether there was a connection (or a running recv loop) to tear down; false
     *              when there was nothing left to close, e.g. a repeated close() or a connection
     *              already closed by the heartbeat checker or the recv loop. Unlike in the base
     *              class, the value does not reflect the raw socket close: that reports failure
     *              whenever a coroutine is still bound to the socket, which on this class is the
     *              normal case -- the recv loop reads the connection permanently.
     */
    public function close(): bool
    {
        $wasUp = $this->connected || $this->recvLoopToken !== null;
        // Invalidate the connection before waking anyone: every requester woken during the
        // teardown may retry immediately, and must find the token cleared and reconnect instead
        // of sending into the socket being torn down. parent::close() itself resumes coroutines
        // bound to the socket (the recv loop, senders mid-send()) and reports
        // SW_ERROR_CO_SOCKET_CLOSE_WAIT on errCode while doing so -- mechanics, not a failure --
        // so the error slot is restored afterwards.
        $this->recvLoopToken = null;
        $errCode             = $this->errCode;
        $errMsg              = $this->errMsg;
        parent::close();
        $this->errCode = $errCode;
        $this->errMsg  = $errMsg;
        $this->flushStreamChannels();
        $this->abandonedStreams = [];
        // Clear the property before closing, as with the startup barrier: the close resumes the
        // heartbeat checker immediately, and when a requester woken above has already started a
        // new connection generation, the checker does not exit -- it must find the property null
        // and create a fresh channel, not re-enter pop() on the closed one, which returns without
        // yielding: a busy spin that would starve the event loop.
        $sleepChannel       = $this->sleepChannel;
        $this->sleepChannel = null;
        $sleepChannel?->close();
        return $wasUp;
    }

    /**
     * Disabled: the shared recv loop owns all reads on a multiplexed connection; reading from user
     * code would steal its frames and corrupt the routing of responses. Use request().
     *
     * @throws \BadMethodCallException always
     */
    public function recv(float $timeout = 0): Response|false
    {
        throw new \BadMethodCallException('the shared recv loop owns all reads on a multiplexed connection; use request()');
    }

    /**
     * Disabled: the shared recv loop owns all reads on a multiplexed connection. Use request().
     *
     * @throws \BadMethodCallException always
     */
    public function read(float $timeout = 0): Response|false
    {
        throw new \BadMethodCallException('the shared recv loop owns all reads on a multiplexed connection; use request()');
    }

    /**
     * Disabled: writing to a stream that request() did not register conflicts with the shared recv
     * loop, and its response could never be routed. Use request().
     *
     * @throws \BadMethodCallException always
     */
    public function write(int $stream_id, mixed $data, bool $end_stream = false): bool
    {
        throw new \BadMethodCallException('streams cannot be written to directly on a multiplexed connection; use request()');
    }

    /**
     * Disabled: shutting the connection down beneath the recv loop and the in-flight requests must
     * go through close().
     *
     * @throws \BadMethodCallException always
     */
    public function goaway(int $error_code = SWOOLE_HTTP2_ERROR_NO_ERROR, string $debug_data = ''): bool
    {
        throw new \BadMethodCallException('a multiplexed connection is shut down through close()');
    }

    /**
     * Registers the channel over which the response for the given stream will be delivered.
     */
    private function openStreamChannel(int $streamId): Channel
    {
        return $this->streamChannels[$streamId] = new Channel(1);
    }

    /**
     * Unregisters a stream's channel, waking its requester (pop() returns false) if one still waits.
     */
    private function closeStreamChannel(int $streamId): void
    {
        if ($channel = $this->streamChannels[$streamId] ?? null) {
            $channel->close();
        }

        unset($this->streamChannels[$streamId]);
    }

    /**
     * Aborts all in-flight requests by closing and unregistering their stream channels.
     */
    private function flushStreamChannels(): void
    {
        foreach (array_keys($this->streamChannels) as $streamId) {
            $this->closeStreamChannel($streamId);
        }
    }

    /**
     * Re-establishes the connection, discarding the current one.
     */
    private function reconnect(): bool
    {
        parent::close();
        return parent::connect();
    }

    /**
     * Makes sure the connection is healthy and the shared recv loop is running, (re)connecting and
     * starting the loop when needed. Serializes concurrent callers so that none of them sends while
     * the connection is still being set up.
     *
     * @return bool false when no recv loop is running: the connection could not be established
     *              (errCode/errMsg are connect()'s), or a concurrent close() aborted the startup
     */
    private function ensureRecvLoop(): bool
    {
        $this->ensureHeartbeatChecker();

        // The health check and the reconnect below both yield; sending during either would fail
        // spuriously. Coroutines arriving in the meantime must wait for the starter to finish
        // (closing the channel wakes all waiters) and then re-check, as the state has changed.
        while ($this->startupBarrier !== null) {
            $this->startupBarrier->pop();
        }
        if ($this->recvLoopToken !== null) {
            return true;
        }

        $this->startupBarrier = new Channel(1);
        $spawned              = false;
        $token                = null;
        try {
            $token = $this->recvLoopToken = new \stdClass();
            if (!$this->ping() && !$this->reconnect()) {
                // The connection cannot be established; connect() has recorded a precise errCode
                // (such as a refused connection). Returning here keeps the caller from send()ing,
                // which would overwrite it with a generic no-connection error.
                return false;
            }
            // close() may have cleared the token while ping()/reconnect() yielded. A loop spawned
            // with that stale token would park in recv() -- binding the socket -- while looking
            // stopped to everyone else, and the next request would spawn a second reader onto the
            // same socket.
            if ($this->recvLoopToken !== $token) {
                $this->setError(SWOOLE_ERROR_CLIENT_NO_CONNECTION, 'the connection was closed during startup');
                return false;
            }
            go(fn () => $this->recvLoop($token));
            $spawned = true;
            // The loop runs immediately until its first yield: on a connection that died between
            // connect() and the first read, it exits -- and runs close() -- before go() returns, so
            // an unconditional true here would let the caller send() on the closed client and
            // overwrite the precise errCode with a generic one.
            return $this->recvLoopToken === $token;
        } finally {
            if (!$spawned && $this->recvLoopToken === $token) {
                // Startup died before the recv loop was spawned (an exception from the health
                // check or reconnect): leave no token behind, or every later request would skip
                // reconnection and send with no coroutine reading the connection.
                $this->recvLoopToken = null;
            }
            // Clear the property before closing: close() resumes the waiters immediately, and a
            // waiter that still saw the barrier set would re-enter pop() on the closed channel,
            // which returns synchronously -- a busy spin that never yields back to this coroutine.
            $barrier              = $this->startupBarrier;
            $this->startupBarrier = null;
            $barrier->close();
        }
    }

    /**
     * Reads responses off the connection and routes each one to its requester's stream channel;
     * runs in a coroutine of its own until the connection breaks or the client is closed.
     *
     * @param object $token the loop's identity: once it no longer matches $recvLoopToken, this loop
     *                      is stale and exits without closing the client
     */
    private function recvLoop(object $token): void
    {
        $reason = 'unknown';
        try {
            while (true) {
                // Wait without a read timeout: recv() called without one falls back to the socket's
                // read timeout (the `timeout` setting, 60 seconds when unset), which would tear down
                // a merely quiet connection as broken -- aborting every in-flight request with it --
                // and cap how long any single response may take regardless of the timeout passed to
                // request(). Idle teardown belongs to the heartbeat checker alone. (parent:: because
                // the public recv() is disabled -- this loop is the connection's only reader.)
                $response = parent::recv(-1);

                if ($this->recvLoopToken !== $token) {
                    $reason = 'the client was closed or the loop was superseded';
                    break;
                }

                if ($response === false) {
                    $reason = 'the connection was broken';
                    break;
                }

                $streamId = $response->streamId;
                if ($channel = $this->streamChannels[$streamId] ?? null) {
                    $channel->push($response);
                } elseif (isset($this->abandonedStreams[$streamId])) {
                    unset($this->abandonedStreams[$streamId]);
                } elseif ($streamId % 2 === 1) {
                    // The response won the race against its requester registering the stream
                    // channel (client-initiated streams have odd IDs): register the channel
                    // here and buffer the response for the requester to pick up.
                    $this->openStreamChannel($streamId)->push($response);
                }
            }
        } catch (\Throwable $exception) {
            $reason = 'an exception was thrown: ' . $exception->getMessage();
            swoole_error_log(SWOOLE_LOG_ERROR, (string) $exception);
        } finally {
            swoole_error_log(SWOOLE_LOG_DEBUG, 'Recv loop stopped; the next request will restart it. Reason: ' . $reason);
            if ($this->recvLoopToken === $token) {
                $this->close();
            }
        }
    }

    /**
     * Makes sure the heartbeat checker is running, unless disabled: a coroutine that closes the
     * connection once no requests are in flight and none was sent for `heartbeat_idle_time` seconds.
     */
    private function ensureHeartbeatChecker(): void
    {
        if ($this->heartbeatCheckerRunning) {
            return;
        }
        $maxIdleTime = (float) ($this->setting[Constant::OPTION_HEARTBEAT_IDLE_TIME] ?? self::DEFAULT_HEARTBEAT_IDLE_TIME);
        if ($maxIdleTime <= 0) {
            return;
        }
        $checkInterval = (float) ($this->setting[Constant::OPTION_HEARTBEAT_CHECK_INTERVAL] ?? self::DEFAULT_HEARTBEAT_CHECK_INTERVAL);
        if ($checkInterval <= 0) {
            // A non-positive interval would make interruptibleSleep() wait forever -- silently
            // disabling idle closing through the wrong option while pinning the checker coroutine.
            $checkInterval = self::DEFAULT_HEARTBEAT_CHECK_INTERVAL;
        }

        $this->heartbeatCheckerRunning = true;
        go(
            function () use ($checkInterval, $maxIdleTime) {
                try {
                    while (true) {
                        $this->interruptibleSleep($checkInterval);
                        if ($this->recvLoopToken === null) {
                            break;
                        }
                        // The pending-requests counter covers requests still connecting or sending;
                        // the stream-channel registry covers responses parked for pickup.
                        if ($this->pendingRequests === 0 && $this->streamChannels === [] && microtime(true) - $this->lastActiveTime > $maxIdleTime) {
                            $this->close();
                            break;
                        }
                    }
                } finally {
                    $this->heartbeatCheckerRunning = false;
                }
            }
        );
    }

    /**
     * Records the failure of the current operation on the client's errCode/errMsg properties.
     */
    private function setError(int $errCode, string $errMsg): void
    {
        $this->errCode = $errCode;
        $this->errMsg  = $errMsg;
    }

    /**
     * Sleeps for the given number of seconds, or until close() wakes the sleeper up early by
     * closing the sleep channel.
     */
    private function interruptibleSleep(float $seconds): void
    {
        // Deliberately not the null-coalescing assignment operator: written adjacently it contains
        // a C trigraph sequence that breaks this file when packed into the extension header.
        $this->sleepChannel = $this->sleepChannel ?? new Channel(1);
        $this->sleepChannel->pop($seconds);
    }
}
