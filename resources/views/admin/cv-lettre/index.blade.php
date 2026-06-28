@extends('layouts_admin.master_admin')
@section('title', 'CV & Lettre de motivation')

@section('content')

{{-- ══ EN-TÊTE ══ --}}
<div class="doc-header">
  <div class="doc-header-left">
    <div class="doc-header-icon">
      <i class="bi bi-file-earmark-person-fill"></i>
    </div>
    <div>
      <div class="doc-eyebrow">Documents professionnels</div>
      <h1 class="doc-title">CV & Lettre de motivation</h1>
      <p class="doc-subtitle">Générez, personnalisez et téléchargez vos documents en PDF.</p>
    </div>
  </div>
  <div class="doc-header-actions">
    <a href="{{ route('admin.cv-lettre.cv.download') }}" class="doc-btn-dl">
      <i class="bi bi-download"></i>
      <span>Télécharger CV</span>
    </a>
  </div>
</div>

{{-- ══ TABS ══ --}}
<div class="doc-tabs-wrap">
  <div class="doc-tabs">
    <button class="doc-tab doc-tab--active" onclick="switchDocTab('cv', this)" data-tab="cv">
      <i class="bi bi-file-earmark-person"></i>
      <span>Mon CV</span>
    </button>
    <button class="doc-tab" onclick="switchDocTab('lettre', this)" data-tab="lettre">
      <i class="bi bi-envelope-paper-fill"></i>
      <span>Lettre de motivation</span>
      @if($lettres->count())
        <span class="doc-tab-badge">{{ $lettres->count() }}</span>
      @endif
    </button>
    <button class="doc-tab" onclick="switchDocTab('infos', this)" data-tab="infos">
      <i class="bi bi-sliders2"></i>
      <span>Infos du CV</span>
    </button>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     ONGLET 1 — MON CV
