FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN mkdir -p var && chmod -R 777 var

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
