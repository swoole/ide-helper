<?php
namespace Swoole\Coroutine;

/**
 * @since 2.0.8
 */
class Redis
{


    /**
     * @return mixed
     */
    public function __construct(){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @return mixed
     */
    public function connect(){}

    /**
     * @return mixed
     */
    public function setDefer(){}

    /**
     * @return mixed
     */
    public function getDefer(){}

    /**
     * @return mixed
     */
    public function recv(){}

    /**
     * @return mixed
     */
    public function close(){}

    /**
     * @return mixed
     */
    public function set(){}

    /**
     * @return mixed
     */
    public function setBit(){}

    /**
     * @return mixed
     */
    public function setEx(){}

    /**
     * @return mixed
     */
    public function psetEx(){}

    /**
     * @return mixed
     */
    public function lSet(){}

    /**
     * @return mixed
     */
    public function get(){}

    /**
     * @return mixed
     */
    public function mGet(){}

    /**
     * @return mixed
     */
    public function del(){}

    /**
     * @return mixed
     */
    public function hDel(){}

    /**
     * @return mixed
     */
    public function hSet(){}

    /**
     * @return mixed
     */
    public function hMSet(){}

    /**
     * @return mixed
     */
    public function hSetNx(){}

    /**
     * @return mixed
     */
    public function delete(){}

    /**
     * @return mixed
     */
    public function mSet(){}

    /**
     * @return mixed
     */
    public function mSetNx(){}

    /**
     * @return mixed
     */
    public function getKeys(){}

    /**
     * @return mixed
     */
    public function keys(){}

    /**
     * @return mixed
     */
    public function exists(){}

    /**
     * @return mixed
     */
    public function type(){}

    /**
     * @return mixed
     */
    public function strLen(){}

    /**
     * @return mixed
     */
    public function lPop(){}

    /**
     * @return mixed
     */
    public function blPop(){}

    /**
     * @return mixed
     */
    public function rPop(){}

    /**
     * @return mixed
     */
    public function brPop(){}

    /**
     * @return mixed
     */
    public function bRPopLPush(){}

    /**
     * @return mixed
     */
    public function lSize(){}

    /**
     * @return mixed
     */
    public function lLen(){}

    /**
     * @return mixed
     */
    public function sSize(){}

    /**
     * @return mixed
     */
    public function scard(){}

    /**
     * @return mixed
     */
    public function sPop(){}

    /**
     * @return mixed
     */
    public function sMembers(){}

    /**
     * @return mixed
     */
    public function sGetMembers(){}

    /**
     * @return mixed
     */
    public function sRandMember(){}

    /**
     * @return mixed
     */
    public function persist(){}

    /**
     * @return mixed
     */
    public function ttl(){}

    /**
     * @return mixed
     */
    public function pttl(){}

    /**
     * @return mixed
     */
    public function zCard(){}

    /**
     * @return mixed
     */
    public function zSize(){}

    /**
     * @return mixed
     */
    public function hLen(){}

    /**
     * @return mixed
     */
    public function hKeys(){}

    /**
     * @return mixed
     */
    public function hVals(){}

    /**
     * @return mixed
     */
    public function hGetAll(){}

    /**
     * @return mixed
     */
    public function debug(){}

    /**
     * @return mixed
     */
    public function restore(){}

    /**
     * @return mixed
     */
    public function dump(){}

    /**
     * @return mixed
     */
    public function renameKey(){}

    /**
     * @return mixed
     */
    public function rename(){}

    /**
     * @return mixed
     */
    public function renameNx(){}

    /**
     * @return mixed
     */
    public function rpoplpush(){}

    /**
     * @return mixed
     */
    public function randomKey(){}

    /**
     * @return mixed
     */
    public function ping(){}

    /**
     * @return mixed
     */
    public function auth(){}

    /**
     * @return mixed
     */
    public function unwatch(){}

    /**
     * @return mixed
     */
    public function watch(){}

    /**
     * @return mixed
     */
    public function save(){}

    /**
     * @return mixed
     */
    public function bgSave(){}

    /**
     * @return mixed
     */
    public function lastSave(){}

    /**
     * @return mixed
     */
    public function flushDB(){}

    /**
     * @return mixed
     */
    public function flushAll(){}

    /**
     * @return mixed
     */
    public function dbSize(){}

    /**
     * @return mixed
     */
    public function bgrewriteaof(){}

    /**
     * @return mixed
     */
    public function time(){}

    /**
     * @return mixed
     */
    public function role(){}

    /**
     * @return mixed
     */
    public function setRange(){}

    /**
     * @return mixed
     */
    public function setNx(){}

    /**
     * @return mixed
     */
    public function getSet(){}

    /**
     * @return mixed
     */
    public function append(){}

    /**
     * @return mixed
     */
    public function lPushx(){}

    /**
     * @return mixed
     */
    public function lPush(){}

    /**
     * @return mixed
     */
    public function rPush(){}

    /**
     * @return mixed
     */
    public function rPushx(){}

    /**
     * @return mixed
     */
    public function sContains(){}

    /**
     * @return mixed
     */
    public function sismember(){}

    /**
     * @return mixed
     */
    public function zScore(){}

    /**
     * @return mixed
     */
    public function zRank(){}

    /**
     * @return mixed
     */
    public function zRevRank(){}

    /**
     * @return mixed
     */
    public function hGet(){}

    /**
     * @return mixed
     */
    public function hMGet(){}

    /**
     * @return mixed
     */
    public function hExists(){}

    /**
     * @return mixed
     */
    public function publish(){}

    /**
     * @return mixed
     */
    public function zIncrBy(){}

    /**
     * @return mixed
     */
    public function zAdd(){}

    /**
     * @return mixed
     */
    public function zDeleteRangeByScore(){}

    /**
     * @return mixed
     */
    public function zRemRangeByScore(){}

    /**
     * @return mixed
     */
    public function zCount(){}

    /**
     * @return mixed
     */
    public function zRange(){}

    /**
     * @return mixed
     */
    public function zRevRange(){}

    /**
     * @return mixed
     */
    public function zRangeByScore(){}

    /**
     * @return mixed
     */
    public function zRevRangeByScore(){}

    /**
     * @return mixed
     */
    public function zRangeByLex(){}

    /**
     * @return mixed
     */
    public function zRevRangeByLex(){}

    /**
     * @return mixed
     */
    public function zInter(){}

    /**
     * @return mixed
     */
    public function zinterstore(){}

    /**
     * @return mixed
     */
    public function zUnion(){}

    /**
     * @return mixed
     */
    public function zunionstore(){}

    /**
     * @return mixed
     */
    public function incrBy(){}

    /**
     * @return mixed
     */
    public function hIncrBy(){}

    /**
     * @return mixed
     */
    public function incr(){}

    /**
     * @return mixed
     */
    public function decrBy(){}

    /**
     * @return mixed
     */
    public function decr(){}

    /**
     * @return mixed
     */
    public function getBit(){}

    /**
     * @return mixed
     */
    public function lInsert(){}

    /**
     * @return mixed
     */
    public function lGet(){}

    /**
     * @return mixed
     */
    public function lIndex(){}

    /**
     * @return mixed
     */
    public function setTimeout(){}

    /**
     * @return mixed
     */
    public function expire(){}

    /**
     * @return mixed
     */
    public function pexpire(){}

    /**
     * @return mixed
     */
    public function expireAt(){}

    /**
     * @return mixed
     */
    public function pexpireAt(){}

    /**
     * @return mixed
     */
    public function move(){}

    /**
     * @return mixed
     */
    public function select(){}

    /**
     * @return mixed
     */
    public function getRange(){}

    /**
     * @return mixed
     */
    public function listTrim(){}

    /**
     * @return mixed
     */
    public function ltrim(){}

    /**
     * @return mixed
     */
    public function lGetRange(){}

    /**
     * @return mixed
     */
    public function lRange(){}

    /**
     * @return mixed
     */
    public function lRem(){}

    /**
     * @return mixed
     */
    public function lRemove(){}

    /**
     * @return mixed
     */
    public function zDeleteRangeByRank(){}

    /**
     * @return mixed
     */
    public function zRemRangeByRank(){}

    /**
     * @return mixed
     */
    public function incrByFloat(){}

    /**
     * @return mixed
     */
    public function hIncrByFloat(){}

    /**
     * @return mixed
     */
    public function bitCount(){}

    /**
     * @return mixed
     */
    public function bitOp(){}

    /**
     * @return mixed
     */
    public function sAdd(){}

    /**
     * @return mixed
     */
    public function sMove(){}

    /**
     * @return mixed
     */
    public function sDiff(){}

    /**
     * @return mixed
     */
    public function sDiffStore(){}

    /**
     * @return mixed
     */
    public function sUnion(){}

    /**
     * @return mixed
     */
    public function sUnionStore(){}

    /**
     * @return mixed
     */
    public function sInter(){}

    /**
     * @return mixed
     */
    public function sInterStore(){}

    /**
     * @return mixed
     */
    public function sRemove(){}

    /**
     * @return mixed
     */
    public function srem(){}

    /**
     * @return mixed
     */
    public function zDelete(){}

    /**
     * @return mixed
     */
    public function zRemove(){}

    /**
     * @return mixed
     */
    public function zRem(){}

    /**
     * @return mixed
     */
    public function pSubscribe(){}

    /**
     * @return mixed
     */
    public function subscribe(){}

    /**
     * @return mixed
     */
    public function multi(){}

    /**
     * @return mixed
     */
    public function exec(){}

    /**
     * @return mixed
     */
    public function eval(){}

    /**
     * @return mixed
     */
    public function evalSha(){}

    /**
     * @return mixed
     */
    public function script(){}


}
