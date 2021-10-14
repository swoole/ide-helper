<?php

declare(strict_types=1);

namespace Swoole\Coroutine;

class Redis
{
    public $host = '';

    public $port = 0;

    public $setting;

    public $sock = -1;

    public $connected = false;

    public $errType = 0;

    public $errCode = 0;

    public $errMsg = '';

    public function __construct($config = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @param mixed $host
     * @param mixed|null $port
     * @param mixed|null $serialize
     * @return mixed
     */
    public function connect($host, $port = null, $serialize = null)
    {
    }

    /**
     * @return mixed
     */
    public function getAuth()
    {
    }

    /**
     * @return mixed
     */
    public function getDBNum()
    {
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
    }

    /**
     * @param mixed $options
     * @return mixed
     */
    public function setOptions($options)
    {
    }

    /**
     * @return mixed
     */
    public function getDefer()
    {
    }

    /**
     * @param mixed $defer
     * @return mixed
     */
    public function setDefer($defer)
    {
    }

    /**
     * @return mixed
     */
    public function recv()
    {
    }

    /**
     * @return mixed
     */
    public function request(array $params)
    {
    }

    /**
     * @return mixed
     */
    public function close()
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param mixed|null $timeout
     * @param mixed|null $opt
     * @return mixed
     */
    public function set($key, $value, $timeout = null, $opt = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function setBit($key, $offset, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $expire
     * @param mixed $value
     * @return mixed
     */
    public function setEx($key, $expire, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $expire
     * @param mixed $value
     * @return mixed
     */
    public function psetEx($key, $expire, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $index
     * @param mixed $value
     * @return mixed
     */
    public function lSet($key, $index, $value)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key)
    {
    }

    /**
     * @param mixed $keys
     * @return mixed
     */
    public function mGet($keys)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function del($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed|null $other_members
     * @return mixed
     */
    public function hDel($key, $member, $other_members = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed $value
     * @return mixed
     */
    public function hSet($key, $member, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $pairs
     * @return mixed
     */
    public function hMSet($key, $pairs)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed $value
     * @return mixed
     */
    public function hSetNx($key, $member, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function delete($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $pairs
     * @return mixed
     */
    public function mSet($pairs)
    {
    }

    /**
     * @param mixed $pairs
     * @return mixed
     */
    public function mSetNx($pairs)
    {
    }

    /**
     * @param mixed $pattern
     * @return mixed
     */
    public function getKeys($pattern)
    {
    }

    /**
     * @param mixed $pattern
     * @return mixed
     */
    public function keys($pattern)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function exists($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function type($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function strLen($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function lPop($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timeout_or_key
     * @param mixed|null $extra_args
     * @return mixed
     */
    public function blPop($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function rPop($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timeout_or_key
     * @param mixed|null $extra_args
     * @return mixed
     */
    public function brPop($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @param mixed $src
     * @param mixed $dst
     * @param mixed $timeout
     * @return mixed
     */
    public function bRPopLPush($src, $dst, $timeout)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function lSize($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function lLen($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function sSize($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function scard($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function sPop($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function sMembers($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function sGetMembers($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $count
     * @return mixed
     */
    public function sRandMember($key, $count = null)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function persist($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function ttl($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function pttl($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function zCard($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function zSize($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function hLen($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function hKeys($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function hVals($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function hGetAll($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function debug($key)
    {
    }

    /**
     * @param mixed $ttl
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function restore($ttl, $key, $value)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function dump($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $newkey
     * @return mixed
     */
    public function renameKey($key, $newkey)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $newkey
     * @return mixed
     */
    public function rename($key, $newkey)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $newkey
     * @return mixed
     */
    public function renameNx($key, $newkey)
    {
    }

    /**
     * @param mixed $src
     * @param mixed $dst
     * @return mixed
     */
    public function rpoplpush($src, $dst)
    {
    }

    /**
     * @return mixed
     */
    public function randomKey()
    {
    }

    /**
     * @param mixed $key
     * @param mixed $elements
     * @return mixed
     */
    public function pfadd($key, $elements)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function pfcount($key)
    {
    }

    /**
     * @param mixed $dstkey
     * @param mixed $keys
     * @return mixed
     */
    public function pfmerge($dstkey, $keys)
    {
    }

    /**
     * @return mixed
     */
    public function ping()
    {
    }

    /**
     * @param mixed $password
     * @return mixed
     */
    public function auth($password)
    {
    }

    /**
     * @return mixed
     */
    public function unwatch()
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function watch($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function save()
    {
    }

    /**
     * @return mixed
     */
    public function bgSave()
    {
    }

    /**
     * @return mixed
     */
    public function lastSave()
    {
    }

    /**
     * @return mixed
     */
    public function flushDB()
    {
    }

    /**
     * @return mixed
     */
    public function flushAll()
    {
    }

    /**
     * @return mixed
     */
    public function dbSize()
    {
    }

    /**
     * @return mixed
     */
    public function bgrewriteaof()
    {
    }

    /**
     * @return mixed
     */
    public function time()
    {
    }

    /**
     * @return mixed
     */
    public function role()
    {
    }

    /**
     * @param mixed $key
     * @param mixed $offset
     * @param mixed $value
     * @return mixed
     */
    public function setRange($key, $offset, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function setNx($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function getSet($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function append($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function lPushx($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function lPush($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function rPush($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function rPushx($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function sContains($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function sismember($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @return mixed
     */
    public function zScore($key, $member)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @return mixed
     */
    public function zRank($key, $member)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @return mixed
     */
    public function zRevRank($key, $member)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @return mixed
     */
    public function hGet($key, $member)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $keys
     * @return mixed
     */
    public function hMGet($key, $keys)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @return mixed
     */
    public function hExists($key, $member)
    {
    }

    /**
     * @param mixed $channel
     * @param mixed $message
     * @return mixed
     */
    public function publish($channel, $message)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param mixed $member
     * @return mixed
     */
    public function zIncrBy($key, $value, $member)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $score
     * @param mixed $value
     * @return mixed
     */
    public function zAdd($key, $score, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $count
     * @return mixed
     */
    public function zPopMin($key, $count)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $count
     * @return mixed
     */
    public function zPopMax($key, $count)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timeout_or_key
     * @param mixed|null $extra_args
     * @return mixed
     */
    public function bzPopMin($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timeout_or_key
     * @param mixed|null $extra_args
     * @return mixed
     */
    public function bzPopMax($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @return mixed
     */
    public function zDeleteRangeByScore($key, $min, $max)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @return mixed
     */
    public function zRemRangeByScore($key, $min, $max)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @return mixed
     */
    public function zCount($key, $min, $max)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $scores
     * @return mixed
     */
    public function zRange($key, $start, $end, $scores = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $scores
     * @return mixed
     */
    public function zRevRange($key, $start, $end, $scores = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $options
     * @return mixed
     */
    public function zRangeByScore($key, $start, $end, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $options
     * @return mixed
     */
    public function zRevRangeByScore($key, $start, $end, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @param mixed|null $offset
     * @param mixed|null $limit
     * @return mixed
     */
    public function zRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @param mixed|null $offset
     * @param mixed|null $limit
     * @return mixed
     */
    public function zRevRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $keys
     * @param mixed|null $weights
     * @param mixed|null $aggregate
     * @return mixed
     */
    public function zInter($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $keys
     * @param mixed|null $weights
     * @param mixed|null $aggregate
     * @return mixed
     */
    public function zinterstore($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $keys
     * @param mixed|null $weights
     * @param mixed|null $aggregate
     * @return mixed
     */
    public function zUnion($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $keys
     * @param mixed|null $weights
     * @param mixed|null $aggregate
     * @return mixed
     */
    public function zunionstore($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function incrBy($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed $value
     * @return mixed
     */
    public function hIncrBy($key, $member, $value)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function incr($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function decrBy($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function decr($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $offset
     * @return mixed
     */
    public function getBit($key, $offset)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $position
     * @param mixed $pivot
     * @param mixed $value
     * @return mixed
     */
    public function lInsert($key, $position, $pivot, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $index
     * @return mixed
     */
    public function lGet($key, $index)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $integer
     * @return mixed
     */
    public function lIndex($key, $integer)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timeout
     * @return mixed
     */
    public function setTimeout($key, $timeout)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $integer
     * @return mixed
     */
    public function expire($key, $integer)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timestamp
     * @return mixed
     */
    public function pexpire($key, $timestamp)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timestamp
     * @return mixed
     */
    public function expireAt($key, $timestamp)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $timestamp
     * @return mixed
     */
    public function pexpireAt($key, $timestamp)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $dbindex
     * @return mixed
     */
    public function move($key, $dbindex)
    {
    }

    /**
     * @param mixed $dbindex
     * @return mixed
     */
    public function select($dbindex)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @return mixed
     */
    public function getRange($key, $start, $end)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $stop
     * @return mixed
     */
    public function listTrim($key, $start, $stop)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $stop
     * @return mixed
     */
    public function ltrim($key, $start, $stop)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @return mixed
     */
    public function lGetRange($key, $start, $end)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @return mixed
     */
    public function lRange($key, $start, $end)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param mixed $count
     * @return mixed
     */
    public function lRem($key, $value, $count)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @param mixed $count
     * @return mixed
     */
    public function lRemove($key, $value, $count)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @return mixed
     */
    public function zDeleteRangeByRank($key, $start, $end)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $min
     * @param mixed $max
     * @return mixed
     */
    public function zRemRangeByRank($key, $min, $max)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function incrByFloat($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed $value
     * @return mixed
     */
    public function hIncrByFloat($key, $member, $value)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function bitCount($key)
    {
    }

    /**
     * @param mixed $operation
     * @param mixed $ret_key
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function bitOp($operation, $ret_key, $key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function sAdd($key, $value)
    {
    }

    /**
     * @param mixed $src
     * @param mixed $dst
     * @param mixed $value
     * @return mixed
     */
    public function sMove($src, $dst, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sDiff($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $dst
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sDiffStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sUnion($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $dst
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sUnionStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sInter($key, $other_keys = null)
    {
    }

    /**
     * @param mixed $dst
     * @param mixed $key
     * @param mixed|null $other_keys
     * @return mixed
     */
    public function sInterStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function sRemove($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return mixed
     */
    public function srem($key, $value)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed|null $other_members
     * @return mixed
     */
    public function zDelete($key, $member, $other_members = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed|null $other_members
     * @return mixed
     */
    public function zRemove($key, $member, $other_members = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $member
     * @param mixed|null $other_members
     * @return mixed
     */
    public function zRem($key, $member, $other_members = null)
    {
    }

    /**
     * @param mixed $patterns
     * @return mixed
     */
    public function pSubscribe($patterns)
    {
    }

    /**
     * @param mixed $channels
     * @return mixed
     */
    public function subscribe($channels)
    {
    }

    /**
     * @param mixed $channels
     * @return mixed
     */
    public function unsubscribe($channels)
    {
    }

    /**
     * @param mixed $patterns
     * @return mixed
     */
    public function pUnSubscribe($patterns)
    {
    }

    /**
     * @return mixed
     */
    public function multi()
    {
    }

    /**
     * @return mixed
     */
    public function exec()
    {
    }

    /**
     * @param mixed $script
     * @param mixed|null $args
     * @param mixed|null $num_keys
     * @return mixed
     */
    public function eval($script, $args = null, $num_keys = null)
    {
    }

    /**
     * @param mixed $script_sha
     * @param mixed|null $args
     * @param mixed|null $num_keys
     * @return mixed
     */
    public function evalSha($script_sha, $args = null, $num_keys = null)
    {
    }

    /**
     * @param mixed $cmd
     * @param mixed|null $args
     * @return mixed
     */
    public function script($cmd, $args = null)
    {
    }

    /**
     * @since 4.8.0
     * @param mixed $key
     * @return mixed
     */
    public function xLen($key)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $id
     * @param mixed $pairs
     * @param mixed|null $options
     * @return mixed
     */
    public function xAdd($key, $id, $pairs, $options = null)
    {
    }

    /**
     * @param mixed $streams
     * @param mixed|null $options
     * @return mixed
     */
    public function xRead($streams, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $id
     * @return mixed
     */
    public function xDel($key, $id)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $count
     * @return mixed
     */
    public function xRange($key, $start, $end, $count = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $start
     * @param mixed $end
     * @param mixed|null $count
     * @return mixed
     */
    public function xRevRange($key, $start, $end, $count = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed|null $options
     * @return mixed
     */
    public function xTrim($key, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $id
     * @param mixed|null $mkstream
     * @return mixed
     */
    public function xGroupCreate($key, $group_name, $id, $mkstream = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $id
     * @return mixed
     */
    public function xGroupSetId($key, $group_name, $id)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @return mixed
     */
    public function xGroupDestroy($key, $group_name)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $consumer_name
     * @return mixed
     */
    public function xGroupCreateConsumer($key, $group_name, $consumer_name)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $consumer_name
     * @return mixed
     */
    public function xGroupDelConsumer($key, $group_name, $consumer_name)
    {
    }

    /**
     * @param mixed $group_name
     * @param mixed $consumer_name
     * @param mixed $streams
     * @param mixed|null $options
     * @return mixed
     */
    public function xReadGroup($group_name, $consumer_name, $streams, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed|null $options
     * @return mixed
     */
    public function xPending($key, $group_name, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $id
     * @return mixed
     */
    public function xAck($key, $group_name, $id)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $consumer_name
     * @param mixed $min_idle_time
     * @param mixed $id
     * @param mixed|null $options
     * @return mixed
     */
    public function xClaim($key, $group_name, $consumer_name, $min_idle_time, $id, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @param mixed $consumer_name
     * @param mixed $min_idle_time
     * @param mixed $start
     * @param mixed|null $options
     * @return mixed
     */
    public function xAutoClaim($key, $group_name, $consumer_name, $min_idle_time, $start, $options = null)
    {
    }

    /**
     * @param mixed $key
     * @param mixed $group_name
     * @return mixed
     */
    public function xInfoConsumers($key, $group_name)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function xInfoGroups($key)
    {
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function xInfoStream($key)
    {
    }
}
