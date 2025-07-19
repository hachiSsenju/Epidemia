# Dockerfile

# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git zip unzip curl libicu-dev libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install intl pdo pdo_pgsql opcache zip

# Enable Apache mod_rewrite for Symfony
RUN a2enmod rewrite

# Copy Symfony files to container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install dependencies (adjust for prod or dev as needed)
RUN composer install --no-dev --optimize-autoloader
# Install Symfony Flex
RUN composer global require symfony/flex
# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/var /var/www/html/vendor

# Set environment variables
ENV APP_ENV=prod

EXPOSE 80
RUN php bin/console doctrine:migrations:migrate --no-interaction
