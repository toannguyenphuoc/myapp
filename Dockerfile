# PHP 8.2 với FPM
FROM php:8.2-fpm

# Cài extension cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd mbstring pdo_mysql xml

# Cài Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Thư mục làm việc
WORKDIR /var/www

# COPY composer files trước để tận dụng cache Docker
COPY composer.json composer.lock ./

# Cài dependencies nhưng tạm bỏ scripts để tránh lỗi artisan chưa có
RUN composer install --no-dev --optimize-autoloader --no-scripts

# COPY toàn bộ source code
COPY . .

# Chạy lại scripts để Laravel thực hiện package discovery
RUN composer run-script post-autoload-dump

# Tạo thư mục nếu chưa có
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expose port 9000 cho PHP-FPM
EXPOSE 9000

# Khởi động PHP-FPM
CMD ["php-fpm"]
