# Use the official PHP-FPM image.
# Note: While your prompt mentions "Apache," this Dockerfile uses php:8.3-fpm.
# If you intend to use Apache directly within the container, you would use
# 'FROM php:8.3-apache' instead, and your web server configuration would differ.
# This Dockerfile assumes you're using php-fpm, which typically pairs with
# a separate web server like Nginx or Apache (configured as a reverse proxy).
FROM php:8.3-fpm

# Install system dependencies and PHP extensions required by Laravel.
# 'libpng-dev', 'libjpeg62-turbo-dev', 'libfreetype6-dev' for GD graphics library.
# 'zip' for composer dependencies, 'git' for version control if needed.
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    git \
    build-essential \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql

# Install Composer globally, which is Laravel's dependency manager.
# '--install-dir=/usr/local/bin' places the composer executable in the PATH.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js and npm for frontend asset compilation.
# Using Node.js v20 LTS.
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Set the working directory inside the container.
# This is where your Laravel application files will reside.
# Changing this to /var/www/html to match the error's indicated path.
WORKDIR /var/www/html

# Copy the Laravel application code from your local directory into the container.
# The '.' refers to the current directory where the Dockerfile is located.
# The '/var/www/html' is the destination inside the container.
COPY . .

# Install PHP dependencies using Composer.
# '--no-dev' skips development dependencies for smaller image size.
# '--optimize-autoloader' optimizes Composer's autoloader for faster execution.
# '--prefer-dist' ensures packages are downloaded as archives for faster installation.
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Install Node.js dependencies and build frontend assets.
# This step requires Node.js and npm to be installed.
RUN npm install \
    && npm run build

# Set appropriate ownership and permissions for Laravel's storage and cache directories.
# These directories need to be writable by the web server user (www-data)
# for Laravel to function correctly (e.g., writing logs, sessions, compiled views).
# '-R' applies the changes recursively.
# 'www-data:www-data' sets the user and group.
# '775' gives read/write/execute permissions to owner/group and read/execute to others.
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy the entrypoint script into the container and make it executable.
# This script typically handles environment setup and starting the application.

# COPY entrypoint.sh /usr/local/bin/entrypoint.sh
# RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port 9000, which is the default port for PHP-FPM.
EXPOSE 9000

# Set the entrypoint for the container.
# The entrypoint script will be executed first.
ENTRYPOINT ["entrypoint.sh"]

# Set the default command to run when the container starts,
# which is to start the PHP-FPM process.
CMD ["php-fpm"]
