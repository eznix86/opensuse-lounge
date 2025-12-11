#!/bin/sh
set -e



echo "Autoload"

composer dump-autoload --optimize --classmap-authoritative


echo "Storage Link"
php artisan storage:link

echo "Caching and Optimizing..."

php artisan optimize

echo "Optimization done..."

php artisan octane:install --server=frankenphp

php artisan migrate --force

exec "$@"
