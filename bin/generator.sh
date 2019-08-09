#!/usr/bin/env bash
#
# To generate IDE help files of specified version of Swoole.
#
# How to use this script:
#     ./bin/generator.sh master # "master" is a branch name.
#     ./bin/generator.sh 4.4.3  # "4.4.3" is a Swoole version #.
#

set -e

if [[ -z ${1} ]] ; then
    echo "Error: a branch name, a tag or a commit number of following Git repository must be passed in:"
    echo "    https://github.com/swoole/swoole-src"
    echo "How to run this script:"
    echo "    ${0} master # 'master' is a branch name."
    echo "    ${0} 4.4.3  # '4.4.3' is a Swoole version #."
    exit 1
fi

pushd "`dirname "$0"`" > /dev/null
ROOT_PATH="`pwd -P`/.."
popd > /dev/null # Switch back to current directory.

cd "${ROOT_PATH}" # Switch to root directory of project "ide-helper".

docker run --rm                      \
    -v "`pwd`":/var/www              \
    -e SWOOLE_EXT_ASYNC=enabled      \
    -e SWOOLE_EXT_ORM=enabled        \
    -e SWOOLE_EXT_POSTGRESQL=enabled \
    -e SWOOLE_EXT_SERIALIZE=enabled  \
    -t deminy/swoole:${1}-php7.3     \
    bash -c "composer install && rm -rf ./output && ./bin/generator.php"
git add ./output
