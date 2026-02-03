@extends('admin.layout')

@section('title', 'Member Profile')
@section('page-title', 'Profile: ' . strtoupper($user->full_name))

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="card-custom p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4">
                    <span class="text-[0.5rem] font-black uppercase tracking-[0.3em] opacity-20">VIBEZ Member ID</span>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black">Full Name</label>
                        <p class="text-xl font-black text-white uppercase tracking-tight">{{ $user->full_name }}</p>
                    </div>

                    <div class="p-4 bg-black/40 rounded-2xl border border-white/5">
                        <label class="text-[0.5rem] uppercase tracking-widest text-white/30 font-black">Digital UUID</label>
                        <p class="font-mono text-xs text-coffee-accent mt-1">{{ $user->uuid }}</p>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black">Contact
                                Points</label>
                            <p class="text-white/80 text-sm mt-1">{{ $user->email ?? 'no-email@vibez.coffee' }}</p>
                            <p class="text-white/40 text-xs">{{ $user->mobile ?? 'no mobile linked' }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/5 space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black">Status</label>
                            @if($user->status === 'active')
                                <span
                                    class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Active</span>
                            @elseif($user->status === 'suspended')
                                <span
                                    class="px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Suspended</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Revoked</span>
                            @endif
                        </div>

                        <div class="flex justify-between items-center">
                            <label
                                class="text-[0.6rem] uppercase tracking-widest text-white/30 font-black">Membership</label>
                            <span class="text-[0.65rem] font-black uppercase tracking-widest text-coffee-accent">
                                {{ $user->user_type === 'employee' ? 'VIBEZ PREMIUM' : 'VIBEZ INSIDER' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Status Actions -->
                <div class="mt-10 space-y-3">
                    <div class="flex flex-wrap gap-2">
                        @if($user->status !== 'active')
                            <form action="/admin/users/{{ $user->uuid }}/status" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="active">
                                <button type="submit"
                                    class="w-full py-2.5 bg-green-500/20 text-green-400 rounded-xl text-[0.6rem] font-black uppercase tracking-widest hover:bg-green-500/30 transition">
                                    Restore
                                </button>
                            </form>
                        @endif

                        @if($user->status !== 'suspended')
                            <form action="/admin/users/{{ $user->uuid }}/status" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="suspended">
                                <button type="submit"
                                    class="w-full py-2.5 bg-yellow-500/20 text-yellow-400 rounded-xl text-[0.6rem] font-black uppercase tracking-widest hover:bg-yellow-500/30 transition">
                                    Suspend
                                </button>
                            </form>
                        @endif

                        @if($user->status !== 'revoked')
                            <form action="/admin/users/{{ $user->uuid }}/status" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="revoked">
                                <button type="submit"
                                    class="w-full py-2.5 bg-red-500/20 text-red-400 rounded-xl text-[0.6rem] font-black uppercase tracking-widest hover:bg-red-500/30 transition">
                                    Revoke
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="pt-6 border-t border-white/5">
                        <form action="/admin/users/{{ $user->uuid }}" method="POST"
                            onsubmit="return confirm('EXTREME ACTION: Are you absolutely sure? This will permanently wipe this member from existence.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-3 bg-red-900/10 text-red-500 border border-red-500/20 rounded-xl text-[0.65rem] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition shadow-lg shadow-red-500/10">
                                Permanent Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wallet Cards & Activity -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card-custom p-8">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-lg font-black text-white uppercase tracking-tighter">Digital Assets</h3>
                        <p class="text-[0.6rem] uppercase tracking-widest text-white/30">Active Wallet Integrations</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @forelse($user->walletCards as $card)
                        <div
                            class="bg-black/30 border border-white/10 rounded-3xl p-6 hover:border-coffee-accent transition group">
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center group-hover:bg-coffee-accent transition">
                                        @if($card->platform === 'apple')
                                            <svg class="w-6 h-6 text-white group-hover:text-coffee-deep" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-white group-hover:text-coffee-deep" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-white uppercase text-sm">{{ strtoupper($card->platform) }}
                                            WALLET</p>
                                        <p class="text-[0.6rem] font-mono text-white/30 mt-0.5">{{ $card->card_serial }}</p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 {{ $card->status === 'active' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }} rounded-full text-[0.6rem] font-black uppercase tracking-widest">
                                    {{ $card->status }}
                                </span>
                            </div>

                            <!-- Permissions -->
                            <div class="space-y-3">
                                <label class="text-[0.55rem] font-black uppercase tracking-[0.2em] text-white/20">Access
                                    Rights</label>
                                @forelse($card->accessPermissions as $permission)
                                    <div class="flex justify-between items-center p-3 bg-white/5 rounded-2xl border border-white/5">
                                        <div>
                                            <p class="text-[0.7rem] font-black text-white/80 uppercase">
                                                {{ $permission->door->door_name }}</p>
                                            <p class="text-[0.6rem] text-white/30 uppercase tracking-widest mt-0.5">
                                                {{ $permission->door->zone->zone_name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[0.6rem] text-white/60 font-mono">
                                                {{ $permission->valid_to->format('Y/m/d') }}</p>
                                            <p class="text-[0.5rem] uppercase tracking-tighter text-white/20 font-black">EXPIRES</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-4 text-center border border-dashed border-white/10 rounded-2xl">
                                        <p class="text-[0.6rem] uppercase tracking-widest text-white/20 font-black">No Active
                                            Permissions</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/20 font-black leading-loose">
                                No Digital Assets Found<br>
                                <span class="opacity-50">Member has not registered any wallet devices yet.</span>
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection