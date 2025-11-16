FROM php:8.2-fpm

# -------------------------
# 1) Install system packages
# -------------------------
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libicu-dev libpq-dev curl \
    && docker-php-ext-install intl zip pdo pdo_pgsql

# -------------------------
# 2) Install Composer
# -------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# -------------------------
# 3) Install Node + NPM
# -------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# -------------------------
# 4) Project files
# -------------------------
WORKDIR /app
COPY . .

# -------------------------
# 5) Install PHP deps
# -------------------------
RUN composer install --no-interaction --no-dev --optimize-autoloader

# -------------------------
# 6) Install JS deps & build assets
# -------------------------
RUN npm install
RUN npm run build

# -------------------------
# 7) Clear cache
# -------------------------
RUN php bin/console cache:clear --env=prod

# -------------------------
# 8) Run server
# -------------------------
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
