# STAGE 1: Composer Build
FROM composer:2 AS composer_installer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
# Prevents the crashing 'php artisan package:discover'
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# STAGE 2: Final Image (PHP-FPM + Nginx)
FROM php:8.4-fpm-bookworm

# Install Nginx and other system dependencies
USER root
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    libpq-dev \
    libzip-dev \
    # Clean up APT lists to reduce image size
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql opcache

# Set the working directory
WORKDIR /var/www/html

# Copy application files and vendor
COPY . /var/www/html
COPY --from=composer_installer /var/www/html/vendor /var/www/html/vendor
COPY .env.example .env # Placeholder for key:generate

# Copy Nginx Configuration
# NOTE: This assumes you have 'docker/nginx.conf' in your repo root.
COPY docker/nginx.conf /etc/nginx/sites-enabled/default

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Run Laravel setup commands
USER www-data
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan optimize --no-interaction

# Start both PHP-FPM and Nginx with a custom script
# You must create this file in your repository root.
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh
EXPOSE 8080
ENTRYPOINT ["/usr/local/bin/start.sh"]
