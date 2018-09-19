<?php
namespace Swoole;

/**
 * @since 4.2.1
 */
class MsgQueue
{


    /**
     * @param $len [required]
     * @return mixed
     */
    public function __construct(int $len){}

    /**
     * @return mixed
     */
    public function __destruct(){}

    /**
     * @param $data [required]
     * @param $type [optional]
     * @return mixed
     */
    public function push($data, $type=null){}

    /**
     * @param $type [optional]
     * @return mixed
     */
    public function pop($type=null){}

    /**
     * @param $blocking [required]
     * @return mixed
     */
    public function setBlocking($blocking){}

    /**
     * @return mixed
     */
    public function stats(){}

    /**
     * @return mixed
     */
    public function destory(){}


}
