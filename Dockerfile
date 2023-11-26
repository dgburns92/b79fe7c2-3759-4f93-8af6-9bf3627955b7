# Use PHP 8.2 image as the base
FROM php:8.2

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpq-dev \
        && docker-php-ext-install zip pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy entire Symfony project to the container
COPY . /app

# Install Symfony dependencies using Composer
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Set permissions if needed
RUN chown -R www-data:www-data /app/var

# Command to execute Symfony console
CMD ["php", "bin/console"]