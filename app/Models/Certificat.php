<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    protected $table = 'certificats';

    protected $fillable = [
        'titre',
        'organisme',
        'date_obtention',
        'url_credential',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'date_obtention' => 'date',
        'actif'          => 'boolean',
    ];

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    public function getDateFormateeAttribute(): string
    {
        return $this->date_obtention?->translatedFormat('F Y') ?? '—';
    }
}