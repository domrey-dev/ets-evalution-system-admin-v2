#!/bin/sh
set -e

chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

exec "$@"
