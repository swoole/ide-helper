#!/usr/bin/env php
<?php
/**
 * To generate IDE help files of Swoole.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\Extensions\Swoole;

$generator = new Swoole();
$generator->export();
echo "IDE help files for Swoole {$generator->getVersion()} are generated successfully.\n";
