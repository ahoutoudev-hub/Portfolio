<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $table = 'parametres';

    protected $fillable = ['cle', 'valeur', 'groupe'];

    /**
     * Récupère une valeur par clé (helper statique).
     * Usage : Parametre::get('site_nom')
     */
    public static function get(string $cle, string $default = ''): string
    {
        return static::where('cle', $cle)->value('valeur') ?? $default;
    }

    /**
     * Définit une valeur par clé.
     */
    public static function set(string $cle, string $valeur): void
    {
        static::where('cle', $cle)->update(['valeur' => $valeur]);
    }
}
