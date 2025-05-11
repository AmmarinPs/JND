FROM php:8.1-apache

# อนุญาตให้ composer รันเป็น root ได้
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/tmp

# ติดตั้งส่วนเสริมที่ต้องใช้
RUN apt-get update && apt-get install -y \
      libzip-dev zip unzip git \
    && docker-php-ext-install pdo_mysql zip

# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

# 1) คัดลอกเฉพาะ composer.json/lock ก่อน
COPY composer.json composer.lock ./

# 2) ติดตั้ง dependencies แต่ข้ามการรันสคริปต์
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts \
    --no-interaction \
    --no-progress

# 3) คัดลอกโค้ดทั้งหมด (รวม .env.example)
COPY . .

# 4) เตรียม .env กับ APP_KEY
RUN cp .env.example .env \
    && php artisan key:generate --ansi

# 5) รันสคริปต์ package discover ทีหลัง เมื่อ .env พร้อมแล้ว
RUN composer run-script post-autoload-dump

# 6) Cache config/routes (optional)
RUN php artisan config:cache \
    && php artisan route:cache

EXPOSE 80
