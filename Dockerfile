# --- Stage 1: Build PHP dependencies ---
FROM php:8.3-fpm AS build

# Install system dependencies and PHP extensions
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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy full Laravel project for artisan and discovery
COPY . .

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader


# --- Stage 2: Final image ---
FROM php:8.3-fpm

# Install system dependencies again (required to run)
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

# Optional: Install Node.js 20 (useful for Laravel Mix / Vite builds)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy source code
COPY . .

# Copy built vendor files from previous stage
COPY --from=build /var/www/html/vendor ./vendor
RUN npm install && npm run build
# Ensure proper permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data .

# Expose PHP-FPM port (default is 9000)
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
