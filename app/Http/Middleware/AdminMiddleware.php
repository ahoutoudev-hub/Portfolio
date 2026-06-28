<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Vérifie que l'utilisateur connecté a le rôle 'admin'.
     * Sinon → déconnexion + redirection vers login avec message d'erreur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            Auth::logout();

            return redirect()
                ->route('auth.connexion')
                ->with('sweet_error', [
                    'icon'    => 'error',
                    'title'   => 'Accès refusé',
                    'message' => 'Vous n\'avez pas les droits pour accéder à cet espace.',
                ]);
        }

        return $next($request);
    }
}
