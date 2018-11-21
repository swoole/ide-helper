Swoole IDE helper
===

# Generate Helper Files
```shell
php dump.php
```
Add `output/` to your ide include path.

# Generate Phar file for files in `output/` (Optional)

```shell
php -d phar.readonly=0 build-phar.php
```

Add `swoole-ide-helper.phar` to your ide include path.