<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    protected $table = 'temoignages';

    protected $fillable = [
        'nom',
        'poste',
        'entreprise',
        'avatar',
        'contenu',
        'note',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'note'  => 'integer',
        'actif' => 'boolean',
    ];

    /*
    |------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------
    */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /*
    |------------------------------------------------------------------
    | Accesseurs
    |------------------------------------------------------------------
    */
    public function getInitialesAttribute(): string
    {
        $parts = explode(' ', trim($this->nom));
        $initiales = '';
        foreach (array_slice($parts, 0, 2) as $part) {
            $initiales .= mb_strtoupper(mb_substr($part, 0, 1));
        }
        return $initiales ?: '?';
    }

    public function getEtoilesAttribute(): string
    {
        return str_repeat('★', $this->note) . str_repeat('☆', 5 - $this->note);
    }
}
