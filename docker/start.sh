#!/bin/sh
set -e

# Replace PORT placeholder in nginx config
if [ -n "${PORT}" ]; then
  envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf
else
  cp /etc/nginx/conf.d/default.conf.template /etc/nginx/conf.d/default.conf
fi

# Ensure permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true

# Start php-fpm and nginx
php-fpm -R &
nginx -g 'daemon off;'
