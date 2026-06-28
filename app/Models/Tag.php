<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = ['nom', 'slug', 'couleur'];

    public function projets()
    {
        return $this->belongsToMany(Projet::class, 'projet_tag');
    }
}