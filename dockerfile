FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libicu-dev \
    && docker-php-ext-install pdo pdo_pgsql intl \
    && apt-get clean

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files
COPY composer.json composer.lock* ./

# Install dependencies بدون تنفيذ الـ scripts
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy full app
COPY . .

# نفذ بس dump-autoload (بدون cache:clear لأن DB ما موجودة)
RUN composer dump-autoload --optimize --no-dev

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]