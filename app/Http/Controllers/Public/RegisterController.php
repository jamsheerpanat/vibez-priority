<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\AccessPermission;
use App\Models\QrSource;
use App\Models\User;
use App\Models\WalletCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Get registration metadata for a QR source
     */
    public function meta(Request $request)
    {
        $sourceCode = $request->query('src');

        if (!$sourceCode) {
            return response()->json([
                'success' => false,
                'message' => 'Source code is required',
            ], 400);
        }

        $qrSource = QrSource::with('assignedZone')
            ->where('source_code', $sourceCode)
            ->where('active', true)
            ->first();

        if (!$qrSource) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive QR source',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'source' => [
                'code' => $qrSource->source_code,
                'description' => $qrSource->description,
                'zone' => $qrSource->assignedZone ? $qrSource->assignedZone->zone_name : null,
            ],
        ]);
    }

    /**
     * Register a new user
     */
    public function register(RegisterUserRequest $request)
    {
        try {
            DB::beginTransaction();

            // Validate QR source if provided
            $qrSource = null;
            if ($request->src) {
                $qrSource = QrSource::with('assignedZone.doors')
                    ->where('source_code', $request->src)
                    ->where('active', true)
                    ->first();

                if (!$qrSource) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid or inactive QR source',
                    ], 400);
                }
            }

            // Find or create user
            $user = User::where('email', $request->email)
                ->orWhere('mobile', $request->mobile)
                ->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'full_name' => $request->full_name,
                    'user_type' => $request->user_type ?? $user->user_type,
                    'status' => 'active',
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'user_type' => $request->user_type ?? 'visitor',
                    'company_name' => $request->company_name,
                    'status' => 'active',
                    'registered_via_qr' => $request->src,
                ]);

                // Create wallet cards only for new users
                $appleCard = WalletCard::create([
                    'user_id' => $user->id,
                    'platform' => 'apple',
                    'card_serial' => 'APPLE-' . strtoupper(Str::random(16)),
                    'status' => 'active',
                    'issued_at' => now(),
                ]);

                $samsungCard = WalletCard::create([
                    'user_id' => $user->id,
                    'platform' => 'samsung',
                    'card_serial' => 'SAMSUNG-' . strtoupper(Str::random(16)),
                    'status' => 'active',
                    'issued_at' => now(),
                ]);

                // Auto-create permissions based on QR source zone
                if ($qrSource && $qrSource->assignedZone) {
                    $doors = $qrSource->assignedZone->doors;
                    $validFrom = now();
                    $validTo = now()->addDays(30);

                    foreach ($doors as $door) {
                        AccessPermission::create([
                            'wallet_card_id' => $appleCard->id,
                            'door_id' => $door->id,
                            'valid_from' => $validFrom,
                            'valid_to' => $validTo,
                        ]);

                        AccessPermission::create([
                            'wallet_card_id' => $samsungCard->id,
                            'door_id' => $door->id,
                            'valid_from' => $validFrom,
                            'valid_to' => $validTo,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user_uuid' => $user->uuid,
                'wallet_urls' => [
                    'apple_wallet_url' => url("/api/v1/wallet/apple/{$user->uuid}"),
                    'samsung_wallet_url' => url("/api/v1/wallet/samsung/{$user->uuid}"),
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
