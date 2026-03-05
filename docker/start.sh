#!/bin/bash
set -e

PORT="${PORT:-8080}"

# Run Laravel setup - FORCE RESEED v3.1 (debug missing 3 companies)
php artisan migrate:fresh --seed --force || true

php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

echo "Starting PHP server on port $PORT..."

# Start PHP built-in server
exec php artisan serve --host=0.0.0.0 --port="$PORT"
