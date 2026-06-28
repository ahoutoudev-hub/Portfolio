<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'experiences';

    protected $fillable = [
        'type',
        'titre',
        'entreprise',
        'logo',
        'localisation',
        'date_debut',
        'date_fin',
        'en_cours',
        'description',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin'   => 'date',
        'en_cours'   => 'boolean',
        'actif'      => 'boolean',
    ];

    /*
    |------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------
    */
    public function scopeTravail($query)
    {
        return $query->where('type', 'travail');
    }

    public function scopeFormation($query)
    {
        return $query->where('type', 'formation');
    }

    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /*
    |------------------------------------------------------------------
    | Accesseurs
    |------------------------------------------------------------------
    */
    public function getPeriodeAttribute(): string
    {
        $debut = $this->date_debut?->translatedFormat('M Y') ?? '—';
        $fin   = $this->en_cours ? 'Présent' : ($this->date_fin?->translatedFormat('M Y') ?? '—');
        return "{$debut} — {$fin}";
    }

    public function getTypeBadgeAttribute(): array
    {
        return match ($this->type) {
            'travail'   => ['label' => 'Travail',   'class' => 'badge-primary'],
            'formation' => ['label' => 'Formation', 'class' => 'badge-info'],
            default     => ['label' => $this->type, 'class' => 'badge-secondary'],
        };
    }
}