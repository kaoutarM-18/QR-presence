<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
    ];

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class, 'user_id');
    }

    public function professeur()
    {
        return $this->hasOne(Professeur::class);
    }

    public function presences()
{
    return $this->hasManyThrough(
        Presence::class,
        Etudiant::class,
        'user_id',      // foreign key on Etudiant
        'etudiant_id',  // foreign key on Presence
        'id',
        'id'
    );
}
    
}

