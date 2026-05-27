ARG PHP_VERSION=8.5

###########
# Backend #
###########

# Base container for dev & deployment
FROM phpdockerio/php:${PHP_VERSION}-fpm AS backend-base
WORKDIR "/application"

ARG PHP_VERSION

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

FROM backend-base AS backend-dev

ARG PHP_VERSION

RUN apt-get update \
    && apt-get -y --no-install-recommends install php${PHP_VERSION}-xdebug \
    && phpdismod xdebug \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Pre-deployment container. The deployed container needs generated frontend assets.
FROM backend-base AS backend-deployment

ARG PHP_VERSION

ENV APP_ENV=prod
ENV SYMFONY_ENV=prod
ENV APP_SECRET=""

ENV GOOGLE_ANALYTICS=""

COPY bin/console /application/bin/
COPY composer.*  /application/

RUN composer install --no-dev --no-scripts \
    && composer clear-cache

COPY infrastructure/php-fpm/php-ini-overrides.ini  /etc/php/${PHP_VERSION}/fpm/conf.d/z-overrides.ini
COPY infrastructure/php-fpm/opcache-prod.ini       /etc/php/${PHP_VERSION}/fpm/conf.d/z-opcache.ini
COPY infrastructure/php-fpm/php-fpm-pool-prod.conf /etc/php/${PHP_VERSION}/fpm/pool.d/z-optimised.conf

COPY config           ./config
COPY src              ./src
COPY templates        ./templates
COPY public/index.php ./public/

RUN touch ./.env

RUN COMPOSER_ALLOW_SUPERUSER=1 composer dump-autoload --optimize --classmap-authoritative --no-scripts \
    && bin/console cache:warmup \
    && chown www-data:www-data var/ -Rf

############
# Frontend #
############
# Use the normal Node image rather than Alpine for more consistent ARM builds.
# Bigger and slower unfortunately, but it works.
FROM node:latest AS frontend-installer

WORKDIR /application

COPY package.json .
COPY package-lock.json .

RUN npm ci

COPY tailwind.config.js postcss.config.js ./
COPY assets/ ./assets/
COPY templates/ ./templates/

RUN npm run build:css

## Actual deployable frontend image
FROM nginx:alpine AS frontend-deployment

WORKDIR /application

COPY infrastructure/nginx/nginx.conf /etc/nginx/conf.d/default.conf

# NGINX config: update php-fpm hostname to localhost (same pod in k8s), activate pagespeed config, deactivate SSL
RUN sed -i "s/# %DEPLOYMENT //g"            /etc/nginx/conf.d/default.conf \
    && sed -i "s/listen 443/#listen 443/g"  /etc/nginx/conf.d/default.conf \
    && sed -i "s/ssl_/#ssl_/g"              /etc/nginx/conf.d/default.conf

COPY --from=frontend-installer /application/node_modules/font-awesome public/vendor/font-awesome
COPY --from=frontend-installer /application/public/css public/css

COPY public/js     public/js
COPY public/images public/images
