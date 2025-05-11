FROM php:8.1-apache

# (บรรทัดก่อนหน้าเหมือนเดิม...)
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/tmp

RUN apt-get update && apt-get install -y \
      libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip

# เปิด mod_rewrite เพื่อให้ .htaccess ของ Laravel ทำงาน
RUN a2enmod rewrite

# เปลี่ยน DocumentRoot เป็น public/
RUN sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf \
 && sed -ri 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --no-progress

COPY . .

RUN cp .env.example .env \
    && php artisan key:generate --ansi \
    && composer run-script post-autoload-dump \
    && php artisan config:cache \
    && php artisan route:cache

EXPOSE 80
