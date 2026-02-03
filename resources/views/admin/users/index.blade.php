@extends('admin.layout')

@section('title', 'Members')
@section('page-title', 'Member Management')

@section('content')
    <div class="card-custom overflow-hidden">
        <!-- Search and Filters -->
        <div class="px-8 py-6 border-b border-white/5 bg-white/5">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px] relative">
                    <input type="text" name="search" placeholder="Search members..." value="{{ request('search') }}"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-white/20 focus:outline-none focus:border-coffee-accent transition">
                </div>

                <select name="status"
                    class="bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-white/60 focus:outline-none focus:border-coffee-accent transition">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>

                <select name="user_type"
                    class="bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-white/60 focus:outline-none focus:border-coffee-accent transition">
                    <option value="">All Types</option>
                    <option value="visitor" {{ request('user_type') === 'visitor' ? 'selected' : '' }}>Insider</option>
                    <option value="employee" {{ request('user_type') === 'employee' ? 'selected' : '' }}>Premium</option>
                </select>

                <button type="submit" class="px-8 py-2.5 bg-coffee-accent text-coffee-deep font-black rounded-xl hover:scale-95 transition-transform uppercase text-xs tracking-widest">
                    Filter
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-[0.6rem] uppercase tracking-[0.2em] text-white/30 border-b border-white/5">
                        <th class="px-8 py-5 text-left font-black">Member</th>
                        <th class="px-8 py-5 text-left font-black">Contact</th>
                        <th class="px-8 py-5 text-left font-black">Membership</th>
                        <th class="px-8 py-5 text-left font-black">Status</th>
                        <th class="px-8 py-5 text-left font-black">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-8 py-5">
                                <div class="text-sm font-black text-white uppercase">{{ $user->full_name }}</div>
                                <div class="text-[0.6rem] font-mono text-white/20 mt-1">{{ $user->uuid }}</div>
                            </td>
                            <td class="px-8 py-5 text-sm">
                                <div class="text-white/60">{{ $user->email ?? '-' }}</div>
                                <div class="text-white/30 text-xs">{{ $user->mobile ?? '-' }}</div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[0.65rem] font-black uppercase tracking-widest text-coffee-accent">
                                    {{ $user->user_type === 'employee' ? 'VIBEZ PREMIUM' : 'VIBEZ INSIDER' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                @if($user->status === 'active')
                                    <span class="px-3 py-1 bg-green-500/10 text-green-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Active</span>
                                @elseif($user->status === 'suspended')
                                    <span class="px-3 py-1 bg-yellow-500/10 text-yellow-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Suspended</span>
                                @else
                                    <span class="px-3 py-1 bg-red-500/10 text-red-400 rounded-full text-[0.6rem] font-black uppercase tracking-widest">Revoked</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('admin.users.show', $user->uuid) }}" class="text-[0.65rem] font-black uppercase tracking-widest text-white/40 hover:text-white transition">View</a>
                                    
                                    <form action="{{ url('admin/users/' . $user->uuid) }}" method="POST" onsubmit="return confirm('Are you absolutely sure? This will permanently delete this member and all their digital passes.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[0.65rem] font-black uppercase tracking-widest text-red-900/40 hover:text-red-500 transition">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-10 text-center text-white/20 text-xs uppercase tracking-widest">No members found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-8 py-6 border-t border-white/5">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection