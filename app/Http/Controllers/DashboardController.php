<?php

namespace App\Http\Controllers;

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

        // Hitung total data global (Untuk Admin)
        $totalIncoming = IncomingLetter::count();
        $totalOutgoing = OutgoingLetter::count();
        $totalUsers = User::count();

        // Hitung total disposisi khusus untuk user yang sedang login (Untuk Member)
        $activeDispositions = Disposition::where('assigned_user_id', Auth::id())->count();

        // Mengambil 5 surat masuk terbaru
        $recentIncoming = IncomingLetter::latest()->take(5)->get()->map(function ($letter) {
            return (object) [
                'type' => 'masuk',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->created_at,
                'status' => $letter->status,
            ];
        });

        // Mengambil 5 surat keluar terbaru
        $recentOutgoing = OutgoingLetter::latest()->take(5)->get()->map(function ($letter) {
            return (object) [
                'type' => 'keluar',
                'letter_number' => $letter->letter_number,
                'subject' => $letter->subject,
                'date' => $letter->created_at,
                'status' => $letter->status,
            ];
        });

        // Menggabungkan kedua koleksi, lalu mengurutkan
        $recentActivities = $recentIncoming->concat($recentOutgoing)->sortByDesc('date')->take(5);

        // Lempar variabel baru ($activeDispositions) ke view
        return view('dashboard', compact(
            'totalIncoming',
            'totalOutgoing',
            'totalUsers',
            'role',
            'recentActivities',
            'activeDispositions'
        ));
    }
}
