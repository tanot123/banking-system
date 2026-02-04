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

RUN mkdir -p database storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache

RUN touch database/database.sqlite

RUN chmod -R 777 storage bootstrap/cache database

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

COPY .env.render .env

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

RUN php artisan migrate --force

RUN php artisan db:seed --force

EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
