<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ParametreController extends Controller
{
    public function index(): View
    {
        $groupes = Parametre::orderBy('groupe')->orderBy('cle')
            ->get()
            ->groupBy('groupe');

        return view('admin.parametres.parametres_index', compact('groupes'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'parametres'         => ['required', 'array'],
            'parametres.*.valeur'=> ['nullable', 'string'],
        ]);

        foreach ($request->parametres as $id => $item) {
            Parametre::where('id', (int) $id)
                ->update(['valeur' => $item['valeur'] ?? '']);
        }

        return back()->with('toast_success', 'Paramètres enregistrés avec succès.');
    }

    /**
     * Mettre à jour un seul paramètre via AJAX.
     */
    public function updateOne(Request $request)
    {
        $request->validate([
            'cle'    => ['required', 'string', 'exists:parametres,cle'],
            'valeur' => ['nullable', 'string'],
        ]);

        Parametre::where('cle', $request->cle)
            ->update(['valeur' => $request->valeur ?? '']);

        return response()->json(['success' => true]);
    }
}
