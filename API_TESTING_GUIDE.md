# OctoPass - API Testing Guide

## 🧪 Complete API Test Suite

### Base URL
```
Local: http://127.0.0.1:8000
Production: https://yourdomain.com
```

## 1️⃣ Public Registration API

### Get QR Source Metadata
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/register/meta?src=lobby" \
  -H "Accept: application/json"
```

**Expected Response:**
```json
{
  "success": true,
  "source": {
    "code": "lobby",
    "description": "Main lobby registration QR code",
    "zone": "Main Lobby"
  }
}
```

### Register New User
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/register" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "full_name": "John Doe",
    "email": "john.doe@example.com",
    "mobile": "+1234567890",
    "user_type": "visitor",
    "company_name": "Acme Corporation",
    "src": "lobby"
  }'
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Registration successful",
  "user_uuid": "550e8400-e29b-41d4-a716-446655440000",
  "wallet_urls": {
    "apple_wallet_url": "http://127.0.0.1:8000/api/v1/wallet/apple/550e8400-e29b-41d4-a716-446655440000",
    "samsung_wallet_url": "http://127.0.0.1:8000/api/v1/wallet/samsung/550e8400-e29b-41d4-a716-446655440000"
  }
}
```

### Register with Email Only
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/register" \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Jane Smith",
    "email": "jane@example.com",
    "user_type": "employee",
    "src": "lobby"
  }'
```

### Register with Mobile Only
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/register" \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Bob Johnson",
    "mobile": "+9876543210",
    "user_type": "visitor",
    "src": "lobby"
  }'
```

## 2️⃣ Wallet Pass API

### Get Apple Wallet Pass
```bash
# Replace {uuid} with actual user UUID from registration
curl -X GET "http://127.0.0.1:8000/api/v1/wallet/apple/{uuid}" \
  -H "Accept: application/json"
```

**Expected Response (without certificates):**
```json
{
  "success": false,
  "message": "Apple Wallet certificates not configured...",
  "pass_data": {
    "formatVersion": 1,
    "passTypeIdentifier": "pass.com.octopass.access",
    "serialNumber": "APPLE-XXXXXXXXXXXX",
    ...
  }
}
```

### Get Samsung Wallet Pass
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/wallet/samsung/{uuid}" \
  -H "Accept: application/json"
```

**Expected Response:**
```json
{
  "success": true,
  "platform": "samsung",
  "pass": {
    "type": "generic",
    "id": "SAMSUNG-XXXXXXXXXXXX",
    ...
  }
}
```

## 3️⃣ NFC Device Access Validation

### Valid Access (Granted)
```bash
# Use the API key from seeder output
curl -X POST "http://127.0.0.1:8000/api/v1/access/validate" \
  -H "X-DEVICE-KEY: octopas_TX3S1jzICbj1Mm4SOVX19OHtGMRNppYOD4r3ASRVlsqzJXDuqp63Vs6sH0nFQPaM" \
  -H "Content-Type: application/json" \
  -d '{
    "card_serial": "APPLE-XXXXXXXXXXXX"
  }'
```

**Expected Response (if valid):**
```json
{
  "access": "granted",
  "user": {
    "name": "John Doe",
    "type": "visitor"
  },
  "door": {
    "name": "Lobby Door"
  }
}
```

### Invalid Card Serial
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/access/validate" \
  -H "X-DEVICE-KEY: octopas_TX3S1jzICbj1Mm4SOVX19OHtGMRNppYOD4r3ASRVlsqzJXDuqp63Vs6sH0nFQPaM" \
  -H "Content-Type: application/json" \
  -d '{
    "card_serial": "INVALID-CARD"
  }'
```

**Expected Response:**
```json
{
  "access": "denied",
  "reason": "Card not found"
}
```

### Missing API Key
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/access/validate" \
  -H "Content-Type: application/json" \
  -d '{
    "card_serial": "APPLE-XXXXXXXXXXXX"
  }'
```

**Expected Response:**
```json
{
  "access": "denied",
  "reason": "Missing device authentication"
}
```

### Invalid API Key
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/access/validate" \
  -H "X-DEVICE-KEY: invalid_key" \
  -H "Content-Type: application/json" \
  -d '{
    "card_serial": "APPLE-XXXXXXXXXXXX"
  }'
```

**Expected Response:**
```json
{
  "access": "denied",
  "reason": "Invalid device credentials"
}
```

## 4️⃣ Admin API (Sanctum)

### Admin Login
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@octopass.local",
    "password": "Admin@12345"
  }'
```

**Expected Response:**
```json
{
  "success": true,
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "admin": {
    "id": 1,
    "name": "Super Admin",
    "email": "admin@octopass.local",
    "role": "super_admin"
  }
}
```

**Save the token for subsequent requests!**

### Get Dashboard Stats
```bash
# Replace {token} with actual token from login
curl -X GET "http://127.0.0.1:8000/api/v1/admin/dashboard" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

