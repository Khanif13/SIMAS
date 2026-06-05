<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use App\Models\OutgoingLetter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        $userId = Auth::id();

        // Hitung total surat secara global untuk Admin & Superadmin
        $totalIncoming = IncomingLetter::count();
        $totalOutgoing = OutgoingLetter::count();
        $totalUsers = User::count();

        // Data yang dikirim ke view
        return view('dashboard', compact(
            'totalIncoming',
            'totalOutgoing',
            'totalUsers',
            'role'
        ));
    }
}
