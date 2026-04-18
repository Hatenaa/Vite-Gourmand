FROM php:8.3-fpm-alpine

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers openssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apk del .build-deps
