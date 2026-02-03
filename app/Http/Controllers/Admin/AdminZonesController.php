<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessZone;
use Illuminate\Http\Request;

class AdminZonesController extends Controller
{
    /**
     * List all zones
     */
    public function index(Request $request)
    {
        $zones = AccessZone::withCount('doors')->orderBy('zone_name')->paginate(20);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'zones' => $zones,
            ]);
        }

        return view('admin.zones.index', compact('zones'));
    }

    /**
     * Store a new zone
     */
    public function store(Request $request)
    {
        $request->validate([
            'zone_name' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string'],
        ]);

        $zone = AccessZone::create($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Zone created successfully',
                'zone' => $zone,
            ], 201);
        }

        return redirect()->back()->with('success', 'Zone created successfully');
    }

    /**
     * Update a zone
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'zone_name' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string'],
        ]);

        $zone = AccessZone::findOrFail($id);
        $zone->update($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Zone updated successfully',
                'zone' => $zone,
            ]);
        }

        return redirect()->back()->with('success', 'Zone updated successfully');
    }

    /**
     * Delete a zone
     */
    public function destroy(int $id)
    {
        $zone = AccessZone::findOrFail($id);

        // Check if zone has doors
        if ($zone->doors()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete zone with associated doors',
                ], 400);
            }

            return redirect()->back()->with('error', 'Cannot delete zone with associated doors');
        }

        $zone->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Zone deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Zone deleted successfully');
    }
}
