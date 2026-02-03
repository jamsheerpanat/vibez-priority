@extends('admin.layout')

@section('title', 'Zones')
@section('page-title', 'Access Zones')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Access Zones</h3>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Zone Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doors</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($zones as $zone)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium">{{ $zone->zone_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $zone->description ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">{{ $zone->doors_count }} doors</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No zones found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">{{ $zones->links() }}</div>
    </div>
@endsection