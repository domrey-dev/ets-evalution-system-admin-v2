# --- Stage 1: Build dependencies ---
FROM php:8.3-fpm AS build

# Install core dependencies
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

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www/html

# Copy composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files and install dependencies
COPY . .
RUN composer install --no-dev --optimize-autoloader

# Run frontend build
RUN npm install && npm run build

# --- Stage 2: Production image ---
FROM php:8.3-fpm

# Install runtime dependencies. Note: The build stage had extra deps for building
# like git, curl, and build-essential, which aren't needed in the final image.
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql pgsql pdo_pgsql

# Set working directory
WORKDIR /var/www/html

# Copy PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini

# Copy the entire built application from the build stage
COPY --from=build /var/www/html /var/www/html

# Create the directories if they don't exist and set permissions
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and set up the entrypoint script
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# The entrypoint script is responsible for setting permissions at runtime
# to handle cases where volumes might be mounted.
ENTRYPOINT ["/entrypoint.sh"]

EXPOSE 9000

CMD ["php-fpm"]
