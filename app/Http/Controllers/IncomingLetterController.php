<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingLetter::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('subject', 'LIKE', "%{$search}%")
                ->orWhere('sender', 'LIKE', "%{$search}%")
                ->orWhere('letter_number', 'LIKE', "%{$search}%");
        }

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('subject', 'LIKE', "%{$search}%")
                ->orWhere('sender', 'LIKE', "%{$search}%")
                ->orWhere('letter_number', 'LIKE', "%{$search}%");
        }

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('status', $request->status('status'));
        }
        $letters = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('incoming-letters.index', compact('letters'));
    }

    public function create()
    {
        $count = IncomingLetter::whereYear('created_at', date('Y'))->count() + 1;
        $autoLetterNumber = 'SM/'.date('Y/m/').str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('incoming-letters.create', compact('autoLetterNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sender' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'receipt_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|mimes:pdf,jpeg,png|max:2048',
        ]);

        $count = IncomingLetter::whereYear('created_at', date('Y'))->count() + 1;
        $letterNumber = 'SM/'.date('Y/m/').str_pad($count, 3, '0', STR_PAD_LEFT);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('incoming_letters', 'public');
        }

        IncomingLetter::create([
            'letter_number' => $letterNumber,
            'receipt_date' => $request->receipt_date,
            'letter_date' => $request->letter_date,
            'sender' => $request->sender,
            'subject' => $request->subject,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => 'pending',
            'user_id' => Auth::id() ?? 1,
        ]);

        return redirect()->route('incoming-letters.index')
            ->with('success', 'Data Surat Masuk berhasil ditambah.');
    }

    public function show($id)
    {
        $letter = IncomingLetter::findOrFail($id);

        return view('incoming-letters.show', compact('letter'));
    }

    public function edit($id)
    {
        $letter = IncomingLetter::findOrFail($id);

        return view('incoming-letters.edit', compact('letter'));
    }

    public function update(Request $request, $id)
    {
        $letter = IncomingLetter::findOrFail($id);

        $request->validate([
            'sender' => 'required|string|max:255',
            'letter_date' => 'required|date',
            'receipt_date' => 'required|date',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf, jpg, jpeg, png|max:5048',
            'status' => 'required|in:pending, dispositioned, archived',
        ]);

        $filePath = $letter->file_path;
        if ($request->hasFile('file')) {
            if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
                Storage::disk('public')->delete($letter->file_path);
            }
            $filePath = $request->file('file')->store('incoming_letters', 'public');
        }

        $letter->update([
            'sender' => $request->sender,
            'letter_date' => $request->letter_date,
            'receipt_date' => $request->receipt_date,
            'subject' => $request->subject,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('incoming-letters.index')->with('success', 'Data Surat Masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $letter = IncomingLetter::findOrFail($id);
        if ($letter->file_path && Storage::disk('public')->exists($letter->file_path)) {
            Storage::disk('public')->delete($letter->file_path);
        }
        $letter->delete();

        return redirect()->route('incoming-letters.index')->with('success', 'Data Surat Masuk berhasil dihapus');
    }
}
