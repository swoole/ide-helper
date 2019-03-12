<?php
namespace Swoole\Coroutine;

class Context extends \ArrayObject
{
    const STD_PROP_LIST = 1;
    const ARRAY_AS_PROPS = 2;


    /**
     * @param $input[optional]
     * @param $flags[optional]
     * @param $iterator_class[optional]
     * @return mixed
     */
    public function __construct($input = null, $flags = null, $iterator_class = null){}

    /**
     * @param $index[required]
     * @return mixed
     */
    public function offsetExists($index){}

    /**
     * @param $index[required]
     * @return mixed
     */
    public function offsetGet($index){}

    /**
     * @param $index[required]
     * @param $newval[required]
     * @return mixed
     */
    public function offsetSet($index, $newval){}

    /**
     * @param $index[required]
     * @return mixed
     */
    public function offsetUnset($index){}

    /**
     * @param $value[required]
     * @return mixed
     */
    public function append($value){}

    /**
     * @return mixed
     */
    public function getArrayCopy(){}

    /**
     * @return mixed
     */
    public function count(){}

    /**
     * @return mixed
     */
    public function getFlags(){}

    /**
     * @param $flags[required]
     * @return mixed
     */
    public function setFlags($flags){}

    /**
     * @return mixed
     */
    public function asort(){}

    /**
     * @return mixed
     */
    public function ksort(){}

    /**
     * @param $cmp_function[required]
     * @return mixed
     */
    public function uasort($cmp_function){}

    /**
     * @param $cmp_function[required]
     * @return mixed
     */
    public function uksort($cmp_function){}

    /**
     * @return mixed
     */
    public function natsort(){}

    /**
     * @return mixed
     */
    public function natcasesort(){}

    /**
     * @param $serialized[required]
     * @return mixed
     */
    public function unserialize($serialized){}

    /**
     * @return mixed
     */
    public function serialize(){}

    /**
     * @return mixed
     */
    public function getIterator(){}

    /**
     * @param $array[required]
     * @return mixed
     */
    public function exchangeArray($array){}

    /**
     * @param $iteratorClass[required]
     * @return mixed
     */
    public function setIteratorClass($iteratorClass){}

    /**
     * @return mixed
     */
    public function getIteratorClass(){}


}
