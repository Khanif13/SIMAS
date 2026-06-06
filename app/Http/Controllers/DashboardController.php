<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        $totalIncoming = IncomingLetter::count();
        $totalOutgoing = OutgoingLetter::count();
        $totalUsers = User::count();

        $activeDispositions = Disposition::where('assigned_user_id', Auth::id())->count();

        $recentIncoming = IncomingLetter::latest()->take(5)->get()->map(function ($letter) {
            return (object) [
                'type' => 'masuk',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->created_at,
                'status' => $letter->status,
            ];
        });

        $recentOutgoing = OutgoingLetter::latest()->take(5)->get()->map(function ($letter) {
            return (object) [
                'type' => 'keluar',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->created_at,
                'status' => $letter->status,
            ];
        });

        $recentActivities = $recentIncoming->concat($recentOutgoing)->sortByDesc('date')->take(5);

        return view('dashboard', compact(
            'totalIncoming',
            'totalOutgoing',
            'totalUsers',
            'role',
            'recentActivities',
            'activeDispositions'
        ));
    }

    public function export()
    {
        if (! in_array(auth()->user()->role, ['superadmin', 'admin'])) {
            abort(403, 'Akses Ditolak');
        }

        $fileName = 'Laporan_Arsip_SIMAS_'.date('Y-m-d').'.csv';

        $incomingLetters = IncomingLetter::orderBy('created_at', 'asc')->get();
        $outgoingLetters = OutgoingLetter::orderBy('created_at', 'asc')->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($incomingLetters, $outgoingLetters) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['=== REKAPITULASI SURAT MASUK ===']);
            fputcsv($file, ['No', 'Nomor Surat', 'Pengirim', 'Tanggal Surat', 'Tanggal Terima', 'Perihal', 'Status']);

            $no = 1;
            foreach ($incomingLetters as $letter) {
                fputcsv($file, [
                    $no++,
                    $letter->letter_number,
                    $letter->sender,
                    $letter->letter_date,
                    $letter->receipt_date,
                    $letter->subject,
                    strtoupper($letter->status),
                ]);
            }

            fputcsv($file, []);
            fputcsv($file, []);

            fputcsv($file, ['=== REKAPITULASI SURAT KELUAR ===']);
            fputcsv($file, ['No', 'Nomor Surat', 'Tujuan', 'Tanggal Surat', 'Perihal', 'Status']);

            $no = 1;
            foreach ($outgoingLetters as $letter) {
                fputcsv($file, [
                    $no++,
                    $letter->letter_number,
                    $letter->destination,
                    $letter->letter_date,
                    $letter->subject,
                    strtoupper($letter->status),
                ]);
            }

            fclose($file);
        };

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Export Laporan',
            'description' => 'Mengunduh rekapitulasi file CSV laporan seluruh Surat Masuk dan Surat Keluar.',
        ]);

        return response()->stream($callback, 200, $headers);
    }
}
