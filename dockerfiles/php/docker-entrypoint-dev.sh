#!/bin/sh
set -eu

VENDOR_DIR=/app/vendor
LOCK_HASH_FILE="$VENDOR_DIR/.composer.lock.hash"

mkdir -p /app/var/cache /app/var/log /app/var/sessions "$VENDOR_DIR"
chown -R www-data:www-data /app/var "$VENDOR_DIR"
chmod -R ug+rwX /app/var "$VENDOR_DIR"

if [ -f /app/composer.lock ]; then
    CURRENT_LOCK_HASH="$(sha1sum /app/composer.lock | awk '{print $1}')"
    INSTALLED_LOCK_HASH=""

    if [ -f "$LOCK_HASH_FILE" ]; then
        INSTALLED_LOCK_HASH="$(cat "$LOCK_HASH_FILE")"
    fi

    if [ ! -f "$VENDOR_DIR/autoload.php" ] || [ "$CURRENT_LOCK_HASH" != "$INSTALLED_LOCK_HASH" ]; then
        echo "Installing Composer dependencies..."
        composer install --working-dir=/app --no-interaction --prefer-dist --no-progress
        printf '%s' "$CURRENT_LOCK_HASH" > "$LOCK_HASH_FILE"
        chown -R www-data:www-data "$VENDOR_DIR"
        chmod -R ug+rwX "$VENDOR_DIR"
    fi
fi

exec docker-php-entrypoint "$@"
