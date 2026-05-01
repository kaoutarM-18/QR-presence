<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable = [
        'etudiant_id', 'seance_id', 'scanned_at', 'status'
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}