FROM phpdockerio/php7-fpm:latest
    
# POST and max upload sizes on php.ini
RUN sed -i "/upload_max_filesize = .*/c\upload_max_filesize = 100M" /etc/php/7.0/fpm/php.ini \
    && sed -i "/post_max_size = .*/c\post_max_size = 108M" /etc/php/7.0/fpm/php.ini

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.0-memcached php7.0-mysql \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# If you're using symfony and the vagranted environment, I strongly recommend you change your AppKernel to use the following temporary folders
# for cache, logs and sessions, otherwise application performance may suffer due to these being shared over NFS back to the host
RUN mkdir -p "/tmp/phpdocker-io/cache" \
    && mkdir -p "/tmp/phpdocker-io/logs" \
    && mkdir -p "/tmp/phpdocker-io/sessions" \
    && chown www-data:www-data -R "/tmp/phpdocker-io"

WORKDIR "/var/www/phpdocker-io"