<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use App\Models\Message;
use App\Models\Visite;
use App\Models\Competence;
use App\Models\Experience;
use App\Models\Certificat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TableauDeBordController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ── Stats KPI ──────────────────────────────────────────
        $stats = [
            'projets_total'    => Projet::count(),
            'projets_publies'  => Projet::where('statut', 'publié')->count(),
            'projets_vedette'  => Projet::where('en_vedette', true)->count(),
            'messages_total'   => Message::count(),
            'messages_non_lus' => Message::where('lu', false)->count(),
            'competences'      => Competence::count(),
            'experiences'      => Experience::where('actif', true)->count(),
            'certificats'      => Certificat::where('actif', true)->count(),
        ];

        // ── Visites 7 derniers jours (graphique) ───────────────
        $visitesChart = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'date'  => $date->translatedFormat('D d/m'),
                'count' => Visite::whereDate('visite_le', $date)->count(),
            ];
        });

        // ── Vues ce mois vs mois précédent ────────────────────
        $vueMoisActuel = Visite::whereMonth('visite_le', now()->month)
                               ->whereYear('visite_le',  now()->year)
                               ->count();

        $moisPrecedent    = now()->subMonth();
        $vueMoisPrecedent = Visite::whereMonth('visite_le', $moisPrecedent->month)
                                  ->whereYear('visite_le',  $moisPrecedent->year)
                                  ->count();

        $evolutionVues = $vueMoisPrecedent > 0
            ? round((($vueMoisActuel - $vueMoisPrecedent) / $vueMoisPrecedent) * 100)
            : ($vueMoisActuel > 0 ? 100 : 0);

        // ── Projets récents ────────────────────────────────────
        $projetsRecents = Projet::with('tags')
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        // ── Activité récente (messages + projets) ─────────────
        $activite = collect();

        Message::orderByDesc('created_at')->take(3)->get()
            ->each(function ($m) use (&$activite) {
                $activite->push([
                    'type'  => 'message',
                    'ico'   => '📩',
                    'color' => '#3b82f6',
                    'titre' => 'Message de ' . trim($m->prenom . ' ' . $m->nom),
                    'sub'   => $m->sujet ?: 'Aucun sujet',
                    'date'  => $m->created_at,
                ]);
            });

        Projet::orderByDesc('updated_at')->take(3)->get()
            ->each(function ($p) use (&$activite) {
                $activite->push([
                    'type'  => 'projet',
                    'ico'   => '🚀',
                    'color' => '#ff7c08',
                    'titre' => $p->titre,
                    'sub'   => ucfirst($p->statut),
                    'date'  => $p->updated_at,
                ]);
            });

        $activite = $activite->sortByDesc('date')->take(5)->values();

        // ── Top projets (pour la vue — utilisé dans le template) ─
        $topProjets = Projet::where('statut', 'publié')
            ->orderByDesc('vues')
            ->take(5)
            ->get(['titre', 'vues', 'image', 'slug']);

        return view('admin.TableauDeBord', compact(
            'user',
            'stats',
            'visitesChart',
            'vueMoisActuel',
            'evolutionVues',
            'projetsRecents',
            'activite',
            'topProjets',
        ));
    }
}
