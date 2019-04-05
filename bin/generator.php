#!/usr/bin/env php
<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Swoole\IDEHelper\ExtensionDocument;

(new ExtensionDocument('chinese', dirname(__DIR__) . '/output', dirname(__DIR__) . '/config'))->export();

echo "IDE helper files for Swoole ", swoole_version(), " are generated successfully.\n";
