<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Competence;
use App\Models\CategorieCompetence;
use App\Models\Experience;
use App\Models\Certificat;
use App\Models\Temoignage;
use App\Models\Parametre;
use App\Models\User;
use App\Models\ReseauSocial;
use Illuminate\Http\Request;

class AccueilController extends Controller
{
    
    public function accueil()
    {
        // ── Paramètres du site ──────────────────────────────────
        $params = Parametre::pluck('valeur', 'cle');

        // ── Projets en vedette (section hero + projets) ─────────
        $projetsVedette = Projet::with('tags')
            ->where('statut', 'publié')
            ->where('en_vedette', true)
            ->orderBy('ordre')
            ->take(3)
            ->get();

        // ── Tous les projets publiés ────────────────────────────
        $projets = Projet::with('tags')
            ->where('statut', 'publié')
            ->orderBy('ordre')
            ->orderByDesc('date_fin')
            ->get();

        // ── Compétences groupées par catégorie ──────────────────
        $categoriesCompetences = CategorieCompetence::with(['competences' => function ($q) {
            $q->orderBy('ordre');
        }])
        ->orderBy('ordre')
        ->get();

        // ── Expériences professionnelles ────────────────────────
        $experiencesTravail = Experience::where('type', 'travail')
            ->where('actif', true)
            ->orderBy('ordre')
            ->orderByDesc('date_debut')
            ->get();

        // ── Formations ──────────────────────────────────────────
        $experiencesFormation = Experience::where('type', 'formation')
            ->where('actif', true)
            ->orderBy('ordre')
            ->orderByDesc('date_debut')
            ->get();

        // ── Témoignages ─────────────────────────────────────────
        $temoignages = Temoignage::where('actif', true)
            ->orderBy('ordre')
            ->get();

        // ── Réseaux sociaux ─────────────────────────────────────
        $reseaux = \App\Models\ReseauSocial::where('actif', true)
            ->orderBy('ordre')
            ->get();

        // ── Certificats ─────────────────────────────────────────
        $certificats = Certificat::where('actif', true)
            ->orderBy('ordre')
            ->get();

        return view('portfolio.portfolio', compact(
            'params',
            'projets',
            'projetsVedette',
            'categoriesCompetences',
            'experiencesTravail',
            'experiencesFormation',
            'temoignages',
            'reseaux',
            'certificats',
        ));
    }

    public function apropos()
    {
        $params = Parametre::pluck('valeur', 'cle');
        $user   = User::where('role', 'admin')->first(); // ← ajout

        $experiencesTravail = Experience::where('type', 'travail')
            ->where('actif', true)
            ->orderBy('ordre')
            ->orderByDesc('date_debut')
            ->get();

        $experiencesFormation = Experience::where('type', 'formation')
            ->where('actif', true)
            ->orderBy('ordre')
            ->orderByDesc('date_debut')
            ->get();

        // ── Ajout manquant ──
        $categoriesCompetences = \App\Models\CategorieCompetence::with(['competences' => function ($q) {
            $q->orderBy('ordre');
        }])
        ->orderBy('ordre')
        ->get();

        $certificats = Certificat::where('actif', true)
            ->orderBy('ordre')
            ->get();

        $temoignages = Temoignage::where('actif', true)
            ->orderBy('ordre')
            ->get();

        $reseaux = \App\Models\ReseauSocial::where('actif', true)
            ->orderBy('ordre')
            ->get();

        return view('portfolio.apropos', compact(
            'params',
            'user',
            'experiencesTravail',
            'experiencesFormation',
            'categoriesCompetences', // ← ajouté
            'certificats',
            'temoignages',
            'reseaux',
        ));
    }

    public function projets()
    {
        $params = Parametre::pluck('valeur', 'cle');

        $projets = Projet::with('tags')
            ->where('statut', 'publié')
            ->orderBy('ordre')
            ->orderByDesc('date_fin')
            ->get();

        // Tags utilisés (pour les filtres)
        $tags = \App\Models\Tag::whereHas('projets', fn($q) => $q->where('statut', 'publié'))
            ->orderBy('nom')
            ->get();

        return view('portfolio.projets', compact('params', 'projets', 'tags'));
    }

    public function projetDetail(string $slug)
    {
        $projet = \App\Models\Projet::with(['tags', 'images'])
            ->where('statut', 'publié')
            ->where('slug', $slug)
            ->firstOrFail();
    
        // Incrémenter les vues
        $projet->increment('vues');
    
        // Enregistrer la visite
        \App\Models\Visite::create([
            'page'      => '/projets/' . $slug,
            'projet_id' => $projet->id,
            'ip_hash'   => hash('sha256', request()->ip()),
            'appareil'  => $this->detectAppareil(),
            'referrer'  => request()->header('referer'),
            'visite_le' => now(),
        ]);
    
        $params = \App\Models\Parametre::pluck('valeur', 'cle');
    
        // Projets similaires par tags
        $tagIds = $projet->tags->pluck('id');
        $projetsLies = \App\Models\Projet::with('tags')
            ->where('statut', 'publié')
            ->where('id', '!=', $projet->id)
            ->whereHas('tags', fn($q) => $q->whereIn('tags.id', $tagIds))
            ->take(3)
            ->get();
    
        // Si pas assez de projets liés par tags → compléter avec d'autres projets récents
        if ($projetsLies->count() < 2) {
            $extras = \App\Models\Projet::with('tags')
                ->where('statut', 'publié')
                ->where('id', '!=', $projet->id)
                ->whereNotIn('id', $projetsLies->pluck('id'))
                ->orderByDesc('updated_at')
                ->take(3 - $projetsLies->count())
                ->get();
            $projetsLies = $projetsLies->merge($extras);
        }
    
        return view('portfolio.projet-detail', compact('projet', 'params', 'projetsLies'));
    }

    /* ── Helper : détecter l'appareil ── */
    private function detectAppareil(): string
    {
        $ua = strtolower(request()->header('User-Agent') ?? '');

        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad')) {
            return 'tablette';
        }
        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone')) {
            return 'mobile';
        }
        return 'desktop';
    }
}