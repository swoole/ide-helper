# Deep review progress — Swoole 6.0.2 stubs

Review target: Swoole v6.0.2 (SWOOLE_VERSION in constants.php).
swoole-src checkout: /tmp/swoole-review @ v6.0.2
Branch: deep-review-swoole-stubs-team-opus
Session: 2026-07-24, team of 8 Opus fixer sub-agents. All 64 files audited symbol-by-symbol
against real swoole-src v6.0.2 .cc/.h source (never .stub.php).

Legend: [ ] pending, [~] in progress, [x] done (with note)

## Tier 1 — Foundation
- [x] src/swoole/constants.php — added SWOOLE_IOURING_DEFAULT/SWOOLE_IOURING_SQPOLL (gated on --enable-iouring, @since v6.0.0); every other constant name/value/gate verified, no removals.
- [x] src/swoole/functions.php — fixed 7 signature/return defects: swoole_event_add int|false, swoole_substr_unserialize/json_decode $length=0 default, swoole_implicit_fn mixed args/return, swoole_async_set bool, 3 admin-server return types, swoole_event_defer bool.
- [x] src/swoole/shortnames.php — corrected curl exception short name to Co\Coroutine\Curl\Exception (interface.cc:247); other 15 aliases verified.

## Tier 2 — Core server & networking
- [x] Swoole/Server.php — fixed command() @param $json_encode -> $json_decode; both v6.0.2 @see line links verified.
- [x] Swoole/Server/Port.php — verified accurate.
- [x] Swoole/Server/Event.php — verified accurate.
- [x] Swoole/Server/PipeMessage.php — verified accurate.
- [x] Swoole/Server/Task.php — verified accurate (final, not-serializable).
- [x] Swoole/Server/TaskResult.php — verified accurate.
- [x] Swoole/Server/StatusInfo.php — fixed malformed </pre> tag.
- [x] Swoole/Server/Packet.php — added missing $data property (set at swoole_server.cc:1222) + full docblocks.
- [x] Swoole/Connection/Iterator.php — verified accurate.

## Tier 3 — Core coroutine primitives
- [x] Swoole/Coroutine.php — fixed gethostbyname @see; deleted stale fread/fgets/fwrite (gone in v6.0.2).
- [x] Swoole/Coroutine/Socket.php — documented sockets-extension build gate on __ext_sockets_* props.
- [x] Swoole/Coroutine/Channel.php — verified accurate.
- [x] Swoole/Coroutine/System.php — deleted stale fread/fwrite/fgets (gone in v6.0.2).
- [x] Swoole/Coroutine/Http/Client.php — verified accurate.
- [x] Swoole/Coroutine/Http/Server.php — verified accurate.
- [x] Swoole/Http/Request.php — documented getData()/getMethod().
- [x] Swoole/Http/Response.php — cookie() first param $name -> $name_or_object (x3), @see Cookie added.
- [x] Swoole/Http/Server.php — verified (empty subclass of swoole_server, correct).
- [x] Swoole/Http/Cookie.php — rewritten: 14 methods documented, @not-serializable, @since 6.0.0.
- [x] Swoole/Table.php — @readonly on $size/$memorySize.
- [x] Swoole/Process.php — @readonly + docblocks on $pipe/$msgQueueId/$msgQueueKey.
- [x] Swoole/Process/Pool.php — @readonly on $master_pid.
- [x] Swoole/Timer.php — verified accurate.
- [x] Swoole/Event.php — added defer(): bool return type.

## Tier 4 — Common but more specialized
- [x] Swoole/Coroutine/Http2/Client.php — documented constructor OpenSSL build gate.
- [x] Swoole/Http2/Request.php — typed $usePipelineRead bool + @see.
- [x] Swoole/Http2/Response.php — verified accurate.
- [x] Swoole/WebSocket/Server.php — verified accurate.
- [x] Swoole/WebSocket/Frame.php — verified accurate.
- [x] Swoole/WebSocket/CloseFrame.php — $code default -> canonical SWOOLE_WEBSOCKET_CLOSE_NORMAL.
- [x] Swoole/Coroutine/Client.php — verified accurate.
- [x] Swoole/Client.php — verified accurate.
- [x] Swoole/Coroutine/Scheduler.php — verified accurate.
- [x] Swoole/Coroutine/Lock.php — verified accurate.
- [x] Swoole/Lock.php — fixed SWOOLE_RWLOCK -> RWLOCK, contradictory unlock sentence.
- [x] Swoole/Atomic.php — verified accurate.
- [x] Swoole/Atomic/Long.php — verified accurate.
- [x] Swoole/Runtime.php — verified accurate (keeps @pseudocode-included).
- [x] Swoole/Exception.php — verified accurate.
- [x] Swoole/Error.php — verified accurate.
- [x] Swoole/ExitException.php — verified accurate.
- [x] Swoole/Coroutine/Iterator.php — verified accurate.
- [x] Swoole/Timer/Iterator.php — verified accurate.
- [x] Swoole/Coroutine/Context.php — verified accurate.
- [x] Swoole/NameResolver/Context.php — verified accurate.

## Tier 5 — Niche / build-flag-gated / rarely touched
- [x] Swoole/Redis/Server.php — verified accurate.
- [x] Swoole/Thread.php — @not-serializable; fixed \Swoole\Swoole:: broken cross-refs; sched policy gating noted.
- [x] Swoole/Thread/ArrayList.php — @not-serializable, @readonly $id.
- [x] Swoole/Thread/Atomic.php — @not-serializable.
- [x] Swoole/Thread/Atomic/Long.php — @not-serializable.
- [x] Swoole/Thread/Barrier.php — @not-serializable.
- [x] Swoole/Thread/Error.php — @readonly $code.
- [x] Swoole/Thread/Lock.php — @not-serializable; RWLOCK/SPINLOCK build-gated; MUTEX reordered first.
- [x] Swoole/Thread/Map.php — @not-serializable.
- [x] Swoole/Thread/Queue.php — @not-serializable; added no-arg __construct().
- [x] Swoole/Async/Client.php — on() first param $host -> $event_name; pause/resume alias tags; added connect/isConnected/close overrides. CONFIRMED class still exists in v6.0.2.
- [x] Swoole/Coroutine/Curl/Exception.php — fixed shortname alias to Co\Coroutine\Curl\Exception; refreshed note.
- [x] Swoole/Coroutine/Http/Client/Exception.php — removed outdated "not in use" claim (it is thrown).
- [x] Swoole/Coroutine/Http2/Client/Exception.php — added usage description + @see.
- [x] Swoole/Client/Exception.php — verified accurate.
- [x] Swoole/Coroutine/Socket/Exception.php — verified accurate.
</content>
