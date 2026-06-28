<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\CategorieCompetence;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompetenceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Competence::with('categorie')->orderBy('categorie_id')->orderBy('ordre');

        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        $competences  = $query->paginate(20)->withQueryString();
        $categories   = CategorieCompetence::orderBy('ordre')->get();

        $stats = [
            'total'      => Competence::count(),
            'categories' => CategorieCompetence::count(),
            'moy_niveau' => round(Competence::avg('niveau') ?? 0),
            'expert'     => Competence::where('niveau', '>=', 80)->count(),
        ];

        return view('admin.competences.competences_index', compact('competences', 'categories', 'stats'));
    }

    public function create(): View
    {
        $categories = CategorieCompetence::orderBy('ordre')->get();
        return view('admin.competences.competences_form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'exists:categorie_competences,id'],
            'nom'          => ['required', 'string', 'max:100'],
            'niveau'       => ['required', 'integer', 'min:0', 'max:100'],
            'icone'        => ['nullable', 'string', 'max:50'],
            'ordre'        => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['ordre'] = $validated['ordre'] ?? 0;

        Competence::create($validated);

        return redirect()
            ->route('competences.index')
            ->with('toast_success', 'Compétence "' . $validated['nom'] . '" créée.');
    }

    public function edit(Competence $competence): View
    {
        $categories = CategorieCompetence::orderBy('ordre')->get();
        return view('admin.competences.competences_form', compact('competence', 'categories'));
    }

    public function update(Request $request, Competence $competence): RedirectResponse
    {
        $validated = $request->validate([
            'categorie_id' => ['required', 'exists:categorie_competences,id'],
            'nom'          => ['required', 'string', 'max:100'],
            'niveau'       => ['required', 'integer', 'min:0', 'max:100'],
            'icone'        => ['nullable', 'string', 'max:50'],
            'ordre'        => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['ordre'] = $validated['ordre'] ?? 0;
        $competence->update($validated);

        return redirect()
            ->route('competences.index')
            ->with('toast_success', 'Compétence "' . $competence->nom . '" mise à jour.');
    }

    public function destroy(Competence $competence): RedirectResponse
    {
        $nom = $competence->nom;
        $competence->delete();

        return redirect()
            ->route('competences.index')
            ->with('toast_success', 'Compétence "' . $nom . '" supprimée.');
    }

    /* ── Catégories ───────────────────────────────────────────── */

    public function indexCategories(): View
    {
        $categories = CategorieCompetence::withCount('competences')->orderBy('ordre')->get();
        return view('admin.competences.competences_categories', compact('categories'));
    }

    public function storeCategorie(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom'    => ['required', 'string', 'max:100'],
            'icone'  => ['nullable', 'string', 'max:50'],
            'couleur'=> ['nullable', 'string', 'max:20'],
            'ordre'  => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['ordre'] = $validated['ordre'] ?? 0;
        CategorieCompetence::create($validated);

        return redirect()
            ->route('competences.categories')
            ->with('toast_success', 'Catégorie "' . $validated['nom'] . '" créée.');
    }

    public function updateCategorie(Request $request, CategorieCompetence $categorieCompetence): RedirectResponse
    {
        $validated = $request->validate([
            'nom'    => ['required', 'string', 'max:100'],
            'icone'  => ['nullable', 'string', 'max:50'],
            'couleur'=> ['nullable', 'string', 'max:20'],
            'ordre'  => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['ordre'] = $validated['ordre'] ?? 0;
        $categorieCompetence->update($validated);

        return redirect()
            ->route('competences.categories')
            ->with('toast_success', 'Catégorie mise à jour.');
    }

    public function destroyCategorie(CategorieCompetence $categorieCompetence): RedirectResponse
    {
        $nom = $categorieCompetence->nom;
        $categorieCompetence->delete(); // cascade supprime les compétences liées

        return redirect()
            ->route('competences.categories')
            ->with('toast_success', 'Catégorie "' . $nom . '" supprimée.');
    }

    /**
     * Mise à jour du niveau en AJAX (drag ou input direct).
     */
    public function updateNiveau(Request $request, Competence $competence)
    {
        $request->validate(['niveau' => ['required', 'integer', 'min:0', 'max:100']]);
        $competence->update(['niveau' => $request->niveau]);

        return response()->json(['niveau' => $competence->niveau]);
    }
}
