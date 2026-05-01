<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'cours_id', 'date_heure', 'duree', 'qr_expire'
    ];
    
    protected $casts = [
        'date_heure' => 'datetime',
        'qr_expire' => 'boolean'
    ];
    
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
    
    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
    
    public function isQRActive()
    {
        if (!$this->qr_expire) return true;
        
        $finSeance = $this->date_heure->copy()->addMinutes($this->duree);
        return now()->between($this->date_heure, $finSeance);
    }
}