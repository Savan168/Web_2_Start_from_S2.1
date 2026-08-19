#!/bin/bash
set -e

# First-run bootstrap: create .env, install deps, and ensure the
# RoadRunner binary is present and executable if they are missing.
if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    composer install
fi

if [ ! -f rr ]; then
    php artisan octane:install --server=roadrunner
fi

chmod +x rr 2>/dev/null || true

php artisan key:generate
wait $!
php artisan migrate
wait $!
exec supervisord -c /etc/supervisor/conf.d/supervisord.development.conf