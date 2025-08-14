# --- Stage 1: Build & Install Composer Dependencies ---
FROM php:8.3-fpm AS build

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    build-essential \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql pgsql pdo_pgsql

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs
# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files and install deps
COPY composer.json composer.lock ./
# RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts


# Copy Laravel app
COPY . .

RUN composer run-script post-autoload-dump
# Set permissions for Laravel storage
RUN chown -R www-data:www-data storage bootstrap/cache

# --- Stage 2: Production Image ---
FROM php:8.3-fpm

WORKDIR /var/www/html

# Copy PHP extensions from build stage
COPY --from=build /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=build /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

# Copy built app
COPY --from=build /var/www/html /var/www/html

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]
