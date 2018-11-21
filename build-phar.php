<?php
if (Phar::canWrite()) {
    $dir = realpath(__DIR__ . '/output/');
    echo "Set target Dir $dir" . PHP_EOL;
    $pharFile = 'swoole-ide-helper.phar';
    $phar     = new Phar($pharFile, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, $pharFile);
    $phar->startBuffering();
    $phar->buildFromDirectory($dir, '/\.php$/');
    $phar->stopBuffering();
    echo sprintf("\033[0;32m" . 'Success: Packed PHP files in %s to %s ' . "\033[0m", $dir, $pharFile) . PHP_EOL;
} else {
    echo sprintf("\033[0;31m" . 'Error: `phar.readonly` is set to true,this should run with `phar.readonly` disabled.
Use:
     php -d phar.readonly=0 %s
to retry this command.' . "\033[0m", __FILE__) . PHP_EOL;
    exit(1);
}
exit(0);