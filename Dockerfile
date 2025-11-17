FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Fix environment variable DEFAULT_URI to avoid cache:clear error
ENV DEFAULT_URI=null

# Create Symfony needed folders (cache + logs + sessions)
RUN mkdir -p var/cache var/log var/sessions \
    && chmod -R 777 var

RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
