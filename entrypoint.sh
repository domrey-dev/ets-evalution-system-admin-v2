#!/bin/bash

set -e

cd /var/www/html

if [ ! -d "vendor" ]; then
    echo "Running composer install..."
    composer install
else
    echo "vendor directory already exists"
fi

npm install

npm run build

echo "Clearing and caching configurations..."

chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exec "$@"
