#!/bin/sh

echo "Running deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Cache everything
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "Deployment complete - using pre-seeded SQLite database!"
