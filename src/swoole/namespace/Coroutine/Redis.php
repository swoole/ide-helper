<?php

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
     * @return mixed
     */
    public function set($key, $value, $timeout = null, $opt = null)
    {
    }

    /**
     * @return mixed
     */
    public function setBit($key, $offset, $value)
    {
    }

    /**
     * @return mixed
     */
    public function setEx($key, $expire, $value)
    {
    }

    /**
     * @return mixed
     */
    public function psetEx($key, $expire, $value)
    {
    }

    /**
     * @return mixed
     */
    public function lSet($key, $index, $value)
    {
    }

    /**
     * @return mixed
     */
    public function get($key)
    {
    }

    /**
     * @return mixed
     */
    public function mGet($keys)
    {
    }

    /**
     * @return mixed
     */
    public function del($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function hDel($key, $member, $other_members = null)
    {
    }

    /**
     * @return mixed
     */
    public function hSet($key, $member, $value)
    {
    }

    /**
     * @return mixed
     */
    public function hMSet($key, $pairs)
    {
    }

    /**
     * @return mixed
     */
    public function hSetNx($key, $member, $value)
    {
    }

    /**
     * @return mixed
     */
    public function delete($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function mSet($pairs)
    {
    }

    /**
     * @return mixed
     */
    public function mSetNx($pairs)
    {
    }

    /**
     * @return mixed
     */
    public function getKeys($pattern)
    {
    }

    /**
     * @return mixed
     */
    public function keys($pattern)
    {
    }

    /**
     * @return mixed
     */
    public function exists($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function type($key)
    {
    }

    /**
     * @return mixed
     */
    public function strLen($key)
    {
    }

    /**
     * @return mixed
     */
    public function lPop($key)
    {
    }

    /**
     * @return mixed
     */
    public function blPop($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @return mixed
     */
    public function rPop($key)
    {
    }

    /**
     * @return mixed
     */
    public function brPop($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @return mixed
     */
    public function bRPopLPush($src, $dst, $timeout)
    {
    }

    /**
     * @return mixed
     */
    public function lSize($key)
    {
    }

    /**
     * @return mixed
     */
    public function lLen($key)
    {
    }

    /**
     * @return mixed
     */
    public function sSize($key)
    {
    }

    /**
     * @return mixed
     */
    public function scard($key)
    {
    }

    /**
     * @return mixed
     */
    public function sPop($key)
    {
    }

    /**
     * @return mixed
     */
    public function sMembers($key)
    {
    }

    /**
     * @return mixed
     */
    public function sGetMembers($key)
    {
    }

    /**
     * @return mixed
     */
    public function sRandMember($key, $count = null)
    {
    }

    /**
     * @return mixed
     */
    public function persist($key)
    {
    }

    /**
     * @return mixed
     */
    public function ttl($key)
    {
    }

    /**
     * @return mixed
     */
    public function pttl($key)
    {
    }

    /**
     * @return mixed
     */
    public function zCard($key)
    {
    }

    /**
     * @return mixed
     */
    public function zSize($key)
    {
    }

    /**
     * @return mixed
     */
    public function hLen($key)
    {
    }

    /**
     * @return mixed
     */
    public function hKeys($key)
    {
    }

    /**
     * @return mixed
     */
    public function hVals($key)
    {
    }

    /**
     * @return mixed
     */
    public function hGetAll($key)
    {
    }

    /**
     * @return mixed
     */
    public function debug($key)
    {
    }

    /**
     * @return mixed
     */
    public function restore($ttl, $key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function dump($key)
    {
    }

    /**
     * @return mixed
     */
    public function renameKey($key, $newkey)
    {
    }

    /**
     * @return mixed
     */
    public function rename($key, $newkey)
    {
    }

    /**
     * @return mixed
     */
    public function renameNx($key, $newkey)
    {
    }

    /**
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
     * @return mixed
     */
    public function pfadd($key, $elements)
    {
    }

    /**
     * @return mixed
     */
    public function pfcount($key)
    {
    }

    /**
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
     * @return mixed
     */
    public function setRange($key, $offset, $value)
    {
    }

    /**
     * @return mixed
     */
    public function setNx($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function getSet($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function append($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function lPushx($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function lPush($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function rPush($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function rPushx($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function sContains($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function sismember($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function zScore($key, $member)
    {
    }

    /**
     * @return mixed
     */
    public function zRank($key, $member)
    {
    }

    /**
     * @return mixed
     */
    public function zRevRank($key, $member)
    {
    }

    /**
     * @return mixed
     */
    public function hGet($key, $member)
    {
    }

    /**
     * @return mixed
     */
    public function hMGet($key, $keys)
    {
    }

    /**
     * @return mixed
     */
    public function hExists($key, $member)
    {
    }

    /**
     * @return mixed
     */
    public function publish($channel, $message)
    {
    }

    /**
     * @return mixed
     */
    public function zIncrBy($key, $value, $member)
    {
    }

    /**
     * @return mixed
     */
    public function zAdd($key, $score, $value)
    {
    }

    /**
     * @return mixed
     */
    public function zPopMin($key, $count)
    {
    }

    /**
     * @return mixed
     */
    public function zPopMax($key, $count)
    {
    }

    /**
     * @return mixed
     */
    public function bzPopMin($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @return mixed
     */
    public function bzPopMax($key, $timeout_or_key, $extra_args = null)
    {
    }

    /**
     * @return mixed
     */
    public function zDeleteRangeByScore($key, $min, $max)
    {
    }

    /**
     * @return mixed
     */
    public function zRemRangeByScore($key, $min, $max)
    {
    }

    /**
     * @return mixed
     */
    public function zCount($key, $min, $max)
    {
    }

    /**
     * @return mixed
     */
    public function zRange($key, $start, $end, $scores = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRevRange($key, $start, $end, $scores = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRangeByScore($key, $start, $end, $options = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRevRangeByScore($key, $start, $end, $options = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRevRangeByLex($key, $min, $max, $offset = null, $limit = null)
    {
    }

    /**
     * @return mixed
     */
    public function zInter($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @return mixed
     */
    public function zinterstore($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @return mixed
     */
    public function zUnion($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @return mixed
     */
    public function zunionstore($key, $keys, $weights = null, $aggregate = null)
    {
    }

    /**
     * @return mixed
     */
    public function incrBy($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function hIncrBy($key, $member, $value)
    {
    }

    /**
     * @return mixed
     */
    public function incr($key)
    {
    }

    /**
     * @return mixed
     */
    public function decrBy($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function decr($key)
    {
    }

    /**
     * @return mixed
     */
    public function getBit($key, $offset)
    {
    }

    /**
     * @return mixed
     */
    public function lInsert($key, $position, $pivot, $value)
    {
    }

    /**
     * @return mixed
     */
    public function lGet($key, $index)
    {
    }

    /**
     * @return mixed
     */
    public function lIndex($key, $integer)
    {
    }

    /**
     * @return mixed
     */
    public function setTimeout($key, $timeout)
    {
    }

    /**
     * @return mixed
     */
    public function expire($key, $integer)
    {
    }

    /**
     * @return mixed
     */
    public function pexpire($key, $timestamp)
    {
    }

    /**
     * @return mixed
     */
    public function expireAt($key, $timestamp)
    {
    }

    /**
     * @return mixed
     */
    public function pexpireAt($key, $timestamp)
    {
    }

    /**
     * @return mixed
     */
    public function move($key, $dbindex)
    {
    }

    /**
     * @return mixed
     */
    public function select($dbindex)
    {
    }

    /**
     * @return mixed
     */
    public function getRange($key, $start, $end)
    {
    }

    /**
     * @return mixed
     */
    public function listTrim($key, $start, $stop)
    {
    }

    /**
     * @return mixed
     */
    public function ltrim($key, $start, $stop)
    {
    }

    /**
     * @return mixed
     */
    public function lGetRange($key, $start, $end)
    {
    }

    /**
     * @return mixed
     */
    public function lRange($key, $start, $end)
    {
    }

    /**
     * @return mixed
     */
    public function lRem($key, $value, $count)
    {
    }

    /**
     * @return mixed
     */
    public function lRemove($key, $value, $count)
    {
    }

    /**
     * @return mixed
     */
    public function zDeleteRangeByRank($key, $start, $end)
    {
    }

    /**
     * @return mixed
     */
    public function zRemRangeByRank($key, $min, $max)
    {
    }

    /**
     * @return mixed
     */
    public function incrByFloat($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function hIncrByFloat($key, $member, $value)
    {
    }

    /**
     * @return mixed
     */
    public function bitCount($key)
    {
    }

    /**
     * @return mixed
     */
    public function bitOp($operation, $ret_key, $key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sAdd($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function sMove($src, $dst, $value)
    {
    }

    /**
     * @return mixed
     */
    public function sDiff($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sDiffStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sUnion($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sUnionStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sInter($key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sInterStore($dst, $key, $other_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function sRemove($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function srem($key, $value)
    {
    }

    /**
     * @return mixed
     */
    public function zDelete($key, $member, $other_members = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRemove($key, $member, $other_members = null)
    {
    }

    /**
     * @return mixed
     */
    public function zRem($key, $member, $other_members = null)
    {
    }

    /**
     * @return mixed
     */
    public function pSubscribe($patterns)
    {
    }

    /**
     * @return mixed
     */
    public function subscribe($channels)
    {
    }

    /**
     * @return mixed
     */
    public function unsubscribe($channels)
    {
    }

    /**
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
     * @return mixed
     */
    public function eval($script, $args = null, $num_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function evalSha($script_sha, $args = null, $num_keys = null)
    {
    }

    /**
     * @return mixed
     */
    public function script($cmd, $args = null)
    {
    }


}
