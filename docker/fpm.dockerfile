FROM php:7.3-fpm

RUN apt-get update && apt-get install -y libpq-dev unzip libcurl4-openssl-dev pkg-config libssl-dev \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-install pdo_mysql pdo sockets \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

ADD php/default.ini /usr/local/etc/php/conf.d/php.ini
ADD php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app
