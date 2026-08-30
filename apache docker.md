


          
Baik, saya akan buatkan versi Apache untuk aplikasi Yii Anda. Ini akan menggantikan Nginx dengan Apache + PHP-FPM atau Apache dengan mod_php.

## 🔧 **Versi Apache untuk DevOps**

Saya akan buat dua opsi:
1. **Apache + PHP-FPM** (lebih modern dan performa)
2. **Apache + mod_php** (lebih simpel)

Mari mulai dengan opsi 1 (Apache + PHP-FPM) yang lebih recommended:

### **1. Buat Apache Configuration**
        
            
toolName: show_diff
            
status: success
          
            
filePath: /home/meninjar/dataproject/inhealtcare/apache-vhost.conf
          
changes: 
              
newStr: <VirtualHost *:80>
    ServerName localhost
    DocumentRoot /var/www/html
    
    # Enable proxy and proxy_fcgi
    ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://php:9000/var/www/html/$1
    
    # Directory settings
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
        
        # Yii specific - pretty URLs
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule . index.php [L]
    </Directory>
    
    # Deny access to protected directories
    <Directory ~ ^/(protected|framework|themes/\w+/views)>
        Require all denied
    </Directory>
    
    # Deny access to hidden files
    <Files ~ "^\.">
        Require all denied
    </Files>
    
    # Set proper headers
    Header always set X-Content-Type-Options nosniff
    Header always set X-Frame-Options DENY
    Header always set X-XSS-Protection "1; mode=block"
    
    # Logging
    ErrorLog /var/log/apache2/error.log
    CustomLog /var/log/apache2/access.log combined
</VirtualHost>
              
oldStr: 
            
          
### **2. Buat Dockerfile untuk Apache Version**

```dockerfile
# Apache + PHP-FPM version
FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

# Install Apache + PHP extensions
RUN apk add --no-cache \
    apache2 \
    apache2-proxy \
    apache2-proxy_fcgi \
    build-base \
    libzip-dev \
    zip \
    postgresql-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_pgsql \
        zip \
        bcmath \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy application code
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Create runtime directories with proper permissions
RUN mkdir -p /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads \
    && chmod -R 775 /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads

# Configure Apache
COPY apache-vhost.conf /etc/apache2/sites-available/000-default.conf
COPY apache-config.conf /etc/apache2/conf-available/yii-config.conf

# Enable Apache modules and configurations
RUN a2enmod rewrite proxy proxy_fcgi headers \
    && a2ensite 000-default \
    && a2enconf yii-config

# Copy entrypoint script
COPY docker-entrypoint-apache.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-apache.sh

ENTRYPOINT ["docker-entrypoint-apache.sh"]
CMD ["apache2-foreground"]
```

### **3. Buat Apache Configuration File**

```apache
# /etc/apache2/conf-available/yii-config.conf
# Global Apache configuration for Yii

# Security headers
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"

# PHP session configuration
php_value session.save_path "/var/lib/php/sessions"
php_value session.gc_maxlifetime 1440
php_value session.cookie_lifetime 0
php_value session.cookie_httponly 1
php_value session.cookie_secure 0
php_value session.use_cookies 1
php_value session.use_only_cookies 1
php_value session.name "PHPSESSID"

# Hide Apache version
ServerTokens Prod
ServerSignature Off

# Enable proxy for PHP-FPM
ProxyPassMatch ^/(.*\.php(/.*)?)$ fcgi://php:9000/var/www/html/$1
```

### **4. Buat Docker Compose untuk Apache Version**
        
            
toolName: show_diff
            
status: success
          
            
filePath: /home/meninjar/dataproject/inhealtcare/docker-compose-apache.yml
          
changes: 
              
newStr: version: "3.8"

