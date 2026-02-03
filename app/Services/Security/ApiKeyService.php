<?php

namespace App\Services\Security;

use App\Models\NfcDevice;
use Illuminate\Support\Str;

class ApiKeyService
{
    /**
     * Generate a new API key
     */
    public function generateApiKey(): string
    {
        return 'octopas_' . Str::random(64);
    }

    /**
     * Hash an API key for storage
     */
    public function hashApiKey(string $apiKey): string
    {
        return hash('sha256', $apiKey);
    }

    /**
     * Verify an API key against a device
     */
    public function verifyApiKey(string $apiKey, NfcDevice $device): bool
    {
        $hashedKey = $this->hashApiKey($apiKey);
        return hash_equals($device->api_key_hash, $hashedKey);
    }

    /**
     * Find device by API key
     */
    public function findDeviceByApiKey(string $apiKey): ?NfcDevice
    {
        $hashedKey = $this->hashApiKey($apiKey);
        return NfcDevice::where('api_key_hash', $hashedKey)
            ->where('status', 'active')
            ->first();
    }
}
