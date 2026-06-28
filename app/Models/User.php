<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = 'users';

    /**
     * Champs assignables en masse.
     */
    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
        'avatar',
        'ville',
        'pays',
        'telephone',
        'poste_actuel',
        'biographie',
        'disponible',
        'cv',
        'role',
    ];

    /**
     * Champs cachés dans les sérialisations JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts automatiques.
     */
    // ⚠️ PAS de 'password' => 'hashed' ici — c'est Laravel 11 uniquement
    protected $casts = [
        'disponible'        => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /*
    |------------------------------------------------------------------
    | Accesseurs utiles
    |------------------------------------------------------------------
    */

    /**
     * Nom complet : "John Doe"
     */
    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Initiales : "JD"
     */
    public function getInitialesAttribute(): string
    {
        return strtoupper(
            mb_substr($this->prenom, 0, 1) .
            mb_substr($this->nom, 0, 1)
        );
    }

    /**
     * Vérifie si l'utilisateur est admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}