FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Environment needed to skip problems during build
ENV APP_ENV=prod
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV SYMFONY_SKIP_ENV_CHECK=1

# Fix Symfony cache folders
RUN mkdir -p var/cache var/log var/sessions \
    && chmod -R 777 var

# Install dependencies without running Symfony auto-scripts
RUN composer install --no-scripts --no-dev --optimize-autoloader --no-interaction

# Now run auto-scripts safely (without breaking build)
RUN composer run-script auto-scripts --no-interaction || true

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
