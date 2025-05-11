# Dockerfile

FROM php:8.1-apache

# 1. อนุญาตให้ composer รันเป็น root ได้
ENV COMPOSER_ALLOW_SUPERUSER=1
# ตั้งค่าโฟลเดอร์สำหรับ Composer home
ENV COMPOSER_HOME=/tmp

# 2. ติดตั้งส่วนเสริมที่ต้องใช้
RUN apt-get update && apt-get install -y \
      libzip-dev \
      zip \
      unzip \
      git \
    && docker-php-ext-install pdo_mysql zip

# 3. ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html

# 4. Copy เฉพาะไฟล์ composer.json และ lock ไว้ก่อน เพื่อ leverage cache
COPY composer.json composer.lock ./

# 5. ติดตั้ง dependencies พร้อม disable plugins ที่โดน root block ไว้
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress

# 6. Copy โค้ดที่เหลือทั้งหมด
COPY . .

# 7. สร้าง key, cache config, cache routes ให้พร้อมรัน
RUN php artisan key:generate --ansi \
    && php artisan config:cache \
    && php artisan route:cache

# 8. เปิดพอร์ต 80
EXPOSE 80
