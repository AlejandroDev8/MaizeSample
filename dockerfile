# syntax=docker/dockerfile:1.7
ARG PHP_VERSION=8.3

# -------------------------
# 1) Vendor (Composer)
#   - Filament requiere ext-intl; composer:2 no la trae por defecto
#   - Instalamos también require-dev (Faker) porque estás corriendo db:seed
#   - NO corremos scripts de composer en build
# -------------------------
FROM composer:2 AS vendor
WORKDIR /app

RUN apk add --no-cache icu-dev $PHPIZE_DEPS \
    && docker-php-ext-install intl \
    && apk del $PHPIZE_DEPS

COPY composer.json composer.lock ./
RUN composer install \
    --no-interaction --no-progress --prefer-dist \
    --no-scripts \
    --optimize-autoloader

COPY . .


# -------------------------
# 2) Frontend build (Vite)
# -------------------------
FROM node:20-alpine AS frontend
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# -------------------------
# 3) Runtime (PHP)
#   - Incluye ca-certificates para HTTPS (INEGI)
# -------------------------
FROM php:${PHP_VERSION}-fpm-alpine AS app
WORKDIR /var/www/html

RUN apk add --no-cache \
    bash git unzip \
    ca-certificates openssl \
    icu-dev oniguruma-dev libzip-dev libpq-dev \
    && update-ca-certificates \
    && docker-php-ext-install \
    pdo_pgsql mbstring intl zip bcmath opcache \
    && rm -rf /var/cache/apk/*

# Copiar app + vendor instalados
COPY --from=vendor /app /var/www/html

# Copiar assets compilados
COPY --from=frontend /app/public/build /var/www/html/public/build

# Crear rutas necesarias para Laravel cache
RUN mkdir -p \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/bootstrap/cache

# Entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Usuario no-root y permisos
RUN adduser -D -u 1000 www \
    && chown -R www:www /var/www/html

USER www

EXPOSE 8000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
