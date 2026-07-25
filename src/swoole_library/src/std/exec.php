<?php
/**
 * This file is part of Swoole.
 *
 * @link     https://www.swoole.com
 * @contact  team@swoole.com
 * @license  https://github.com/swoole/library/blob/master/LICENSE
 */

declare(strict_types=1);

use Swoole\Coroutine\System;

function swoole_exec(string $command, &$output = null, &$returnVar = null)
{
    $result = System::exec($command);
    if ($result) {
        $outputList = explode(PHP_EOL, $result['output']);
        foreach ($outputList as &$value) {
            $value = rtrim($value);
        }
        if (($endLine = end($outputList)) === '') {
            array_pop($outputList);
            $endLine = end($outputList);
        }
        if ($output) {
            $output = array_merge($output, $outputList);
        } else {
            $output = $outputList;
        }
        $returnVar = $result['code'];
        return $endLine;
    }
    return false;
}

function swoole_shell_exec(string $cmd)
{
    $result = System::exec($cmd);
    if ($result && $result['output'] !== '') {
        return $result['output'];
    }
    return null;
}
