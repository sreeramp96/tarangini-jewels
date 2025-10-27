# STAGE 1: Composer Build Stage
# Use a dedicated composer image to download dependencies
FROM composer:2 AS composer_installer

# Set working directory for composer
WORKDIR /app

# Copy the minimum files required for dependency installation
COPY composer.json composer.lock ./

# CRITICAL FIX: Use --no-scripts to prevent the crashing 'php artisan package:discover'
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts


# STAGE 2: Final Runtime Stage (FrankenPHP)
# Use a stable FrankenPHP image with PHP 8.4 and Alpine
FROM dunglas/frankenphp:1.4-php8.4-alpine

# Set the application directory
WORKDIR /app

# Copy the source code (excluding .gitignore entries)
COPY . /app

# Copy the vendor directory from the build stage
COPY --from=composer_installer /app/vendor /app/vendor

COPY .env.example .env
# Switch to root for installing system dependencies
USER root
# Install common database extensions (PostgreSQL and MySQL)
RUN apk add --no-cache libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql opcache

# Change file ownership to the application user (www-data is the default in this image)
RUN chown -R www-data:www-data /app

# Switch back to the non-root user for running commands
USER www-data

# Set file permissions (CRUCIAL for Laravel storage, cache, and logs)
RUN chmod -R 775 storage bootstrap/cache

# Run Laravel production setup commands
# NOTE: This replaces the failing Composer scripts and optimizes the application
RUN php artisan key:generate --force
RUN php artisan migrate --force
RUN php artisan storage:link
RUN php artisan optimize --no-interaction
RUN php artisan migrate:fresh --seed --force

# Define the web root for FrankenPHP
ENV SERVER_DOCUMENT_ROOT public

# Expose the default port (8080 is a common convention for internal services)
EXPOSE 8080

# The base image's default command (CMD) will start FrankenPHP automatically,
# serving the application from the 'public' directory on the exposed port.