══════════════════════════════════════════════ --}}
<div id="tab-cv" class="doc-panel">
  <div class="cv-panel-grid">

    {{-- Colonne principale : aperçu --}}
    <div class="cv-preview-col">
      <div class="doc-card">
        <div class="doc-card-head">
          <span class="doc-card-ico"><i class="bi bi-eye-fill"></i></span>
          <span class="doc-card-titre">Aperçu du CV</span>
          <div class="doc-card-actions ms-auto">
            <button class="doc-icon-btn" onclick="refreshPreview()" title="Actualiser l'aperçu">
              <i class="bi bi-arrow-clockwise"></i>
            </button>
            <a href="{{ route('admin.cv-lettre.cv.download') }}" class="doc-btn-dl-sm">
              <i class="bi bi-download"></i> PDF
            </a>
          </div>
        </div>
        <div class="cv-frame-wrap">
          {{-- Placeholder affiché avant de charger l'aperçu --}}
          <div class="cv-frame-placeholder" id="cvFramePlaceholder">
            <div class="cv-frame-ph-inner">
              <div class="cv-frame-ph-ico"><i class="bi bi-file-earmark-person-fill"></i></div>
              <div class="cv-frame-ph-title">Aperçu du CV</div>
              <p class="cv-frame-ph-hint">La génération du PDF peut prendre quelques secondes.</p>
              <button class="cv-frame-ph-btn" onclick="loadCvPreview()">
                <i class="bi bi-eye"></i> Charger l'aperçu
              </button>
            </div>
          </div>
          {{-- Iframe chargé à la demande --}}
          <iframe id="cvPreviewFrame"
            title="Aperçu CV"
            style="display:none;width:100%;height:900px;border:none;background:#fff"></iframe>
          <div class="cv-frame-overlay" id="cvFrameOverlay" style="display:none">
            <div class="cv-frame-overlay-inner">
              <div class="cv-frame-spinner"></div>
              <p>Génération du PDF…</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Colonne droite : stats + QR + liens --}}
    <div class="cv-sidebar-col">

      {{-- Statut des données --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#10b981"><i class="bi bi-bar-chart-fill"></i></span>
          <span class="doc-card-titre">Données du CV</span>
          <span class="doc-card-badge ms-auto">{{ now()->format('d/m/Y') }}</span>
        </div>
        <div class="doc-card-body p-0">
          @php
            $dataRows = [
              ['ico'=>'bi-person-fill','color'=>'#6366f1','label'=>'Identité','val'=>$user->prenom.' '.$user->nom,'ok'=>true],
              ['ico'=>'bi-briefcase-fill','color'=>'#f59e0b','label'=>'Expériences','val'=>$experiencesTravail->count().' enregistrée(s)','ok'=>$experiencesTravail->count()>0],
              ['ico'=>'bi-mortarboard-fill','color'=>'#3b82f6','label'=>'Formations','val'=>$experiencesFormation->count().' enregistrée(s)','ok'=>$experiencesFormation->count()>0],
              ['ico'=>'bi-lightning-charge-fill','color'=>'#ec4899','label'=>'Compétences','val'=>$categoriesCompetences->sum(fn($c)=>$c->competences->count()).' enregistrée(s)','ok'=>true],
              ['ico'=>'bi-trophy-fill','color'=>'#f59e0b','label'=>'Certificats','val'=>$certificats->count().' enregistré(s)','ok'=>$certificats->count()>0],
              ['ico'=>'bi-rocket-takeoff-fill','color'=>'#10b981','label'=>'Projets','val'=>$projets->count().' publiés','ok'=>true],
            ];
          @endphp
          @foreach($dataRows as $row)
          <div class="cv-stat-row">
            <div class="cv-stat-ico" style="background:{{ $row['color'] }}18;color:{{ $row['color'] }}">
              <i class="bi {{ $row['ico'] }}"></i>
            </div>
            <div class="cv-stat-text">
              <div class="cv-stat-label">{{ $row['label'] }}</div>
              <div class="cv-stat-val">{{ $row['val'] }}</div>
            </div>
            <div class="cv-stat-chip {{ $row['ok'] ? 'cv-stat-chip--ok' : 'cv-stat-chip--warn' }}">
              <i class="bi {{ $row['ok'] ? 'bi-check-lg' : 'bi-exclamation' }}"></i>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- QR Code --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico"><i class="bi bi-qr-code"></i></span>
          <span class="doc-card-titre">QR Code Portfolio</span>
        </div>
        <div class="doc-card-body text-center">
          <div class="cv-qr-wrap">
            {!! QrCode::size(110)->margin(1)->generate($params['site_url'] ?? url('/')) !!}
          </div>
          <p class="doc-hint mt-3">
            Intégré automatiquement dans le PDF.<br>
            Redirige vers : <strong style="color:var(--primary)">{{ Str::limit($params['site_url'] ?? url('/'), 30) }}</strong>
          </p>
          @if(!($params['site_url'] ?? null))
            <div class="doc-alert-warn">
              <i class="bi bi-exclamation-triangle-fill"></i>
              Configurez <code>site_url</code> dans
              <a href="{{ route('parametres.index') }}">Paramètres → Site</a>
            </div>
          @endif
        </div>
      </div>

      {{-- Liens rapides --}}
      <div class="doc-card">
        <div class="doc-card-head">
          <span class="doc-card-ico"><i class="bi bi-lightning-charge-fill"></i></span>
          <span class="doc-card-titre">Mise à jour rapide</span>
        </div>
        <div class="doc-card-body p-0">
          @foreach([
            ['route'=>'experiences.index', 'ico'=>'bi-briefcase-fill',   'label'=>'Gérer les expériences', 'color'=>'#f59e0b'],
            ['route'=>'competences.index', 'ico'=>'bi-lightning-charge-fill', 'label'=>'Gérer les compétences', 'color'=>'#ec4899'],
            ['route'=>'certificats.index', 'ico'=>'bi-trophy-fill',      'label'=>'Gérer les certificats',  'color'=>'#10b981'],
            ['route'=>'profil.index',      'ico'=>'bi-person-fill',       'label'=>'Modifier le profil',     'color'=>'#6366f1'],
          ] as $lien)
          <a href="{{ route($lien['route']) }}" class="doc-quick-link">
            <span class="doc-quick-ico" style="color:{{ $lien['color'] }}"><i class="bi {{ $lien['ico'] }}"></i></span>
            {{ $lien['label'] }}
            <i class="bi bi-chevron-right ms-auto" style="font-size:.65rem;opacity:.4"></i>
          </a>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     ONGLET 2 — LETTRE DE MOTIVATION
══════════════════════════════════════════════ --}}
<div id="tab-lettre" class="doc-panel" style="display:none">
  <div class="row g-4">

    {{-- Formulaire --}}
    <div class="col-lg-5">
      <div class="doc-card h-100">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#6366f1"><i class="bi bi-pencil-fill"></i></span>
          <span class="doc-card-titre">Générer une lettre</span>
        </div>
        <div class="doc-card-body">
          <form method="POST" action="{{ route('admin.cv-lettre.lettre.generer') }}" id="lettreForm">
            @csrf

            {{-- Modèle --}}
            <div class="f-field">
              <label class="f-label">Modèle <span class="f-req">*</span></label>
              <div class="modeles-grid">
                @foreach([
                  ['slug'=>'classique', 'nom'=>'Classique', 'ico'=>'bi-file-text-fill',   'desc'=>'Sobre et professionnel', 'color'=>'#6366f1'],
                  ['slug'=>'moderne',   'nom'=>'Moderne',   'ico'=>'bi-stars',             'desc'=>'Design contemporain',    'color'=>'#ec4899'],
                  ['slug'=>'colore',    'nom'=>'Coloré',    'ico'=>'bi-palette-fill',      'desc'=>'Accent couleur portfolio','color'=>'#f59e0b'],
                ] as $m)
                <label class="modele-card {{ $m['slug']==='classique' ? 'modele-card--active' : '' }}">
                  <input type="radio" name="modele" value="{{ $m['slug'] }}" {{ $m['slug']==='classique' ? 'checked' : '' }}>
                  <span class="modele-ico" style="color:{{ $m['color'] }}"><i class="bi {{ $m['ico'] }}"></i></span>
                  <span class="modele-nom">{{ $m['nom'] }}</span>
                  <span class="modele-desc">{{ $m['desc'] }}</span>
                </label>
                @endforeach
              </div>
            </div>

            {{-- Entreprise + Poste --}}
            <div class="f-field-row">
              <div class="f-field">
                <label class="f-label">Entreprise <span class="f-req">*</span></label>
                <input type="text" name="entreprise" class="f-input @error('entreprise') f-input--err @enderror"
                  placeholder="Ex : Google…" required value="{{ old('entreprise') }}">
                @error('entreprise')<p class="f-err-msg">{{ $message }}</p>@enderror
              </div>
              <div class="f-field">
                <label class="f-label">Recruteur <span class="f-label-opt">optionnel</span></label>
                <input type="text" name="recruteur" class="f-input"
                  placeholder="M. Konan Jean-Baptiste" value="{{ old('recruteur') }}">
              </div>
            </div>

            <div class="f-field">
              <label class="f-label">Poste recherché <span class="f-req">*</span></label>
              <input type="text" name="poste" class="f-input @error('poste') f-input--err @enderror"
                placeholder="Ex : Développeur Full-Stack Laravel" required value="{{ old('poste') }}">
              @error('poste')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Type de contrat --}}
            <div class="f-field">
              <label class="f-label">Type de contrat <span class="f-req">*</span></label>
              <div class="contrat-pills">
                @foreach(['cdi'=>'CDI','cdd'=>'CDD','stage'=>'Stage','alternance'=>'Alternance','freelance'=>'Freelance','mission'=>'Mission','interim'=>'Intérim'] as $val=>$lbl)
                <label class="contrat-pill">
                  <input type="radio" name="type_contrat" value="{{ $val }}" {{ old('type_contrat','cdi')===$val ? 'checked' : '' }}>
                  {{ $lbl }}
                </label>
                @endforeach
              </div>
              @error('type_contrat')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Ville + Date --}}
            <div class="f-field-row">
              <div class="f-field">
                <label class="f-label">Ville</label>
                <input type="text" name="ville" class="f-input"
                  placeholder="{{ $params['site_ville'] ?? 'Abidjan' }}"
                  value="{{ old('ville', $params['site_ville'] ?? '') }}">
              </div>
              <div class="f-field">
                <label class="f-label">Date <span class="f-req">*</span></label>
                <input type="date" name="date_lettre" class="f-input"
                  value="{{ old('date_lettre', now()->format('Y-m-d')) }}" required>
              </div>
            </div>

            {{-- Infos complémentaires --}}
            <div class="f-field mb-0">
              <label class="f-label">Informations complémentaires</label>
              <textarea name="infos_complementaires" class="f-input f-textarea" rows="3"
                placeholder="Ex : Disponible immédiatement, télétravail possible…">{{ old('infos_complementaires') }}</textarea>
            </div>

            <button type="submit" class="f-btn-submit mt-4" id="lettreSubmitBtn">
              <i class="bi bi-file-earmark-check-fill"></i>
              <span>Générer la lettre</span>
            </button>
          </form>
        </div>
      </div>
    </div>

    {{-- Historique --}}
    <div class="col-lg-7">
      <div class="doc-card h-100">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#ec4899"><i class="bi bi-collection-fill"></i></span>
          <span class="doc-card-titre">Lettres générées</span>
          <span class="doc-card-badge ms-auto">{{ $lettres->count() }}</span>
        </div>

        @if($lettres->isNotEmpty())
        <div class="lettre-list">
          @foreach($lettres as $lettre)
          <div class="lettre-item">
            <div class="lettre-item-ico lettre-ico--{{ $lettre->modele ?? 'classique' }}">
              {!! match($lettre->type_contrat) {
                'stage'                => '<i class="bi bi-mortarboard-fill"></i>',
                'freelance','mission'  => '<i class="bi bi-briefcase-fill"></i>',
                'alternance'           => '<i class="bi bi-arrow-repeat"></i>',
                default                => '<i class="bi bi-file-earmark-text-fill"></i>',
              } !!}
            </div>
            <div class="lettre-item-body">
              <div class="lettre-item-title">
                {{ $lettre->poste }}
                <span class="lettre-badge-contrat">{{ $lettre->type_contrat_label }}</span>
                @if($lettre->modele && $lettre->modele !== 'classique')
                  <span class="lettre-badge-modele">{{ ucfirst($lettre->modele) }}</span>
                @endif
              </div>
              <div class="lettre-item-meta">
                <i class="bi bi-building"></i> {{ $lettre->entreprise }}
                @if($lettre->ville) · <i class="bi bi-geo-alt"></i> {{ $lettre->ville }} @endif
                · <i class="bi bi-calendar3"></i> {{ $lettre->date_lettre->translatedFormat('d M Y') }}
              </div>
            </div>
            <div class="lettre-item-actions">
              <a href="{{ route('admin.cv-lettre.lettre.preview', $lettre) }}"
                class="lettre-btn lettre-btn--view" title="Aperçu">
                <i class="bi bi-eye"></i>
              </a>
              <a href="{{ route('admin.cv-lettre.lettre.download', $lettre) }}"
                class="lettre-btn lettre-btn--dl" title="Télécharger PDF">
                <i class="bi bi-download"></i>
              </a>
              <button type="button"
                class="lettre-btn lettre-btn--del"
                title="Supprimer"
                onclick="confirmDelete('{{ route('admin.cv-lettre.lettre.destroy', $lettre) }}', 'lettre pour {{ addslashes($lettre->poste) }} chez {{ addslashes($lettre->entreprise) }}')">
                <i class="bi bi-trash3"></i>
              </button>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="lettre-empty">
          <div class="lettre-empty-ico"><i class="bi bi-envelope-paper"></i></div>
          <div class="lettre-empty-title">Aucune lettre générée</div>
          <p>Remplissez le formulaire pour créer votre première lettre de motivation.</p>
        </div>
        @endif

      </div>
    </div>
  </div>
