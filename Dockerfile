# STAGE 1: Composer Build
FROM composer:2 AS composer_installer
WORKDIR /var/www/html
COPY composer.json composer.lock ./
# Prevents the crashing 'php artisan package:discover'
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# STAGE 2: PHP-FPM Runtime (Handles PHP logic)
FROM php:8.4-fpm-bookworm AS app_builder
WORKDIR /var/www/html

# Install Debian system dependencies
RUN apt-get update && apt-get install -y \
    git \
    libpq-dev \
    libzip-dev \
    # ... install other needed system packages

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pdo_mysql opcache

# Copy code and vendor from previous stages
COPY . /var/www/html
COPY --from=composer_installer /var/www/html/vendor /var/www/html/vendor
COPY .env.example .env # Placeholder for key:generate

# Set file ownership/permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Run Laravel setup commands
USER www-data
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan optimize --no-interaction

# STAGE 3: Final Nginx Web Server (Render will run this)
FROM nginx:stable-alpine AS final_image
WORKDIR /var/www/html

# Copy the Nginx configuration file
# NOTE: You must create a file named 'nginx.conf' in a 'docker' folder in your repo root.
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copy application files (ONLY the necessary public assets from the app_builder stage)
COPY --from=app_builder /var/www/html/public /var/www/html/public

# Copy PHP application files needed for FPM (e.g., vendor, artisan, config)
COPY --from=app_builder /var/www/html /var/www/html

# Expose port and start Nginx
EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]
