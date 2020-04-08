# Swoole IDE Helper

[![Build Status](https://travis-ci.org/swoole/ide-helper.svg?branch=master)](https://travis-ci.org/swoole/ide-helper)
[![Latest Stable Version](https://poser.pugx.org/swoole/ide-helper/v/stable.svg)](https://packagist.org/packages/swoole/ide-helper)
[![License](https://poser.pugx.org/swoole/ide-helper/license)](LICENSE)

This package contains IDE help files for [Swoole](https://github.com/swoole/swoole-src). You may use it in your IDE to provide accurate autocompletion. 

## Install

You may add this package to your project using [Composer](https://getcomposer.org):

```bash
composer require swoole/ide-helper:@dev
# or you may install a specific version, like:
composer require swoole/ide-helper:~4.4.7
```

It's better to install this package on only development systems by adding the `--dev` flag to your Composer commands:

```bash
composer require --dev swoole/ide-helper:@dev
# or you may install a specific version, like:
composer require --dev swoole/ide-helper:~4.4.7
```

## Alternatives

The stubs are created by reverse-engineering the Swoole extensions directly; thus there is no documentation included,
and type hinting is missing in many places. The Swoole team has tried its best to keep the stubs up to date, and we do
want to add inline documentation and type hinting in the future; however, due to limited resources we don't know when it
will be ready.
 
Here are some alternatives you can consider:

* [eaglewu/swoole-ide-helper](https://github.com/wudi/swoole-ide-helper)

## Generate IDE Help Files

Have Docker running first, then use script _./bin/generator.sh_ to generate IDE help files and put them under folder
`output/` with commands like following:

```bash
./bin/generator.sh 4.4.16
./bin/generator.sh 4.4.16   master
./bin/generator.sh 4.4.16   4.4.16
./bin/generator.sh 4.4.16   b5c9cede8c6150feba50d0e28d56de355fa69d16
./bin/generator.sh 4.5.0RC1 7c913105c3273aab005489d78e0ff9043bfecb54
#
```

The first parameter specifies a stable release of Swoole. The second parameter is optional; it is to specify which
version of [Swoole library](https://github.com/swoole/library) to be integrated with (by default it will have the latest Swoole library included).
