<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - VIBEZ COFFEE</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --coffee-deep: #2c1810;
            --coffee-mocha: #442b21;
            --coffee-cream: #f5f5e6;
            --coffee-accent: #d4a373;
            --dark-bg: #0a0a0a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-bg);
            color: var(--coffee-cream);
        }

        .sidebar {
            background: linear-gradient(180deg, var(--coffee-deep) 0%, #1a1a1a 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: var(--coffee-cream);
            background: rgba(255, 255, 255, 0.03);
        }

        .nav-link.active {
            color: var(--coffee-cream);
            background: rgba(255, 255, 255, 0.05);
            border-left-color: var(--coffee-accent);
        }

        .top-bar {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .card-custom {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.5rem;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--coffee-mocha);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--coffee-accent);
        }
    </style>
</head>

<body class="bg-[#0a0a0a] overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="sidebar w-64 flex-shrink-0 flex flex-col">
            <div class="p-8">
                <div class="flex items-center gap-3 mb-2">
                    <img src="/images/icon.png" class="w-8 h-8 rounded-lg bg-white p-1" alt="Vibez">
                    <h1 class="text-xl font-black tracking-tighter text-white">VIBEZ</h1>
                </div>
                <p class="text-[0.6rem] uppercase tracking-[0.3em] text-white/30 font-bold">HQ Control Center</p>
            </div>

            <nav class="mt-4 flex-1 space-y-1">
                <a href="/admin/dashboard"
                    class="nav-link flex items-center px-8 py-4 {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    <span class="text-sm font-bold tracking-wide uppercase">Dashboard</span>
                </a>

                <a href="/admin/users"
                    class="nav-link flex items-center px-8 py-4 {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="text-sm font-bold tracking-wide uppercase">Members</span>
                </a>

                <a href="/admin/cards"
                    class="nav-link flex items-center px-8 py-4 {{ request()->is('admin/cards*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                        </path>
                    </svg>
                    <span class="text-sm font-bold tracking-wide uppercase">Passes</span>
                </a>

                <a href="/admin/zones"
                    class="nav-link flex items-center px-8 py-4 {{ request()->is('admin/zones*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="text-sm font-bold tracking-wide uppercase">Zones</span>
                </a>

                <a href="/admin/logs"
                    class="nav-link flex items-center px-8 py-4 {{ request()->is('admin/logs*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="text-sm font-bold tracking-wide uppercase">Activity</span>
                </a>
            </nav>

            <div class="p-8 border-t border-white/5">
                <form action="/admin/logout" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-white/40 hover:text-white transition group">
                        <svg class="w-5 h-5 mr-3 group-hover:text-red-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="text-xs font-black uppercase tracking-widest">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="top-bar z-10">
                <div class="px-8 py-6 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tighter uppercase">
                            @yield('page-title', 'Management')</h2>
                        <div class="h-1 w-8 bg-coffee-accent mt-1 rounded-full opacity-50"></div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-xs font-black text-white uppercase">
                                {{ auth('admin')->user()->name ?? 'Administrator' }}</p>
                            <p class="text-[0.6rem] text-white/30 uppercase tracking-widest">Master Access</p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-coffee-accent to-coffee-mocha flex items-center justify-center text-coffee-deep font-black">
                            {{ substr(auth('admin')->user()->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8">
                @if(session('success'))
                    <div
                        class="mb-8 p-4 bg-green-500/10 border border-green-500/30 text-green-200 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div
                        class="mb-8 p-4 bg-red-500/10 border border-red-500/30 text-red-200 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs font-bold uppercase tracking-widest">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>