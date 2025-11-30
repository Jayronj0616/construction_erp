#!/bin/sh

echo "Running deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader --no-interaction

# Generate key if needed
php artisan key:generate --force --no-interaction

# Run migrations
php artisan migrate --force --no-interaction

# Seed demo data
php artisan db:seed --class=DemoDataSeeder --force --no-interaction

# Cache everything
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

echo "Deployment complete!"
