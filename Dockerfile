# STAGE 1: Build Stage (Used only to install Composer dependencies)
# Use a dedicated composer image, which is fast and ensures Composer is available.
FROM composer:2 AS composer_installer

# Set the working directory for Composer
WORKDIR /app

# Copy the Laravel files needed for Composer
COPY composer.json composer.lock ./

# Run composer install
# We use the official composer image, so we don't need to install composer itself.
RUN composer install --no-dev --optimize-autoloader --no-interaction


# STAGE 2: Final Runtime Stage (The image that Render will run)
FROM dunglas/frankenphp:1.4-php8.4-alpine

# Set the working directory
WORKDIR /app

# Copy application code
COPY . /app

# Copy the vendor directory from the composer_installer stage
COPY --from=composer_installer /app/vendor /app/vendor

# Set permissions and ownership
# Switch to root for permission commands
USER root
# Ensure system dependencies for DB connection are present (if needed)
RUN apk add --no-cache libpq-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql opcache
# Change ownership to the non-root user (www-data)
RUN chown -R www-data:www-data /app

# Switch back to the non-root user
USER www-data

# Set permissions for Laravel (must run as the user that will run the app)
RUN chmod -R 775 storage bootstrap/cache

# Run Laravel production optimization steps during the build (now that PHP is running)
# We can run these because the final image contains the php binary.
RUN php artisan key:generate --force
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Define the web root and port
ENV SERVER_DOCUMENT_ROOT public
EXPOSE 8080
