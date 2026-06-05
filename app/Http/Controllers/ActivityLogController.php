<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        // Proteksi: Hanya superadmin DAN admin yang bisa lihat rekaman CCTV
        if (! in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Akses Ditolak');
        }

        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(15);

        return view('activity-logs.index', compact('logs'));
    }
}
