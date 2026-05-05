FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip zip nodejs npm \
    libzip-dev libpng-dev libonig-dev \
    libxml2-dev libicu-dev g++

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    xml

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install && npm run build

RUN cp -n .env.example .env || true

RUN chmod -R 775 storage bootstrap/cache

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080

CMD ["/bin/bash", "/start.sh"]