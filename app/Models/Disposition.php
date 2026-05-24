<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposition extends Model
{
    protected $fillable = [
        'incoming_letter_id',
        'user_id',
        'assigned_to',
        'instruction',
        'due_date',
    ];

    public function incomingletter()
    {
        return $this->belongsTo(IncomingLetter::class, 'incoming_letter_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
