# Build assets with Node
FROM node:22-alpine AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Set up PHP for Laravel
FROM php:8.2-fpm
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev zip unzip git curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel app files
COPY --from=nodebuild /app ./

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"]
