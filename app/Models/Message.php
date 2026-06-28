<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'sujet',
        'message',
        'lu',
        'lu_le',
        'repondu',
        'important',
        'ip',
    ];

    protected $casts = [
        'lu'       => 'boolean',
        'repondu'  => 'boolean',
        'important'=> 'boolean',
        'lu_le'    => 'datetime',
    ];

    /*
    |------------------------------------------------------------------
    | Scopes
    |------------------------------------------------------------------
    */
    public function scopeNonLu($query)
    {
        return $query->where('lu', false);
    }

    public function scopeImportant($query)
    {
        return $query->where('important', true);
    }

    public function scopeRepondu($query)
    {
        return $query->where('repondu', true);
    }

    /*
    |------------------------------------------------------------------
    | Accesseurs
    |------------------------------------------------------------------
    */
    public function getNomCompletAttribute(): string
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? ''));
    }

    public function getInitialesAttribute(): string
    {
        $p = mb_substr($this->prenom ?? '', 0, 1);
        $n = mb_substr($this->nom ?? '', 0, 1);
        return strtoupper($p . $n) ?: '?';
    }
}
