<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIBEZ PREMIUM - Digital Pass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --coffee-deep: #2c1810;
            --coffee-mocha: #442b21;
            --coffee-cream: #f5f5e6;
            --coffee-accent: #d4a373;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #1a1a1a;
            color: var(--coffee-cream);
        }

        .pass-card {
            aspect-ratio: 1 / 1.586;
            background: var(--coffee-deep);
            border-radius: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.9);
            max-width: 320px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .pass-bg-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
            mix-blend-mode: soft-light;
        }

        .pass-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(44, 24, 16, 0.4) 0%, rgba(44, 24, 16, 0.95) 80%);
            z-index: 5;
        }

        .pass-header {
            padding: 1.5rem;
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .hero-section {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .hero-logo-container {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            border: 4px solid var(--coffee-mocha);
            overflow: hidden;
        }

        .hero-logo {
            width: 70%;
            height: 70%;
            object-fit: contain;
        }

        .pass-body {
            padding: 1.5rem;
            position: relative;
            z-index: 10;
        }

        .label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 0.2rem;
            font-weight: 700;
        }

        .value {
            font-size: 1.15rem;
            font-weight: 900;
            color: white;
            letter-spacing: -0.01em;
        }

        .tier-badge {
            background: linear-gradient(90deg, #d4a373, #faedcd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 900;
            letter-spacing: 0.05em;
            font-size: 0.9rem;
        }

        .qr-container {
            background: white;
            padding: 0.8rem;
            border-radius: 1rem;
            width: fit-content;
            margin: 1.5rem auto 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            text-align: center;
            background: rgba(0, 0, 0, 0.3);
            font-size: 0.55rem;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase;
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-6 bg-neutral-950">
    <div class="w-full max-w-sm">
        <div class="pass-card">
            <!-- New Vector Texture Background -->
            <img src="/images/background-coffee.png" class="pass-bg-image" alt="Texture">
            <div class="pass-overlay"></div>

            <!-- Single Logo Header -->
            <div class="pass-header">
                <span class="text-[0.55rem] font-black tracking-[0.5em] uppercase text-white/40">Exclusive
                    Membership</span>
            </div>

            <!-- Hero Ticket Section -->
            <div class="hero-section">
                <!-- Circular Thumbnail Logo -->
                <div class="hero-logo-container">
                    <img src="/images/icon.png" class="hero-logo" alt="Vibez">
                </div>
            </div>

            <!-- Content -->
            <div class="pass-body space-y-5">
                <div class="text-center mb-4">
                    <div class="label">Member</div>
                    <div class="value text-2xl tracking-tighter">{{ strtoupper($user->full_name) }}</div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-white/5">
                    <div>
                        <div class="label">Status</div>
                        <div class="tier-badge">PLATINUM</div>
                    </div>
                    <div class="text-right">
                        <div class="label">Points</div>
                        <div class="value text-lg">1,250</div>
                    </div>
                </div>

                <!-- QR Code Section -->
                <div class="qr-container">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="black">
                        <path
                            d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 0h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 0h2v2h-2v-2zm3 3h3v2h-3v-2zm-3 0h2v2h-2v-2z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="footer">
                Digital Pass ID: {{ substr($walletCard->card_serial, -12) }}
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-12 space-y-4">
            <div class="bg-white/5 border border-white/10 rounded-3xl p-6 text-center backdrop-blur-md">
                <p class="text-xs uppercase tracking-widest text-white/40 mb-4">Optimized for VIBEZ Coffee Roasters</p>
                <a href="/success/{{ $user->uuid }}"
                    class="block w-full py-4 bg-[#d4a373] text-[#2c1810] font-black rounded-xl hover:bg-[#c49363] transition shadow-lg text-sm tracking-widest">
                    BACK TO TERMINAL
                </a>
            </div>
        </div>
    </div>
</body>

</html>