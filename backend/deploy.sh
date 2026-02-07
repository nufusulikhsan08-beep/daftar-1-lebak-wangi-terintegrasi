#!/bin/bash
# deploy.sh - Deployment script for Daftar 1 Digital

echo "🚀 Starting deployment..."

# Configuration
APP_DIR="/var/www/daftar1-lebakwangi"
BACKUP_DIR="/var/backups/daftar1"
DATE=$(date +%Y%m%d_%H%M%S)

# 1. Backup current application
echo "📦 Creating backup..."
mkdir -p $BACKUP_DIR
cp -r $APP_DIR $BACKUP_DIR/backup_$DATE

# 2. Pull latest code
echo "📥 Pulling latest code..."
cd $APP_DIR
git pull origin main

# 3. Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 4. Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# 5. Clear caches
echo "🧹 Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data $APP_DIR/storage
chown -R www-data:www-data $APP_DIR/bootstrap/cache
chmod -R 775 $APP_DIR/storage
chmod -R 775 $APP_DIR/bootstrap/cache

# 7. Optimize
echo "⚡ Optimizing application..."
php artisan optimize

# 8. Restart queue workers
echo "🔄 Restarting queue workers..."
php artisan queue:restart

echo "✅ Deployment completed successfully!"