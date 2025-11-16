FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy all project files
COPY . .

# Install Symfony dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8080

# Serve the Symfony App
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
