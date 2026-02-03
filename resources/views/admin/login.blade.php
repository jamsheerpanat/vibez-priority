<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - VIBEZ COFFEE</title>
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
            opacity: 0.1;
            mix-blend-mode: soft-light;
            z-index: -1;
        }

        .bg-overlay {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, rgba(44, 24, 16, 0.4) 0%, rgba(10, 10, 10, 1) 100%);
            z-index: -1;
        }

        .login-card {
            background: linear-gradient(145deg, rgba(44, 24, 16, 0.8) 0%, rgba(68, 43, 33, 0.4) 100%);
            backdrop-filter: blur(20px);
            border-radius: 2.5rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.8);
        }

        .input-field {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--coffee-cream);
            border-radius: 1.25rem;
            padding: 1rem 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--coffee-accent);
            background: rgba(0, 0, 0, 0.3);
            box-shadow: 0 0 20px rgba(212, 163, 115, 0.1);
        }

        .input-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.25em;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 0.5rem;
            padding-left: 0.5rem;
            font-weight: 700;
        }

        .btn-premium {
            background: linear-gradient(90deg, #d4a373 0%, #faedcd 100%);
            color: #2c1810;
            font-weight: 900;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            border-radius: 1.25rem;
            padding: 1.25rem;
            transition: all 0.3s ease;
            box-shadow: 0 15px 35px -10px rgba(212, 163, 115, 0.4);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 45px -10px rgba(212, 163, 115, 0.5);
        }

        .logo-box {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border: 2px solid var(--coffee-mocha);
            margin: 0 auto 2rem;
            overflow: hidden;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Background Design -->
    <img src="/images/background-coffee.png" class="bg-vector" alt="Texture">
    <div class="bg-overlay"></div>

    <div class="w-full max-w-sm">
        <div class="login-card p-10 pt-12">
            <!-- Branding -->
            <div class="logo-box">
                <img src="/images/icon.png" class="w-[60%]" alt="Vibez">
            </div>

            <div class="text-center mb-10">
                <h1 class="text-2xl font-black tracking-tighter text-white mb-2 uppercase">MASTER CONTROL</h1>
                <p class="text-[0.6rem] uppercase tracking-[0.4em] text-white/30">VIBEZ HQ Management</p>
                <div class="h-1 w-8 bg-white/10 mx-auto rounded-full mt-6"></div>
            </div>

            <!-- Login Form -->
            <form action="/admin/login" method="POST" class="space-y-6">
                @csrf

                @if($errors->any())
                    <div
                        class="bg-red-500/10 border border-red-500/30 text-red-200 px-4 py-3 rounded-2xl text-[0.6rem] uppercase tracking-widest text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <label for="email" class="input-label">Admin Email</label>
                    <input type="email" id="email" name="email" required placeholder="admin@vibez.coffee"
                        class="w-full input-field" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="password" class="input-label">Vault Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••"
                        class="w-full input-field">
                </div>

                <button type="submit" class="w-full btn-premium">
                    Unlock Portal
                </button>
            </form>

            <div class="mt-12 text-center opacity-10">
                <p class="text-[0.5rem] uppercase tracking-[1em] text-white">Confidential Access Only</p>
            </div>
        </div>
    </div>
</body>

</html>