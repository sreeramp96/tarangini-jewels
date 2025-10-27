# STAGE 1: Composer Build
FROM composer:2 AS composer_installer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# STAGE 2: PHP-FPM Runtime
FROM php:8.4-fpm-bookworm AS app
WORKDIR /var/www/html

# Install system dependencies (Debian based)
RUN apt-get update && apt-get install -y \
    git \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    # Add other required system packages here

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql zip opcache gd

# Copy application files and vendor
COPY . /var/www/html
COPY --from=composer_installer /var/www/html/vendor /var/www/html/vendor

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Run Laravel setup
USER www-data
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan optimize --no-interaction

EXPOSE 9000
CMD ["php-fpm"]

# STAGE 3: Nginx Web Server
FROM nginx:alpine
# Copy Nginx config (MUST be in your repo)
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy application files (only public)
COPY --from=app /var/www/html/public /var/www/html/public

# The nginx service will listen on $PORT
EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]