**Expected Response:**
```json
{
  "success": true,
  "stats": {
    "total_users": 1,
    "active_users": 1,
    "total_cards": 2,
    "active_cards": 2,
    "total_doors": 1,
    "active_doors": 1,
    "today_attempts": 0,
    "today_granted": 0,
    "today_denied": 0
  },
  "recent_logs": []
}
```

### List Users
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/admin/users" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Get User Details
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/admin/users/{uuid}" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Update User Status
```bash
curl -X PUT "http://127.0.0.1:8000/api/v1/admin/users/{uuid}/status" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "status": "suspended"
  }'
```

**Valid statuses:** `active`, `suspended`, `revoked`

### List Wallet Cards
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/admin/cards?platform=apple&status=active" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Revoke Card
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/admin/cards/{id}/revoke" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Reissue Card
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/admin/cards/{id}/reissue" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### List Access Logs
```bash
curl -X GET "http://127.0.0.1:8000/api/v1/admin/logs?result=denied&date_from=2024-01-01" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

### Admin Logout
```bash
curl -X POST "http://127.0.0.1:8000/api/v1/admin/logout" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"
```

## 🧪 Complete Test Workflow

### 1. Register a User
```bash
RESPONSE=$(curl -s -X POST "http://127.0.0.1:8000/api/v1/register" \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Test User",
    "email": "test@example.com",
    "mobile": "+1234567890",
    "src": "lobby"
  }')

echo $RESPONSE | jq .

# Extract UUID
UUID=$(echo $RESPONSE | jq -r '.user_uuid')
echo "User UUID: $UUID"
```

### 2. Get Wallet Passes
```bash
# Apple Wallet
curl -s "http://127.0.0.1:8000/api/v1/wallet/apple/$UUID" | jq .

# Samsung Wallet
curl -s "http://127.0.0.1:8000/api/v1/wallet/samsung/$UUID" | jq .
```

### 3. Admin Login
```bash
TOKEN_RESPONSE=$(curl -s -X POST "http://127.0.0.1:8000/api/v1/admin/login" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@octopass.local",
    "password": "Admin@12345"
  }')

TOKEN=$(echo $TOKEN_RESPONSE | jq -r '.token')
echo "Admin Token: $TOKEN"
```

### 4. View User in Admin
```bash
curl -s "http://127.0.0.1:8000/api/v1/admin/users/$UUID" \
  -H "Authorization: Bearer $TOKEN" | jq .
```

### 5. Test NFC Access
```bash
# Get card serial from user details
CARD_SERIAL="APPLE-XXXXXXXXXXXX"  # Replace with actual

curl -s -X POST "http://127.0.0.1:8000/api/v1/access/validate" \
  -H "X-DEVICE-KEY: octopas_TX3S1jzICbj1Mm4SOVX19OHtGMRNppYOD4r3ASRVlsqzJXDuqp63Vs6sH0nFQPaM" \
  -H "Content-Type: application/json" \
  -d "{\"card_serial\":\"$CARD_SERIAL\"}" | jq .
```

### 6. View Access Logs
```bash
curl -s "http://127.0.0.1:8000/api/v1/admin/logs" \
  -H "Authorization: Bearer $TOKEN" | jq .
```

## 📝 Postman Collection

Import this JSON into Postman for easy testing:

```json
{
  "info": {
    "name": "OctoPass API",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "variable": [
    {
      "key": "base_url",
      "value": "http://127.0.0.1:8000"
    },
    {
      "key": "admin_token",
      "value": ""
    },
    {
      "key": "device_api_key",
      "value": "octopas_TX3S1jzICbj1Mm4SOVX19OHtGMRNppYOD4r3ASRVlsqzJXDuqp63Vs6sH0nFQPaM"
    }
  ]
}
```

## 🎯 Expected Behaviors

### Registration
- ✅ Creates user with UUID
- ✅ Creates 2 wallet cards (Apple + Samsung)
- ✅ Auto-assigns permissions based on QR zone
- ✅ Returns wallet URLs
- ❌ Fails if neither email nor mobile provided
- ❌ Fails if invalid QR source

### Access Validation
- ✅ Grants access if all conditions met
- ❌ Denies if card not found
- ❌ Denies if card revoked
- ❌ Denies if user suspended/revoked
- ❌ Denies if no valid permission
- ❌ Denies if outside time window
- ✅ Logs every attempt

### Admin Operations
- ✅ Requires authentication
- ✅ Returns 401 if token invalid
- ✅ Supports filtering and search
- ✅ Validates all inputs
- ✅ Returns proper error messages

---

**Happy Testing! 🚀**
