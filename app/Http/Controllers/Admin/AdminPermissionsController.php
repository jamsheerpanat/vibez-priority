<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessPermission;
use App\Models\WalletCard;
use App\Models\Door;
use Illuminate\Http\Request;

class AdminPermissionsController extends Controller
{
    /**
     * List all permissions
     */
    public function index(Request $request)
    {
        $query = AccessPermission::with(['walletCard.user', 'door.zone']);

        // Filter by wallet card
        if ($request->wallet_card_id) {
            $query->where('wallet_card_id', $request->wallet_card_id);
        }

        // Filter by door
        if ($request->door_id) {
            $query->where('door_id', $request->door_id);
        }

        // Filter expired
        if ($request->filter === 'expired') {
            $query->where('valid_to', '<', now());
        } elseif ($request->filter === 'active') {
            $query->where('valid_from', '<=', now())
                ->where('valid_to', '>=', now());
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate(20);
        $doors = Door::with('zone')->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'permissions' => $permissions,
                'doors' => $doors,
            ]);
        }

        return view('admin.permissions.index', compact('permissions', 'doors'));
    }

    /**
     * Store a new permission
     */
    public function store(Request $request)
    {
        $request->validate([
            'wallet_card_id' => ['required', 'exists:wallet_cards,id'],
            'door_id' => ['required', 'exists:doors,id'],
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date', 'after:valid_from'],
            'time_start' => ['nullable', 'date_format:H:i'],
            'time_end' => ['nullable', 'date_format:H:i', 'after:time_start'],
        ]);

        $permission = AccessPermission::create($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission created successfully',
                'permission' => $permission->load(['walletCard.user', 'door.zone']),
            ], 201);
        }

        return redirect()->back()->with('success', 'Permission created successfully');
    }

    /**
     * Update a permission
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'valid_from' => ['required', 'date'],
            'valid_to' => ['required', 'date', 'after:valid_from'],
            'time_start' => ['nullable', 'date_format:H:i'],
            'time_end' => ['nullable', 'date_format:H:i', 'after:time_start'],
        ]);

        $permission = AccessPermission::findOrFail($id);
        $permission->update($request->all());

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission updated successfully',
                'permission' => $permission->load(['walletCard.user', 'door.zone']),
            ]);
        }

        return redirect()->back()->with('success', 'Permission updated successfully');
    }

    /**
     * Delete a permission
     */
    public function destroy(int $id)
    {
        $permission = AccessPermission::findOrFail($id);
        $permission->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully',
            ]);
        }

        return redirect()->back()->with('success', 'Permission deleted successfully');
    }
}
