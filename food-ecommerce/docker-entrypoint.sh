#!/bin/sh
set -e

# Run composer install if vendor/autoload.php doesn't exist
if [ ! -f "vendor/autoload.php" ]; then
    echo "Running composer install..."
    composer install --no-interaction --optimize-autoloader
fi

# Run npm install & build if node_modules or public/build doesn't exist
if [ ! -d "node_modules" ] || [ ! -d "public/build" ]; then
    echo "Running npm install & build..."
    npm install
    npm run build
fi

# Clear caches to avoid stale configs
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run database migrations only in the web server container
if [ "$1" = "apache2-foreground" ]; then
    echo "Running migrations..."
    php artisan migrate --force
fi

# Exec the container's main command
exec "$@"
