FROM php:5.5.9-fpm-alpine

WORKDIR /var/www/html
RUN docker-php-ext-install pdo pdo_mysql