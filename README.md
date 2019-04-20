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
composer require swoole/ide-helper:~4.3.0
```

It's better to install this package on only development systems by adding the `--dev` flag to your Composer commands:

```bash
composer require --dev swoole/ide-helper:@dev
# or you may install a specific version, like:
composer require --dev swoole/ide-helper:~4.3.0
```

## Generate IDE Help Files

Have Docker running first, then use following commands to generate IDE help files and put them under folder `output/`.

```bash
./bin/generator.sh swoole-version
# Please replace "swoole-version" with a Swoole version #. e.g.,
./bin/generator.sh 4.3.1
./bin/generator.sh 4.3.2
```
