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
            --coffee-deep: #1a0f0a;
            --coffee-mocha: #2d1b14;
            --coffee-accent: #d4a373;
            --coffee-cream: #f5f5e6;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #050505;
            color: var(--coffee-cream);
        }

        .pass-container {
            width: 100%;
            max-width: 340px;
            margin: 0 auto;
            position: relative;
        }

        .pass-card {
            width: 100%;
            aspect-ratio: 1 / 1.6;
            background: var(--coffee-deep);
            border-radius: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
        }

        /* Top Notch Cutout */
        .pass-card::before {
            content: '';
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 40px;
            background: #050505;
            border-radius: 50%;
            z-index: 20;
        }

        .pass-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
            filter: brightness(0.5) contrast(1.2);
        }

        .pass-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(26, 15, 10, 0.2) 0%,
                    rgba(26, 15, 10, 0.6) 40%,
                    rgba(26, 15, 10, 0.95) 85%);
            z-index: 5;
        }

        /* Ticket Content */
        .pass-content {
            position: relative;
            z-index: 10;
            padding: 2rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .pass-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
        }

        .header-icon {
            width: 24px;
            height: 24px;
            color: var(--coffee-accent);
        }

        .header-text {
            font-size: 0.7rem;
            font-black;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: white;
        }

        .primary-fields {
            margin-top: 1rem;
        }

        .label {
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .value-large {
            font-size: 1.75rem;
            font-weight: 900;
            color: white;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .secondary-section {
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .secondary-fields {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .value-mid {
            font-size: 1rem;
            font-weight: 900;
            color: white;
            text-transform: uppercase;
        }

        /* Circular Side Image Badge */
        .thumbnail-container {
            width: 84px;
            height: 84px;
            background: white;
            border-radius: 50%;
            padding: 4px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            border: 3px solid var(--coffee-mocha);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .thumbnail-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        /* Barcode Section */
        .barcode-section {
            background: white;
            margin: auto 0 0.5rem;
            padding: 1.25rem;
            border-radius: 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .barcode-img {
            width: 100%;
            height: 60px;
            background-color: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .barcode-id {
            font-family: monospace;
            font-size: 0.65rem;
            color: #000;
            letter-spacing: 0.2em;
            font-weight: 700;
        }

        .pass-footer-info {
            position: relative;
            z-index: 10;
            padding: 1rem;
            text-align: center;
            font-size: 0.5rem;
            color: rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.3em;
        }

        .btn-action {
            display: block;
            width: 100%;
            padding: 1.25rem;
            background: var(--coffee-accent);
            color: var(--coffee-deep);
            text-align: center;
            border-radius: 1.25rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.75rem;
            margin-top: 2.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(212, 163, 115, 0.2);
        }

        .btn-action:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 163, 115, 0.3);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-6 pb-12">
    <div class="pass-container">
        <div class="pass-card">
            <!-- Background Image -->
            <img src="{{ asset('images/background-coffee.png') }}" class="pass-bg" alt="Vibez Background">
            <div class="pass-overlay"></div>

            <div class="pass-content">
                <!-- Header -->
                <div class="pass-header">
                    <svg class="header-icon" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.5 3H5.5C4.12 3 3 4.12 3 5.5v13C3 19.88 4.12 21 5.5 21h13c1.38 0 2.5-1.12 2.5-2.5v-13C21 4.12 19.88 3 18.5 3zM12 17l-1.5-1.5L14 12l-3.5-3.5L12 7l5 5-5 5z"/>
                    </svg>
                    <span class="header-text">VIBEZ EXPERIENCE</span>
                </div>

                <!-- Primary Membership Field -->
                <div class="primary-fields">
                    <div class="label">Member</div>
                    <div class="value-large">{{ strtoupper($user->full_name) }}</div>
                </div>

                <!-- Secondary Section with Thumbnail -->
                <div class="secondary-section">
                    <div class="secondary-fields">
                        <div>
                            <div class="label">Membership</div>
                            <div class="value-mid">{{ $user->user_type === 'employee' ? 'VIBEZ PREMIUM' : 'VIBEZ INSIDER' }}</div>
                        </div>
                        <div>
                            <div class="label">Points Balance</div>
                            <div class="value-mid">1,250 PTS</div>
                        </div>
                    </div>

                    <!-- Right Side Circular Logo -->
                    <div class="thumbnail-container">
                        <img src="{{ asset('images/icon.png') }}" class="thumbnail-img" alt="Vibez Logo">
                    </div>
                </div>

                <!-- Barcode Section (Ticket Style) -->
                <div class="barcode-section">
                    <div class="barcode-img">
                        <!-- Simulated PDF417/1D Barcode Pattern -->
                        <div class="flex gap-[2px] h-full items-center opacity-80">
                            @for($i = 0; $i < 40; $i++)
                                <div class="bg-black" style="width:{{ rand(1,4) }}px; height:80%"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="barcode-id">{{ substr($walletCard->card_serial, 0, 4) }}-{{ substr($walletCard->card_serial, 4, 4) }}-{{ substr($walletCard->card_serial, -4) }}</div>
                </div>
            </div>
        </div>

        <div class="pass-footer-info">
            Verified Digital Identity • Priority Access Enabled
        </div>

        <a href="{{ url('success/' . $user->uuid) }}" class="btn-action">
            Back to Terminal
        </a>
    </div>
</body>

</html>