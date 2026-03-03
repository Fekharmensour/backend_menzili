FROM php:8.2-cli

WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install backend dependencies
RUN composer install --no-dev --optimize-autoloader

# Install frontend dependencies and build Vite
RUN npm install
RUN npm run build

# Expose port
EXPOSE 10000

# Runtime command (IMPORTANT PART)
CMD php artisan migrate --force && \
    php artisan scribe:generate && \
    php -S 0.0.0.0:${PORT:-10000} -t public
