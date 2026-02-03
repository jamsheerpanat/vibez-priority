@extends('admin.layout')

@section('title', 'Access Logs')
@section('page-title', 'Access Logs')

@section('content')
    <div class="grid grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Today's Total</p>
            <p class="text-3xl font-bold">{{ $stats['total_today'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Granted</p>
            <p class="text-3xl font-bold text-green-600">{{ $stats['granted_today'] }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600">Denied</p>
            <p class="text-3xl font-bold text-red-600">{{ $stats['denied_today'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <form method="GET" class="flex gap-4">
                <select name="result" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">All Results</option>
                    <option value="granted" {{ request('result') === 'granted' ? 'selected' : '' }}>Granted</option>
                    <option value="denied" {{ request('result') === 'denied' ? 'selected' : '' }}>Denied</option>
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg">
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg">
                <button type="submit"
                    class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Door</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Result</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="px-6 py-4 text-sm">{{ $log->walletCard->user->full_name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $log->door->door_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $log->device->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 py-1 {{ $log->result === 'granted' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full text-xs">
                                    {{ ucfirst($log->result) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $log->reason ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No logs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t">
            {{ $logs->links() }}
        </div>
    </div>
@endsection