FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip zip nodejs npm libzip-dev libpng-dev libonig-dev

# Extensions PHP nécessaires pour Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

# Créer le fichier .env depuis .env.example si absent
RUN cp -n .env.example .env || true

RUN chmod -R 775 storage bootstrap/cache

RUN php artisan config:clear
RUN php artisan cache:clear

EXPOSE 8080

CMD php artisan config:cache && php -S 0.0.0.0:8080 -t public