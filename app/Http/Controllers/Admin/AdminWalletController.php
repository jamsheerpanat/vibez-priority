<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessPermission;
use App\Models\WalletCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminWalletController extends Controller
{
    /**
     * List all wallet cards
     */
    public function index(Request $request)
    {
        $query = WalletCard::with('user');

        // Filter by platform
        if ($request->platform) {
            $query->where('platform', $request->platform);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Search by card serial or user
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('card_serial', 'like', "%{$request->search}%")
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('full_name', 'like', "%{$request->search}%");
                    });
            });
        }

        $cards = $query->orderBy('created_at', 'desc')->paginate(20);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cards' => $cards,
            ]);
        }

        return view('admin.cards.index', compact('cards'));
    }

    /**
     * Revoke a wallet card
     */
    public function revoke(int $id)
    {
        $card = WalletCard::findOrFail($id);

        $card->status = 'revoked';
        $card->revoked_at = now();
        $card->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Card revoked successfully',
                'card' => $card,
            ]);
        }

        return redirect()->back()->with('success', 'Card revoked successfully');
    }

    /**
     * Reissue a wallet card
     */
    public function reissue(int $id)
    {
        $oldCard = WalletCard::with('user', 'accessPermissions')->findOrFail($id);

        // Create new card
        $newCard = WalletCard::create([
            'user_id' => $oldCard->user_id,
            'platform' => $oldCard->platform,
            'card_serial' => strtoupper($oldCard->platform) . '-' . strtoupper(Str::random(16)),
            'status' => 'active',
            'issued_at' => now(),
        ]);

        // Copy permissions from old card
        foreach ($oldCard->accessPermissions as $permission) {
            AccessPermission::create([
                'wallet_card_id' => $newCard->id,
                'door_id' => $permission->door_id,
                'valid_from' => $permission->valid_from,
                'valid_to' => $permission->valid_to,
                'time_start' => $permission->time_start,
                'time_end' => $permission->time_end,
            ]);
        }

        // Revoke old card
        $oldCard->status = 'revoked';
        $oldCard->revoked_at = now();
        $oldCard->save();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Card reissued successfully',
                'old_card' => $oldCard,
                'new_card' => $newCard,
            ]);
        }

        return redirect()->back()->with('success', 'Card reissued successfully');
    }
}
