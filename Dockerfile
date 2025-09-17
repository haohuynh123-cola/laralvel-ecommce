# Sử dụng PHP base image
FROM php:8.2-fpm

# Cài extension cần thiết cho Laravel
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Cài Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy file composer trước để cache dependency
COPY source/composer.json source/composer.lock ./

RUN composer install --no-scripts --no-autoloader

# Copy toàn bộ source code vào container
COPY source/ .

# Chạy autoload
RUN composer dump-autoload --optimize

# Quyền cho storage và bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
