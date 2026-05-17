<?php

namespace App\Http\Controllers;

use App\Models\IncomingLetter;
use Illuminate\Http\Request;

class IncomingLetterController extends Controller
{
    public function index(Request $request)
    {
        $query = IncomingLetter::query();

        // Implement Archive Search Feature (Phase 4)
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('subject', 'LIKE', "%{$search}%")
                ->orWhere('sender', 'LIKE', "%{$search}%")
                ->orWhere('letter_number', 'LIKE', "%{$search}%");
        }

        $letters = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('incoming-letters.index', compact('letters'));
    }

    public function create()
    {
        return view('incoming-letters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'receipt_date' => 'required|date',
            'letter_date' => 'required|date',
            'sender' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,jpeg,png|max:2048', // 2MB Max
        ]);

        $count = IncomingLetter::whereYear('created_at', date('Y'))->count() + 1;
        $letterNumber = 'SM/'.date('Y/m/').str_pad($count, 3, '0', STR_PAD_LEFT);

        $filePath = $request->file('file')->store('incoming_letters', 'public');

        IncomingLetter::create([
            'letter_number' => $letterNumber,
            'receipt_date' => $request->receipt_date,
            'letter_date' => $request->letter_date,
            'sender' => $request->sender,
            'subject' => $request->subject,
            'description' => $request->description,
            'file_path' => $filePath,
            'status' => 'pending', // Initial status
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('incoming-letters.index')
            ->with('success', 'Surat Masuk berhasil diarsipkan.');
    }
}
