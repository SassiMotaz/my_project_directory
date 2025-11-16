# نبدأ بـ PHP-FPM
FROM php:8.2-fpm

# تثبيت بعض الحاجات اللازمة
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# نسخ الملفات
COPY . .

# تنفيذ composer install
RUN composer install --no-dev --optimize-autoloader

# بناء الكاش (اختياري، حسب project)
# RUN php bin/console cache:clear --env=prod

EXPOSE 8080

# نطلق السيرفر
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
