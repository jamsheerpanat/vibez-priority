<?php

namespace Database\Seeders;

use App\Models\AccessZone;
use App\Models\Door;
use App\Models\NfcDevice;
use App\Models\QrSource;
use App\Services\Security\ApiKeyService;
use Illuminate\Database\Seeder;

class DemoInfraSeeder extends Seeder
{
    public function run(): void
    {
        $apiKeyService = new ApiKeyService();

        // Create zone
        $zone = AccessZone::create([
            'zone_name' => 'Main Lobby',
            'description' => 'Main entrance and lobby area',
        ]);

        echo "\n✅ Created zone: {$zone->zone_name}\n";

        // Create NFC device
        $apiKey = $apiKeyService->generateApiKey();
        $device = NfcDevice::create([
            'name' => 'Reader-1',
            'location' => 'Main Lobby Entrance',
            'reader_uid' => 'READER001',
            'api_key_hash' => $apiKeyService->hashApiKey($apiKey),
            'status' => 'active',
        ]);

        echo "✅ Created NFC device: {$device->name}\n";
        echo "   Reader UID: {$device->reader_uid}\n";
        echo "   API Key: {$apiKey}\n";
        echo "   ⚠️  SAVE THIS API KEY - It won't be shown again!\n\n";

        // Create door
        $door = Door::create([
            'zone_id' => $zone->id,
            'device_id' => $device->id,
            'door_name' => 'Lobby Door',
            'status' => 'active',
        ]);

        echo "✅ Created door: {$door->door_name}\n";

        // Create QR source
        $qrSource = QrSource::create([
            'source_code' => 'lobby',
            'description' => 'Main lobby registration QR code',
            'assigned_zone_id' => $zone->id,
            'active' => true,
        ]);

        echo "✅ Created QR source: {$qrSource->source_code}\n";
        echo "   Registration URL: " . url("/register?src=lobby") . "\n\n";
    }
}
