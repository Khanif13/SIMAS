<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Akses Ditolak');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:superadmin,admin,member',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|in:superadmin,admin,member',
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Hak akses dan sandi pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
