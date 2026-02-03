<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletCard;
use Illuminate\Http\Request;

class AdminUsersController extends Controller
{
    /**
     * List all users
     */
    public function index(Request $request)
    {
        $query = User::with('walletCards');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('mobile', 'like', "%{$request->search}%")
                    ->orWhere('company_name', 'like', "%{$request->search}%");
            });
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by user type
        if ($request->user_type) {
            $query->where('user_type', $request->user_type);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'users' => $users,
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show user details
     */
    public function show(string $uuid)
    {
        $user = User::with(['walletCards.accessPermissions.door.zone'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ]);
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user status
     */
    public function updateStatus(Request $request, string $uuid)
    {
        $request->validate([
            'status' => ['required', 'in:active,suspended,revoked'],
        ]);

        $user = User::where('uuid', $uuid)->firstOrFail();
        $user->status = $request->status;
        $user->save();

        // If revoking, also revoke all wallet cards
        if ($request->status === 'revoked') {
            WalletCard::where('user_id', $user->id)
                ->update([
                    'status' => 'revoked',
                    'revoked_at' => now(),
                ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User status updated',
                'user' => $user,
            ]);
        }

        return redirect()->back()->with('success', 'User status updated successfully');
    }
    /**
     * Delete user
     */
    public function destroy(string $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        // This will trigger cascading deletes if set in DB or we can do it manually
        // For card relationships:
        WalletCard::where('user_id', $user->id)->delete();

        $user->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
