# ใช้ official PHP image กับ Apache
FROM php:8.1-apache

# ติดตั้งส่วนเสริมที่จำเป็น (pdo_mysql, zip, unzip, git)
RUN apt-get update && apt-get install -y \
      libzip-dev \
      zip \
      unzip \
      git \
    && docker-php-ext-install pdo_mysql zip

# ติดตั้ง Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# ตั้ง working directory
WORKDIR /var/www/html

# คัดลอกไฟล์ composer ก่อนเพื่อ leverage Docker cache
COPY composer.json composer.lock ./

# ติดตั้ง dependencies
RUN composer install --no-dev --optimize-autoloader

# คัดลอกโค้ดที่เหลือ
COPY . .

# สร้าง key และ cache config เข้า production mode
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache

# ให้ Apache ชี้ไปที่ public
# (ใน php:apache image, DocumentRoot คือ /var/www/html ของเรา)
EXPOSE 80
