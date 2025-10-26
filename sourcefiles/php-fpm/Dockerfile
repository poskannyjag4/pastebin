FROM php:8.3-fpm

WORKDIR "/application"

RUN apt-get update && apt-get upgrade -y && apt-get install curl \
    unzip \
    libpq-dev \
    libicu-dev \
    libzip-dev -y \
    && docker-php-ext-install \
    pdo_pgsql \
    intl  \
    zip \
    bcmath

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

