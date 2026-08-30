# ... (bagian atas Dockerfile tetap sama) ...
FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

# Mode aplikasi. Default 'production' supaya image yang dideploy tidak pernah
# membocorkan stack trace. Untuk pengembangan lokal, timpa lewat .env
# (docker-compose.yml sudah memuatnya) dengan APP_ENV=development.
ENV APP_ENV=production

RUN apk add --no-cache \
        build-base \
        libzip-dev \
        zip \
        postgresql-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_pgsql \
        zip \
        bcmath \
        opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Create session directory with proper permissions
RUN mkdir -p /var/lib/php/sessions \
    && chown -R www-data:www-data /var/lib/php/sessions \
    && chmod 775 /var/lib/php/sessions
    
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Salin seluruh kode aplikasi ke dalam container
COPY . .

# --- PERUBAHAN PENTING DI SINI ---
# 1. Berikan kepemilikan SELURUH proyek ke user www-data (user PHP-FPM)
RUN chown -R www-data:www-data /var/www/html

# 2. Berikan izin baca dan eksekusi ke folder, dan izin baca ke file
#    Ini memastikan Nginx (yang berjalan sebagai user 'nginx') bisa membaca file milik 'www-data'
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# 3. Berikan izin tulis ekstra ke folder yang membutuhkannya (runtime, assets, uploads)
RUN chmod -R 775 /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads

# --- AKHIR PERUBAHAN ---

COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zz-custom.conf

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]