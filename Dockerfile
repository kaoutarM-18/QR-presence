FROM php:8.2-cli

# Installer dépendances
RUN apt-get update && apt-get install -y \
    git curl unzip nodejs npm

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Dossier app
WORKDIR /app

# Copier projet
COPY . .

# Installer Laravel
RUN composer install --no-dev --optimize-autoloader

# 🔥 IMPORTANT (corrige ton problème CSS)
RUN npm install
RUN npm run build

# Port Railway
EXPOSE 8080

# Lancer serveur
CMD php -S 0.0.0.0:8080 -t public