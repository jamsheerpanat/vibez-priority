@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'VIBEZ HQ OVERVIEW')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Members Stats -->
        <div class="card-custom p-6 border-b-4 border-b-coffee-accent">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black mb-1">Total Members</p>
                    <p class="text-4xl font-black text-white">{{ $stats['total_users'] }}</p>
                    <p class="text-[0.6rem] text-green-400 mt-2 font-bold uppercase tracking-widest">{{ $stats['active_users'] }} ACTIVE</p>
                </div>
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-coffee-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Cards Stats -->
        <div class="card-custom p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black mb-1">Passes Issued</p>
                    <p class="text-4xl font-black text-white">{{ $stats['total_cards'] }}</p>
                    <p class="text-[0.6rem] text-coffee-accent mt-2 font-bold uppercase tracking-widest tracking-widest">{{ $stats['active_cards'] }} LIVE</p>
                </div>
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-coffee-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today's Traffic -->
        <div class="card-custom p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black mb-1">Today's Visits</p>
                    <p class="text-4xl font-black text-white">{{ $stats['today_attempts'] }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-[0.5rem] font-black text-green-400 uppercase tracking-widest">{{ $stats['today_granted'] }} OK</span>
                        <span class="text-[0.5rem] font-black text-red-400 uppercase tracking-widest">{{ $stats['today_denied'] }} NO</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-coffee-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Registration QR -->
        <div class="card-custom p-6 bg-gradient-to-br from-coffee-accent/20 to-transparent border border-coffee-accent/20">
            <div class="flex flex-col items-center justify-center text-center">
                <p class="text-[0.6rem] uppercase tracking-widest text-coffee-accent font-black mb-3">Lobby Registration</p>
                <div class="bg-white p-2 rounded-xl shadow-lg shadow-coffee-accent/10">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(config('app.url') . '/register?src=lobby') }}" class="w-16 h-16" alt="Registration QR">
                </div>
                <button onclick="window.open('https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode(config('app.url') . '/register?src=lobby') }}', '_blank')" class="mt-3 text-[0.55rem] font-black uppercase tracking-widest text-white/40 hover:text-white transition">
                    Download Print QR
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Access Logs -->
        <div class="lg:col-span-2">
            <div class="card-custom h-full overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 bg-white/5 flex justify-between items-center">
                    <h3 class="text-sm font-black text-white uppercase tracking-widest">Live Activity Stream</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-[0.55rem] uppercase tracking-[0.2em] text-white/20 border-b border-white/5">
                                <th class="px-8 py-4 text-left font-black">Time</th>
                                <th class="px-8 py-4 text-left font-black">Member</th>
                                <th class="px-8 py-4 text-left font-black">Location</th>
                                <th class="px-8 py-4 text-left font-black">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentLogs as $log)
                                <tr class="hover:bg-white/[0.02] transition">
                                    <td class="px-8 py-4 text-xs font-mono text-white/40">{{ $log->created_at->format('H:i:s') }}</td>
                                    <td class="px-8 py-4">
                                        <div class="text-xs font-black text-white uppercase">{{ $log->walletCard->user->full_name ?? 'Guest' }}</div>
                                    </td>
                                    <td class="px-8 py-4 text-[0.6rem] font-black text-white/30 uppercase tracking-widest">
                                        {{ $log->door->door_name ?? 'Main Entry' }}
                                    </td>
                                    <td class="px-8 py-4">
                                        @if($log->result === 'granted')
                                            <span class="text-[0.6rem] font-black text-green-400 uppercase tracking-widest">Authorized</span>
                                        @else
                                            <span class="text-[0.6rem] font-black text-red-400 uppercase tracking-widest">Denied</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-white/20 text-[0.6rem] uppercase tracking-widest">Waiting for activity...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Zones -->
        <div class="space-y-6">
            <div class="card-custom p-8">
                <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6">HQ Quick Actions</h3>
                <div class="space-y-4">
                    <a href="/admin/users" class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-coffee-accent/30 transition group">
                        <span class="text-[0.65rem] font-black uppercase tracking-widest text-white/60 group-hover:text-white">New Membership</span>
                        <svg class="w-4 h-4 text-white/20 group-hover:text-coffee-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </a>
                    <a href="/admin/logs" class="flex items-center justify-between p-4 bg-white/5 rounded-2xl border border-white/5 hover:border-coffee-accent/30 transition group">
                        <span class="text-[0.65rem] font-black uppercase tracking-widest text-white/60 group-hover:text-white">Export Daily Report</span>
                        <svg class="w-4 h-4 text-white/20 group-hover:text-coffee-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection