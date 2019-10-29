## Dev environment
FROM phpdockerio/php74-fpm:latest AS base
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.4-pgsql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

## Deployed environment
FROM base AS deployment

ENV APP_ENV=prod

COPY composer.* /application/
RUN composer install --no-dev --prefer-dist --no-scripts ; \
    composer clear-cache

ADD bin    /application/bin
ADD public /application/public
ADD config /application/config
ADD src    /application/src

RUN mkdir -p /application/var/cache/prod; \
    composer dump-autoload --optimize --classmap-authoritative; \
    bin/console cache:warmup
