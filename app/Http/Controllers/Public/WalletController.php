<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletCard;
use App\Services\Wallet\ApplePassService;
use App\Services\Wallet\SamsungPassService;

class WalletController extends Controller
{
    public function __construct(
        private ApplePassService $applePassService,
        private SamsungPassService $samsungPassService
    ) {
    }

    /**
     * Download Apple Wallet pass
     */
    public function apple(string $userUuid)
    {
        $user = User::where('uuid', $userUuid)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $walletCard = WalletCard::where('user_id', $user->id)
            ->where('platform', 'apple')
            ->where('status', 'active')
            ->first();

        if (!$walletCard) {
            return response()->json([
                'success' => false,
                'message' => 'Apple wallet card not found or inactive',
            ], 404);
        }

        $result = $this->applePassService->generatePkpass($user, $walletCard);

        if (!$result['success']) {
            return view('public.pass-preview', [
                'user' => $user,
                'walletCard' => $walletCard,
                'error' => $result['message']
            ]);
        }

        return response()->download($result['path'], $result['filename'], [
            'Content-Type' => 'application/vnd.apple.pkpass',
        ]);
    }

    /**
     * Get Samsung Wallet pass payload
     */
    public function samsung(string $userUuid)
    {
        $user = User::where('uuid', $userUuid)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $walletCard = WalletCard::where('user_id', $user->id)
            ->where('platform', 'samsung')
            ->where('status', 'active')
            ->first();

        if (!$walletCard) {
            return response()->json([
                'success' => false,
                'message' => 'Samsung wallet card not found or inactive',
            ], 404);
        }

        $payload = $this->samsungPassService->generatePassPayload($user, $walletCard);

        return view('public.pass-preview', [
            'user' => $user,
            'walletCard' => $walletCard,
            'error' => $payload['message']
        ]);
    }
}
