<?php

namespace App\Services\Wallet;

use App\Models\User;
use App\Models\WalletCard;

class ApplePassService
{
    /**
     * Build unsigned pass data structure for Apple Wallet
     */
    public function buildUnsignedPassData(User $user, WalletCard $walletCard): array
    {
        return [
            'formatVersion' => 1,
            'passTypeIdentifier' => env('APPLE_PASS_TYPE_ID', 'pass.com.vibez.loyalty'),
            'serialNumber' => $walletCard->card_serial,
            'teamIdentifier' => env('APPLE_TEAM_ID', '2RZSDZ3JFQ'),
            'organizationName' => 'VIBEZ COFFEE',
            'description' => 'VIBEZ PREMIUM LOYALTY',
            'logoText' => 'VIBEZ COFFEE',
            'foregroundColor' => 'rgb(255, 255, 255)',
            'backgroundColor' => 'rgb(44, 24, 16)',
            'labelColor' => 'rgba(255, 255, 255, 0.6)',
            'eventTicket' => [
                'primaryFields' => [
                    [
                        'key' => 'member',
                        'label' => 'MEMBER',
                        'value' => strtoupper($user->full_name),
                    ],
                ],
                'secondaryFields' => [
                    [
                        'key' => 'tier',
                        'label' => 'STATUS',
                        'value' => 'VIBEZ PLATINUM',
                    ],
                ],
                'auxiliaryFields' => [
                    [
                        'key' => 'points',
                        'label' => 'POINTS',
                        'value' => '1,250',
                    ],
                ],
                'backFields' => [
                    [
                        'key' => 'about',
                        'label' => 'VIBEZ EXPERIENCE',
                        'value' => 'Artisanal roasts and premium community vibez.',
                    ],
                ],
            ],
            'barcodes' => [
                [
                    'message' => $walletCard->card_serial,
                    'format' => 'PKBarcodeFormatQR',
                    'messageEncoding' => 'iso-8859-1',
                ]
            ],
        ];
    }

    /**
     * Check if certificates are configured
     */
    public function areCertificatesConfigured(): bool
    {
        $certPath = storage_path('app/certs/apple_pass_cert.pem');
        $keyPath = storage_path('app/certs/apple_pass_key.pem');
        $wwdrPath = storage_path('app/certs/wwdr.pem');

        return file_exists($certPath) && file_exists($keyPath) && file_exists($wwdrPath);
    }

    /**
     * Generate pkpass file
     */
    public function generatePkpass(User $user, WalletCard $walletCard)
    {
        if (!$this->areCertificatesConfigured()) {
            return [
                'success' => false,
                'message' => 'Apple Wallet certificates not configured.',
                'pass_data' => $this->buildUnsignedPassData($user, $walletCard),
            ];
        }

        // Create temporary directory for pass assembly
        $workDir = storage_path('app/temp/pass_' . uniqid());
        if (!file_exists($workDir)) {
            mkdir($workDir, 0755, true);
        }

        try {
            // 1. Create pass.json
            $passData = $this->buildUnsignedPassData($user, $walletCard);
            file_put_contents($workDir . '/pass.json', json_encode($passData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

            // 2. Ensure we have basic images (Apple requires icon.png)
            $this->ensureBasePassImages($workDir);

            // 3. Create manifest.json (hashes of all files)
            $manifest = [];
            foreach (scandir($workDir) as $file) {
                if ($file === '.' || $file === '..')
                    continue;
                $manifest[$file] = sha1_file($workDir . '/' . $file);
            }
            file_put_contents($workDir . '/manifest.json', json_encode($manifest));

            // 4. Sign the manifest to create signature file
            $this->signManifest($workDir);

            // 5. Package as .pkpass (zip)
            $pkpassName = 'pass_' . $walletCard->card_serial . '.pkpass';
            $pkpassPath = storage_path('app/public/passes/' . $pkpassName);

            if (!file_exists(dirname($pkpassPath))) {
                mkdir(dirname($pkpassPath), 0755, true);
            }

            $zip = new \ZipArchive();
            if ($zip->open($pkpassPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                foreach (scandir($workDir) as $file) {
                    if ($file === '.' || $file === '..')
                        continue;
                    $zip->addFile($workDir . '/' . $file, $file);
                }
                $zip->close();
            }

            // Cleanup work dir
            $this->recursiveRmdir($workDir);

            return [
                'success' => true,
                'path' => $pkpassPath,
                'filename' => 'vibez_loyalty.pkpass'
            ];

        } catch (\Exception $e) {
            if (file_exists($workDir))
                $this->recursiveRmdir($workDir);
            return [
                'success' => false,
                'message' => 'Error generating pass: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Sign the manifest.json file
     */
    private function signManifest(string $workDir): void
    {
        $certPath = storage_path('app/certs/apple_pass_cert.pem');
        $keyPath = storage_path('app/certs/apple_pass_key.pem');
        $wwdrPath = storage_path('app/certs/wwdr.pem');

        $cert = file_get_contents($certPath);
        $key = file_get_contents($keyPath);
        $wwdr = file_get_contents($wwdrPath);

        $manifestPath = $workDir . '/manifest.json';
        $signaturePath = $workDir . '/signature';

        if (!openssl_pkcs7_sign($manifestPath, $signaturePath, $cert, $key, [], PKCS7_BINARY | PKCS7_DETACHED, $wwdrPath)) {
            throw new \Exception('Failed to sign manifest with OpenSSL');
        }

        // PKCS7 signing creates a MIME message, we need just the actual signature content
        $signatureContent = file_get_contents($signaturePath);
        $parts = explode("\n\n", $signatureContent);
        $rawSignature = base64_decode($parts[3]);
        file_put_contents($signaturePath, $rawSignature);
    }

    /**
     * Create placeholder images if not present
     */
    private function ensureBasePassImages(string $workDir): void
    {
        $iconSource = public_path('images/icon.png');
        $backgroundSource = public_path('images/background-coffee.png'); // Need a blurred coffee BG
        $thumbnailSource = public_path('images/icon.png'); // Use the logo in a circle (thumbnail)

        // Helper to copy if exists, else use placeholder
        $copyOrPlaceholder = function ($source, $targetName) use ($workDir) {
            if (file_exists($source)) {
                copy($source, $workDir . '/' . $targetName);
                // For icon and thumbnail, also copy a @2x version if it's not already a @2x source
                if (in_array($targetName, ['icon.png', 'thumbnail.png'])) {
                    copy($source, $workDir . '/' . str_replace('.png', '@2x.png', $targetName));
                }
            } else {
                // Generate a transparent 1x1 pixel as default if missing
                $pngPixel = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
                file_put_contents($workDir . '/' . $targetName, $pngPixel);
            }
        };

        $copyOrPlaceholder($iconSource, 'icon.png');
        $copyOrPlaceholder($thumbnailSource, 'thumbnail.png');

        // Custom background handling
        if (file_exists($backgroundSource)) {
            copy($backgroundSource, $workDir . '/background.png');
            copy($backgroundSource, $workDir . '/background@2x.png');
        } else {
            // Fallback for background if background-coffee.png is not found
            $pngPixel = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
            file_put_contents($workDir . '/background.png', $pngPixel);
            file_put_contents($workDir . '/background@2x.png', $pngPixel);
        }
    }

    /**
     * Helper to cleanup directory
     */
    private function recursiveRmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                        $this->recursiveRmdir($dir . DIRECTORY_SEPARATOR . $object);
                    else
                        unlink($dir . DIRECTORY_SEPARATOR . $object);
                }
            }
            rmdir($dir);
        }
    }
}
