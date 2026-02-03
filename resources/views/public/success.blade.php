<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful - VIBEZ COFFEE</title>
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
            background-color: #0a0a0a;
            color: var(--coffee-cream);
        }

        .bg-vector {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.15;
            mix-blend-mode: soft-light;
            z-index: -1;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, rgba(44, 24, 16, 0.4) 0%, rgba(10, 10, 10, 1) 100%);
            z-index: -1;
        }

        .success-card {
            background: linear-gradient(145deg, rgba(44, 24, 16, 0.8) 0%, rgba(68, 43, 33, 0.4) 100%);
            backdrop-filter: blur(20px);
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
        }

        .btn-wallet {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--coffee-cream);
            border-radius: 1.5rem;
            padding: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .btn-wallet:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--coffee-accent);
            transform: translateY(-2px);
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border: 4px solid var(--coffee-mocha);
            margin: -60px auto 2rem;
            overflow: hidden;
        }

        .success-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #d4a373, #faedcd);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: #2c1810;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Background Design -->
    <img src="/images/background-coffee.png" class="bg-vector" alt="Texture">
    <div class="bg-overlay"></div>

    <div class="w-full max-w-md mt-20">
        <div class="success-card p-10 pt-1">
            <!-- Branding -->
            <div class="logo-circle">
                <img src="/images/icon.png" class="w-[70%]" alt="Vibez">
            </div>

            <div class="text-center mb-10">
                <div class="success-icon animate-bounce">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-black tracking-tighter text-white mb-2 uppercase">WELCOME TO VIBEZ</h1>
                <p class="text-[0.6rem] uppercase tracking-[0.4em] text-white/30">Your Premium Coffee ID Is Ready</p>
                <div class="h-1 w-12 bg-white/10 mx-auto rounded-full mt-6"></div>
            </div>

            <!-- Wallet Options -->
            <div class="space-y-4">
                <a href="/api/v1/wallet/apple/{{ $userUuid }}" target="_blank" class="btn-wallet">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                    </svg>
                    <span>Add to Apple Wallet</span>
                </a>

                <a href="/api/v1/wallet/samsung/{{ $userUuid }}" target="_blank" class="btn-wallet">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    <span>Add to Samsung Wallet</span>
                </a>
            </div>

            <div class="mt-10 p-4 bg-white/5 rounded-2xl border border-white/5">
                <p class="text-[0.6rem] uppercase tracking-widest text-center text-white/30 leading-relaxed">
                    Tap a button above to install your membership pass for priority access and points.
                </p>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="/register?src=lobby"
                class="text-[0.6rem] uppercase tracking-[0.3em] text-white/20 hover:text-white/40 transition">
                Register Another Member
            </a>
        </div>
    </div>
</body>

</html>