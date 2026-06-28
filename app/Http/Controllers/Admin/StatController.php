<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visite;
use App\Models\Projet;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class StatController extends Controller
{
    public function index(Request $request): View
    {
        // ── Période sélectionnée ───────────────────────────────
        $periode = $request->get('periode', '30'); // 7, 30, 90, 365
        $debut   = Carbon::now()->subDays((int) $periode);

        // ── Visites par jour (graphique ligne) ─────────────────
        $visitesParJour = collect(range((int)$periode - 1, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);
            return [
                'date'  => $date->format('d/m'),
                'full'  => $date->toDateString(),
                'count' => Visite::whereDate('visite_le', $date)->count(),
            ];
        });

        // ── Totaux de la période ───────────────────────────────
        $visitesTotalPeriode  = Visite::where('visite_le', '>=', $debut)->count();
        $visitesTotalPrecedent = Visite::whereBetween('visite_le', [
            Carbon::now()->subDays((int)$periode * 2),
            $debut,
        ])->count();
        $evolutionVisites = $visitesTotalPrecedent > 0
            ? round((($visitesTotalPeriode - $visitesTotalPrecedent) / $visitesTotalPrecedent) * 100)
            : ($visitesTotalPeriode > 0 ? 100 : 0);

        // ── Appareils ──────────────────────────────────────────
        $appareils = [
            'desktop'  => Visite::where('visite_le', '>=', $debut)->where('appareil', 'desktop')->count(),
            'mobile'   => Visite::where('visite_le', '>=', $debut)->where('appareil', 'mobile')->count(),
            'tablette' => Visite::where('visite_le', '>=', $debut)->where('appareil', 'tablette')->count(),
        ];

        // ── Pages les plus visitées ────────────────────────────
        $topPages = Visite::where('visite_le', '>=', $debut)
            ->selectRaw('page, COUNT(*) as total')
            ->groupBy('page')
            ->orderByDesc('total')
            ->take(8)
            ->get();

        // ── Top projets par vues ───────────────────────────────
        $topProjets = Projet::where('statut', 'publié')
            ->orderByDesc('vues')
            ->take(6)
            ->get(['titre', 'vues', 'image', 'slug', 'date_fin']);

        $maxVues = $topProjets->max('vues') ?: 1;

        // ── Messages par mois (6 derniers mois) ───────────────
        $messagesParMois = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);
            return [
                'label' => $date->translatedFormat('M Y'),
                'count' => Message::whereYear('created_at', $date->year)
                                  ->whereMonth('created_at', $date->month)
                                  ->count(),
            ];
        });

        // ── Résumé messages ────────────────────────────────────
        $messagesStats = [
            'total'     => Message::count(),
            'non_lus'   => Message::where('lu', false)->count(),
            'repondus'  => Message::where('repondu', true)->count(),
            'importants'=> Message::where('important', true)->count(),
            'ce_mois'   => Message::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)->count(),
        ];

        // ── Visites par heure (aujourd'hui) ───────────────────
        $visitesParHeure = collect(range(0, 23))->map(function ($h) {
            return [
                'heure' => str_pad($h, 2, '0', STR_PAD_LEFT) . 'h',
                'count' => Visite::whereDate('visite_le', today())
                                  ->whereRaw('HOUR(visite_le) = ?', [$h])
                                  ->count(),
            ];
        });

        // ── Récapitulatif global ───────────────────────────────
        $recap = [
            'total_visites'   => Visite::count(),
            'visites_auj'     => Visite::whereDate('visite_le', today())->count(),
            'visites_semaine' => Visite::where('visite_le', '>=', Carbon::now()->startOfWeek())->count(),
            'projets_publie'  => Projet::where('statut', 'publié')->count(),
            'total_vues'      => Projet::sum('vues'),
        ];

        return view('admin.stats.stats_index', compact(
            'periode',
            'debut',
            'visitesParJour',
            'visitesTotalPeriode',
            'evolutionVisites',
            'appareils',
            'topPages',
            'topProjets',
            'maxVues',
            'messagesParMois',
            'messagesStats',
            'visitesParHeure',
            'recap',
        ));
    }
}