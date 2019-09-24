#!/bin/sh
php composer.phar update;
echo "Downloading composer dependencies: done";

echo "Clearing Laravels config: start";
php artisan config:clear;
echo "Clearing Laravels config: done";

echo "Making database migrations: start";
php artisan migrate:fresh;
echo "Making database migrations: done";

echo "Filling database with film data: start";
php artisan fillfilms:go;
echo "Filling database with film data: done";

echo "Installing npms dependencies (front-end): start";
npm install;
echo "Installing npms dependencies (front-end): done";
    
echo "Launch front-end builder (npm run production): start";
npm run production;
echo "Launch front-end builder: done";

echo "Starting jobs-queue: start";
php artisan queue:work;