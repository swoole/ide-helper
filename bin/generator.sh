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

SWOOLE_VERSION=${1}
DOCKER_IMAGE=swoole/ide-helper:${SWOOLE_VERSION}

cd "${ROOT_PATH}"

if ! docker image inspect ${DOCKER_IMAGE} >/dev/null 2>&1 ; then
    docker build --build-arg SWOOLE_VERSION=${SWOOLE_VERSION} -t ${DOCKER_IMAGE} .
fi

rm -rf  ./output
docker run --rm -v "`pwd`":/var/www -t ${DOCKER_IMAGE} bash -c "composer update && ./bin/generator.php"
if hash git 2>/dev/null ; then
    git add ./output
fi
