<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfilController extends Controller
{
    public function index(): View
    {
        return view('admin.profil.profil_index', ['user' => Auth::user()]);
    }

    public function updateInfos(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'prenom'       => ['required', 'string', 'max:100'],
            'nom'          => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'unique:users,email,' . $user->id],
            'telephone'    => ['nullable', 'string', 'max:30'],
            'poste_actuel' => ['nullable', 'string', 'max:150'],
            'ville'        => ['nullable', 'string', 'max:100'],
            'pays'         => ['nullable', 'string', 'max:100'],
            'biographie'   => ['nullable', 'string'],
            'disponible'   => ['boolean'],
        ]);

        $validated['disponible'] = $request->boolean('disponible');
        $user->update($validated);

        return back()->with('toast_success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('toast_success', 'Mot de passe modifié avec succès.');
    }

    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('toast_success', 'Avatar mis à jour.');
    }

    public function deleteAvatar(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return back()->with('toast_success', 'Avatar supprimé.');
    }

    /* ──────────────────────────────────────────────────────
       CV
    ────────────────────────────────────────────────────── */

    /**
     * Uploader un nouveau CV (PDF uniquement).
     */
    public function uploadCv(Request $request): RedirectResponse
    {
        $request->validate([
            'cv' => ['required', 'file', 'mimes:pdf', 'max:5120'], // 5 Mo max
        ]);

        $user = Auth::user();

        // Supprimer l'ancien CV
        if ($user->cv && Storage::disk('public')->exists($user->cv)) {
            Storage::disk('public')->delete($user->cv);
        }

        // Stocker avec un nom propre
        $filename = 'CV_' . str_replace(' ', '_', $user->nom_complet) . '.pdf';
        $path = $request->file('cv')->storeAs('cv', $filename, 'public');

        $user->update(['cv' => $path]);

        // Mettre à jour le paramètre site_cv
        \App\Models\Parametre::where('cle', 'site_cv')
            ->update(['valeur' => Storage::disk('public')->url($path)]);

        return back()->with('toast_success', 'CV importé avec succès.');
    }

    /**
     * Télécharger le CV.
     */
    public function downloadCv(): StreamedResponse|RedirectResponse
    {
        $user = Auth::user();

        if (!$user->cv || !Storage::disk('public')->exists($user->cv)) {
            return back()->with('toast_error', 'Aucun CV disponible.');
        }

        $filename = 'CV_' . str_replace(' ', '_', $user->nom_complet) . '.pdf';

        return Storage::disk('public')->download($user->cv, $filename);
    }

    /**
     * Supprimer le CV.
     */
    public function deleteCv(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->cv && Storage::disk('public')->exists($user->cv)) {
            Storage::disk('public')->delete($user->cv);
        }

        $user->update(['cv' => null]);

        \App\Models\Parametre::where('cle', 'site_cv')->update(['valeur' => '']);

        return back()->with('toast_success', 'CV supprimé.');
    }
}