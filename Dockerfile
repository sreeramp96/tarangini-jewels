FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Copy vendor from composer stage
COPY --from=composer_installer /var/www/html/vendor /var/www/html/vendor

# Create .env before running artisan
COPY .env.example .env

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 storage bootstrap/cache

# Laravel setup
USER www-data
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan optimize --no-interaction

