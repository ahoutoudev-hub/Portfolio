<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    /* ── Formulaire "e-mail" ── */
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    /* ── Envoi du lien de réinitialisation ── */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'L\'adresse e-mail est obligatoire.',
            'email.email'    => 'Veuillez saisir une adresse e-mail valide.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Un lien de réinitialisation a été envoyé à votre adresse e-mail.');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => __($status)]);
    }

    /* ── Formulaire "nouveau mot de passe" ── */
    public function showReset(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /* ── Réinitialisation ── */
    public function reset(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ], [
            'email.required'        => 'L\'adresse e-mail est obligatoire.',
            'email.email'           => 'Adresse e-mail invalide.',
            'password.required'     => 'Le mot de passe est obligatoire.',
            'password.min'          => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth.connexion')
                ->with('success_reset', 'Mot de passe réinitialisé avec succès. Vous pouvez vous connecter.');
        }

        return back()
            ->withInput()
            ->withErrors(['email' => __($status)]);
    }
}
