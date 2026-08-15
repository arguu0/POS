# ---------- 1. Build PHP Dependencies ----------
FROM php:8.4-cli AS composer-stage

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader


# ---------- 2. Build Frontend Assets (Node standard image) ----------
FROM node:22 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

# Pull vendor files so Tailwind/Vite can extract Flux CSS & scan Blade classes
COPY --from=composer-stage /var/www/html/vendor ./vendor

COPY resources ./resources
COPY vite.config.js ./

RUN npm run build


# ---------- 3. Production Laravel ----------
FROM composer-stage AS final

WORKDIR /var/www/html

# Copy compiled Vite assets into the final runtime image
COPY --from=frontend /app/public/build ./public/build

RUN php artisan storage:link || true

EXPOSE 8000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]