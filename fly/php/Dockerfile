# Installation des assets
FROM node:20-alpine AS node_build
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY webpack.config.js ./
COPY assets ./assets
RUN npm run build

# On installe nos dépendances PHP avec Composer
FROM composer:2 AS composer_build
WORKDIR /app

COPY composer.json composer.lock symfony.lock ./
COPY src ./src
COPY config ./config
COPY migrations ./migrations
COPY bin ./bin
COPY public/index.php ./public/index.php

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --optimize-autoloader \
    --ignore-platform-req=ext-mongodb

# Préparation de l'image finale
FROM php:8.3-fpm-alpine

WORKDIR /app

# On installe nginx et supervisord
RUN apk add --no-cache nginx supervisor

COPY /fly/php/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /etc/supervisor/conf.d && \
    echo "[supervisord]" > /etc/supervisor/conf.d/supervisord.conf && \
    echo "nodaemon=true" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "[program:nginx]" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "command=/usr/sbin/nginx -g 'daemon off;'" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "autostart=true" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "autorestart=true" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "[program:php-fpm]" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "command=/usr/local/sbin/php-fpm" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "autostart=true" >> /etc/supervisor/conf.d/supervisord.conf && \
    echo "autorestart=true" >> /etc/supervisor/conf.d/supervisord.conf

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS linux-headers openssl-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    docker-php-ext-install pdo pdo_mysql mysqli opcache && \
    apk del .build-deps

# Configurer PHP-FPM pour écouter sur IPv4
RUN printf "[www]\nlisten = 127.0.0.1:9000\n" > /usr/local/etc/php-fpm.d/zz-listen.conf

# Configuration PHP pour la production
RUN printf "opcache.enable=1\nopcache.preload_user=www-data\nupload_max_filesize=10M\npost_max_size=10M\n" \
    > /usr/local/etc/php/conf.d/prod.ini

COPY --from=node_build /app/public/build /app/public/build

COPY --from=composer_build /app/vendor /app/vendor

# Copier les dépendances Composer (métadonnées)
COPY composer.json composer.lock symfony.lock ./
COPY public ./public
COPY templates ./templates
COPY src ./src
COPY config ./config
COPY bin ./bin
COPY migrations ./migrations
COPY .env ./

# Override APP_ENV pour production
RUN sed -i 's/APP_ENV=dev/APP_ENV=prod/' .env

# Créer les répertoires nécessaires et donner les permissions à www-data
RUN mkdir -p var/cache var/log var/sessions public/uploads && \
    chown -R www-data:www-data /app/var /app/public

# Réchauffer le cache à build time
RUN php bin/console cache:warmup --env=prod || true

# Exposer le port 80
EXPOSE 80

# Démarrer supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]