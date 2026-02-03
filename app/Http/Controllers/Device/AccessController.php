<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateAccessRequest;
use App\Models\AccessLog;
use App\Models\AccessPermission;
use App\Models\Door;
use App\Models\NfcDevice;
use App\Models\WalletCard;
use App\Services\Security\ApiKeyService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AccessController extends Controller
{
    public function __construct(
        private ApiKeyService $apiKeyService
    ) {
    }

    /**
     * Validate card access for NFC door reader
     */
    public function validate(ValidateAccessRequest $request)
    {
        // Authenticate device
        $apiKey = $request->header('X-DEVICE-KEY');

        if (!$apiKey) {
            return response()->json([
                'access' => 'denied',
                'reason' => 'Missing device authentication',
            ], 401);
        }

        $device = $this->apiKeyService->findDeviceByApiKey($apiKey);

        if (!$device) {
            return response()->json([
                'access' => 'denied',
                'reason' => 'Invalid device credentials',
            ], 401);
        }

        // Find wallet card
        $walletCard = WalletCard::with('user')
            ->where('card_serial', $request->card_serial)
            ->first();

        if (!$walletCard) {
            $this->logAccess(null, null, $device->id, 'denied', 'Card not found', [
                'card_serial' => $request->card_serial,
            ]);

            return response()->json([
                'access' => 'denied',
                'reason' => 'Card not found',
            ]);
        }

        // Check wallet card status
        if ($walletCard->status !== 'active') {
            $this->logAccess($walletCard->id, null, $device->id, 'denied', 'Card is ' . $walletCard->status, [
                'card_status' => $walletCard->status,
            ]);

            return response()->json([
                'access' => 'denied',
                'reason' => 'Card is ' . $walletCard->status,
            ]);
        }

        // Check user status
        if ($walletCard->user->status !== 'active') {
            $this->logAccess($walletCard->id, null, $device->id, 'denied', 'User is ' . $walletCard->user->status, [
                'user_status' => $walletCard->user->status,
            ]);

            return response()->json([
                'access' => 'denied',
                'reason' => 'User is ' . $walletCard->user->status,
            ]);
        }

        // Find door(s) associated with this device
        $doors = Door::where('device_id', $device->id)
            ->where('status', 'active')
            ->get();

        if ($doors->isEmpty()) {
            $this->logAccess($walletCard->id, null, $device->id, 'denied', 'No active doors for this device');

            return response()->json([
                'access' => 'denied',
                'reason' => 'No active doors configured',
            ]);
        }

        // Check permissions for each door
        $now = Carbon::now();
        $currentTime = $now->format('H:i:s');

        foreach ($doors as $door) {
            $permission = AccessPermission::where('wallet_card_id', $walletCard->id)
                ->where('door_id', $door->id)
                ->where('valid_from', '<=', $now)
                ->where('valid_to', '>=', $now)
                ->first();

            if ($permission) {
                // Check time restrictions if set
                if ($permission->time_start && $permission->time_end) {
                    if ($currentTime < $permission->time_start || $currentTime > $permission->time_end) {
                        continue; // Outside allowed time window
                    }
                }

                // Access granted
                $this->logAccess($walletCard->id, $door->id, $device->id, 'granted', null, [
                    'user_name' => $walletCard->user->full_name,
                    'door_name' => $door->door_name,
                    'permission_id' => $permission->id,
                ]);

                return response()->json([
                    'access' => 'granted',
                    'user' => [
                        'name' => $walletCard->user->full_name,
                        'type' => $walletCard->user->user_type,
                    ],
                    'door' => [
                        'name' => $door->door_name,
                    ],
                ]);
            }
        }

        // No valid permission found
        $this->logAccess($walletCard->id, $doors->first()->id ?? null, $device->id, 'denied', 'No valid permission', [
            'checked_doors' => $doors->pluck('id')->toArray(),
        ]);

        return response()->json([
            'access' => 'denied',
            'reason' => 'No valid permission for this door',
        ]);
    }

    /**
     * Log access attempt
     */
    private function logAccess(?int $walletCardId, ?int $doorId, int $deviceId, string $result, ?string $reason = null, array $meta = [])
    {
        AccessLog::create([
            'wallet_card_id' => $walletCardId,
            'door_id' => $doorId,
            'device_id' => $deviceId,
            'result' => $result,
            'reason' => $reason,
            'meta' => $meta,
        ]);
    }
}
