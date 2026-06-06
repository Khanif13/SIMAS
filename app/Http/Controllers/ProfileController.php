<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Logika untuk ubah password jika form diisi
        if ($request->filled('password')) {
            // Cek apakah password lama yang dimasukkan benar
            if (! Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok dengan sistem.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Informasi profil berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Kata sandi yang Anda masukkan salah.']);
        }

        if ($user->id === 1) {
            return back()->with('error', 'Sistem menolak! Akun Superadmin Utama tidak dapat dihapus.');
        }

        ActivityLog::create([
            'user_id' => 1,
            'action' => 'Hapus Akun Mandiri',
            'description' => 'Pengguna ['.strtoupper($user->role)."] bernama {$user->name} ({$user->email}) telah menghapus akunnya sendiri secara permanen.",
        ]);

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus secara permanen.');
    }
}
