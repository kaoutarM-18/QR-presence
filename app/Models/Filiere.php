<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['nom_filiere', 'nombre_etudiants'];

    // Filiere.php
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class); 
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}