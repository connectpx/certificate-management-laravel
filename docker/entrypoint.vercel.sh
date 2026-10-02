#!/bin/sh
set -eu

cd /app

# Neon/PgBouncer: prefer a direct (unpooled) URL for migrations/advisory locks.
MIGRATE_DB_URL="${DB_URL_UNPOOLED:-${DATABASE_URL_UNPOOLED:-${DB_URL:-${DATABASE_URL:-}}}}"

echo "Running database migrations..."
if [ -n "$MIGRATE_DB_URL" ]; then
    DB_URL="$MIGRATE_DB_URL" php artisan migrate --force --no-interaction
else
    php artisan migrate --force --no-interaction
fi

if [ "${RUN_DB_SEED:-false}" = "true" ]; then
    echo "Running database seeders..."
    if [ -n "$MIGRATE_DB_URL" ]; then
        DB_URL="$MIGRATE_DB_URL" php artisan db:seed --force --no-interaction
    else
        php artisan db:seed --force --no-interaction
    fi
fi

echo "Starting FrankenPHP..."
exec frankenphp run --config /etc/frankenphp/Caddyfile
