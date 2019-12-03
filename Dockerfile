FROM php:7.2-fpm

RUN rm /etc/apt/preferences.d/no-debian-php

RUN apt-get update -y && apt-get install -y \
    libxml2-dev \
    php-soap \
    zip \
    git

RUN docker-php-ext-install soap

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
