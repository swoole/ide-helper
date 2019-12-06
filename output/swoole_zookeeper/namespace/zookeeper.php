<?php

namespace swoole;

class zookeeper
{

    const PERM_READ = 1;

    const PERM_WRITE = 2;

    const PERM_ALL = 31;

    const PERM_ADMIN = 16;

    const PERM_CREATE = 4;

    const PERM_DELETE = 8;

    public $errCode = 0;

    private $logStream = null;

    private $watcher = null;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function create()
    {
    }

    /**
     * @return mixed
     */
    public function addAuth()
    {
    }

    /**
     * @return mixed
     */
    public function set()
    {
    }

    /**
     * @return mixed
     */
    public function get()
    {
    }

    /**
     * @return mixed
     */
    public function exists()
    {
    }

    /**
     * @return mixed
     */
    public function delete()
    {
    }

    /**
     * @return mixed
     */
    public function setAcl()
    {
    }

    /**
     * @return mixed
     */
    public function getAcl()
    {
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
    }

    /**
     * @return mixed
     */
    public function watch()
    {
    }

    /**
     * @return mixed
     */
    public function watchChildren()
    {
    }

    /**
     * @return mixed
     */
    public function wait()
    {
    }

    /**
     * @return mixed
     */
    public static function setDebugLevel()
    {
    }

    /**
     * @return mixed
     */
    public function getState()
    {
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
    }

    /**
     * @return mixed
     */
    public function setDeterministicConnOrder()
    {
    }

    /**
     * @return mixed
     */
    public function setLogStream()
    {
    }

    /**
     * @return mixed
     */
    public function setWatcher()
    {
    }


}
