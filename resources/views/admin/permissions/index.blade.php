@extends('admin.layout')

@section('title', 'Permissions')
@section('page-title', 'Access Permissions')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Access Permissions</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Door</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Window</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($permissions as $permission)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $permission->walletCard->user->full_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $permission->door->door_name }}
                            ({{ $permission->door->zone->zone_name }})</td>
                        <td class="px-6 py-4 text-sm">
                            {{ $permission->valid_from->format('Y-m-d') }} to {{ $permission->valid_to->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($permission->time_start && $permission->time_end)
                                {{ $permission->time_start }} - {{ $permission->time_end }}
                            @else
                                All day
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No permissions found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $permissions->links() }}</div>
    </div>
@endsection