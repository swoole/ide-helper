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
`output/`. This script accepts one parameter only, which should be a branch name, a tag or a commit number of repository
[https://github.com/swoole/swoole-src](https://github.com/swoole/swoole-src). e.g.,

```bash
./bin/generator.sh master  # "master" is a branch name.
./bin/generator.sh v4.3.3  # "v4.3.3" is a tag.
./bin/generator.sh 49d44ca # "49d44ca" is a Git commit number.
```
