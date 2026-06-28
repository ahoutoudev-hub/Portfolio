<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $table = 'visites';

    public $timestamps = false;

    protected $fillable = [
        'page',
        'projet_id',
        'ip_hash',
        'appareil',
        'referrer',
        'visite_le',
    ];

    protected $casts = [
        'visite_le' => 'datetime',
    ];

    /*
    |------------------------------------------------------------------
    | Relations
    |------------------------------------------------------------------
    */
    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    /*
    |------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------
    */
    public function scopeAujourdhui($query)
    {
        return $query->whereDate('visite_le', today());
    }

    public function scopeCetteSemaine($query)
    {
        return $query->where('visite_le', '>=', now()->startOfWeek());
    }

    public function scopeCeMois($query)
    {
        return $query->whereMonth('visite_le', now()->month)
                     ->whereYear('visite_le', now()->year);
    }
}
