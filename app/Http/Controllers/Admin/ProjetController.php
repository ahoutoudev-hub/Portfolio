<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjetController extends Controller
{
    public function index(Request $request): View
    {
        $query = Projet::with('tags')->orderBy('ordre')->orderByDesc('updated_at');

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%' . $request->search . '%');
        }

        $projets = $query->paginate(12)->withQueryString();

        $stats = [
            'total'    => Projet::count(),
            'publies'  => Projet::where('statut', 'publié')->count(),
            'vedette'  => Projet::where('en_vedette', true)->count(),
            'archive'  => Projet::where('statut', 'archivé')->count(),
            'brouillon'=> Projet::where('statut', 'brouillon')->count(),
        ];

        return view('admin.projets.projets_index', compact('projets', 'stats'));
    }

    public function create(): View
    {
        $tags         = Tag::orderBy('nom')->get();
        $selectedTags = [];
        return view('admin.projets.projets_form', compact('tags', 'selectedTags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'titre'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'contenu'     => ['nullable', 'string'],
            'statut'      => ['required', 'in:brouillon,publié,archivé'],
            'en_vedette'  => ['boolean'],
            'ordre'       => ['nullable', 'integer'],
            'type_projet' => ['nullable', 'string', 'max:100'],
            'role'        => ['nullable', 'string', 'max:150'],
            'client'      => ['nullable', 'string', 'max:150'],
            'duree'       => ['nullable', 'string', 'max:80'],
            'date_debut'  => ['nullable', 'date'],
            'date_fin'    => ['nullable', 'date'],
            'url_demo'    => ['nullable', 'url', 'max:255'],
            'url_github'  => ['nullable', 'url', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['integer', 'exists:tags,id'],
            'fonctionnalites'   => ['nullable', 'array'],
            'fonctionnalites.*' => ['nullable', 'string'],
            'defis_challenge'   => ['nullable', 'array'],
            'defis_challenge.*' => ['nullable', 'string'],
            'defis_solution'    => ['nullable', 'array'],
            'defis_solution.*'  => ['nullable', 'string'],
        ]);

        $galerieRules = [
            'galerie'                     => ['nullable', 'array'],
            'galerie.*'                   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'galerie_nouvelles_legendes'  => ['nullable', 'array'],
            'galerie_nouvelles_legendes.*'=> ['nullable', 'string', 'max:255'],
            'galerie_supprimer'           => ['nullable', 'array'],
            'galerie_supprimer.*'         => ['nullable', 'integer', 'exists:projet_images,id'],
            'galerie_legendes'            => ['nullable', 'array'],
        ];
        $request->validate($galerieRules);

        $validated['en_vedette'] = $request->boolean('en_vedette');
        $validated['slug']       = $this->uniqueSlug($validated['slug'] ?: Str::slug($validated['titre']));

        // Image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projets', 'public');
        }

        // Fonctionnalités → filtrer les vides
        $fonctionnalites = collect($request->input('fonctionnalites', []))
            ->filter(fn($v) => !empty(trim($v)))
            ->values()
            ->toArray();
        $validated['fonctionnalites'] = !empty($fonctionnalites) ? $fonctionnalites : null;

        // Défis → combiner challenge + solution
        $challenges = $request->input('defis_challenge', []);
        $solutions  = $request->input('defis_solution', []);
        $defis = collect($challenges)
            ->map(fn($c, $i) => [
                'challenge' => trim($c ?? ''),
                'solution'  => trim($solutions[$i] ?? ''),
            ])
            ->filter(fn($d) => !empty($d['challenge']))
            ->values()
            ->toArray();
        $validated['defis'] = !empty($defis) ? $defis : null;

        unset($validated['defis_challenge'], $validated['defis_solution']);

        $projet = Projet::create($validated);
        $projet->tags()->sync($request->input('tags', []));
        $this->syncGalerie($projet, $request);

        return redirect()
            ->route('projets.index')
            ->with('toast_success', 'Projet "' . $projet->titre . '" créé avec succès.');
    }

    public function edit(Projet $projet): View
    {
        $tags         = Tag::orderBy('nom')->get();
        $selectedTags = $projet->tags->pluck('id')->toArray();
        return view('admin.projets.projets_form', compact('projet', 'tags', 'selectedTags'));
    }

    public function update(Request $request, Projet $projet): RedirectResponse
    {
        $validated = $request->validate([
            'titre'       => ['required', 'string', 'max:255'],
            'slug'        => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'contenu'     => ['nullable', 'string'],
            'statut'      => ['required', 'in:brouillon,publié,archivé'],
            'en_vedette'  => ['boolean'],
            'ordre'       => ['nullable', 'integer'],
            'type_projet' => ['nullable', 'string', 'max:100'],
            'role'        => ['nullable', 'string', 'max:150'],
            'client'      => ['nullable', 'string', 'max:150'],
            'duree'       => ['nullable', 'string', 'max:80'],
            'date_debut'  => ['nullable', 'date'],
            'date_fin'    => ['nullable', 'date'],
            'url_demo'    => ['nullable', 'url', 'max:255'],
            'url_github'  => ['nullable', 'url', 'max:255'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'tags'        => ['nullable', 'array'],
            'tags.*'      => ['integer', 'exists:tags,id'],
            'fonctionnalites'   => ['nullable', 'array'],
            'fonctionnalites.*' => ['nullable', 'string'],
            'defis_challenge'   => ['nullable', 'array'],
            'defis_challenge.*' => ['nullable', 'string'],
            'defis_solution'    => ['nullable', 'array'],
            'defis_solution.*'  => ['nullable', 'string'],
        ]);

        $galerieRules = [
            'galerie'                     => ['nullable', 'array'],
            'galerie.*'                   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'galerie_nouvelles_legendes'  => ['nullable', 'array'],
            'galerie_nouvelles_legendes.*'=> ['nullable', 'string', 'max:255'],
            'galerie_supprimer'           => ['nullable', 'array'],
            'galerie_supprimer.*'         => ['nullable', 'integer', 'exists:projet_images,id'],
            'galerie_legendes'            => ['nullable', 'array'],
        ];
        $request->validate($galerieRules);

        $validated['en_vedette'] = $request->boolean('en_vedette');

        // Slug
        $newSlug = $validated['slug'] ?: Str::slug($validated['titre']);
        if ($newSlug !== $projet->slug) {
            $validated['slug'] = $this->uniqueSlug($newSlug, $projet->id);
        }

        // Image
        if ($request->boolean('supprimer_image') && $projet->image) {
            Storage::disk('public')->delete($projet->image);
            $validated['image'] = null;
        }
        if ($request->hasFile('image')) {
            if ($projet->image) Storage::disk('public')->delete($projet->image);
            $validated['image'] = $request->file('image')->store('projets', 'public');
        }

        // Fonctionnalités
        $fonctionnalites = collect($request->input('fonctionnalites', []))
            ->filter(fn($v) => !empty(trim($v)))
            ->values()->toArray();
        $validated['fonctionnalites'] = !empty($fonctionnalites) ? $fonctionnalites : null;

        // Défis
        $challenges = $request->input('defis_challenge', []);
        $solutions  = $request->input('defis_solution', []);
        $defis = collect($challenges)
            ->map(fn($c, $i) => [
                'challenge' => trim($c ?? ''),
                'solution'  => trim($solutions[$i] ?? ''),
            ])
            ->filter(fn($d) => !empty($d['challenge']))
            ->values()->toArray();
        $validated['defis'] = !empty($defis) ? $defis : null;

        unset($validated['defis_challenge'], $validated['defis_solution']);

        $projet->update($validated);
        $projet->tags()->sync($request->input('tags', []));
        $this->syncGalerie($projet, $request); 

        return redirect()
            ->route('projets.index')
            ->with('toast_success', 'Projet "' . $projet->titre . '" mis à jour.');
    }

    public function destroy(Projet $projet): RedirectResponse
    {
        if ($projet->image) Storage::disk('public')->delete($projet->image);
        $titre = $projet->titre;
        $projet->delete();

        return redirect()
            ->route('projets.index')
            ->with('toast_success', 'Projet "' . $titre . '" supprimé.');
    }

    public function toggleVedette(Projet $projet)
    {
        $projet->update(['en_vedette' => !$projet->en_vedette]);
        return response()->json(['en_vedette' => $projet->en_vedette]);
    }

    private function uniqueSlug(string $slug, int $excludeId = 0): string
    {
        $original = $slug;
        $i = 1;
        while (Projet::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }

    private function syncGalerie(Projet $projet, Request $request): void
    {
        // 1. Supprimer les images cochées
        $toDelete = $request->input('galerie_supprimer', []);
        if (!empty($toDelete)) {
            $images = $projet->images()->whereIn('id', $toDelete)->get();
            foreach ($images as $img) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($img->image);
                $img->delete();
            }
        }
    
        // 2. Mettre à jour les légendes des images existantes
        $legendes = $request->input('galerie_legendes', []);
        foreach ($legendes as $id => $legende) {
            $projet->images()->where('id', $id)->update(['legende' => $legende ?: null]);
        }
    
        // 3. Uploader les nouvelles images
        if ($request->hasFile('galerie')) {
            $nouvellesLegendes = $request->input('galerie_nouvelles_legendes', []);
            $maxOrdre = $projet->images()->max('ordre') ?? 0;
    
            foreach ($request->file('galerie') as $i => $file) {
                if (!$file->isValid()) continue;
    
                $path = $file->store('projets/galerie', 'public');
                $projet->images()->create([
                    'image'   => $path,
                    'legende' => $nouvellesLegendes[$i] ?? null,
                    'ordre'   => $maxOrdre + $i + 1,
                ]);
            }
        }
    }
}