<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $primaryKey = 'id_filiere'; // ✅ clé primaire personnalisée

    protected $fillable = ['nom_filiere', 'nombre_etudiants'];

    // Filiere.php
public function etudiants()
{
    return $this->hasMany(Etudiant::class, 'id_filiere', 'id_filiere'); // ✅ Etudiant pas User
}
    public function cours()
    {
        return $this->hasMany(Cours::class, 'id_filiere', 'id_filiere');
    }
}