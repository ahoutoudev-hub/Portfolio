<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetImage extends Model
{
    protected $table = 'projet_images';

    protected $fillable = ['projet_id', 'image', 'legende', 'ordre'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }
}
