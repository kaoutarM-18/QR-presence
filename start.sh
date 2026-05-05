#!/bin/bash

echo "=== Démarrage Laravel ==="

echo ">>> Config clear..."
php artisan config:clear

echo ">>> Cache clear..."
php artisan cache:clear

echo ">>> Route clear..."
php artisan route:clear

echo ">>> View clear..."
php artisan view:clear

echo ">>> Migration fresh (supprime et recrée tout)..."
php artisan migrate:fresh --force

echo ">>> Seeders..."
php artisan db:seed --force

echo ">>> Config cache..."
php artisan config:cache

echo ">>> Route cache..."
php artisan route:cache

echo ">>> Optimisation..."
php artisan optimize

echo "=== Lancement serveur sur port 8080 ==="
php -S 0.0.0.0:8080 -t public