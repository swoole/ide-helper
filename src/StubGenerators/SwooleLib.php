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
 * @see https://github.com/swoole/swoole-src/blob/v4.4.13/php_swoole_library.h#L5
 */
class SwooleLib extends AbstractStubGenerator
{
    private const EXTRA_FILES = [
        "examples",
        "src/ext",
        "src/std",
        "src/constants.php",
        "src/functions.php",
        ".gitignore",
        "LICENSE",
        "README.md",
        "composer.json",
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

        $this->extension = "swoole_library";
        $this->dirOutput = dirname($this->dirOutput) . DIRECTORY_SEPARATOR . $this->extension;
    }

    /**
     * @inheritDoc
     */
    public function export(): void
    {
        $this->download("library", $this->rf_version, $this->dirOutput);

        $fileSystem = new Filesystem();
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
        $this->extension  = Constant::EXT_SWOOLE; // Set to a dummy value temporarily.
        $this->rf_version = $_SERVER["SWOOLE_LIB_VERSION"] ?? self::DEFAULT_VERSION;

        return $this;
    }
}
