#!/usr/bin/env bash
# Safe production deploy for Hostinger.
# - Updates code from GitHub
# - Installs PHP deps + runs migrations
# - NEVER runs db:seed
# - NEVER overwrites .env
# - NEVER deletes storage/ (uploaded images live in storage/app/public)

set -euo pipefail

APP_DIR="${APP_DIR:-$HOME/domains/proxwebs.com/laravel}"
BRANCH="${DEPLOY_BRANCH:-main}"

cd "$APP_DIR"

echo "==> Deploy started in $APP_DIR"

# Keep production secrets and uploads safe
if [ ! -f .env ]; then
  echo "ERROR: .env missing — aborting so we do not wipe production config."
  exit 1
fi

echo "==> Fetching $BRANCH"
git fetch origin "$BRANCH"

echo "==> Updating tracked code only (untracked files like .env and storage uploads are kept)"
git reset --hard "origin/$BRANCH"

# Extra safety: never let a cleanup wipe uploads
if [ -d storage/app/public ]; then
  echo "==> storage/app/public present (uploads preserved)"
fi

echo "==> Composer install"
composer install --no-dev --optimize-autoloader --no-interaction --no-scripts
php -d disable_functions= artisan package:discover --ansi || true

echo "==> Running migrations only (no seed)"
php -d disable_functions= artisan migrate --force

echo "==> Ensuring storage symlink"
php -d disable_functions= artisan storage:link 2>/dev/null || true

echo "==> Refreshing caches"
php -d disable_functions= artisan config:cache
php -d disable_functions= artisan route:cache
php -d disable_functions= artisan view:cache

echo "==> Fixing writable permissions for storage/cache"
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "==> Deploy finished successfully"
