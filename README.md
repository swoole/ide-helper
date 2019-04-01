# Swoole IDE Helper

[![Latest Stable Version](https://poser.pugx.org/swoole/ide-helper/v/stable.svg)](https://packagist.org/packages/swoole/ide-helper)
[![License](https://poser.pugx.org/swoole/ide-helper/license)](LICENSE)

This package contains IDE help files for [Swoole](https://github.com/swoole/swoole-src). You may use it in your IDE to provide accurate autocompletion. 

## Install

You may add this package to your project using [Composer](https://getcomposer.org):

```bash
composer require swoole/ide-helper:@dev
# or,
composer require swoole/ide-helper:~4.3.0
```

It's better to install this package on only development systems by adding the `--dev` flag to your Composer commands:

```bash
composer require --dev swoole/ide-helper:@dev
# or,
composer require --dev swoole/ide-helper:~4.3.0
```

## Generate IDE Help Files

Use following commands to generate IDE help files and put them under folder `output/`.

```bash
rm -rf ./output && php dump.php
```
