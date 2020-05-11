#!/usr/bin/env bash
#
# To generate IDE help files of Swoole.
#
# How to use this script:
#     ./bin/generator.sh 4.4.16
#     ./bin/generator.sh 4.4.16   master
#     ./bin/generator.sh 4.4.16   4.4.16
#     ./bin/generator.sh 4.4.16   b5c9cede8c6150feba50d0e28d56de355fa69d16
#     ./bin/generator.sh 4.5.0RC1 7c913105c3273aab005489d78e0ff9043bfecb54
#
# The first parameter specifies a stable release of Swoole. The second parameter is optional; it is to specify which
# version of Swoole library to be integrated with (by default it will have the latest Swoole library included).
#

set -e

pushd "`dirname "$0"`" > /dev/null
ROOT_PATH="`pwd -P`/.."
popd > /dev/null # Switch back to current directory.

cd "${ROOT_PATH}" # Switch to root directory of project "ide-helper".

rm -rf ./output
docker run --rm                     \
    -v "$(pwd)":/var/www            \
    -e SWOOLE_LIB_VERSION=${2}      \
    -t phpswoole/swoole:${1}-php7.1 \
    bash -c "composer install && ./bin/generator.php"
git add ./output
