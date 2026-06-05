<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    public function index()
    {
        $dispositions = Disposition::with(['incomingletter', 'user'])
            ->where('assigned_user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dispositions.index', compact('dispositions'));
    }

    public function store(Request $request, $incomingLetterId)
    {
        $request->validate([
            'assigned_user_id' => 'required|exists:users,id',
            'instruction' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        // Create the disposition
        Disposition::create([
            'incoming_letter_id' => $incomingLetterId,
            'user_id' => auth()->id(),
            'assigned_user_id' => $request->assigned_user_id,
            'instruction' => $request->instruction,
            'due_date' => $request->due_date,
        ]);

        $letter = IncomingLetter::findOrFail($incomingLetterId);
        $letter->update(['status' => 'dispositioned']);

        return back()->with('success', 'Disposisi berhasil dikirim.');
    }
}
