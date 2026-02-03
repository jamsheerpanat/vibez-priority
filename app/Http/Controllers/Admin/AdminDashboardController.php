<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WalletCard;
use App\Models\Door;
use App\Models\AccessLog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_cards' => WalletCard::count(),
            'active_cards' => WalletCard::where('status', 'active')->count(),
            'total_doors' => Door::count(),
            'active_doors' => Door::where('status', 'active')->count(),
            'today_attempts' => AccessLog::whereDate('created_at', today())->count(),
            'today_granted' => AccessLog::whereDate('created_at', today())->where('result', 'granted')->count(),
            'today_denied' => AccessLog::whereDate('created_at', today())->where('result', 'denied')->count(),
        ];

        // Recent logs
        $recentLogs = AccessLog::with(['walletCard.user', 'door', 'device'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'recent_logs' => $recentLogs,
            ]);
        }

        return view('admin.dashboard', compact('stats', 'recentLogs'));
    }
}
