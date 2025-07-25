#!/bin/bash

set -e

cd /var/www/html

if [ ! -d "vendor" ]; then
    echo "Running composer install..."
    composer install
else
    echo "vendor directory already exists. Skipping composer install."
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

# If not, generate it. This is crucial for Laravel's security features.
# if grep -qE '^APP_KEY=\s*$' .env || ! grep -q '^APP_KEY=' .env; then
#     echo "Generating application key..."
#     php artisan key:generate
# else
#     echo "Application key already exists."
# fi
pwd
cat .env

php artisan key:generate

cat .env

if [ ! -d "node_modules" ]; then
    echo "Running npm install..."
    npm install
else
    echo "Skipping npm install."
fi

if [ -d "node_modules" ]; then
    echo "Running npm run build..."
    npm run build
else
    echo "node_modules not found, skipping npm run build."
fi

# Run Laravel migrations.
# echo "Running Laravel migrations..."
# php artisan migrate --seed

echo "Clearing and caching configurations..."

chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exec "$@"
