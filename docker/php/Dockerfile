# Offical Docker Image for PHP
# https://hub.docker.com/_/php
FROM php:7.4-fpm

# Set Current Directory
WORKDIR /var/www/vhost/

# Install dependencies
RUN apt-get clean && apt-get update && apt-get upgrade -y && apt-get install -y \
    git \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libmagickwand-dev \
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
    gd \
    mbstring \
    pdo_mysql \
    fileinfo \
    tokenizer \
    xml \
    zip

# Install Composer from Official Docker Image
# https://hub.docker.com/_/composer
COPY --from=composer /usr/bin/composer /usr/bin/composer
