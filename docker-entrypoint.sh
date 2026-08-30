#!/bin/sh
set -e

# 1. FIX PERMISSIONS (Cukup sekali saja)
echo "🔧 Memperbaiki izin folder runtime, assets, dan uploads..."

# Sessions
if [ ! -d "/var/lib/php/sessions" ]; then
    mkdir -p /var/lib/php/sessions
fi
chown -R www-data:www-data /var/lib/php/sessions
chmod 775 /var/lib/php/sessions

# Yii Folders (Gunakan loop agar lebih rapi)
for folder in "/var/www/html/protected/runtime" "/var/www/html/assets" "/var/www/html/uploads"; do
    if [ -d "$folder" ]; then
        chown -R www-data:www-data "$folder"
        chmod -R 775 "$folder"
        echo "✅ Permissions fixed for $folder"
    fi
done

# 2. HANDLE YIIC COMMAND
if [ "$1" = 'yiic' ]; then
    cd /var/www/html/protected
    shift
    exec php yiic.php "$@"
fi

# 3. EXECUTE DEFAULT COMMAND (PHP-FPM)
exec "$@"