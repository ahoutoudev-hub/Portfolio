<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    protected $table = 'competences';

    protected $fillable = ['categorie_id', 'nom', 'niveau', 'icone', 'ordre'];

    protected $casts = ['niveau' => 'integer', 'ordre' => 'integer'];

    public function categorie()
    {
        return $this->belongsTo(CategorieCompetence::class, 'categorie_id');
    }

    public function getNiveauLabelAttribute(): string
    {
        return match (true) {
            $this->niveau >= 90 => 'Expert',
            $this->niveau >= 75 => 'Avancé',
            $this->niveau >= 50 => 'Intermédiaire',
            default             => 'Débutant',
        };
    }

    public function getNiveauColorAttribute(): string
    {
        return match (true) {
            $this->niveau >= 90 => '#10b981',
            $this->niveau >= 75 => '#3b82f6',
            $this->niveau >= 50 => '#f59e0b',
            default             => '#9ca3af',
        };
    }
}