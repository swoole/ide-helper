<?php

if (Phar::canWrite()) {
    $dir = realpath(__DIR__ . '/output/');
    printf("Set target Dir %s" . PHP_EOL,$dir);
    $pharFile = 'swoole-ide-helper.phar';
    $phar     = new Phar($pharFile, FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, $pharFile);
    $phar->startBuffering();
    $phar->buildFromDirectory($dir, '/\.php$/');
    $phar->stopBuffering();
    printf("\033[0;32m" . 'Success: Packed PHP files in %s to %s ' . "\033[0m".PHP_EOL, $dir, $pharFile);
} else {
    printf("\033[0;31m" . 'Error: `phar.readonly` is set to true,run me with  `phar.readonly` disabled
     php -d phar.readonly=0 %s
to retry this command' . "\033[0m".PHP_EOL, __FILE__) ;
    exit(1);
}
exit(0);