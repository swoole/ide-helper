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
composer require swoole/ide-helper:~4.3.3
```

It's better to install this package on only development systems by adding the `--dev` flag to your Composer commands:

```bash
composer require --dev swoole/ide-helper:@dev
# or you may install a specific version, like:
composer require --dev swoole/ide-helper:~4.3.3
```

## Generate IDE Help Files

Have Docker running first, then use script _./bin/generator.sh_ to generate IDE help files and put them under folder
`output/` with commands like following:

```bash
./bin/generator.sh       # To generate stubs with latest code from the master branch of Swoole.
./bin/generator.sh 4.4.3 # To generate stubs for a specific version of Swoole.
```
