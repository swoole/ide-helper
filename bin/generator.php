#!/usr/bin/env php
<?php
/**
 * To generate IDE help files of Swoole.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\Extensions\Swoole;
use Swoole\IDEHelper\Extensions\SwooleAsync;
use Swoole\IDEHelper\Extensions\SwooleOrm;
use Swoole\IDEHelper\Extensions\SwooleSerialize;

/** @var AbstractStubGenerator[] $generators */
$generators = [
    new Swoole(),
    new SwooleAsync(),
    new SwooleOrm(),
    new SwooleSerialize(),
];
foreach ($generators as $generator) {
    $generator->export();
    echo "IDE help files for {$generator->getExtension()} {$generator->getVersion()} are generated successfully.\n";
}
