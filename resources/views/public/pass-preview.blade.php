<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIBEZ PREMIUM - Next-Gen Digital Pass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --coffee-deep: #1a0f0a;
            --coffee-gold: #d4a373;
            --coffee-cream: #f5f5e6;
            --glass: rgba(26, 15, 10, 0.7);
            --glass-border: rgba(212, 163, 115, 0.2);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #030303;
            color: var(--coffee-cream);
            overflow-x: hidden;
        }

        .pass-wrapper {
            perspective: 1000px;
            padding: 2rem;
        }

        .pass-container {
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            position: relative;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotateX(2deg);
            }

            50% {
                transform: translateY(-15px) rotateX(-2deg);
            }
        }

        .pass-card {
            width: 100%;
            aspect-ratio: 1 / 1.6;
            background: #000;
            border-radius: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.9),
                0 0 40px rgba(212, 163, 115, 0.05);
            display: flex;
            flex-direction: column;
            border: 1px solid var(--glass-border);
        }

        /* Top Notch Cutout */
        .pass-card::before {
            content: '';
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 50px;
            background: #030303;
            border-radius: 50%;
            z-index: 30;
            box-shadow: inset 0 -10px 15px rgba(0, 0, 0, 0.5);
        }

        .pass-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            filter: saturate(1.2) brightness(0.8);
            transform: scale(1.1);
        }

        .pass-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(0, 0, 0, 0.1) 0%,
                    rgba(0, 0, 0, 0.3) 40%,
                    rgba(0, 0, 0, 0.9) 100%);
            z-index: 5;
        }

        /* Glassmorphism Shine */
        .glass-shine {
            position: absolute;
            top: -150%;
            left: -150%;
            width: 400%;
            height: 400%;
            background: linear-gradient(45deg,
                    transparent 45%,
                    rgba(255, 255, 255, 0.05) 48%,
                    rgba(255, 255, 255, 0.1) 50%,
                    rgba(255, 255, 255, 0.05) 52%,
                    transparent 55%);
            z-index: 25;
            animation: shine 8s infinite linear;
            pointer-events: none;
        }

        @keyframes shine {
            0% {
                transform: translate(-10%, -10%);
            }

            100% {
                transform: translate(10%, 10%);
            }
        }

        .pass-content {
            position: relative;
            z-index: 10;
            padding: 2.25rem 1.75rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .pass-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .header-dot {
            width: 6px;
            height: 6px;
            background: var(--coffee-gold);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--coffee-gold);
        }

        .header-text {
            font-size: 0.65rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.4em;
            color: rgba(255, 255, 255, 0.5);
        }

        .primary-fields {
            margin-top: 2rem;
        }

        .label {
            font-size: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            color: var(--coffee-gold);
            font-weight: 900;
            margin-bottom: 0.5rem;
            opacity: 0.8;
        }

        .value-name {
            font-size: 2.25rem;
            font-weight: 900;
            color: #fff;
            line-height: 0.9;
            text-transform: uppercase;
            letter-spacing: -0.05em;
            text-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
        }

        .secondary-section {
            margin-top: auto;
            padding-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .info-grid {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .value-status {
            font-size: 0.9rem;
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .thumbnail-wrapper {
            position: relative;
        }

        .thumbnail-glow {
            position: absolute;
            inset: -10px;
            background: var(--coffee-gold);
            border-radius: 50%;
            filter: blur(20px);
            opacity: 0.2;
            z-index: -1;
        }

        .thumbnail-container {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 1);
            border-radius: 50%;
            padding: 3px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            border: 2px solid var(--coffee-gold);
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

        /* Next-Gen Barcode Section */
        .barcode-area {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.25rem;
            border-radius: 1.25rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
        }

        .barcode-strips {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2px;
            overflow: hidden;
        }

        .strip {
            height: 100%;
            background: #000;
            border-radius: 1px;
        }

        .id-text {
            font-family: 'Outfit', sans-serif;
            font-size: 0.65rem;
            color: #000;
            letter-spacing: 0.3em;
            font-weight: 900;
            text-transform: uppercase;
        }

        .pass-meta {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.55rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5em;
        }

        .action-button {
            display: block;
            width: 100%;
            padding: 1.5rem;
            background: linear-gradient(135deg, #d4a373 0%, #a67c52 100%);
            color: #000;
            text-align: center;
            border-radius: 1.5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            font-size: 0.8rem;
            margin-top: 3rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 15px 45px rgba(212, 163, 115, 0.25);
            border: none;
            cursor: pointer;
        }

        .action-button:hover {
            transform: scale(1.02) translateY(-5px);
            box-shadow: 0 20px 60px rgba(212, 163, 115, 0.4);
            filter: brightness(1.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-[#030303]">
    <div class="pass-wrapper">
        <div class="pass-container">
            <div class="pass-card">
                <!-- Premium Abstract Background -->
                <img src="{{ asset('images/pass-bg-premium.png') }}" class="pass-bg" alt="Vibez Background">
                <div class="pass-overlay"></div>
                <div class="glass-shine"></div>

                <div class="pass-content">
                    <!-- Brand Header -->
                    <div class="pass-header">
                        <div class="header-brand">
                            <div class="header-dot"></div>
                            <span class="header-text">VIBEZ MASTER PASS</span>
                        </div>
                        <svg class="w-4 h-4 text-white/20" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                        </svg>
                    </div>

                    <!-- Member Identity -->
                    <div class="primary-fields">
                        <div class="label">Priority Member</div>
                        <div class="value-name">{{ strtoupper($user->full_name) }}</div>
                    </div>

                    <!-- Status and Perks -->
                    <div class="secondary-section">
                        <div class="info-grid">
                            <div>
                                <div class="label">Membership</div>
                                <div class="value-status">
                                    {{ $user->user_type === 'employee' ? 'VIBEZ PREMIUM' : 'VIBEZ INSIDER' }}</div>
                            </div>
                            <div>
                                <div class="label">Roast Points</div>
                                <div class="value-status">2,450 <span
                                        class="text-xs text-coffee-gold opacity-60">PTS</span></div>
                            </div>
                        </div>

                        <!-- Side Badge -->
                        <div class="thumbnail-wrapper">
                            <div class="thumbnail-glow"></div>
                            <div class="thumbnail-container">
                                <img src="{{ asset('images/icon.png') }}" class="thumbnail-img" alt="Vibez Logo">
                            </div>
                        </div>
                    </div>

                    <!-- Next-Gen Barcode -->
                    <div class="barcode-area">
                        <div class="barcode-strips">
                            @for($i = 0; $i < 64; $i++)
                                @php $w = [1, 2, 3, 4][rand(0, 3)]; @endphp
                                <div class="strip" style="width: {{ $w }}px; opacity: {{ rand(4, 10) / 10 }};"></div>
                            @endfor
                        </div>
                        <div class="id-text">VBZ-{{ substr($user->uuid, 0, 4) }}-{{ substr($user->uuid, -4) }}</div>
                    </div>
                </div>
            </div>

            <div class="pass-meta">
                Encrypted Mobile Identity • Verified at VIBEZ HQ
            </div>

            <a href="{{ url('success/' . $user->uuid) }}" class="action-button">
                Done
            </a>
        </div>
    </div>
</body>

</html>