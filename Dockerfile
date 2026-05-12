# -------------------------
# Stage 1 — Frontend Build
# -------------------------
FROM node:20 AS frontend

WORKDIR /app

# Install dependencies
COPY package*.json ./
RUN npm install

# Copy project and build frontend
COPY . .
RUN npm run build


# -------------------------
# Stage 2 — Laravel Runtime
# -------------------------
FROM php:8.4-fpm

WORKDIR /var/www/html

# Install PHP & system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    nginx \
    libicu-dev \
    libzip-dev \
    zip

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    opcache \
    intl \
    zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy backend code
COPY . .

# Fix git ownership issue
RUN git config --global --add safe.directory /var/www/html

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy built frontend from Stage 1
COPY --from=frontend /app/public/build /var/www/html/public/build

# PHP upload config
COPY docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Laravel build tasks
RUN php artisan storage:link --force && \
    php artisan scramble:export

# Copy Nginx config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Remove default nginx site
RUN rm -f /etc/nginx/sites-enabled/default

EXPOSE 80

# Start Nginx + PHP-FPM
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
