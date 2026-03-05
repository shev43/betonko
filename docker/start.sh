#!/bin/bash
set -e

PORT="${PORT:-8080}"

# Run Laravel setup
php artisan migrate --force 2>/dev/null || true

# Seed database if it's empty (first deploy)
USERS_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null || echo "0")
if [ "$USERS_COUNT" = "0" ] || [ "$USERS_COUNT" = "" ]; then
    echo "Empty database detected, running seeders..."
    php artisan db:seed --force 2>/dev/null || true
fi

php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

echo "Starting PHP server on port $PORT..."

# Start PHP built-in server
exec php artisan serve --host=0.0.0.0 --port="$PORT"
