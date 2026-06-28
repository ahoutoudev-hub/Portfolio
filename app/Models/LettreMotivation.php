<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LettreMotivation extends Model
{
    protected $table = 'lettres_motivations';

    protected $fillable = [
        'user_id', 'modele', 'entreprise', 'recruteur',
        'poste', 'type_contrat', 'ville', 'date_lettre',
        'infos_complementaires', 'contenu_genere',
    ];

    protected $casts = [
        'date_lettre' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* Libellés des types de contrat */
    public function getTypeContratLabelAttribute(): string
    {
        return match($this->type_contrat) {
            'cdi'        => 'CDI',
            'cdd'        => 'CDD',
            'stage'      => 'Stage',
            'alternance' => 'Alternance',
            'freelance'  => 'Freelance',
            'mission'    => 'Mission',
            'interim'    => 'Intérim',
            default      => ucfirst($this->type_contrat),
        };
    }
}
