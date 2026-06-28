<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Temoignage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TemoignageController extends Controller
{
    public function index(): View
    {
        $temoignages = Temoignage::orderBy('ordre')->orderByDesc('created_at')->get();

        $stats = [
            'total'  => Temoignage::count(),
            'actifs' => Temoignage::where('actif', true)->count(),
            'moy'    => round(Temoignage::avg('note') ?? 0, 1),
        ];

        return view('admin.temoignages.temoignages_index', compact('temoignages', 'stats'));
    }

    public function create(): View
    {
        return view('admin.temoignages.temoignages_form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom'        => ['required', 'string', 'max:150'],
            'poste'      => ['nullable', 'string', 'max:150'],
            'entreprise' => ['nullable', 'string', 'max:150'],
            'contenu'    => ['required', 'string'],
            'note'       => ['required', 'integer', 'min:1', 'max:5'],
            'actif'      => ['boolean'],
            'ordre'      => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Temoignage::create($validated);

        return redirect()
            ->route('temoignages.index')
            ->with('toast_success', 'Témoignage de "' . $validated['nom'] . '" créé.');
    }

    public function edit(Temoignage $temoignage): View
    {
        return view('admin.temoignages.temoignages_form', compact('temoignage'));
    }

    public function update(Request $request, Temoignage $temoignage): RedirectResponse
    {
        $validated = $request->validate([
            'nom'        => ['required', 'string', 'max:150'],
            'poste'      => ['nullable', 'string', 'max:150'],
            'entreprise' => ['nullable', 'string', 'max:150'],
            'contenu'    => ['required', 'string'],
            'note'       => ['required', 'integer', 'min:1', 'max:5'],
            'actif'      => ['boolean'],
            'ordre'      => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $temoignage->update($validated);

        return redirect()
            ->route('temoignages.index')
            ->with('toast_success', 'Témoignage de "' . $temoignage->nom . '" mis à jour.');
    }

    public function destroy(Temoignage $temoignage): RedirectResponse
    {
        $nom = $temoignage->nom;
        $temoignage->delete();

        return redirect()
            ->route('temoignages.index')
            ->with('toast_success', 'Témoignage de "' . $nom . '" supprimé.');
    }

    public function toggleActif(Temoignage $temoignage)
    {
        $temoignage->update(['actif' => !$temoignage->actif]);

        return response()->json([
            'actif'   => $temoignage->actif,
            'message' => $temoignage->actif ? 'Témoignage affiché.' : 'Témoignage masqué.',
        ]);
    }
}
