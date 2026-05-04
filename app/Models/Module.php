<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //protected $primaryKey = 'id_module';
    
    //protected $fillable = ['nom', 'id_filiere'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}