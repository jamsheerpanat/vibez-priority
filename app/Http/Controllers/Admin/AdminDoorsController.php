<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Door;
use App\Models\AccessZone;
use App\Models\NfcDevice;
use Illuminate\Http\Request;

class AdminDoorsController extends Controller
{
    /**
     * List all doors
     */
    public function index(Request $request)
    {
        $query = Door::with(['zone', 'device']);

        if ($request->zone_id) {
            $query->where('zone_id', $request->zone_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $doors = $query->orderBy('door_name')->paginate(20);
        $zones = AccessZone::all();
        $devices = NfcDevice::all();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'doors' => $doors,
                'zones' => $zones,
                'devices' => $devices,
            ]);
        }

        return view('admin.doors.index', compact('doors', 'zones', 'devices'));
    }

    /**
     * Store a new door
     */
    public function store(Request $request)
    {
        $request->validate([
            'zone_id' => ['required', 'exists:access_zones,id'],
            'device_id' => ['required', 'exists:nfc_devices,id'],
            'door_name' => ['required', 'string', 'max:190'],
            'status' => ['nullable', 'in:active,locked,disabled'],
        ]);

        $door = Door::create($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Door created successfully',
                'door' => $door->load(['zone', 'device']),
            ], 201);
        }

        return redirect()->back()->with('success', 'Door created successfully');
    }

    /**
     * Update a door
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'zone_id' => ['required', 'exists:access_zones,id'],
            'device_id' => ['required', 'exists:nfc_devices,id'],
            'door_name' => ['required', 'string', 'max:190'],
            'status' => ['required', 'in:active,locked,disabled'],
        ]);

        $door = Door::findOrFail($id);
        $door->update($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Door updated successfully',
                'door' => $door->load(['zone', 'device']),
            ]);
        }

        return redirect()->back()->with('success', 'Door updated successfully');
    }

    /**
     * Delete a door
     */
    public function destroy(int $id)
    {
        $door = Door::findOrFail($id);
        $door->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Door deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Door deleted successfully');
    }
}
