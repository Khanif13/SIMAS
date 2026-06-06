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

    public function export()
    {
        // Proteksi otorisasi
        if (! in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Akses Ditolak');
        }

        $fileName = 'Log_Aktivitas_SIMAS_'.date('Y-m-d').'.csv';

        // Ambil semua data log urut dari yang paling lama hingga terbaru
        $logs = ActivityLog::with('user')->orderBy('created_at', 'asc')->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            // Header kolom Excel/CSV
            fputcsv($file, ['No', 'Waktu (WITA)', 'Nama Pengguna', 'Jabatan/Role', 'Aksi', 'Keterangan Detail']);

            $no = 1;
            foreach ($logs as $log) {
                fputcsv($file, [
                    $no++,
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user->name ?? 'Sistem / Dihapus',
                    strtoupper($log->user->role ?? 'UNKNOWN'),
                    $log->action,
                    $log->description,
                ]);
            }
            fclose($file);
        };

        // Rekam aktivitas pengunduhan log ini ke dalam log itu sendiri (Inception!)
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Export Log Aktivitas',
            'description' => 'Mengunduh rekapitulasi file CSV seluruh riwayat log aktivitas sistem.',
        ]);

        return response()->stream($callback, 200, $headers);
    }
}
