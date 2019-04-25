#!/usr/bin/env bash
#
# To generate IDE help files of specified version of Swoole.
#
# How to use this script:
#     ./bin/generator.sh master  # "master" is a branch name.
#     ./bin/generator.sh v4.3.3  # "v4.3.3" is a tag.
#     ./bin/generator.sh 49d44ca # "49d44ca" is a Git commit number.
#

set -e

if [[ -z ${1} ]] ; then
    echo "Error: a branch name, a tag or a commit number of following Git repository must be passed in:"
    echo "    https://github.com/swoole/swoole-src"
    echo "How to run this script:"
    echo "    ${0} master  # 'master' is a branch name."
    echo "    ${0} v4.3.3  # 'v4.3.3' is a tag."
    echo "    ${0} 49d44ca # '49d44ca' is a Git commit number."
    exit 1
fi

pushd "`dirname "$0"`" > /dev/null
ROOT_PATH="`pwd -P`/.."
popd > /dev/null # Switch back to current directory.

cd "${ROOT_PATH}" # Switch to root directory of project "ide-helper".

docker build --build-arg SWOOLE_VERSION=${1} -t swoole/ide-helper .
docker run --rm -v "`pwd`":/var/www -t swoole/ide-helper bash -c \
    "composer install && rm -rf ./output && ./bin/generator.php && if [[ -d .git ]] ; then git add ./output ; fi"
