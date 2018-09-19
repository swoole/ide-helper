<?php
namespace Swoole\Table;

/**
 * @since 4.2.1
 */
class Row
{

    public $key;
    public $value;

    /**
     * @param $offset [required]
     * @return mixed
     */
    public function offsetExists(int $offset){}

    /**
     * @param $offset [required]
     * @return mixed
     */
    public function offsetGet(int $offset){}

    /**
     * @param $offset [required]
     * @param $value [required]
     * @return mixed
     */
    public function offsetSet(int $offset, $value){}

    /**
     * @param $offset [required]
     * @return mixed
     */
    public function offsetUnset(int $offset){}

    /**
     * @return mixed
     */
    public function __destruct(){}


}
