<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    protected $fillable = [
        'nom_cours', 'description', 'enseignant_id'
    ];

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}