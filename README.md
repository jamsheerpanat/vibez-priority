# OctoPass - QR Registration + Wallet Pass + NFC Door Access

A complete Laravel-based access control system with QR code registration, mobile wallet integration (Apple & Samsung), and NFC door reader validation.

## Features

- ✅ QR Code Registration System
- ✅ User Management with UUID-based public references
- ✅ Apple Wallet & Samsung Wallet Pass Generation
- ✅ NFC Door Reader API with Device Authentication
- ✅ Zone-based Access Control
- ✅ Time-based Access Permissions
- ✅ Comprehensive Access Logging
- ✅ Admin Dashboard with Tailwind UI
- ✅ Role-based Admin Access (Super Admin, Operator)
- ✅ MySQL Database
- ✅ Hostinger-compatible (no daemon requirements)

## Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL 8.0+

## Local Setup (macOS)

### 1. Install Dependencies

```bash
# Install Homebrew packages
brew install php composer mysql node

# Start MySQL
brew services start mysql
```

### 2. Create Database

```bash
mysql -u root -e "CREATE DATABASE octopass CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Install Project

```bash
# Navigate to project directory
cd octopass

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment

Edit `.env` file:

```env
APP_NAME=OctoPass
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=octopass
DB_USERNAME=root
DB_PASSWORD=

# Apple Wallet Configuration (optional)
APPLE_PASS_TYPE_ID=pass.com.octopass.access
APPLE_TEAM_ID=YOUR_TEAM_ID

# For production, set:
# APP_ENV=production
# APP_DEBUG=false
```

### 5. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

**Important:** Save the NFC device API key shown in the console output!

### 6. Build Assets & Start Server

```bash
# Build frontend assets
npm run dev

# In a new terminal, start Laravel server
php artisan serve
```

## Access Points

### Public Registration
- URL: `http://127.0.0.1:8000/register?src=lobby`
- QR Source Code: `lobby`

### Admin Panel
- URL: `http://127.0.0.1:8000/admin`
- Email: `admin@octopass.local`
- Password: `Admin@12345`

### API Endpoints

#### Public Registration
```bash
# Get QR source metadata
GET /api/v1/register/meta?src=lobby

# Register new user
POST /api/v1/register
{
  "full_name": "John Doe",
  "email": "john@example.com",
  "mobile": "+1234567890",
  "user_type": "visitor",
  "company_name": "Acme Corp",
  "src": "lobby"
}
```

#### Wallet Passes
```bash
# Get Apple Wallet pass
GET /api/v1/wallet/apple/{userUuid}

# Get Samsung Wallet pass
GET /api/v1/wallet/samsung/{userUuid}
```

#### NFC Device Access Validation
```bash
curl -X POST http://127.0.0.1:8000/api/v1/access/validate \
  -H "X-DEVICE-KEY: YOUR_API_KEY_HERE" \
  -H "Content-Type: application/json" \
  -d '{"card_serial":"APPLE-XXXXXXXXXXXX"}'
```

#### Admin API (with Sanctum)
```bash
# Login
POST /api/v1/admin/login
{
  "email": "admin@octopass.local",
  "password": "Admin@12345"
}

# Use returned token in subsequent requests
Authorization: Bearer {token}

# Get dashboard stats
GET /api/v1/admin/dashboard

# List users
GET /api/v1/admin/users

# Update user status
PUT /api/v1/admin/users/{uuid}/status
{
  "status": "suspended"
}

# List access logs
GET /api/v1/admin/logs?result=denied&date_from=2024-01-01
```

## Database Schema

### Tables
- `users` - Customer master with UUID
- `admins` - Admin users with roles
- `wallet_cards` - Apple & Samsung wallet passes
- `access_zones` - Logical groupings of doors
- `qr_sources` - QR code sources linked to zones
- `nfc_devices` - NFC door readers with API keys
- `doors` - Physical doors linked to zones & devices
- `access_permissions` - Time-based access rules
- `access_logs` - Complete audit trail

## Apple Wallet Configuration

To enable actual .pkpass file generation:

1. Create certificates directory:
```bash
mkdir -p storage/app/certs
```

2. Add your Apple certificates:
- `storage/app/certs/apple_pass_cert.pem` - Pass Type ID certificate
- `storage/app/certs/apple_pass_key.pem` - Private key
- `storage/app/certs/wwdr.pem` - Apple WWDR certificate

3. Update `.env`:
```env
APPLE_PASS_TYPE_ID=pass.com.yourcompany.octopass
APPLE_TEAM_ID=YOUR_TEAM_ID
```

Currently, without certificates, the API returns JSON with pass structure for testing.

## Hostinger Deployment

### 1. Upload Files
- Upload all files to your hosting account
- Point document root to `/public` directory

### 2. Configure Environment
```bash
# Copy and edit .env
cp .env.example .env

# Set production values
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Configure database
DB_HOST=localhost
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

### 3. Run Setup Commands
```bash
composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink
php artisan storage:link
```

### 4. Build Assets
```bash
npm install
npm run build
```

### 5. Set Permissions
```bash
chmod -R 755 storage bootstrap/cache
```

### 6. Setup Cron (Optional)
Add to crontab for cleanup tasks:
```cron
* * * * * cd /path/to/octopass && php artisan schedule:run >> /dev/null 2>&1
```

## Security Notes

1. **API Keys**: NFC device API keys are hashed using SHA-256. Store the plain key securely when generated.

2. **UUIDs**: All public-facing user references use UUIDs, never exposing internal IDs.

3. **Admin Authentication**: Supports both session-based (web) and token-based (API) authentication.

4. **Access Validation**: Multi-layer checks including:
   - Device authentication
   - Card status
   - User status
   - Permission validity
   - Time-based restrictions

5. **Audit Trail**: All access attempts are logged with metadata.

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Reset
```bash
php artisan migrate:fresh --seed
```

## Troubleshooting

### MySQL Connection Issues
```bash
# Check MySQL is running
brew services list

# Restart MySQL
brew services restart mysql
```

### Permission Errors
```bash
chmod -R 755 storage bootstrap/cache
```

### Asset Build Issues
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

## Support

For issues or questions, please refer to the Laravel documentation:
- https://laravel.com/docs/11.x

## License

This project is proprietary software.

---

**Built with Laravel 11, Tailwind CSS, and Alpine.js**
