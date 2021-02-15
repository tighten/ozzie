# Offical Docker Image for PHP
# https://hub.docker.com/_/php
FROM php:7.4-fpm

# Set Current Directory
WORKDIR /var/www/vhost/

# Install dependencies
RUN apt-get clean && apt-get update && apt-get upgrade -y && apt-get install -y \
    git \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip \
    zip \
    redis-server

RUN docker-php-source extract && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    docker-php-source delete

# PHP Extensions
RUN docker-php-ext-install \
    bcmath \
    ctype \
    json \
    mbstring \
    pdo_mysql \
    fileinfo \
    tokenizer \
    xml \
    zip

COPY ./start.sh /usr/local/bin/start

# Install Composer from Official Docker Image
# https://hub.docker.com/_/composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN  chmod u+x /usr/local/bin/start
CMD ["/usr/local/bin/start"]
