@extends('admin.layout')

@section('title', 'Doors')
@section('page-title', 'Doors Management')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Doors</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Door Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Device</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($doors as $door)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">{{ $door->door_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $door->zone->zone_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $door->device->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span
                                class="px-2 py-1 {{ $door->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} rounded-full text-xs">
                                {{ ucfirst($door->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No doors found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $doors->links() }}</div>
    </div>
@endsection