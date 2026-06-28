<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Projet extends Model
{
    protected $table = 'projets';

    protected $fillable = [
        'titre', 'slug', 'description', 'contenu',
        'image', 'statut', 'en_vedette',
        'url_demo', 'url_github',
        'type_projet', 'role', 'client', 'duree',
        'fonctionnalites', 'defis',
        'vues', 'ordre',
        'date_debut', 'date_fin',
    ];

    protected $casts = [
        'en_vedette'     => 'boolean',
        'date_debut'     => 'date',
        'date_fin'       => 'date',
        'fonctionnalites'=> 'array',
        'defis'          => 'array',
    ];

    /* Relations */
    public function tags()   { return $this->belongsToMany(Tag::class, 'projet_tag'); }
    public function images() { return $this->hasMany(ProjetImage::class)->orderBy('ordre'); }

    /* Scopes */
    public function scopePublie($q)    { return $q->where('statut', 'publié'); }
    public function scopeEnVedette($q) { return $q->where('en_vedette', true); }

    /* Accesseurs */
    public function getImageUrlAttribute(): string
    {
        return $this->image ? asset('storage/' . $this->image) : '';
    }

    /* Auto-slug */
    protected static function booted(): void
    {
        static::creating(function ($projet) {
            if (empty($projet->slug)) {
                $projet->slug = Str::slug($projet->titre);
            }
        });
    }
}