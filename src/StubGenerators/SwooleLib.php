<?php

namespace Swoole\IDEHelper\StubGenerators;

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Constant;
use Swoole\IDEHelper\Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class SwooleLib
 *
 * @package Swoole\IDEHelper\StubGenerators
 * @see https://github.com/swoole/swoole-src/tree/master/library
 */
class SwooleLib extends AbstractStubGenerator
{
    const EXTRA_FILES = [
        "ext",
        "std",
        "README.md",
        "config.inc",
    ];

    /**
     * @var string
     */
    protected $libDir;

    /**
     * AbstractStubGenerator constructor.
     *
     * @throws Exception
     * @throws ReflectionException
     */
    public function __construct()
    {
        parent::__construct();

        $this->extension = "swoole_lib";
        $this->dirOutput = dirname($this->dirOutput) . DIRECTORY_SEPARATOR . $this->extension;
    }

    /**
     * @inheritDoc
     */
    public function export(): void
    {
        $this->mkdir($this->dirOutput);

        $fileSystem = new Filesystem();
        $fileSystem->mirror($this->libDir, $this->dirOutput);
        foreach (self::EXTRA_FILES as $file) {
            $fileSystem->remove($this->dirOutput . DIRECTORY_SEPARATOR . $file);
        }
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    protected function init(): AbstractStubGenerator
    {
        $this->extension = Constant::EXT_SWOOLE;

        if (!empty($_SERVER["SWOOLE_LIB_DIR"])) {
            $this->libDir = $_SERVER["SWOOLE_LIB_DIR"];
        } elseif (!empty($_SERVER["SWOOLE_SRC_DIR"])) {
            $this->libDir = $_SERVER["SWOOLE_SRC_DIR"] . DIRECTORY_SEPARATOR . "library";
        }

        if (empty($this->libDir)) {
            throw new Exception("Swoole library directory is not specified.");
        } elseif (!is_dir($this->libDir)) {
            throw new Exception("Swoole library directory \"{$this->libDir}\" is invalid.");
        }

        return $this;
    }
}
