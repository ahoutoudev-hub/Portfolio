<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('projets')->orderBy('nom')->get();

        return view('admin.tags.tags_index', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom'     => ['required', 'string', 'max:100'],
            'couleur' => ['nullable', 'string', 'max:20'],
        ]);

        $validated['slug']    = $this->uniqueSlug(Str::slug($validated['nom']));
        $validated['couleur'] = $validated['couleur'] ?? '#ff7c08';

        Tag::create($validated);

        return redirect()
            ->route('tags.index')
            ->with('toast_success', 'Tag "' . $validated['nom'] . '" créé.');
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $validated = $request->validate([
            'nom'     => ['required', 'string', 'max:100'],
            'couleur' => ['nullable', 'string', 'max:20'],
        ]);

        $newSlug = Str::slug($validated['nom']);
        if ($newSlug !== $tag->slug) {
            $validated['slug'] = $this->uniqueSlug($newSlug, $tag->id);
        }

        $validated['couleur'] = $validated['couleur'] ?? '#ff7c08';
        $tag->update($validated);

        return redirect()
            ->route('tags.index')
            ->with('toast_success', 'Tag "' . $tag->nom . '" mis à jour.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        if ($tag->projets()->count() > 0) {
            return redirect()
                ->route('tags.index')
                ->with('toast_error', 'Impossible de supprimer "' . $tag->nom . '" : il est utilisé par ' . $tag->projets()->count() . ' projet(s).');
        }

        $nom = $tag->nom;
        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('toast_success', 'Tag "' . $nom . '" supprimé.');
    }

    private function uniqueSlug(string $slug, int $excludeId = 0): string
    {
        $original = $slug;
        $i = 1;
        while (Tag::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = $original . '-' . $i++;
        }
        return $slug;
    }
}
