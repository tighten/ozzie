#!/bin/bash
composer install
npm install
npm run dev
cp .env.example .env
php artisan key:generate
