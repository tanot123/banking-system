FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    sqlite3 \
    libsqlite3-dev

RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN mkdir -p database storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

RUN touch database/database.sqlite

RUN chmod -R 775 storage bootstrap/cache database

RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

RUN php artisan migrate --force

RUN php artisan db:seed --force

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
