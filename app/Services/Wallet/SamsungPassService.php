<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Models\WalletCard;

class SamsungPassService
{
    /**
     * Generate Samsung Wallet pass payload
     */
    public function generatePassPayload(User $user, WalletCard $walletCard): array
    {
        return [
            'success' => true,
            'platform' => 'samsung',
            'pass' => [
                'type' => 'generic',
                'id' => $walletCard->card_serial,
                'title' => 'OctoPass Access Card',
                'subtitle' => $user->full_name,
                'description' => 'Access card for ' . ($user->company_name ?? 'OctoPass'),
                'logo' => [
                    'url' => url('/images/logo.png'),
                    'description' => 'OctoPass Logo',
                ],
                'barcode' => [
                    'type' => 'QR_CODE',
                    'value' => $walletCard->card_serial,
                    'alternateText' => $walletCard->card_serial,
                ],
                'fields' => [
                    [
                        'label' => 'Name',
                        'value' => $user->full_name,
                        'type' => 'primary',
                    ],
                    [
                        'label' => 'Type',
                        'value' => ucfirst($user->user_type),
                        'type' => 'secondary',
                    ],
                    [
                        'label' => 'Company',
                        'value' => $user->company_name ?? 'N/A',
                        'type' => 'auxiliary',
                    ],
                    [
                        'label' => 'Card Serial',
                        'value' => $walletCard->card_serial,
                        'type' => 'back',
                    ],
                    [
                        'label' => 'Email',
                        'value' => $user->email ?? 'N/A',
                        'type' => 'back',
                    ],
                    [
                        'label' => 'Mobile',
                        'value' => $user->mobile ?? 'N/A',
                        'type' => 'back',
                    ],
                ],
                'colors' => [
                    'background' => '#3C414C',
                    'foreground' => '#FFFFFF',
                    'label' => '#CCCCCC',
                ],
            ],
            'message' => 'Samsung Wallet pass payload generated. Integrate with Samsung Wallet API for actual pass creation.',
        ];
    }
}
