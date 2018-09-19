<?php
namespace Swoole\Memory\Pool;

/**
 * @since 4.2.1
 */
class Slice
{


    /**
     * @param $size [optional]
     * @param $offset [optional]
     * @return mixed
     */
    public function read(int $size=null, int $offset=null){}

    /**
     * @param $data [required]
     * @param $offset [optional]
     * @return mixed
     */
    public function write($data, int $offset=null){}

    /**
     * @return mixed
     */
    public function __destruct(){}


}
