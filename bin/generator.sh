#!/usr/bin/env bash
#
# To generate IDE help files of Swoole.
#
# How to use this script:
#     ./bin/generator.sh
#     ./bin/generator.sh master
#     ./bin/generator.sh a236ce004518e166b483d8d72cf5cc9ac2282164
#
# The only parameter accepted is to specify which version of Swoole library to be integrated in. By default it will have
# latest Swoole library included (from the master branch).
#

set -e

pushd "`dirname "$0"`" > /dev/null
ROOT_PATH="`pwd -P`/.."
popd > /dev/null # Switch back to current directory.

cd "${ROOT_PATH}" # Switch to root directory of project "ide-helper".

rm -rf ./output
docker run --rm                \
    -v "$(pwd)":/var/www        \
    -e SWOOLE_LIB_VERSION=${1} \
    -t $(docker build -q .)    \
    bash -c "composer install && ./bin/generator.php"
git add ./output
