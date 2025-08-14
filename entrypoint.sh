#!/bin/bash

set -e

# Change to the application directory
cd /var/www/html


chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exec "$@"
