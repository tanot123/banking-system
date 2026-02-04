#!/usr/bin/env bash

composer install --no-dev --optimize-autoloader

npm install
npm run build

php artisan config:cache
php artisan route:cache
php artisan view:cache

mkdir -p database
touch database/database.sqlite

php artisan migrate --force
php artisan db:seed --force
