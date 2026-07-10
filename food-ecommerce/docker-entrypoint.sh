#!/bin/sh
set -e

# Run initialization steps only for the web server container to avoid race conditions
if [ "$1" = "apache2-foreground" ]; then
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

    # Ensure the public/storage symlink exists so uploaded images are served
    # (--force recreates it if missing or broken, e.g. after a fresh volume mount)
    php artisan storage:link --force

    # Run database migrations
    echo "Running migrations..."
    php artisan migrate --force
else
    # For worker and other commands, just clear config cache so the latest settings are loaded
    php artisan config:clear
fi

# Exec the container's main command
exec "$@"
