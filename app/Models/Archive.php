<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'incoming_letter_id',
        'outgoing_letter_id',
        'archive_code',
        'locaion',
        'notes',
    ];

    public function incomingLetter()
    {
        return $this->belongsTo(IncomingLetter::class, 'incoming_letter_id');
    }

    public function outgoingLetter()
    {
        return $this->belongsTo(OutgoingLetter::class, 'outgoing_letter_id');
    }
}
