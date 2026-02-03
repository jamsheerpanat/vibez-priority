<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - VIBEZ COFFEE</title>
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

        .registration-card {
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

        .btn-premium:active {
            transform: translateY(0);
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
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-4">
    <!-- Background Design -->
    <img src="{{ asset('images/background-coffee.png') }}" class="bg-vector" alt="Texture">
    <div class="bg-overlay"></div>

    <div class="w-full max-w-lg mt-20">
        <div class="registration-card p-10 pt-1">
            <!-- Branding -->
            <div class="logo-circle">
                <img src="{{ asset('images/icon.png') }}" class="w-[70%]" alt="Vibez">
            </div>

            <div class="text-center mb-10">
                <h1 class="text-3xl font-black tracking-tighter text-white mb-2 uppercase">VIBEZ LOYALTY</h1>
                <p class="text-[0.6rem] uppercase tracking-[0.4em] text-white/30">Join the Premium Roast Community</p>
                <div class="h-1 w-12 bg-white/10 mx-auto rounded-full mt-6"></div>
            </div>

            <!-- Registration Form -->
            <form id="registrationForm" class="space-y-6">
                @csrf
                <input type="hidden" name="src" id="src" value="">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="input-label">FullName</label>
                        <input type="text" id="full_name" name="full_name" required placeholder="John Doe"
                            class="w-full input-field">
                    </div>
                    <div>
                        <label for="mobile" class="input-label">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile" placeholder="+1..." class="w-full input-field">
                    </div>
                </div>

                <div>
                    <label for="email" class="input-label">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="john@example.com"
                        class="w-full input-field">
                </div>

                <div>
                    <label for="user_type" class="input-label">Membership Type</label>
                    <select id="user_type" name="user_type" class="w-full input-field appearance-none">
                        <option value="visitor" class="bg-neutral-900">VIBEZ INSIDER</option>
                        <option value="employee" class="bg-neutral-900">PREMIUM MEMBER</option>
                    </select>
                </div>

                <div id="errorMessage"
                    class="hidden bg-red-500/10 border border-red-500/30 text-red-200 px-6 py-4 rounded-3xl text-xs uppercase tracking-widest text-center">
                </div>

                <button type="submit" id="submitBtn" class="w-full btn-premium">
                    Get My Coffee ID
                </button>
            </form>

            <p class="text-center text-white/20 text-[0.6rem] mt-10 uppercase tracking-widest">
                * Membership requires either Email or Mobile
            </p>
        </div>
    </div>

    <script>
        // Get QR source from URL
        const urlParams = new URLSearchParams(window.location.search);
        const src = urlParams.get('src');
        if (src) {
            document.getElementById('src').value = src;
        }

        // Handle form submission
        document.getElementById('registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const errorMessage = document.getElementById('errorMessage');

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> PROCESSING...</span>';
            errorMessage.classList.add('hidden');

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData);

            try {
                const response = await fetch('{{ url("api/v1/register") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = `{{ url("success") }}/${result.user_uuid}`;
                } else {
                    errorMessage.textContent = result.message || 'Registration failed';
                    errorMessage.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Get My Coffee ID';
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred. Please try again.';
                errorMessage.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.textContent = 'Get My Coffee ID';
            }
        });
    </script>
</body>

</html>