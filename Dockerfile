FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Create Laravel storage directories
RUN mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/views /var/www/html/storage/framework/sessions /var/www/html/bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN npm install && npm run build

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

# Expose port 80
EXPOSE 80

# Run migration on Render
RUN php artisan migrate --force

# Start Nginx and PHP-FPM
CMD service nginx start && php-fpm