<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Parametre, Experience, CategorieCompetence, Certificat,
                Projet, LettreMotivation, CvInfo, CvLangue, CvInteret, CvQualite};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CvLettreController extends Controller
{
    /* ── Données communes ── */
    private function cvData(): array
    {
        $user   = Auth::user();
        $params = Parametre::pluck('valeur', 'cle');
        $cvInfo = CvInfo::firstOrNew(['user_id' => $user->id]);

        return [
            'user'   => $user,
            'params' => $params,
            'cvInfo' => $cvInfo,
            'experiencesTravail'    => Experience::where('actif', true)->where('type', 'travail')->orderByDesc('date_debut')->get(),
            'experiencesFormation'  => Experience::where('actif', true)->where('type', 'formation')->orderByDesc('date_debut')->get(),
            'categoriesCompetences' => CategorieCompetence::with(['competences' => fn($q) => $q->orderBy('ordre')])->orderBy('ordre')->get(),
            'certificats'           => Certificat::where('actif', true)->orderBy('ordre')->get(),
            'projets'               => Projet::where('statut', 'publié')->orderBy('ordre')->take(6)->get(),
            'langues'               => CvLangue::where('user_id', $user->id)->orderBy('ordre')->get(),
            'interets'              => CvInteret::where('user_id', $user->id)->orderBy('ordre')->get(),
            'qualites'              => CvQualite::where('user_id', $user->id)->orderBy('ordre')->get(),
            'qrCode'                => QrCode::size(80)->margin(0)->generate($params['site_url'] ?? url('/')),
        ];
    }

    /* ── Index ── */
    public function index(): \Illuminate\View\View
    {
        $data            = $this->cvData();
        $data['lettres'] = LettreMotivation::where('user_id', Auth::id())->orderByDesc('created_at')->take(10)->get();
        return view('admin.cv-lettre.index', $data);
    }

    /* ── Sauvegarde infos CV ── */
    public function saveInfos(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $cvInfo = CvInfo::updateOrCreate(['user_id' => $user->id], [
            'date_naissance'         => $request->date_naissance ?: null,
            'lieu_naissance'         => $request->lieu_naissance,
            'genre'                  => $request->genre,
            'nationalite'            => $request->nationalite,
            'situation_matrimoniale' => $request->situation_matrimoniale,
            'permis'                 => $request->permis,
            'titre_professionnel'    => $request->titre_professionnel,
        ]);

        // Langues
        CvLangue::where('user_id', $user->id)->delete();
        foreach ($request->input('langues', []) as $i => $item) {
            if (!empty(trim($item['langue'] ?? ''))) {
                CvLangue::create(['user_id' => $user->id, 'langue' => $item['langue'], 'niveau' => $item['niveau'] ?? 'courant', 'ordre' => $i]);
            }
        }

        // Intérêts
        CvInteret::where('user_id', $user->id)->delete();
        foreach ($request->input('interets', []) as $i => $item) {
            if (!empty(trim($item['interet'] ?? ''))) {
                CvInteret::create(['user_id' => $user->id, 'interet' => $item['interet'], 'icone' => $item['icone'] ?? null, 'ordre' => $i]);
            }
        }

        // Qualités
        CvQualite::where('user_id', $user->id)->delete();
        foreach ($request->input('qualites', []) as $i => $item) {
            if (!empty(trim($item['qualite'] ?? ''))) {
                CvQualite::create(['user_id' => $user->id, 'qualite' => $item['qualite'], 'icone' => $item['icone'] ?? null, 'ordre' => $i]);
            }
        }

        return back()->with('toast_success', 'Informations du CV sauvegardées.');
    }

    /* ── Aperçu CV (iframe) ── */
    public function previewCv(): \Illuminate\View\View
    {
        return view('admin.cv-lettre.cv-pdf', $this->cvData());
    }

    /* ── Télécharger CV PDF ── */
    public function downloadCv()
    {
        $data = $this->cvData();
        $pdf  = Pdf::loadView('admin.cv-lettre.cv-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'Arial', 'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'dpi' => 150]);

        $nom      = trim(($data['user']->prenom ?? '') . '_' . ($data['user']->nom ?? 'CV'));
        $filename = 'CV_' . str_replace([' ', "'"], '_', $nom) . '.pdf';
        return $pdf->download($filename);
    }

    /* ── Générer lettre ── */
    public function genererLettre(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'entreprise'   => ['required', 'string', 'max:150'],
            'poste'        => ['required', 'string', 'max:150'],
            'type_contrat' => ['required', 'string'],
            'modele'       => ['required', 'string'],
            'date_lettre'  => ['required', 'date'],
        ]);

        $lettre = LettreMotivation::create([
            'user_id'              => Auth::id(),
            'modele'               => $request->modele,
            'entreprise'           => $request->entreprise,
            'recruteur'            => $request->recruteur,
            'poste'                => $request->poste,
            'type_contrat'         => $request->type_contrat,
            'ville'                => $request->ville,
            'date_lettre'          => $request->date_lettre,
            'infos_complementaires'=> $request->infos_complementaires,
        ]);

        return redirect()->route('admin.cv-lettre.lettre.preview', $lettre)->with('toast_success', 'Lettre générée !');
    }

    /* ── Aperçu lettre ── */
    public function previewLettre(LettreMotivation $lettre): \Illuminate\View\View
    {
        abort_if($lettre->user_id !== Auth::id(), 403);
        $data = $this->cvData();
        return view('admin.cv-lettre.lettre-preview', array_merge($data, ['lettre' => $lettre]));
    }

    /* ── HTML lettre (iframe) ── */
    public function lettreHtml(LettreMotivation $lettre): \Illuminate\View\View
    {
        abort_if($lettre->user_id !== Auth::id(), 403);
        $data = $this->cvData();
        return view('admin.cv-lettre.lettre-pdf', array_merge($data, ['lettre' => $lettre]));
    }

    /* ── Download lettre PDF ── */
    public function downloadLettre(LettreMotivation $lettre)
    {
        abort_if($lettre->user_id !== Auth::id(), 403);
        $data = $this->cvData();
        $pdf  = Pdf::loadView('admin.cv-lettre.lettre-pdf', array_merge($data, ['lettre' => $lettre]))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'Arial', 'isHtml5ParserEnabled' => true, 'dpi' => 150]);

        return $pdf->download('Lettre_' . str_replace(' ', '_', $lettre->poste) . '_' . str_replace(' ', '_', $lettre->entreprise) . '.pdf');
    }

    /* ── Supprimer lettre ── */
    public function destroyLettre(LettreMotivation $lettre): \Illuminate\Http\RedirectResponse
    {
        abort_if($lettre->user_id !== Auth::id(), 403);
        $lettre->delete();
        return back()->with('toast_success', 'Lettre supprimée.');
    }
}