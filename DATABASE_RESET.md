# 🔄 OctoPass - Database Reconfigured

## ✅ Database Reset Complete

**Date:** 2026-02-02  
**Status:** Fresh database with demo data

---

## 🔐 NEW CREDENTIALS

### Admin Access
```
Email: admin@octopass.local
Password: Admin@12345
```

### NFC Device API Key (NEW!)
```
octopas_XIZjuWrE3TlAOOMYgIiRAnr56fN7k6B3goFpEuYTxyzNtGHo3UlqoAbbrcESxM8p
```

⚠️ **IMPORTANT:** Save this API key securely! It won't be shown again.

### Demo Infrastructure
- **Zone:** Main Lobby
- **NFC Device:** Reader-1 (UID: READER001)
- **Door:** Lobby Door
- **QR Source:** lobby

---

## 🌐 Access Points

### Public Registration
```
http://127.0.0.1:8003/register?src=lobby
```

### Admin Panel
```
http://127.0.0.1:8003/admin
```

---

## 📊 What Was Reset

### Tables Recreated
- ✅ users
- ✅ admins
- ✅ wallet_cards
- ✅ access_zones
- ✅ qr_sources
- ✅ nfc_devices
- ✅ doors
- ✅ access_permissions
- ✅ access_logs

### Demo Data Created
- ✅ 1 Super Admin user
- ✅ 1 Access Zone (Main Lobby)
- ✅ 1 NFC Device (Reader-1)
- ✅ 1 Door (Lobby Door)
- ✅ 1 QR Source (lobby)

---

## 🧪 Test the New Setup

### 1. Test NFC Access Validation
```bash
curl -X POST http://127.0.0.1:8003/api/v1/access/validate \
  -H "X-DEVICE-KEY: octopas_XIZjuWrE3TlAOOMYgIiRAnr56fN7k6B3goFpEuYTxyzNtGHo3UlqoAbbrcESxM8p" \
  -H "Content-Type: application/json" \
  -d '{"card_serial":"TEST-CARD-SERIAL"}'
```

### 2. Register a New User
```bash
curl -X POST http://127.0.0.1:8003/api/v1/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "full_name": "John Doe",
    "email": "john@example.com",
    "mobile": "+1234567890",
    "user_type": "visitor",
    "company_name": "Acme Corp",
    "src": "lobby"
  }'
```

### 3. Admin Login
```bash
curl -X POST http://127.0.0.1:8003/api/v1/admin/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@octopass.local",
    "password": "Admin@12345"
  }'
```

---

## 📝 Next Steps

1. **Test Registration:**
   - Visit: http://127.0.0.1:8003/register?src=lobby
   - Fill out the form
   - Get wallet download links

2. **Login to Admin:**
   - Visit: http://127.0.0.1:8003/admin
   - Use credentials above
   - Explore the dashboard

3. **Create More Infrastructure:**
   - Add more zones
   - Add more doors
   - Create QR sources for different entry points
   - Add more NFC devices

---

## 🔧 Database Commands

### Reset Database Again
```bash
php artisan migrate:fresh --seed
```

### Run Migrations Only
```bash
php artisan migrate
```

### Run Seeders Only
```bash
php artisan db:seed
```

### Rollback Last Migration
```bash
php artisan migrate:rollback
```

---

## 📊 Current State

- **Total Users:** 0 (fresh start)
- **Total Admins:** 1
- **Total Zones:** 1
- **Total Doors:** 1
- **Total NFC Devices:** 1
- **Total QR Sources:** 1
- **Total Wallet Cards:** 0
- **Total Access Logs:** 0

---

## ⚠️ Important Notes

1. **API Key Changed:** The NFC device API key has been regenerated. Update any external systems using the old key.

2. **All Data Lost:** Previous users, cards, and logs have been deleted.

3. **Admin Password:** Still using default password. Change it in production!

4. **Fresh Start:** Perfect for testing and development.

---

**Database reconfiguration complete!** 🎉

Your OctoPass system is ready with a fresh database and new credentials.
