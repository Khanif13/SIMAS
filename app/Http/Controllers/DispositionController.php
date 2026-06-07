<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
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

        Disposition::create([
            'incoming_letter_id' => $incomingLetterId,
            'user_id' => auth()->id(),
            'assigned_user_id' => $request->assigned_user_id,
            'instruction' => $request->instruction,
            'due_date' => $request->due_date,
        ]);

        $letter = IncomingLetter::findOrFail($incomingLetterId);
        $letter->update(['status' => 'dispositioned']);

        $assignedUser = User::find($request->assigned_user_id);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Kirim Disposisi',
            'description' => 'Mengirimkan disposisi/tugas dari surat nomor: '.$letter->letter_number.' kepada anggota: '.($assignedUser->name ?? 'Tidak diketahui'),
        ]);

        return back()->with('success', 'Disposisi berhasil dikirim.');
    }

    public function submitFeedback(Request $request, $id)
    {
        $disposition = Disposition::findOrFail($id);

        if (auth()->id() !== $disposition->assigned_user_id) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'feedback_note' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        $disposition->update([
            'feedback_note' => $request->feedback_note,
            'status' => $request->status,
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'Feedback Disposisi',
            'description' => 'Memberikan laporan/feedback pada tugas disposisi dari surat nomor: '.($disposition->incomingletter->letter_number ?? 'Tidak diketahui'),
        ]);

        return back()->with('success', 'Laporan feedback disposisi berhasil dikirim ke Admin.');
    }
}
