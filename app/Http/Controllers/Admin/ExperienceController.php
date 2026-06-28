<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    /**
     * Liste de toutes les expériences.
     */
    public function index(Request $request): View
    {
        $query = Experience::orderBy('type')->orderBy('ordre')->orderByDesc('date_debut');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('entreprise', 'like', '%' . $request->search . '%');
            });
        }

        $experiences = $query->paginate(10)->withQueryString();

        $stats = [
            'total'     => Experience::count(),
            'travail'   => Experience::where('type', 'travail')->count(),
            'formation' => Experience::where('type', 'formation')->count(),
            'en_cours'  => Experience::where('en_cours', true)->count(),
        ];

        return view('admin.experiences.experiences_index', compact('experiences', 'stats'));
    }

    /**
     * Formulaire de création.
     */
    public function create(): View
    {
        return view('admin.experiences.experiences_form');
    }

    /**
     * Enregistrement d'une nouvelle expérience.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'         => ['required', 'in:travail,formation'],
            'titre'        => ['required', 'string', 'max:255'],
            'entreprise'   => ['required', 'string', 'max:255'],
            'logo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'localisation' => ['nullable', 'string', 'max:150'],
            'date_debut'   => ['required', 'date'],
            'date_fin'     => ['nullable', 'date', 'after_or_equal:date_debut'],
            'en_cours'     => ['boolean'],
            'description'  => ['nullable', 'string'],
            'ordre'        => ['nullable', 'integer', 'min:0'],
            'actif'        => ['boolean'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('experiences/logos', 'public');
        }

        $validated['en_cours'] = $request->boolean('en_cours');
        $validated['actif']    = $request->boolean('actif', true);
        $validated['ordre']    = $validated['ordre'] ?? 0;

        // Si en cours → pas de date de fin
        if ($validated['en_cours']) {
            $validated['date_fin'] = null;
        }

        Experience::create($validated);

        return redirect()
            ->route('experiences.index')
            ->with('toast_success', 'Expérience "' . $validated['titre'] . '" créée avec succès.');
    }

    /**
     * Formulaire d'édition.
     */
    public function edit(Experience $experience): View
    {
        return view('admin.experiences.experiences_form', compact('experience'));
    }

    /**
     * Mise à jour d'une expérience.
     */
    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $validated = $request->validate([
            'type'         => ['required', 'in:travail,formation'],
            'titre'        => ['required', 'string', 'max:255'],
            'entreprise'   => ['required', 'string', 'max:255'],
            'logo'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1024'],
            'localisation' => ['nullable', 'string', 'max:150'],
            'date_debut'   => ['required', 'date'],
            'date_fin'     => ['nullable', 'date', 'after_or_equal:date_debut'],
            'en_cours'     => ['boolean'],
            'description'  => ['nullable', 'string'],
            'ordre'        => ['nullable', 'integer', 'min:0'],
            'actif'        => ['boolean'],
        ]);

        if ($request->hasFile('logo')) {
            if ($experience->logo) {
                Storage::disk('public')->delete($experience->logo);
            }
            $validated['logo'] = $request->file('logo')->store('experiences/logos', 'public');
        }

        if ($request->boolean('supprimer_logo') && $experience->logo) {
            Storage::disk('public')->delete($experience->logo);
            $validated['logo'] = null;
        }

        $validated['en_cours'] = $request->boolean('en_cours');
        $validated['actif']    = $request->boolean('actif', true);
        $validated['ordre']    = $validated['ordre'] ?? 0;

        if ($validated['en_cours']) {
            $validated['date_fin'] = null;
        }

        $experience->update($validated);

        return redirect()
            ->route('experiences.index')
            ->with('toast_success', 'Expérience "' . $experience->titre . '" mise à jour.');
    }

    /**
     * Suppression.
     */
    public function destroy(Experience $experience): RedirectResponse
    {
        if ($experience->logo) {
            Storage::disk('public')->delete($experience->logo);
        }

        $titre = $experience->titre;
        $experience->delete();

        return redirect()
            ->route('experiences.index')
            ->with('toast_success', 'Expérience "' . $titre . '" supprimée.');
    }

    /**
     * Basculer actif/inactif via AJAX.
     */
    public function toggleActif(Experience $experience)
    {
        $experience->update(['actif' => !$experience->actif]);

        return response()->json([
            'actif'   => $experience->actif,
            'message' => $experience->actif ? 'Expérience activée.' : 'Expérience désactivée.',
        ]);
    }
}
