FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip zip nodejs npm \
    libzip-dev libpng-dev libonig-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
RUN cp -n .env.example .env || true
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8080

CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan migrate --force && \
    php -S 0.0.0.0:8080 -t public