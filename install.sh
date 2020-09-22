#!/bin/sh
composer install
cpp .env.example .env
php artisan key:generate
php artisan config:cache
php artisan migrate
npm run dev
