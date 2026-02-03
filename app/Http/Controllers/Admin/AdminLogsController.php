<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccessLog;
use Illuminate\Http\Request;

class AdminLogsController extends Controller
{
    /**
     * List all access logs
     */
    public function index(Request $request)
    {
        $query = AccessLog::with(['walletCard.user', 'door.zone', 'device']);

        // Filter by result
        if ($request->result) {
            $query->where('result', $request->result);
        }

        // Filter by door
        if ($request->door_id) {
            $query->where('door_id', $request->door_id);
        }

        // Filter by device
        if ($request->device_id) {
            $query->where('device_id', $request->device_id);
        }

        // Filter by date range
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by user name
        if ($request->search) {
            $query->whereHas('walletCard.user', function ($q) use ($request) {
                $q->where('full_name', 'like', "%{$request->search}%");
            });
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        // Get stats
        $stats = [
            'total_today' => AccessLog::whereDate('created_at', today())->count(),
            'granted_today' => AccessLog::whereDate('created_at', today())->where('result', 'granted')->count(),
            'denied_today' => AccessLog::whereDate('created_at', today())->where('result', 'denied')->count(),
        ];

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'logs' => $logs,
                'stats' => $stats,
            ]);
        }

        return view('admin.logs.index', compact('logs', 'stats'));
    }
}
