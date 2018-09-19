<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class Buffer
{


    /**
     * @param $size [optional]
     * @return mixed
     */
    public function __construct(int $size=null){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @return mixed
     */
    public function __toString(){}

    /**
     * @param $offset [required]
     * @param $length [optional]
     * @param $seek [optional]
     * @return mixed
     */
    public function substr(int $offset, int $length=null, $seek=null){}

    /**
     * @param $offset [required]
     * @param $data [required]
     * @return mixed
     */
    public function write(int $offset, $data){}

    /**
     * @param $offset [required]
     * @param $length [required]
     * @return mixed
     */
    public function read(int $offset, int $length){}

    /**
     * @param $data [required]
     * @return mixed
     */
    public function append($data){}

    /**
     * @param $size [required]
     * @return mixed
     */
    public function expand(int $size){}

    /**
     * @return mixed
     */
    public function recycle(){}

    /**
     * @return mixed
     */
    public function clear(){}


}
