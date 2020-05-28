<?php

namespace Swoole;

class Lock
{

    public const FILELOCK = 2;

    public const MUTEX = 3;

    public const SEM = 4;

    public const RWLOCK = 1;

    public const SPINLOCK = 5;

    public $errCode = 0;

    public function __construct($type = null, $filename = null)
    {
    }

    public function __destruct()
    {
    }

    /**
     * @return mixed
     */
    public function lock()
    {
    }

    /**
     * @return mixed
     */
    public function lockwait($timeout = null)
    {
    }

    /**
     * @return mixed
     */
    public function trylock()
    {
    }

    /**
     * @return mixed
     */
    public function lock_read()
    {
    }

    /**
     * @return mixed
     */
    public function trylock_read()
    {
    }

    /**
     * @return mixed
     */
    public function unlock()
    {
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
    }


}
