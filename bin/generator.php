#!/usr/bin/env php
<?php

/**
 * To generate IDE help files of Swoole.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\AbstractStubGenerator;
use Swoole\IDEHelper\StubGenerators\Swoole;
use Swoole\IDEHelper\StubGenerators\SwooleAsync;
use Swoole\IDEHelper\StubGenerators\SwooleLib;
use Swoole\IDEHelper\StubGenerators\SwooleOrm;
use Swoole\IDEHelper\StubGenerators\SwoolePostgresql;
use Swoole\IDEHelper\StubGenerators\SwooleSerialize;
use Swoole\IDEHelper\StubGenerators\SwooleZookeeper;

/** @var AbstractStubGenerator[] $generators */
$generators = [
    new Swoole(),
    new SwooleLib(),
    // new SwooleAsync(),
    // new SwooleOrm(),
    // new SwoolePostgresql(),
    // new SwooleSerialize(),
    // new SwooleZookeeper(),
];
foreach ($generators as $generator) {
    $generator->export();
    echo "IDE help files for {$generator->getExtension()} {$generator->getVersion()} generated successfully.\n";
}
