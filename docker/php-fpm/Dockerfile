FROM php:8.2.29-fpm-bookworm

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
