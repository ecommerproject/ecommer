#!/bin/sh
set -e

# Ensure Laravel storage & database folders exist with write permissions
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache \
         /var/www/html/database

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# If MySQL host is invalid or not an external DB, automatically fallback to SQLite
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_HOST" ] || [ "$DB_HOST" = "127.0.0.1" ] || [ "$DB_HOST" = "localhost" ] || [ "$DB_HOST" = "your-database-host.com" ]; then
    export DB_CONNECTION=sqlite
    export DB_DATABASE="/var/www/html/database/database.sqlite"
    if [ ! -f "$DB_DATABASE" ]; then
        touch "$DB_DATABASE"
    fi
    chown www-data:www-data "$DB_DATABASE"
    chmod 666 "$DB_DATABASE"
fi

# Run migrations and seed data so products, categories, and settings exist
php artisan migrate --force || true
php artisan db:seed --force || true

# Clear and optimize configuration
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Start Apache in foreground
exec apache2-foreground
