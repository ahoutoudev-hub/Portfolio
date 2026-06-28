<?php

namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function Connexion()
    {
        if (Auth::check()) {
            return redirect()->route('TableauDeBord');
        }
        return view('auth.auth');
    }

    public function SeConnecter(Request $request): RedirectResponse
    {
        // ── 1. Validation des champs ─────────────────────────────
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
 
        // ── 2. Protection anti brute-force (5 tentatives / minute) ──
        $throttleKey = Str::lower($request->email) . '|' . $request->ip();
 
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
 
            return back()->with('sweet_error', [
                'icon'    => 'warning',
                'title'   => 'Trop de tentatives',
                'message' => "Trop de tentatives échouées. Réessayez dans {$seconds} secondes.",
            ]);
        }
 
        // ── 3a. Vérifier si l'email existe en BDD ────────────────
        $user = User::where('email', $request->email)->first();
 
        if (!$user) {
            RateLimiter::hit($throttleKey, 60);
 
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('sweet_error', [
                    'icon'    => 'error',
                    'title'   => 'Email introuvable',
                    'message' => 'Aucun compte associé à cette adresse e-mail.',
                ]);
        }
 
        // ── 3b. Vérifier si le mot de passe est correct ──────────
        if (!Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
 
            return back()
                ->withInput($request->only('email', 'remember'))
                ->with('sweet_error', [
                    'icon'    => 'error',
                    'title'   => 'Mot de passe incorrect',
                    'message' => 'Le mot de passe saisi est incorrect.',
                ]);
        }
 
        // ── 4. Vérifier que l'utilisateur est bien admin ─────────
        if ($user->role !== 'admin') {
            return back()->with('sweet_error', [
                'icon'    => 'error',
                'title'   => 'Accès refusé',
                'message' => 'Vous n\'avez pas les droits pour accéder à cet espace.',
            ]);
        }
 
        // ── 5. Connexion réussie ─────────────────────────────────
        RateLimiter::clear($throttleKey);
 
        Auth::login($user, $request->boolean('remember'));
 
        $request->session()->regenerate();
 
        return redirect()
            ->intended(route('TableauDeBord'))
            ->with('sweet_success', [
                'title'   => 'Connexion réussie !',
                'message' => 'Bienvenue ' . $user->prenom . ' 👋',
            ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.connexion')
            ->with('sweet_success', [
                'title'   => 'Déconnexion réussie',
                'message' => 'À bientôt !',
            ]);
    }
}