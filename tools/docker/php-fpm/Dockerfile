FROM php:7.2-fpm

MAINTAINER Fenrir Inc.

RUN apt-get update \
 && apt-get install -y vim git zip wget libtool libz-dev

RUN docker-php-ext-install pdo_mysql mysqli mbstring

# pecl extensions
RUN pecl channel-update pecl.php.net \
#    && pecl install xdebug-2.6.0 \
#    && pecl install redis-4.0.1 \
    && pecl install grpc \
    && pecl install protobuf \
    && docker-php-ext-enable grpc protobuf
#    && docker-php-ext-enable redis xdebug grpc protobuf

COPY php.ini /usr/local/etc/php/conf.d
