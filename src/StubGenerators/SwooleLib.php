<?php

declare(strict_types=1);

namespace Swoole\IDEHelper\StubGenerators;

use DirectoryIterator;
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
    private const EXTRA_SRC_FILES = [
        "src/ext",
        "src/std",
        "src/constants.php",
        "src/functions.php",
    ];

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

        $extraFiles = self::EXTRA_SRC_FILES;
        /** @var DirectoryIterator $file */
        foreach (new DirectoryIterator($this->dirOutput) as $file) {
            if (!$file->isDot() && ($file->getFilename() != 'src')) {
                $extraFiles[] = $file->getFilename();
            }
        }
        $fileSystem = new Filesystem();
        foreach ($extraFiles as $file) {
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
