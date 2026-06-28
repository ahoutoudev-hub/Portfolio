<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CertificatController extends Controller
{
    public function index(Request $request): View
    {
        $query = Certificat::orderBy('ordre')->orderByDesc('date_obtention');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%')
                  ->orWhere('organisme', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('actif')) {
            $query->where('actif', $request->actif);
        }

        $certificats = $query->paginate(12)->withQueryString();

        $stats = [
            'total'  => Certificat::count(),
            'actifs' => Certificat::where('actif', true)->count(),
            'avec_lien' => Certificat::whereNotNull('url_credential')->count(),
        ];

        return view('admin.certificats.certificats_index', compact('certificats', 'stats'));
    }

    public function create(): View
    {
        return view('admin.certificats.certificats_form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre'          => ['required', 'string', 'max:255'],
            'organisme'      => ['required', 'string', 'max:150'],
            'date_obtention' => ['required', 'date'],
            'url_credential' => ['nullable', 'url', 'max:255'],
            'actif'          => ['boolean'],
            'ordre'          => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['ordre'] = $validated['ordre'] ?? 0;

        Certificat::create($validated);

        return redirect()
            ->route('certificats.index')
            ->with('toast_success', 'Certificat "' . $validated['titre'] . '" créé.');
    }

    public function edit(Certificat $certificat): View
    {
        return view('admin.certificats.certificats_form', compact('certificat'));
    }

    public function update(Request $request, Certificat $certificat): RedirectResponse
    {
        $validated = $request->validate([
            'titre'          => ['required', 'string', 'max:255'],
            'organisme'      => ['required', 'string', 'max:150'],
            'date_obtention' => ['required', 'date'],
            'url_credential' => ['nullable', 'url', 'max:255'],
            'actif'          => ['boolean'],
            'ordre'          => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['actif'] = $request->boolean('actif', true);
        $validated['ordre'] = $validated['ordre'] ?? 0;

        $certificat->update($validated);

        return redirect()
            ->route('certificats.index')
            ->with('toast_success', 'Certificat "' . $certificat->titre . '" mis à jour.');
    }

    public function destroy(Certificat $certificat): RedirectResponse
    {
        $titre = $certificat->titre;
        $certificat->delete();

        return redirect()
            ->route('certificats.index')
            ->with('toast_success', 'Certificat "' . $titre . '" supprimé.');
    }

    public function toggleActif(Certificat $certificat)
    {
        $certificat->update(['actif' => !$certificat->actif]);

        return response()->json([
            'actif'   => $certificat->actif,
            'message' => $certificat->actif ? 'Certificat affiché.' : 'Certificat masqué.',
        ]);
    }
}
