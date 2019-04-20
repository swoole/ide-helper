#!/usr/bin/env bash

set -e

if [[ -z ${1} ]] ; then
    echo "Error: Swoole version # is not specified."
    echo "How to run the script:"
    echo "    ${0} swoole-version"
    echo "For example:"
    echo "    ${0} 4.0.0"
    exit 1
fi

pushd "`dirname "$0"`" > /dev/null
ROOT_PATH="`pwd -P`/.." # Switch to root directory of project "ide-helper".
popd > /dev/null # Switch back to current directory.

cd "${ROOT_PATH}"

docker build --build-arg SWOOLE_VERSION=${1} -t swoole/ide-helper .
docker run --rm -v "`pwd`":/var/www -t swoole/ide-helper bash -c \
    "composer install && rm -rf ./output && ./bin/generator.php && if [[ -d .git ]] ; then git add ./output ; fi"
