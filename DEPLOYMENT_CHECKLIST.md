# OctoPass - Deployment Checklist

## ✅ Pre-Deployment Verification

### Local Testing
- [x] Database migrations successful
- [x] Seeders created demo data
- [x] Laravel server running on http://127.0.0.1:8000
- [x] Assets compiled successfully
- [x] All routes configured
- [x] Authentication working

### Test These URLs Locally

#### Public Pages
- [ ] http://127.0.0.1:8000 (redirects to admin login)
- [ ] http://127.0.0.1:8000/register?src=lobby (registration form)
- [ ] http://127.0.0.1:8000/admin/login (admin login)

#### Admin Panel (after login)
- [ ] http://127.0.0.1:8000/admin/dashboard
- [ ] http://127.0.0.1:8000/admin/users
- [ ] http://127.0.0.1:8000/admin/cards
- [ ] http://127.0.0.1:8000/admin/zones
- [ ] http://127.0.0.1:8000/admin/doors
- [ ] http://127.0.0.1:8000/admin/permissions
- [ ] http://127.0.0.1:8000/admin/logs

#### API Endpoints
- [ ] POST /api/v1/register (test with curl/Postman)
- [ ] GET /api/v1/wallet/apple/{uuid}
- [ ] GET /api/v1/wallet/samsung/{uuid}
- [ ] POST /api/v1/access/validate (with API key)
- [ ] POST /api/v1/admin/login

## 📋 Hostinger Deployment Steps

### 1. Prepare Files
```bash
# Create deployment package
cd /Users/jamsheerpanat/Documents/My\ Projects\ 2025/VIBEZ/octopass
tar -czf octopass-deploy.tar.gz \
  --exclude='node_modules' \
  --exclude='.git' \
  --exclude='storage/logs/*' \
  --exclude='storage/framework/cache/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  .
```

### 2. Upload to Hostinger
- Upload `octopass-deploy.tar.gz` via FTP/File Manager
- Extract in your hosting directory
- Point document root to `/public` directory

### 3. Configure Environment
```bash
# SSH into Hostinger
cp .env.example .env
nano .env

# Update these values:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 5. Setup Laravel
```bash
php artisan key:generate
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

### 6. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 7. Configure Web Server
Ensure `.htaccess` in public directory contains:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 8. Test Production
- [ ] Visit your domain
- [ ] Test admin login
- [ ] Test registration flow
- [ ] Test API endpoints
- [ ] Check error logs

## 🔐 Security Checklist

### Environment
- [ ] APP_DEBUG=false in production
- [ ] Strong APP_KEY generated
- [ ] Database credentials secure
- [ ] .env file not publicly accessible

### Access Control
- [ ] Change default admin password
- [ ] Generate new NFC device API keys
- [ ] Review user permissions
- [ ] Enable HTTPS/SSL

### Monitoring
- [ ] Setup error logging
- [ ] Monitor access logs
- [ ] Regular database backups
- [ ] Monitor disk space

## 📊 Post-Deployment Tasks

### Initial Setup
1. Login to admin panel
2. Change admin password
3. Create additional admin users if needed
4. Configure zones and doors
5. Create QR sources for different entry points
6. Setup NFC devices and save API keys securely

### Testing
1. Register a test user via QR
2. Download wallet passes
3. Test NFC access validation
4. Verify permissions work correctly
5. Check access logs are recording

### Documentation
1. Document your custom zones
2. Save all API keys securely
3. Create user guides if needed
4. Document any customizations

## 🎯 Important Credentials

### Default Admin
- Email: admin@octopass.local
- Password: Admin@12345
- ⚠️ CHANGE THIS IMMEDIATELY IN PRODUCTION!

### Demo NFC Device
- Reader UID: READER001
- API Key: octopas_TX3S1jzICbj1Mm4SOVX19OHtGMRNppYOD4r3ASRVlsqzJXDuqp63Vs6sH0nFQPaM
- ⚠️ REGENERATE IN PRODUCTION!

### Demo QR Source
- Source Code: lobby
- Zone: Main Lobby
- Registration URL: /register?src=lobby

## 🚨 Troubleshooting

### Common Issues

**500 Error**
- Check storage permissions: `chmod -R 755 storage`
- Clear cache: `php artisan cache:clear`
- Check .env configuration

**Database Connection Failed**
- Verify DB credentials in .env
- Check database exists
- Ensure MySQL is running

**Assets Not Loading**
- Run `npm run build`
- Check public/build directory exists
- Verify APP_URL in .env

**Routes Not Working**
- Clear route cache: `php artisan route:clear`
- Check .htaccess file
- Verify mod_rewrite is enabled

## 📞 Support Resources

- Laravel Documentation: https://laravel.com/docs/11.x
- Hostinger Support: https://www.hostinger.com/support
- Project README: See README.md
- Project Summary: See PROJECT_SUMMARY.md

## ✨ Success Criteria

Your deployment is successful when:
- ✅ Admin panel accessible and functional
- ✅ Users can register via QR codes
- ✅ Wallet passes generate correctly
- ✅ NFC validation API responds correctly
- ✅ Access logs are recording
- ✅ All CRUD operations work
- ✅ No errors in production logs

---

**Last Updated:** 2026-02-02
**Version:** 1.0.0
**Status:** Production Ready
