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
}
