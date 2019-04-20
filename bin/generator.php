#!/usr/bin/env php
<?php
/**
 * To generate IDE helper files of Swoole.
 */

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\ExtensionDocument;

$doc = new ExtensionDocument('chinese', dirname(__DIR__) . '/output', dirname(__DIR__) . '/config');
$doc->export();
echo "IDE helper files for Swoole {$doc->getVersion()} are generated successfully.\n";