</div>

{{-- ══════════════════════════════════════════════
     ONGLET 3 — INFOS DU CV
══════════════════════════════════════════════ --}}
<div id="tab-infos" class="doc-panel" style="display:none">

  <form method="POST" action="{{ route('admin.cv-lettre.cv.infos.save') }}" id="cvInfosForm">
  @csrf

  <div class="row g-4">

    {{-- Colonne gauche --}}
    <div class="col-lg-7">

      {{-- Informations personnelles --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#6366f1"><i class="bi bi-person-vcard-fill"></i></span>
          <span class="doc-card-titre">Informations personnelles</span>
          <span class="doc-card-hint">affichées dans la sidebar du CV</span>
        </div>
        <div class="doc-card-body">
          <div class="f-field-row">
            <div class="f-field">
              <label class="f-label">Date de naissance</label>
              <input type="date" name="date_naissance" class="f-input"
                value="{{ $cvInfo->date_naissance?->format('Y-m-d') ?? '' }}">
            </div>
            <div class="f-field">
              <label class="f-label">Lieu de naissance</label>
              <input type="text" name="lieu_naissance" class="f-input"
                placeholder="Ex : Daloa, Côte d'Ivoire"
                value="{{ $cvInfo->lieu_naissance ?? '' }}">
            </div>
          </div>
          <div class="f-field-row">
            <div class="f-field">
              <label class="f-label">Genre</label>
              <div class="f-select-wrap">
                <select name="genre" class="f-input f-select">
                  <option value="">— Sélectionner —</option>
                  @foreach(['homme'=>'Homme','femme'=>'Femme','autre'=>'Autre'] as $v=>$l)
                    <option value="{{ $v }}" {{ ($cvInfo->genre ?? '')=== $v ? 'selected' : '' }}>{{ $l }}</option>
                  @endforeach
                </select>
                <svg class="f-select-arr" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
              </div>
            </div>
            <div class="f-field">
              <label class="f-label">Nationalité</label>
              <input type="text" name="nationalite" class="f-input"
                placeholder="Ex : Ivoirienne"
                value="{{ $cvInfo->nationalite ?? '' }}">
            </div>
          </div>
          <div class="f-field-row">
            <div class="f-field">
              <label class="f-label">Situation matrimoniale</label>
              <div class="f-select-wrap">
                <select name="situation_matrimoniale" class="f-input f-select">
                  <option value="">— Sélectionner —</option>
                  @foreach(['célibataire'=>'Célibataire','marié(e)'=>'Marié(e)','divorcé(e)'=>'Divorcé(e)','veuf/veuve'=>'Veuf/Veuve','pacsé(e)'=>'Pacsé(e)'] as $v=>$l)
                    <option value="{{ $v }}" {{ ($cvInfo->situation_matrimoniale ?? '')=== $v ? 'selected' : '' }}>{{ $l }}</option>
                  @endforeach
                </select>
                <svg class="f-select-arr" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
              </div>
            </div>
            <div class="f-field">
              <label class="f-label">Permis de conduire</label>
              <input type="text" name="permis" class="f-input"
                placeholder="Ex : B, Aucun"
                value="{{ $cvInfo->permis ?? '' }}">
            </div>
          </div>
          <div class="f-field mb-0">
            <label class="f-label">Titre professionnel <span class="f-label-hint">affiché sous votre nom</span></label>
            <input type="text" name="titre_professionnel" class="f-input"
              placeholder="Ex : Développeur Full-Stack & Data Analytics"
              value="{{ $cvInfo->titre_professionnel ?? ($params['site_poste'] ?? '') }}">
          </div>
        </div>
      </div>

      {{-- Langues --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#3b82f6"><i class="bi bi-translate"></i></span>
          <span class="doc-card-titre">Langues parlées</span>
        </div>
        <div class="doc-card-body">
          <div id="languesList">
            @forelse($langues as $i => $langue)
            <div class="cv-dyn-row">
              <div class="cv-dyn-fields">
                <input type="text" name="langues[{{ $i }}][langue]"
                  class="f-input" placeholder="Ex : Français"
                  value="{{ $langue->langue }}">
                <div class="f-select-wrap" style="flex:1">
                  <select name="langues[{{ $i }}][niveau]" class="f-input f-select">
                    @foreach(\App\Models\CvLangue::NIVEAUX as $val => $info)
                      <option value="{{ $val }}" {{ $langue->niveau===$val ? 'selected' : '' }}>{{ $info['label'] }}</option>
                    @endforeach
                  </select>
                  <svg class="f-select-arr" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
                </div>
              </div>
              <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            </div>
            @empty
            <div class="cv-dyn-row">
              <div class="cv-dyn-fields">
                <input type="text" name="langues[0][langue]" class="f-input" placeholder="Ex : Français" value="Français">
                <div class="f-select-wrap" style="flex:1">
                  <select name="langues[0][niveau]" class="f-input f-select">
                    @foreach(\App\Models\CvLangue::NIVEAUX as $val => $info)
                      <option value="{{ $val }}" {{ $val==='natif' ? 'selected' : '' }}>{{ $info['label'] }}</option>
                    @endforeach
                  </select>
                  <svg class="f-select-arr" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
                </div>
              </div>
              <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            </div>
            @endforelse
          </div>
          <button type="button" class="cv-dyn-add" onclick="addLangue()">
            <i class="bi bi-plus-lg"></i> Ajouter une langue
          </button>
        </div>
      </div>

    </div>

    {{-- Colonne droite --}}
    <div class="col-lg-5">

      {{-- Centres d'intérêt --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#f59e0b"><i class="bi bi-star-fill"></i></span>
          <span class="doc-card-titre">Centres d'intérêt</span>
        </div>
        <div class="doc-card-body">
          <div id="interetsList">
            @php $defaultInterets = $interets->isNotEmpty() ? $interets : collect([
              (object)['interet'=>'Jeux vidéos','icone'=>'🎮'],
              (object)['interet'=>'Documentaire','icone'=>'📽️'],
              (object)['interet'=>'Football','icone'=>'⚽'],
              (object)['interet'=>'Athlétisme','icone'=>'🏃'],
              (object)['interet'=>'Hackathons tech','icone'=>'💻'],
            ]); @endphp
            @foreach($defaultInterets as $i => $item)
            <div class="cv-dyn-row">
              <div class="cv-dyn-fields">
                <input type="text" name="interets[{{ $i }}][icone]"
                  class="f-input cv-emoji-input" placeholder="🎯"
                  value="{{ $item->icone ?? '' }}" maxlength="4">
                <input type="text" name="interets[{{ $i }}][interet]"
                  class="f-input" placeholder="Ex : Football"
                  value="{{ $item->interet ?? '' }}">
              </div>
              <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            </div>
            @endforeach
          </div>
          <button type="button" class="cv-dyn-add" onclick="addInteret()">
            <i class="bi bi-plus-lg"></i> Ajouter un intérêt
          </button>
        </div>
      </div>

      {{-- Qualités --}}
      <div class="doc-card mb-4">
        <div class="doc-card-head">
          <span class="doc-card-ico" style="color:#10b981"><i class="bi bi-lightbulb-fill"></i></span>
          <span class="doc-card-titre">Qualités / Soft skills</span>
        </div>
        <div class="doc-card-body">
          <div id="qualitesList">
            @php $defaultQualites = $qualites->isNotEmpty() ? $qualites : collect([
              (object)['qualite'=>'Rigoureux','icone'=>'✅'],
              (object)['qualite'=>'Responsable','icone'=>'🎯'],
              (object)['qualite'=>'Esprit d\'équipe','icone'=>'🤝'],
              (object)['qualite'=>'Créativité','icone'=>'💡'],
            ]); @endphp
            @foreach($defaultQualites as $i => $item)
            <div class="cv-dyn-row">
              <div class="cv-dyn-fields">
                <input type="text" name="qualites[{{ $i }}][icone]"
                  class="f-input cv-emoji-input" placeholder="✅"
                  value="{{ $item->icone ?? '' }}" maxlength="4">
                <input type="text" name="qualites[{{ $i }}][qualite]"
                  class="f-input" placeholder="Ex : Rigoureux"
                  value="{{ $item->qualite ?? '' }}">
              </div>
              <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
            </div>
            @endforeach
          </div>
          <button type="button" class="cv-dyn-add" onclick="addQualite()">
            <i class="bi bi-plus-lg"></i> Ajouter une qualité
          </button>
        </div>
      </div>

      <button type="submit" class="f-btn-submit">
        <i class="bi bi-floppy-fill"></i> Sauvegarder le CV
      </button>

    </div>
  </div>
  </form>
</div>

@endsection

@push('styles')
<style>
/* ══════════════════════════════════════
   EN-TÊTE
══════════════════════════════════════ */
.doc-header {
  display: flex; align-items: center; justify-content: space-between;
  gap: 20px; flex-wrap: wrap;
  padding: 24px 28px; margin-bottom: 24px;
  background: #fff; border: 1px solid var(--border);
  border-radius: var(--radius); box-shadow: var(--shadow);
  position: relative; overflow: hidden;
}
.doc-header::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, #6366f1, var(--primary), #ec4899);
}
.doc-header-left { display: flex; align-items: center; gap: 18px; }
.doc-header-icon {
  width: 50px; height: 50px; border-radius: 14px;
  background: var(--primary-light); color: var(--primary);
  display: flex; align-items: center; justify-content: center;
  font-size: 1.35rem; flex-shrink: 0;
}
.doc-eyebrow {
  font-family: var(--font-display); font-size: .68rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: .14em; color: var(--primary); margin-bottom: 3px;
}
.doc-title {
  font-family: var(--font-display); font-size: 1.4rem; font-weight: 800;
  color: var(--dark); margin: 0 0 3px;
}
.doc-subtitle { font-size: .82rem; color: var(--muted); margin: 0; }
.doc-btn-dl {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  padding: 10px 20px; border-radius: 10px; text-decoration: none;
  box-shadow: 0 4px 14px rgba(255,124,8,.35); transition: all var(--transition);
}
.doc-btn-dl:hover { background: var(--primary-dark); color: #fff; transform: translateY(-2px); }

/* ══ TABS ══ */
.doc-tabs-wrap { margin-bottom: 24px; }
.doc-tabs {
  display: inline-flex; gap: 3px;
  background: #fff; border: 1px solid var(--border);
  border-radius: 12px; padding: 4px; box-shadow: var(--shadow);
}
.doc-tab {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 9px 22px; border-radius: 9px;
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  color: var(--muted); border: none; background: transparent;
  cursor: pointer; transition: all var(--transition); position: relative;
}
.doc-tab:hover { background: var(--gray-bg); color: var(--text); }
.doc-tab--active { background: var(--dark); color: #fff; }
.doc-tab-badge {
  background: var(--primary); color: #fff;
  font-size: .62rem; font-weight: 800;
  padding: 1px 6px; border-radius: 99px; line-height: 1.6;
}

/* ══ PANEL ══ */
.doc-panel { animation: panelIn .22s ease; }
@@keyframes panelIn { from { opacity:0; transform:translateY(6px) } to { opacity:1; transform:none } }

/* ══ CARDS ══ */
.doc-card {
  background: #fff; border: 1px solid var(--border);
  border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow);
}
.doc-card-head {
  display: flex; align-items: center; gap: 9px;
  padding: 13px 18px; border-bottom: 1px solid var(--border);
  background: var(--gray-bg);
}
.doc-card-ico { font-size: .95rem; line-height: 1; }
.doc-card-titre { font-family: var(--font-display); font-size: .86rem; font-weight: 700; color: var(--dark); }
.doc-card-hint { font-size: .71rem; color: var(--muted); margin-left: 4px; }
.doc-card-badge {
  font-family: var(--font-display); font-size: .68rem; font-weight: 800;
  color: var(--muted); background: var(--border); padding: 2px 9px; border-radius: 99px;
}
.doc-card-actions { display: flex; align-items: center; gap: 8px; }
.doc-card-body { padding: 18px; }
.doc-card-body.p-0 { padding: 0; }
.doc-icon-btn {
  width: 32px; height: 32px; border-radius: 8px;
  background: var(--gray-bg); border: 1px solid var(--border);
  color: var(--muted); display: flex; align-items: center; justify-content: center;
  cursor: pointer; font-size: .9rem; transition: all var(--transition);
}
.doc-icon-btn:hover { background: var(--border); color: var(--dark); }
.doc-btn-dl-sm {
  display: inline-flex; align-items: center; gap: 6px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .76rem;
  padding: 7px 14px; border-radius: 8px; text-decoration: none;
  transition: all var(--transition);
}
.doc-btn-dl-sm:hover { background: var(--primary-dark); color: #fff; }

/* ══ LAYOUT CV ══ */
.cv-panel-grid {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 24px;
  align-items: start;
}
.cv-preview-col .doc-card { height: 100%; }
.cv-frame-wrap { position: relative; background: #f4f4f5; min-height: 340px; }

/* Placeholder */
.cv-frame-placeholder {
  display: flex; align-items: center; justify-content: center;
  min-height: 340px; padding: 40px;
}
.cv-frame-ph-inner { text-align: center; }
.cv-frame-ph-ico {
  font-size: 3.5rem; margin-bottom: 14px;
  color: var(--border);
}
.cv-frame-ph-title {
  font-family: var(--font-display); font-size: 1rem; font-weight: 800;
  color: var(--dark); margin-bottom: 8px;
}
.cv-frame-ph-hint { font-size: .8rem; color: var(--muted); margin-bottom: 20px; }
.cv-frame-ph-btn {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .88rem;
  padding: 11px 24px; border-radius: 10px; border: none; cursor: pointer;
  box-shadow: 0 4px 14px rgba(255,124,8,.35); transition: all var(--transition);
}
.cv-frame-ph-btn:hover { background: var(--primary-dark); transform: translateY(-2px); }

/* Overlay pendant le chargement */
.cv-frame-overlay {
  position: absolute; inset: 0;
  background: rgba(255,255,255,.9);
  display: flex; align-items: center; justify-content: center;
}
.cv-frame-overlay-inner { text-align: center; color: var(--muted); font-size: .82rem; }
.cv-frame-spinner {
  width: 40px; height: 40px; border-radius: 50%;
  border: 3px solid var(--border); border-top-color: var(--primary);
  animation: spin .8s linear infinite; margin: 0 auto 12px;
}

/* ══ STATS DATA ══ */
.cv-stat-row {
  display: flex; align-items: center; gap: 12px;
  padding: 12px 16px; border-bottom: 1px solid var(--border);
}
.cv-stat-row:last-child { border-bottom: none; }
.cv-stat-ico {
  width: 34px; height: 34px; border-radius: 9px;
  display: flex; align-items: center; justify-content: center;
  font-size: .9rem; flex-shrink: 0;
}
.cv-stat-label { font-size: .72rem; color: var(--muted); font-weight: 600; margin-bottom: 1px; }
.cv-stat-val { font-size: .83rem; font-weight: 700; color: var(--dark); }
.cv-stat-chip {
  width: 22px; height: 22px; border-radius: 6px;
  display: flex; align-items: center; justify-content: center;
  font-size: .72rem; font-weight: 800; flex-shrink: 0; margin-left: auto;
}
.cv-stat-chip--ok   { background: rgba(16,185,129,.12); color: var(--success); }
.cv-stat-chip--warn { background: rgba(245,158,11,.12);  color: var(--warning); }

/* ══ QR ══ */
.cv-qr-wrap {
  display: flex; justify-content: center;
  padding: 14px; background: var(--gray-bg);
  border: 1px solid var(--border); border-radius: 10px;
}
.cv-qr-wrap svg { max-width: 110px; }
.doc-hint { font-size: .76rem; color: var(--muted); line-height: 1.5; margin: 0; }
.doc-alert-warn {
  background: rgba(245,158,11,.08); border: 1px solid rgba(245,158,11,.25);
  border-radius: 8px; padding: 8px 12px;
  font-size: .74rem; color: var(--warning);
}
.doc-alert-warn a { color: var(--warning); }

/* ══ QUICK LINKS ══ */
.doc-quick-link {
  display: flex; align-items: center; gap: 10px;
  padding: 12px 16px; font-size: .83rem;
  color: var(--text); text-decoration: none; font-weight: 600;
  font-family: var(--font-display);
  border-bottom: 1px solid var(--border);
  transition: all var(--transition);
}
.doc-quick-link:last-child { border-bottom: none; }
.doc-quick-link:hover { background: var(--primary-light); color: var(--primary); }
.doc-quick-ico { font-size: 1rem; width: 20px; text-align: center; }

/* ══ LETTRES ══ */
.modeles-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 8px; }
.modele-card {
  border: 1.5px solid var(--border); border-radius: 10px;
  padding: 12px 8px; text-align: center; cursor: pointer;
  transition: all var(--transition); display: flex; flex-direction: column; align-items: center; gap: 4px;
}
.modele-card:hover { border-color: var(--primary); background: var(--primary-light); }
.modele-card--active,.modele-card:has(input:checked) { border-color: var(--primary); background: var(--primary-light); }
.modele-card input { display: none; }
.modele-ico { font-size: 1.4rem; }
.modele-nom { font-family: var(--font-display); font-size: .78rem; font-weight: 700; color: var(--dark); }
.modele-desc { font-size: .67rem; color: var(--muted); }

.contrat-pills { display: flex; flex-wrap: wrap; gap: 5px; }
.contrat-pill {
  display: inline-flex; align-items: center; padding: 5px 13px;
  border-radius: 99px; border: 1.5px solid var(--border);
  font-family: var(--font-display); font-size: .74rem; font-weight: 700;
  color: var(--text); cursor: pointer; background: #fff; transition: all var(--transition);
}
.contrat-pill:hover { border-color: var(--primary); color: var(--primary); }
.contrat-pill:has(input:checked) { background: var(--primary); border-color: var(--primary); color: #fff; }
.contrat-pill input { display: none; }

.lettre-list { border-top: 1px solid var(--border); }
.lettre-item {
  display: flex; align-items: center; gap: 12px;
  padding: 14px 18px; border-bottom: 1px solid var(--border);
  transition: background var(--transition);
}
.lettre-item:last-child { border-bottom: none; }
.lettre-item:hover { background: rgba(255,124,8,.012); }
.lettre-item-ico {
  width: 38px; height: 38px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1rem; flex-shrink: 0;
}
.lettre-ico--classique { background: rgba(99,102,241,.1);  color: #6366f1; }
.lettre-ico--moderne   { background: rgba(236,72,153,.1);  color: #ec4899; }
.lettre-ico--colore    { background: rgba(245,158,11,.1);  color: #f59e0b; }
.lettre-item-body { flex: 1; min-width: 0; }
.lettre-item-title {
  font-family: var(--font-display); font-size: .85rem; font-weight: 700;
  color: var(--dark); display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
}
.lettre-badge-contrat {
  background: var(--primary-light); color: var(--primary);
  font-size: .62rem; font-weight: 800; padding: 2px 7px; border-radius: 99px;
}
.lettre-badge-modele {
  background: rgba(99,102,241,.1); color: #6366f1;
  font-size: .62rem; font-weight: 800; padding: 2px 7px; border-radius: 99px;
}
.lettre-item-meta { font-size: .74rem; color: var(--muted); margin-top: 3px; }
.lettre-item-meta i { font-size: .65rem; }
.lettre-item-actions { display: flex; gap: 4px; flex-shrink: 0; }
.lettre-btn {
  width: 32px; height: 32px; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: .82rem; border: none; cursor: pointer; text-decoration: none;
  transition: all var(--transition);
}
.lettre-btn--view { background: rgba(59,130,246,.08);  color: var(--info); }
.lettre-btn--view:hover { background: rgba(59,130,246,.18); }
.lettre-btn--dl   { background: rgba(16,185,129,.08);  color: var(--success); }
.lettre-btn--dl:hover { background: rgba(16,185,129,.18); }
.lettre-btn--del  { background: rgba(239,68,68,.08);   color: var(--danger); }
.lettre-btn--del:hover { background: rgba(239,68,68,.18); }

.lettre-empty {
  padding: 56px 24px; text-align: center;
}
.lettre-empty-ico {
  font-size: 2.8rem; color: var(--border); margin-bottom: 12px;
}
.lettre-empty-title {
  font-family: var(--font-display); font-size: .95rem; font-weight: 700;
  color: var(--dark); margin-bottom: 6px;
}
.lettre-empty p { font-size: .82rem; color: var(--muted); margin: 0; }

/* ══ FORM ══ */
.f-field { margin-bottom: 16px; }
.f-field.mb-0 { margin-bottom: 0; }
.f-field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.f-label { display: block; font-size: .8rem; font-weight: 600; color: var(--dark); margin-bottom: 6px; }
.f-label-hint { font-size: .72rem; color: var(--muted); font-weight: 400; margin-left: 5px; }
.f-label-opt  { font-size: .72rem; color: var(--muted); font-weight: 400; }
.f-req { color: var(--primary); }
.f-hint { font-size: .73rem; color: var(--muted); margin-top: 4px; margin-bottom: 0; }
.f-err-msg { font-size: .75rem; color: var(--danger); margin-top: 3px; margin-bottom: 0; }
.f-input {
  width: 100%; padding: 9px 13px;
  border: 1.5px solid var(--border); border-radius: 9px;
  background: var(--gray-bg); color: var(--text);
  font-family: var(--font-body); font-size: .87rem;
  outline: none; transition: all var(--transition);
}
.f-input:focus { border-color: var(--primary); box-shadow: 0 0 0 4px rgba(255,124,8,.1); background: #fff; }
.f-input--err { border-color: var(--danger) !important; }
.f-textarea { resize: vertical; min-height: 80px; }
.f-select-wrap { position: relative; }
.f-select { padding-right: 32px; cursor: pointer; }
.f-select-arr { position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
.f-btn-submit {
  width: 100%; padding: 12px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .88rem;
  border: none; border-radius: var(--radius); cursor: pointer;
  box-shadow: 0 4px 16px rgba(255,124,8,.32);
  display: flex; align-items: center; justify-content: center; gap: 8px;
  transition: all var(--transition);
}
.f-btn-submit:hover { background: var(--primary-dark); transform: translateY(-2px); }

/* ══ DYNAMIC ROWS ══ */
.cv-dyn-row { display: flex; align-items: center; gap: 8px; margin-bottom: 8px; }
.cv-dyn-fields { display: flex; gap: 8px; flex: 1; }
.cv-emoji-input { max-width: 56px; text-align: center; font-size: 1.1rem; padding: 6px 8px; }
.cv-dyn-rm {
  width: 30px; height: 30px; border-radius: 8px;
  background: rgba(239,68,68,.08); color: var(--danger);
  border: none; cursor: pointer; font-size: .85rem; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  transition: all var(--transition);
}
.cv-dyn-rm:hover { background: rgba(239,68,68,.18); }
.cv-dyn-add {
  display: inline-flex; align-items: center; gap: 6px;
  margin-top: 8px; padding: 7px 14px; border-radius: 9px;
  background: var(--gray-bg); color: var(--primary);
  font-family: var(--font-display); font-weight: 700; font-size: .77rem;
  border: 1.5px dashed rgba(255,124,8,.3); cursor: pointer;
  transition: all var(--transition);
}
.cv-dyn-add:hover { background: var(--primary-light); }

@@keyframes spin { to { transform: rotate(360deg); } }

/* ══ RESPONSIVE ══ */
@media (max-width: 1100px) { .cv-panel-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) {
  .doc-header { padding: 18px; }
  .doc-header-icon { display: none; }
  .doc-tabs { flex-wrap: wrap; }
  .doc-tab span { display: none; }
  .doc-tab { padding: 9px 14px; }
  .f-field-row { grid-template-columns: 1fr; }
  .modeles-grid { grid-template-columns: 1fr; }
  .cv-frame-wrap iframe { height: 600px; }
}
</style>
@endpush

@push('scripts')
<script>
/* ── Switcher d'onglets ── */
function switchDocTab(tab, btn) {
  document.querySelectorAll('.doc-tab').forEach(b => b.classList.remove('doc-tab--active'));
  btn.classList.add('doc-tab--active');
  ['cv','lettre','infos'].forEach(t => {
    const el = document.getElementById('tab-' + t);
    if (el) el.style.display = t === tab ? 'block' : 'none';
  });
}

/* ── Chargement à la demande de l'aperçu CV ── */
function loadCvPreview() {
  const placeholder = document.getElementById('cvFramePlaceholder');
  const overlay     = document.getElementById('cvFrameOverlay');
  const frame       = document.getElementById('cvPreviewFrame');
  if (!frame) return;

  // Afficher overlay, cacher placeholder
  if (placeholder) placeholder.style.display = 'none';
  if (overlay)     overlay.style.display      = 'flex';
  frame.style.display = 'none';

  // Charger l'URL dans l'iframe
  frame.src = '{{ route('admin.cv-lettre.cv.preview') }}';

  // Quand chargé : masquer overlay, afficher iframe
  frame.onload = function() {
    if (overlay) overlay.style.display = 'none';
    frame.style.display = 'block';
  };

  // Fallback si l'événement load ne se déclenche pas (PDF natif)
  setTimeout(function() {
    if (overlay && overlay.style.display !== 'none') {
      overlay.style.display = 'none';
      frame.style.display   = 'block';
    }
  }, 15000);
}

/* ── Actualiser l'aperçu (bouton refresh) ── */
function refreshPreview() {
  const overlay = document.getElementById('cvFrameOverlay');
  const frame   = document.getElementById('cvPreviewFrame');
  const placeholder = document.getElementById('cvFramePlaceholder');
  if (!frame || !frame.src) { loadCvPreview(); return; }

  if (placeholder) placeholder.style.display = 'none';
  if (overlay)     overlay.style.display      = 'flex';
  frame.style.display = 'none';

  const url = new URL(frame.src);
  url.searchParams.set('_t', Date.now());
  frame.src = url.toString();

  frame.onload = function() {
    if (overlay) overlay.style.display = 'none';
    frame.style.display = 'block';
  };
  setTimeout(function() {
    if (overlay && overlay.style.display !== 'none') {
      overlay.style.display = 'none';
      frame.style.display   = 'block';
    }
  }, 15000);
}

/* ── Sélection modèle lettre ── */
document.querySelectorAll('.modele-card input').forEach(r => {
  r.addEventListener('change', function() {
    document.querySelectorAll('.modele-card').forEach(c => c.classList.remove('modele-card--active'));
    this.closest('.modele-card').classList.add('modele-card--active');
  });
});

/* ── Spinner bouton génération lettre ── */
document.getElementById('lettreForm')?.addEventListener('submit', function() {
  const btn = document.getElementById('lettreSubmitBtn');
  if (btn) {
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin .8s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Génération…';
    btn.disabled = true;
  }
});

/* ── Rows dynamiques ── */
let langueCount  = {{ $langues->count() ?: 1 }};
let interetCount = {{ $interets->count() ?: 5 }};
let qualiteCount = {{ $qualites->count() ?: 4 }};

function removeRow(btn) { btn.closest('.cv-dyn-row')?.remove(); }

function addLangue() {
  const opts = Object.entries(@json(\App\Models\CvLangue::NIVEAUX))
    .map(([v,d]) => `<option value="${v}">${d.label}</option>`).join('');
  document.getElementById('languesList').insertAdjacentHTML('beforeend', `
    <div class="cv-dyn-row">
      <div class="cv-dyn-fields">
        <input type="text" name="langues[${langueCount}][langue]" class="f-input" placeholder="Ex : Espagnol">
        <div class="f-select-wrap" style="flex:1">
          <select name="langues[${langueCount}][niveau]" class="f-input f-select">${opts}</select>
          <svg class="f-select-arr" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
        </div>
      </div>
      <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
    </div>`);
  langueCount++;
}

function addInteret() {
  document.getElementById('interetsList').insertAdjacentHTML('beforeend', `
    <div class="cv-dyn-row">
      <div class="cv-dyn-fields">
        <input type="text" name="interets[${interetCount}][icone]" class="f-input cv-emoji-input" placeholder="🎯" maxlength="4">
        <input type="text" name="interets[${interetCount}][interet]" class="f-input" placeholder="Ex : Lecture">
      </div>
      <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
    </div>`);
  interetCount++;
}

function addQualite() {
  document.getElementById('qualitesList').insertAdjacentHTML('beforeend', `
    <div class="cv-dyn-row">
      <div class="cv-dyn-fields">
        <input type="text" name="qualites[${qualiteCount}][icone]" class="f-input cv-emoji-input" placeholder="✅" maxlength="4">
        <input type="text" name="qualites[${qualiteCount}][qualite]" class="f-input" placeholder="Ex : Autonome">
      </div>
      <button type="button" class="cv-dyn-rm" onclick="removeRow(this)"><i class="bi bi-x"></i></button>
    </div>`);
  qualiteCount++;
}

/* ── Ouvrir sur le bon onglet selon la session ── */
@if(session('toast_success') && str_contains(request()->route()?->getName() ?? '', 'lettre'))
  switchDocTab('lettre', document.querySelector('[data-tab="lettre"]'));
@endif
</script>
@endpush
