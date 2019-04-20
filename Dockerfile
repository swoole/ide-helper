FROM php:7.3-cli

ARG SWOOLE_VERSION

RUN \
    docker-php-ext-install sockets              && \
    apt-get update                              && \
    apt-get install -y libpq-dev libssl-dev     && \
    pecl update-channels                        && \
    pecl install                                   \
        --onlyreqdeps                              \
        --nobuild                                  \
        swoole-${SWOOLE_VERSION}                && \
    cd "$(pecl config-get temp_dir)/swoole"     && \
    phpize                                      && \
    ./configure                                    \
        --enable-sockets                           \
        --enable-openssl                           \
        --enable-http2                             \
        --enable-mysqlnd                           \
        --enable-coroutine-postgresql           && \
    make                                        && \
    make install                                && \
    docker-php-ext-enable swoole                && \
    rm -r /var/lib/apt/lists/*                  && \
    echo '#!/usr/bin/env bash' > /entrypoint.sh && \
    echo 'exec "$@"'          >> /entrypoint.sh && \
    chmod +x /entrypoint.sh                     && \
    curl                      \
        -sf                   \
        --connect-timeout 5   \
        --max-time         15 \
        --retry            5  \
        --retry-delay      2  \
        --retry-max-time   60 \
        http://getcomposer.org/installer | php -- --install-dir="/usr/bin" --filename=composer

ENTRYPOINT ["/entrypoint.sh"]
CMD []

WORKDIR "/var/www/"
