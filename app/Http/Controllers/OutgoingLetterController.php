<?php

namespace App\Http\Controllers;

use App\Models\OutgoingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OutgoingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = OutgoingLetter::query();

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('subject', 'LIKE', "%{$search}%")
                ->orWhere('destination', 'LIKE', "%{$search}%")
                ->orWhere('letter_number', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('date') && $request->input('date') != '') {
            $query->whereDate('letter_date', $request->input('date'));
        }

        $letters = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('outgoing-letters.index', compact('letters'));
    }

    public function create()
    {
        $count = OutgoingLetter::whereYear('created_at', date('Y'))->count() + 1;
        $autoLetterNumber = 'SK/'.date('Y/m/').str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('outgoing-letters.create', compact('autoLetterNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'destination' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $count = OutgoingLetter::whereYear('created_at', date('Y'))->count() + 1;
        $letterNumber = 'SK/'.date('Y/m/').str_pad($count, 3, '0', STR_PAD_LEFT);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('outgoing_letters', 'public');
        }

        $status = $request->hasFile('file') ? 'sent' : 'draft';

        OutgoingLetter::create([
            'letter_number' => $letterNumber,
            'letter_date' => $request->letter_date,
            'destination' => $request->destination,
            'subject' => $request->subject,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => $status,
            'user_id' => Auth::id() ?? 1,
        ]);

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Data Surat Keluar berhasil ditambahkan.');
    }

    public function show($id)
    {
        $letter = OutgoingLetter::findOrFail($id);

        return view('outgoing-letters.show', compact('letter'));
    }

    public function edit($id)
    {
        $letter = OutgoingLetter::findOrFail($id);

        return view('outgoing-letters.edit', compact('letter'));
    }

    public function update(Request $request, $id)
    {
        $letter = OutgoingLetter::findOrFail($id);

        $request->validate([
            'destination' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:draft,sent,archived',
        ]);

        $filePath = $letter->file_path;
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada file baru yang diunggah
            if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }
            $filePath = $request->file('file')->store('outgoing_letters', 'public');
        }

        $letter->update([
            'letter_date' => $request->letter_date,
            'destination' => $request->destination,
            'subject' => $request->subject,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Data Surat Keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $letter = OutgoingLetter::findOrFail($id);

        // Hapus berkas file fisik di dalam storage sebelum menghapus baris database
        if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
            Storage::disk('public')->delete($letter->file_path);
        }

        $letter->delete();

        return redirect()->route('outgoing-letters.index')
            ->with('success', 'Data Surat Keluar berhasil dihapus dari sistem.');
    }
}
