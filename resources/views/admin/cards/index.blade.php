@extends('admin.layout')

@section('title', 'Wallet Cards')
@section('page-title', 'Wallet Cards')

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <form method="GET" class="flex gap-4">
                <input type="text" name="search" placeholder="Search cards..." value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
                <select name="platform" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Platforms</option>
                    <option value="apple" {{ request('platform') === 'apple' ? 'selected' : '' }}>Apple</option>
                    <option value="samsung" {{ request('platform') === 'samsung' ? 'selected' : '' }}>Samsung</option>
                </select>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
                <button type="submit"
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Platform</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Card Serial</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Issued</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($cards as $card)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $card->user->full_name }}</td>
                            <td class="px-6 py-4 text-sm">{{ ucfirst($card->platform) }}</td>
                            <td class="px-6 py-4 text-sm font-mono">{{ $card->card_serial }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 py-1 {{ $card->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs">
                                    {{ ucfirst($card->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $card->issued_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                @if($card->status === 'active')
                                    <form action="/admin/cards/{{ $card->id }}/revoke" method="POST" class="inline">
                                        @csrf
                                        <button class="text-red-600 hover:text-red-900">Revoke</button>
                                    </form>
                                @else
                                    <form action="/admin/cards/{{ $card->id }}/reissue" method="POST" class="inline">
                                        @csrf
                                        <button class="text-blue-600 hover:text-blue-900">Reissue</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No cards found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t">
            {{ $cards->links() }}
        </div>
    </div>
@endsection