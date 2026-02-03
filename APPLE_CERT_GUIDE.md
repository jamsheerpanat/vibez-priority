# 🍎 Apple Wallet Certificate Setup Guide

To enable real Apple Wallet `.pkpass` generation, you need to generate three specific `.pem` files and place them in your project. Since you have an Apple Developer subscription, follow these steps:

## 🌐 Part 1: Apple Developer Portal

1.  **Create a Pass Type ID**:
    *   Go to [Certificates, Identifiers & Profiles](https://developer.apple.com/account/resources/identifiers/list/passTypeId).
    *   Click the **+** button next to Identifiers.
    *   Select **Pass Type IDs** and click Continue.
    *   Enter a description and an identifier (e.g., `pass.com.yourcompany.octopass`). **Save this identifier.**
    *   Click Register.

2.  **Generate the Pass Certificate**:
    *   Find your new Pass Type ID in the list and click on it.
    *   Click **Create Certificate**.
    *   You will be asked to upload a **Certificate Signing Request (CSR)**. (See Part 2 below).

## 💻 Part 2: Generate CSR on your Mac

1.  Open **Keychain Access** on your Mac.
2.  Go to **Keychain Access > Certificate Assistant > Request a Certificate from a Certificate Authority**.
3.  Enter your email and a common name (e.g., "OctoPass Cert").
4.  Select **Saved to disk** and click Continue.
5.  Save the `CertificateSigningRequest.certSigningRequest` file.
6.  Go back to the Apple Developer Portal tab from Part 1 and **upload this file**.
7.  Download the resulting `.cer` file (e.g., `pass.cer`).

## 🔑 Part 3: Convert to .pem Files

Apple gives you a `.cer` file, but the server needs `.pem` files.

### 1. Extract the Certificate and Private Key
1.  Double-click `pass.cer` to add it to your Keychain.
2.  In Keychain Access, find the certificate (under "My Certificates").
3.  Right-click it and select **Export "Pass Type ID: ..."**.
4.  Save it as `Certificates.p12`. (Leave the password blank or remember it).
5.  Open your Terminal and run these commands to create the `.pem` files:

```bash
# Export the Certificate
openssl pkcs12 -in Certificates.p12 -clcerts -nokeys -out apple_pass_cert.pem

# Export the Private Key (Choose a password, then remove it so the server can read it)
openssl pkcs12 -in Certificates.p12 -nocerts -out apple_pass_key_encrypted.pem
openssl rsa -in apple_pass_key_encrypted.pem -out apple_pass_key.pem
```

### 2. Get the WWDR Intermediate Certificate
1.  Download the **Worldwide Developer Relations (WWDR) Certificate** (G4 or latest) from [Apple's Certificate Authority page](https://www.apple.com/certificateauthority/AppleWWDRCAG4.cer).
2.  Convert it to PEM:
```bash
openssl x509 -inform der -in AppleWWDRCAG4.cer -out wwdr.pem
```

## 📂 Part 4: Add to Laravel

1.  Create the directory: `mkdir -p storage/app/certs`
2.  Move your three files there:
    *   `storage/app/certs/apple_pass_cert.pem`
    *   `storage/app/certs/apple_pass_key.pem`
    *   `storage/app/certs/wwdr.pem`

## ⚙️ Part 5: Update .env

Open your `.env` file and add these values from your developer account:

```env
APPLE_PASS_TYPE_ID=pass.com.yourcompany.octopass
APPLE_TEAM_ID=XXXXXXXXXX
```
*(Your Team ID is found in the top right of the Apple Developer portal next to your name).*

---

### ✅ Success!
Once these files are in place, OctoPass will automatically detect them and start generating real, signed `.pkpass` files that your phone will "Add" to the native Wallet app.
