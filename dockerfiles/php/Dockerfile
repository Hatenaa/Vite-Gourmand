FROM php:8.3-fpm-alpine

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer/composer:2-bin /composer /usr/local/bin/composer

RUN apk add --no-cache git unzip \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers openssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apk del .build-deps

RUN mkdir -p /app/var/cache /app/var/log /app/var/sessions

RUN printf "upload_max_filesize=10M\npost_max_size=10M\n" > /usr/local/etc/php/conf.d/uploads.ini

COPY composer.json composer.lock symfony.lock ./
COPY bin ./bin
COPY config ./config
COPY migrations ./migrations
COPY public/index.php ./public/
COPY src ./src
COPY templates ./templates
COPY .env ./
COPY .env.dev ./
COPY dockerfiles/php/docker-entrypoint-dev.sh /usr/local/bin/docker-entrypoint-dev.sh

RUN chmod +x /usr/local/bin/composer /usr/local/bin/docker-entrypoint-dev.sh

ENTRYPOINT ["docker-entrypoint-dev.sh"]
CMD ["php-fpm"]