services:
  # Apache Web Server
  apache:
    build:
      context: .
      dockerfile: Dockerfile.apache
    container_name: inhealtcare-apache
    ports:
      - "8080:80" # Akses aplikasi di http://localhost:8080
    volumes:
      - .:/var/www/html # Mount seluruh kode aplikasi ke container
      - php-sessions:/var/lib/php/sessions # Session persistence
      - apache-logs:/var/log/apache2 # Apache logs
    depends_on:
      - php
    networks:
      - yii-network

  # PHP-FPM Backend
  php:
    build:
      context: .
      dockerfile: Dockerfile.php-fpm # PHP-FPM only
    container_name: inhealtcare-php-apache
    volumes:
      - .:/var/www/html # Mount seluruh kode aplikasi ke container
      - php-sessions:/var/lib/php/sessions # Shared session storage
    environment:
      - PHP_SESSION_SAVE_PATH=/var/lib/php/sessions
    networks:
      - yii-network

  # Optional: PostgreSQL Database (jika belum ada)
  # db:
  #   image: postgres:13-alpine
  #   container_name: inhealtcare-db
  #   environment:
  #     POSTGRES_DB: inhealtcare
  #     POSTGRES_USER: inhealtcare
  #     POSTGRES_PASSWORD: your_password
  #   volumes:
  #     - postgres-data:/var/lib/postgresql/data
  #   networks:
  #     - yii-network

volumes:
  php-sessions: # Shared session storage
  apache-logs: # Apache logs persistence
  # postgres-data: # Database persistence (optional)

networks:
  yii-network:
    driver: bridge
              
oldStr: 
            
          
### **5. Buat PHP-FPM Only Dockerfile**

```dockerfile
# Dockerfile.php-fpm - PHP-FPM only for Apache setup
FROM php:7.4-fpm-alpine

WORKDIR /var/www/html

# Install PHP extensions
RUN apk add --no-cache \
    build-base \
    libzip-dev \
    zip \
    postgresql-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_pgsql \
        zip \
        bcmath \
        opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy application code
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

# Create session directory
RUN mkdir -p /var/lib/php/sessions \
    && chown -R www-data:www-data /var/lib/php/sessions \
    && chmod 775 /var/lib/php/sessions

# Create runtime directories with proper permissions
RUN mkdir -p /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads \
    && chmod -R 775 /var/www/html/assets /var/www/html/protected/runtime /var/www/html/uploads

# PHP-FPM configuration for Apache
COPY php-fpm-apache.conf /usr/local/etc/php-fpm.d/zz-custom.conf

ENTRYPOINT ["docker-entrypoint-apache.sh"]
CMD ["php-fpm"]
```

### **6. Buat PHP-FPM Configuration untuk Apache**
        
            
toolName: show_diff
            
status: success
          
            
filePath: /home/meninjar/dataproject/inhealtcare/php-fpm-apache.conf
          
changes: 
              
newStr: ; PHP-FPM configuration for Apache setup

[www]
user = www-data
group = www-data
listen = 9000
listen.owner = www-data
listen.group = www-data
listen.mode = 0660
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35

; Session configuration
php_admin_value[session.save_path] = /var/lib/php/sessions
php_admin_value[session.gc_maxlifetime] = 1440
php_admin_value[session.cookie_lifetime] = 0
php_admin_value[session.cookie_httponly] = 1
php_admin_value[session.cookie_secure] = 0
php_admin_value[session.use_cookies] = 1
php_admin_value[session.use_only_cookies] = 1
php_admin_value[session.name] = PHPSESSID

; Security settings
php_admin_value[expose_php] = Off
php_admin_value[display_errors] = Off
php_admin_value[log_errors] = On
php_admin_value[error_log] = /var/log/php_errors.log

; Performance settings
php_admin_value[memory_limit] = 256M
php_admin_value[max_execution_time] = 300
php_admin_value[max_input_time] = 300
php_admin_value[post_max_size] = 50M
php_admin_value[upload_max_filesize] = 50M
              
