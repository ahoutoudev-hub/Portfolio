<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieCompetence extends Model
{
    protected $table = 'categorie_competences';

    protected $fillable = ['nom', 'icone', 'couleur', 'ordre'];

    public function competences()
    {
        return $this->hasMany(Competence::class, 'categorie_id');
    }
}
