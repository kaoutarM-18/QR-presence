<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $fillable = ['user_id', 'filiere_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function filiere()
    {
       // return $this->belongsTo(Filiere::class, 'id_filiere');
       return $this->belongsTo(Filiere::class);
    }
}