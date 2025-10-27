# Use the official FrankenPHP base image with the Alpine distribution
FROM dunglas/frankenphp:php8.4

# Set the working directory
WORKDIR /app

# Copy the entire Laravel application into the container
COPY . /app

# 1. Install Composer dependencies
# Use the non-root user (www-data) for security
USER www-data
RUN composer install --no-dev --optimize-autoloader

# 2. Install necessary PHP extensions (pdo_mysql is common for Laravel)
# Note: FrankenPHP images often come with many common extensions pre-installed.
# Check documentation for the specific image, but here's how to install if needed:
# USER root
# RUN apk add --no-cache libpq-dev \
#     && docker-php-ext-install pdo_pgsql pdo_mysql opcache
# USER www-data

# 3. Set permissions for Laravel
# Crucial for writing logs, cache, and session data
RUN chmod -R 775 storage bootstrap/cache

# 4. Run Laravel production optimization steps during the build
RUN php artisan key:generate --force
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# 5. Define the web root for the application
ENV APP_RUN_ENV=prod
ENV SERVER_DOCUMENT_ROOT public

# Expose the default FrankenPHP port (usually 80 or 443 internally)
# We set this to 8080 as a common standard, Render will map its $PORT to this.
EXPOSE 8080

# The default CMD of the FrankenPHP image will automatically start the server
# pointing to the document root defined above. No need for a startCommand in render.yaml!
