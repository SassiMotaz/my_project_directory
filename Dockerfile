FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Permissions for Symfony
RUN mkdir -p var && chmod -R 777 var

# Expose port
EXPOSE 8000

# Run Symfony web server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
