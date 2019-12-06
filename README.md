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

[Swoole Library](https://github.com/swoole/library) is not included in this repository. To add Swoole Library, please
run Composer commands like:

```bash
composer require swoole/library:@dev
```

## Alternatives

The stubs are created by reverse-engineering the Swoole extensions directly; thus there is no documentation included,
and type hinting is missing in many places. The Swoole team has tried its best to keep the stubs up to date, and we do
want to add inline documentation and type hinting in the future; however, due to limited resources we don't know when it
will be ready.
 
Here are some alternatives you can consider:

* [eaglewu/swoole-ide-helper](https://github.com/wudi/swoole-ide-helper)
* [swoft/swoole-ide-helper](https://github.com/swoft-cloud/swoole-ide-helper)

## Generate IDE Help Files

Have Docker running first, then use script _./bin/generator.sh_ to generate IDE help files and put them under folder
`output/` with commands like following:

```bash
./bin/generator.sh       # To generate stubs with latest code from the master branch of Swoole.
./bin/generator.sh 4.4.7 # To generate stubs for a specific version of Swoole.
```
