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

WORKDIR /var/www/html

# Copy app files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Generate app key and storage link
RUN php artisan key:generate
RUN php artisan storage:link

# Expose the default Render port
EXPOSE 8080

# Start Laravel’s built-in server
CMD php artisan serve --host=0.0.0.0 --port=8080
