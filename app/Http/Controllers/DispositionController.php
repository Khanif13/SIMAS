<?php

namespace App\Http\Controllers;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use Illuminate\Http\Request;

class DispositionController extends Controller
{
    public function store(Request $request, $incomingLetterId)
    {
        $request->validate([
            'assigned_to' => 'required|string',
            'instruction' => 'required|string',
            'due_date' => 'nullable|date',
        ]);

        // Create the disposition
        Disposition::create([
            'incoming_letter_id' => $incomingLetterId,
            'user_id' => auth()->id(),
            'assigned_to' => $request->assigned_to,
            'instruction' => $request->instruction,
            'due_date' => $request->due_date,
        ]);

        $letter = IncomingLetter::findOrFail($incomingLetterId);
        $letter->update(['status' => 'dispositioned']);

        return back()->with('success', 'Disposisi berhasil dikirim.');
    }
}
