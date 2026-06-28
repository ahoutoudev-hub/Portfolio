<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReseauSocial extends Model
{
    protected $table = 'reseaux_sociaux';

    protected $fillable = ['nom', 'url', 'icone', 'couleur', 'actif', 'ordre'];

    protected $casts = ['actif' => 'boolean'];

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }
}