oldStr: 
            
          
### **7. Buat Entrypoint Script untuk Apache**
        
            
toolName: show_diff
            
status: success
          
            
filePath: /home/meninjar/dataproject/inhealtcare/docker-entrypoint-apache.sh
          
changes: 
              
newStr: #!/bin/sh
set -e

echo "Starting Apache + PHP-FPM setup..."

# Create session directory with proper permissions
mkdir -p /var/lib/php/sessions
chown -R www-data:www-data /var/lib/php/sessions
chmod 775 /var/lib/php/sessions

# Fix Yii specific directories permissions
echo "Fixing permissions for Yii directories..."
if [ -d "/var/www/html/protected/runtime" ]; then
    chown -R www-data:www-data /var/www/html/protected/runtime
    chmod -R 775 /var/www/html/protected/runtime
fi

if [ -d "/var/www/html/assets" ]; then
    chown -R www-data:www-data /var/www/html/assets
    chmod -R 775 /var/www/html/assets
fi

if [ -d "/var/www/html/uploads" ]; then
    chown -R www-data:www-data /var/www/html/uploads
    chmod -R 775 /var/www/html/uploads
fi

# Create log directories
mkdir -p /var/log/apache2 /var/log/php
chown -R www-data:www-data /var/log/apache2 /var/log/php

# If yiic command is requested
if [ "$1" = 'yiic' ]; then
    cd /var/www/html/protected
    shift
    exec php yiic.php "$@"
fi

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground
              
oldStr: 
            
          
## 🚀 **Cara Deploy Versi Apache**

### **Langkah 1: Pilih Salah Satu Opsi**

**Opsi A: Apache + PHP-FPM (Recommended)**
```bash
# Build dan jalankan
docker-compose -f docker-compose-apache.yml up -d --build

# Cek logs
docker-compose -f docker-compose-apache.yml logs -f
```

**Opsi B: Apache + mod_php (Simpler)**
```bash
# Build dan jalankan
docker-compose -f docker-compose-apache-simple.yml up -d --build
```

### **Langkah 2: Test Aplikasi**
```bash
# Cek Apache running
curl http://localhost:8080

# Cek logs untuk session issues
docker-compose -f docker-compose-apache.yml logs apache | grep -i session
docker-compose -f docker-compose-apache.yml logs php | grep -i session
```

### **Langkah 3: Fix Permission Issues**
```bash
# Fix permissions jika masih ada issue
docker-compose -f docker-compose-apache.yml exec apache chown -R www-data:www-data /var/www/html
docker-compose -f docker-compose-apache.yml exec apache chmod -R 775 /var/www/html/protected/runtime
```

## 📋 **Kelebihan Apache vs Nginx untuk Yii**

| Fitur | Apache | Nginx |
|-------|---------|---------|
| **.htaccess support** | ✅ Native | ❌ Tidak support |
| **mod_rewrite** | ✅ Built-in | ❌ Need manual config |
| **Yii pretty URLs** | ✅ Auto | ⚠️ Manual config |
| **Performance** | ⚠️ Good | ✅ Excellent |
| **Configuration complexity** | ✅ Simple | ⚠️ Complex |
| **Session handling** | ✅ Built-in | ⚠️ Need PHP-FPM |

## 🔍 **Troubleshooting Apache Session Issues**

Jika masih ada masalah login redirect:

```bash
# Cek Apache session config
docker-compose -f docker-compose-apache.yml exec apache php -i | grep session

# Cek session directory permissions
docker-compose -f docker-compose-apache.yml exec apache ls -la /var/lib/php/sessions

# Cek Apache error logs
docker-compose -f docker-compose-apache.yml exec apache tail -f /var/log/apache2/error.log
```

**Untuk versi Apache + mod_php yang lebih simpel**, beri tahu saya dan saya akan buatkan versi yang lebih straightforward!

Apakah Anda ingin saya bantu deploy versi Apache ini?
        