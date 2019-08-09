#!/usr/bin/env php
<?php
/**
 * To generate IDE help files of Swoole.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\StubGenerators\Swoole;
use Swoole\IDEHelper\StubGenerators\SwooleAsync;
use Swoole\IDEHelper\StubGenerators\SwooleOrm;
use Swoole\IDEHelper\StubGenerators\SwoolePostgresql;
use Swoole\IDEHelper\StubGenerators\SwooleSerialize;

/** @var AbstractStubGenerator[] $generators */
$generators = [
    new Swoole(),
    new SwooleAsync(),
    new SwooleOrm(),
    new SwoolePostgresql(),
    new SwooleSerialize(),
];
foreach ($generators as $generator) {
    $generator->export();
    echo "IDE help files for {$generator->getExtension()} {$generator->getVersion()} are generated successfully.\n";
}
