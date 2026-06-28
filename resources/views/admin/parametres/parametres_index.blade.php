@extends('layouts_admin.master_admin')
@section('title', 'Paramètres')

@section('content')
@php
/* ══ Métadonnées groupes ══ */
$groupeMeta = [
  'site'   => [
    'ico'   => 'bi-globe2',
    'label' => 'Site',
    'desc'  => 'Informations générales de votre portfolio',
    'color' => '#6366f1',
  ],
  'stats'  => [
    'ico'   => 'bi-bar-chart-line-fill',
    'label' => 'Statistiques',
    'desc'  => 'Chiffres affichés dans la section stats',
    'color' => '#f59e0b',
  ],
  'seo'    => [
    'ico'   => 'bi-search',
    'label' => 'SEO',
    'desc'  => 'Optimisation pour les moteurs de recherche',
    'color' => '#10b981',
  ],
  'mail'   => [
    'ico'   => 'bi-envelope-at-fill',
    'label' => 'Mail',
    'desc'  => 'Configuration des emails de contact',
    'color' => '#3b82f6',
  ],
  'social' => [
    'ico'   => 'bi-share-fill',
    'label' => 'Réseaux',
    'desc'  => 'Liens vers vos profils sociaux',
    'color' => '#ec4899',
  ],
];

/* ══ Libellés & descriptions par clé ══ */
$fieldMeta = [
  'site_nom'           => ['label' => 'Nom du site',          'desc' => 'Affiché dans le titre de l\'onglet et l\'en-tête'],
  'site_titre'         => ['label' => 'Titre principal',      'desc' => 'Titre affiché en haut de votre portfolio'],
  'site_sous_titre'    => ['label' => 'Sous-titre',           'desc' => 'Texte court affiché sous le titre principal'],
  'site_description'   => ['label' => 'Description',          'desc' => 'Présentation complète affichée dans la section À propos'],
  'site_a_propos'      => ['label' => 'À propos',             'desc' => 'Texte long de présentation de votre parcours'],
  'site_bio_courte'    => ['label' => 'Bio courte',           'desc' => 'Résumé de votre profil (140 caractères max)'],
  'site_email'         => ['label' => 'Email de contact',     'desc' => 'Affiché dans la section contact'],
  'site_telephone'     => ['label' => 'Téléphone',            'desc' => 'Numéro affiché dans les infos de contact'],
  'site_ville'         => ['label' => 'Ville',                'desc' => 'Votre localisation actuelle'],
  'site_disponible'    => ['label' => 'Disponibilité',        'desc' => 'Indique si vous êtes ouvert aux missions'],
  'site_cv_url'        => ['label' => 'Lien CV',              'desc' => 'URL vers votre CV (PDF ou page dédiée)'],
  'site_logo_url'      => ['label' => 'URL du logo',          'desc' => 'Lien vers l\'image de votre logo'],
  'seo_titre'          => ['label' => 'Titre SEO',            'desc' => 'Titre affiché dans les résultats Google (60 car. max)'],
  'seo_description'    => ['label' => 'Description SEO',      'desc' => 'Résumé de la page pour les moteurs de recherche (160 car. max)'],
  'seo_mots_cles'      => ['label' => 'Mots-clés',            'desc' => 'Séparés par des virgules'],
  'seo_og_image'       => ['label' => 'Image Open Graph',     'desc' => 'Image affichée lors du partage sur les réseaux'],
  'stats_projets'      => ['label' => 'Projets réalisés',     'desc' => 'Nombre total de projets livrés'],
  'stats_clients'      => ['label' => 'Clients satisfaits',   'desc' => 'Nombre de clients accompagnés'],
  'stats_experience'   => ['label' => 'Années d\'expérience', 'desc' => 'Durée de votre activité professionnelle'],
  'stats_satisfaction' => ['label' => 'Taux de satisfaction', 'desc' => 'En pourcentage (ex : 98)'],
  'mail_from_name'     => ['label' => 'Nom expéditeur',       'desc' => 'Nom affiché à la réception du mail'],
  'mail_from_address'  => ['label' => 'Email expéditeur',     'desc' => 'Adresse email d\'envoi des notifications'],
  'mail_to_address'    => ['label' => 'Email destinataire',   'desc' => 'Où vous recevez les messages du formulaire'],
  'social_github'      => ['label' => 'GitHub',               'desc' => 'Lien vers votre profil GitHub'],
  'social_linkedin'    => ['label' => 'LinkedIn',             'desc' => 'Lien vers votre profil LinkedIn'],
  'social_whatsapp'    => ['label' => 'WhatsApp',             'desc' => 'Numéro ou lien WhatsApp (ex : https://wa.me/225XXXXXXXX)'],
  'social_facebook'    => ['label' => 'Facebook',             'desc' => 'Lien vers votre page Facebook'],
  'social_instagram'   => ['label' => 'Instagram',            'desc' => 'Lien vers votre compte Instagram'],
  'social_youtube'     => ['label' => 'YouTube',              'desc' => 'Lien vers votre chaîne YouTube'],
  'social_dribbble'    => ['label' => 'Dribbble',             'desc' => 'Lien vers votre profil Dribbble'],
  'social_behance'     => ['label' => 'Behance',              'desc' => 'Lien vers votre profil Behance'],
];

/* ══ Icônes réseaux sociaux SVG ══ */
$socialIcons = [
  'github'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/></svg>',
  'linkedin'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
  'whatsapp'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>',
  'instagram' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
  'facebook'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
  'youtube'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
  'dribbble'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.017-8.04 6.39 1.73 1.35 3.92 2.165 6.29 2.165 1.42 0 2.77-.29 4-.805zm-12.44-3.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C5.17 11.4 1.087 11.507.07 11.55c0 .13-.004.26-.004.394 0 2.42.87 4.64 2.497 6.326zm-2.31-8.42c1.034-.026 4.82-.075 9.395-1.26-.42-.787-.862-1.57-1.327-2.33C6.47 5.562 3.35 6.64 2.078 7.207c.004.344.026.685.066 1.023zm7.985-5.54c.47.77.916 1.555 1.34 2.35 3.9-1.64 5.535-4.13 5.745-4.456C16.01 2.135 14.08 1.41 12 1.41c-1.3 0-2.54.24-3.684.67zm9.38 2.28c-.248.34-2.02 2.99-6.07 4.814.262.553.512 1.11.754 1.673.077.183.152.366.228.55 3.392-.427 6.77.258 7.1.33-.028-2.685-.93-5.16-2.012-7.368z"/></svg>',
  'behance'   => '<svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22 7h-7V5h7v2zm1.726 10c-.442 1.297-2.029 3-5.101 3-3.074 0-5.564-1.729-5.564-5.675 0-3.91 2.325-5.92 5.466-5.92 3.082 0 4.964 1.782 5.375 4.426.078.506.109 1.188.095 2.14H15.97c.13 3.211 3.483 3.312 4.588 2.029H23.7zM15.999 13c-.029-1.744 1.165-2.85 2.577-2.85 1.413 0 2.588 1.05 2.577 2.85H15.999zM3 6h5.093c3.513 0 4.797 1.797 4.797 3.54 0 1.493-.738 2.661-2.115 3.235 1.754.441 2.831 1.678 2.831 3.535C13.606 19.327 11.546 21 8.558 21H3V6zm5.21 5.89c1.198 0 1.968-.737 1.968-1.74 0-.99-.753-1.65-1.968-1.65H5.895v3.39H8.21zm.218 5.47c1.406 0 2.175-.738 2.175-1.945 0-1.159-.796-1.857-2.175-1.857H5.895v3.802H8.428z"/></svg>',
];

$firstGroupe = $groupes->keys()->first();
@endphp

{{-- ══ EN-TÊTE ══ --}}
<div class="params-header">
  <div class="params-header-left">
    <div class="params-header-icon">
      <i class="bi bi-sliders2"></i>
    </div>
    <div>
      <div class="params-eyebrow">Configuration</div>
      <h1 class="params-title">Paramètres du portfolio</h1>
      <p class="params-subtitle">Personnalisez chaque aspect de votre portfolio depuis un seul endroit.</p>
    </div>
  </div>
  <div class="params-header-actions">
    <button type="submit" form="parametresForm" class="params-btn-save" id="mainSaveBtn">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
      </svg>
      <span>Enregistrer tout</span>
    </button>
  </div>
</div>

{{-- ══ LAYOUT ══ --}}
<div class="params-layout">

  {{-- ── Sidebar navigation ── --}}
  <aside class="params-nav">
    <div class="params-nav-inner">
      <div class="params-nav-label">Sections</div>
      @foreach($groupes as $groupe => $params)
        @php $m = $groupeMeta[$groupe] ?? ['ico'=>'bi-gear-fill','label'=>ucfirst($groupe),'desc'=>'','color'=>'#6366f1']; @endphp
        <button type="button"
          class="params-nav-item {{ $groupe === $firstGroupe ? 'active' : '' }}"
          style="--nav-color:{{ $m['color'] }}"
          onclick="switchGroup('{{ $groupe }}', this)">
          <span class="params-nav-dot"></span>
          <span class="params-nav-ico"><i class="bi {{ $m['ico'] }}"></i></span>
          <div class="params-nav-text">
            <span class="params-nav-name">{{ $m['label'] }}</span>
            <span class="params-nav-count">{{ $params->count() }} champ{{ $params->count()>1?'s':'' }}</span>
          </div>
          <i class="bi bi-chevron-right params-nav-arrow"></i>
        </button>
      @endforeach
    </div>

    <div class="params-nav-footer">
      <div class="params-nav-footer-text">
        <i class="bi bi-shield-check-fill" style="color:var(--success);font-size:.85rem"></i>
        Données sécurisées
      </div>
    </div>
  </aside>

  {{-- ── Contenu ── --}}
  <div class="params-body">
    <form method="POST" action="{{ route('parametres.update') }}" id="parametresForm">
      @csrf

      @foreach($groupes as $groupe => $params)
      @php $m = $groupeMeta[$groupe] ?? ['ico'=>'bi-gear-fill','label'=>ucfirst($groupe),'desc'=>'','color'=>'#6366f1']; @endphp

      <div class="params-section" id="group-{{ $groupe }}"
        style="{{ $groupe !== $firstGroupe ? 'display:none' : '' }}">

        {{-- Section header --}}
        <div class="params-section-head">
          <div class="params-section-head-icon" style="background:{{ $m['color'] }}18;color:{{ $m['color'] }}">
            <i class="bi {{ $m['ico'] }}"></i>
          </div>
          <div class="params-section-head-text">
            <h2 class="params-section-title">{{ $m['label'] }}</h2>
            <p class="params-section-desc">{{ $m['desc'] ?? '' }}</p>
          </div>
          <button type="button" class="params-btn-group-save" onclick="saveGroup('{{ $groupe }}')">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            Enregistrer
          </button>
        </div>

        {{-- Champs --}}
        <div class="params-fields-list">
          @foreach($params as $param)
          @php
            $fmeta    = $fieldMeta[$param->cle] ?? null;
            $flabel   = $fmeta['label'] ?? \Str::of($param->cle)->after('_')->replace('_',' ')->title()->toString();
            $fdesc    = $fmeta['desc']  ?? null;
            $isLong   = Str::contains($param->cle, ['biographie','description','a_propos','bio']);
            $isEmail  = Str::contains($param->cle, ['email','mail']);
            $isUrl    = Str::contains($param->cle, ['url','github','linkedin','whatsapp','instagram','social_','cv','dribbble','behance','youtube','facebook']);
            $isTel    = Str::contains($param->cle, ['telephone','tel','phone']);
            $isBool   = Str::contains($param->cle, ['disponible','actif']);
            $isNumber = Str::contains($param->cle, ['projets','clients','experience','satisfaction']);
            $socialKey= collect(['github','linkedin','whatsapp','instagram','facebook','youtube','dribbble','behance'])->first(fn($k)=>Str::contains($param->cle,$k));
          @endphp
          <input type="hidden" name="parametres[{{ $param->id }}][cle]" value="{{ $param->cle }}">

          <div class="param-field {{ $isLong ? 'param-field--full' : '' }}">

            {{-- Label colonne --}}
            <div class="param-field-label">
              <label class="param-field-name" for="param_{{ $param->id }}">{{ $flabel }}</label>
              @if($fdesc)
                <p class="param-field-desc">{{ $fdesc }}</p>
              @endif
              <code class="param-field-cle">{{ $param->cle }}</code>
            </div>

            {{-- Input colonne --}}
            <div class="param-field-control">

              @if($isBool)
                {{-- Toggle --}}
                <div class="param-toggle-wrap">
                  <label class="param-toggle" for="param_{{ $param->id }}">
                    <input type="hidden" name="parametres[{{ $param->id }}][valeur]" value="0">
                    <input type="checkbox" id="param_{{ $param->id }}"
                      name="parametres[{{ $param->id }}][valeur]" value="1"
                      {{ $param->valeur=='1' ? 'checked' : '' }}>
                    <span class="param-toggle-track"><span class="param-toggle-thumb"></span></span>
                  </label>
                  <span class="param-toggle-label" id="toggle_label_{{ $param->id }}">
                    {{ $param->valeur=='1' ? 'Activé' : 'Désactivé' }}
                  </span>
                </div>

              @elseif($isLong)
                {{-- Quill --}}
                <input type="hidden"
                  name="parametres[{{ $param->id }}][valeur]"
                  id="param_{{ $param->id }}"
                  value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                <div data-quill-target="param_{{ $param->id }}"
                  data-placeholder="Saisissez votre {{ strtolower($flabel) }}..."></div>

              @elseif($isNumber)
                {{-- Compteur --}}
                <div class="param-counter">
                  <button type="button" class="param-counter-btn" onclick="stepCounter('param_{{ $param->id }}',-1)">
                    <i class="bi bi-dash"></i>
                  </button>
                  <input type="number" id="param_{{ $param->id }}"
                    name="parametres[{{ $param->id }}][valeur]"
                    class="param-counter-input param-input"
                    min="0" value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                  <button type="button" class="param-counter-btn" onclick="stepCounter('param_{{ $param->id }}',1)">
                    <i class="bi bi-plus"></i>
                  </button>
                  @if(Str::contains($param->cle, 'satisfaction')) <span class="param-unit">%</span> @endif
                  @if(Str::contains($param->cle, 'experience'))   <span class="param-unit">ans</span> @endif
                </div>

              @elseif($isEmail)
                {{-- Email --}}
                <div class="param-input-wrap">
                  <span class="param-input-prefix">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                  </span>
                  <input type="email" id="param_{{ $param->id }}"
                    name="parametres[{{ $param->id }}][valeur]"
                    class="param-input param-input--ico"
                    placeholder="email@exemple.com"
                    value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                </div>

              @elseif($isTel)
                {{-- Téléphone --}}
                <div class="param-input-wrap">
                  <span class="param-input-prefix">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                  </span>
                  <input type="tel" id="param_{{ $param->id }}"
                    name="parametres[{{ $param->id }}][valeur]"
                    class="param-input param-input--ico"
                    placeholder="+225 07 00 00 00"
                    value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                </div>

              @elseif($isUrl && $socialKey)
                {{-- Réseau social --}}
                <div class="param-social-row">
                  <div class="param-input-wrap" style="flex:1">
                    <span class="param-input-prefix param-social-icon">
                      {!! $socialIcons[$socialKey] ?? '<i class="bi bi-link-45deg"></i>' !!}
                    </span>
                    <input type="{{ $socialKey === 'whatsapp' ? 'text' : 'url' }}"
                      id="param_{{ $param->id }}"
                      name="parametres[{{ $param->id }}][valeur]"
                      class="param-input param-input--ico"
                      placeholder="{{ $socialKey === 'whatsapp' ? 'https://wa.me/225XXXXXXXXX ou 07XXXXXXXX' : 'https://'.$socialKey.'.com/votre-profil' }}"
                      value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                  </div>
                  @if($param->valeur)
                    <a href="{{ $param->valeur }}" target="_blank" class="param-open-link" title="Ouvrir">
                      <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                  @endif
                </div>

              @elseif($isUrl)
                {{-- URL générique --}}
                <div class="param-social-row">
                  <div class="param-input-wrap" style="flex:1">
                    <span class="param-input-prefix">
                      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                      </svg>
                    </span>
                    <input type="url" id="param_{{ $param->id }}"
                      name="parametres[{{ $param->id }}][valeur]"
                      class="param-input param-input--ico"
                      placeholder="https://..."
                      value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
                  </div>
                  @if($param->valeur)
                    <a href="{{ $param->valeur }}" target="_blank" class="param-open-link" title="Ouvrir">
                      <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                  @endif
                </div>

              @else
                {{-- Texte simple --}}
                <input type="text" id="param_{{ $param->id }}"
                  name="parametres[{{ $param->id }}][valeur]"
                  class="param-input"
                  placeholder="—"
                  value="{{ old('parametres.'.$param->id.'.valeur', $param->valeur) }}">
              @endif

            </div>{{-- /control --}}
          </div>{{-- /field --}}
          @endforeach
        </div>{{-- /fields-list --}}

      </div>{{-- /section --}}
      @endforeach

    </form>
  </div>{{-- /body --}}

</div>{{-- /layout --}}
</main>
@endsection

<style>
/* ══════════════════════════════════════════════════════════
   PARAMÈTRES — Design
══════════════════════════════════════════════════════════ */

/* ── En-tête ── */
.params-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 20px;
  flex-wrap: wrap;
  margin-bottom: 32px;
  padding: 28px 32px;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  position: relative;
  overflow: hidden;
}
.params-header::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, var(--primary), #f59e0b, #ec4899);
}
.params-header-left { display: flex; align-items: center; gap: 20px; }
.params-header-icon {
  width: 52px; height: 52px;
  background: var(--primary-light);
  border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.4rem; color: var(--primary);
  flex-shrink: 0;
}
.params-eyebrow {
  font-family: var(--font-display);
  font-size: .69rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: .14em;
  color: var(--primary); margin-bottom: 3px;
}
.params-title {
  font-family: var(--font-display);
  font-size: 1.45rem; font-weight: 800;
  color: var(--dark); line-height: 1.2;
  margin: 0 0 4px;
}
.params-subtitle {
  font-size: .83rem; color: var(--muted);
  margin: 0; line-height: 1.5;
}
.params-btn-save {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  padding: 11px 22px; border-radius: var(--radius);
  border: none; cursor: pointer;
  box-shadow: 0 4px 16px rgba(255,124,8,.35);
  transition: all var(--transition);
  white-space: nowrap;
}
.params-btn-save:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,124,8,.45); }
.params-btn-save:disabled { opacity: .6; pointer-events: none; }

/* ── Layout ── */
.params-layout { display: grid; grid-template-columns: 240px 1fr; gap: 24px; align-items: start; }

/* ── Nav sidebar ── */
.params-nav {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  position: sticky;
  top: calc(var(--topbar-height) + 16px);
  overflow: hidden;
}
.params-nav-inner { padding: 12px 10px 6px; }
.params-nav-label {
  font-family: var(--font-display);
  font-size: .65rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: .14em;
  color: var(--muted); padding: 6px 8px 10px;
}
.params-nav-item {
  width: 100%;
  display: flex; align-items: center; gap: 10px;
  padding: 10px 10px 10px 14px;
  border-radius: 10px; border: none;
  background: transparent; cursor: pointer;
  transition: all var(--transition); text-align: left;
  position: relative; margin-bottom: 2px;
}
.params-nav-item:hover { background: var(--gray-bg); }
.params-nav-item.active {
  background: color-mix(in srgb, var(--nav-color) 10%, transparent);
}
.params-nav-dot {
  width: 6px; height: 6px; border-radius: 50%;
  background: var(--border); flex-shrink: 0;
  transition: background var(--transition);
}
.params-nav-item.active .params-nav-dot { background: var(--nav-color); }
.params-nav-ico {
  width: 30px; height: 30px;
  background: var(--gray-bg); border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: .95rem; color: var(--muted);
  transition: all var(--transition); flex-shrink: 0;
}
.params-nav-item.active .params-nav-ico {
  background: color-mix(in srgb, var(--nav-color) 15%, transparent);
  color: var(--nav-color);
}
.params-nav-text { flex: 1; min-width: 0; }
.params-nav-name {
  display: block;
  font-family: var(--font-display); font-size: .84rem; font-weight: 700;
  color: var(--text); line-height: 1.2;
  transition: color var(--transition);
}
.params-nav-item.active .params-nav-name { color: var(--nav-color); }
.params-nav-count {
  font-size: .68rem; color: var(--muted); font-weight: 500;
}
.params-nav-arrow {
  font-size: .65rem; color: var(--muted);
  opacity: 0; transition: all var(--transition);
}
.params-nav-item:hover .params-nav-arrow,
.params-nav-item.active .params-nav-arrow { opacity: 1; color: var(--nav-color); }

.params-nav-footer {
  border-top: 1px solid var(--border);
  padding: 12px 14px;
  margin-top: 4px;
}
.params-nav-footer-text {
  display: flex; align-items: center; gap: 6px;
  font-size: .72rem; color: var(--muted); font-weight: 500;
}

/* ── Corps section ── */
.params-section { display: flex; flex-direction: column; gap: 16px; }

.params-section-head {
  display: flex; align-items: center; gap: 16px;
  flex-wrap: wrap;
  padding: 20px 24px;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
}
.params-section-head-icon {
  width: 44px; height: 44px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.2rem; flex-shrink: 0;
}
.params-section-head-text { flex: 1; }
.params-section-title {
  font-family: var(--font-display); font-size: 1rem; font-weight: 800;
  color: var(--dark); margin: 0 0 2px;
}
.params-section-desc { font-size: .78rem; color: var(--muted); margin: 0; }
.params-btn-group-save {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 9px 18px;
  background: var(--primary-light); color: var(--primary);
  border: 1.5px solid rgba(255,124,8,.25);
  font-family: var(--font-display); font-weight: 700; font-size: .8rem;
  border-radius: 10px; cursor: pointer;
  transition: all var(--transition); white-space: nowrap;
}
.params-btn-group-save:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
.params-btn-group-save:disabled { opacity:.5; pointer-events:none; }

/* ── Liste de champs ── */
.params-fields-list {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.param-field {
  display: grid;
  grid-template-columns: 240px 1fr;
  gap: 0;
  border-bottom: 1px solid var(--border);
  transition: background var(--transition);
}
.param-field:last-child { border-bottom: none; }
.param-field:hover { background: rgba(255,124,8,.012); }
.param-field--full { grid-template-columns: 1fr; }

.param-field-label {
  padding: 20px 20px 20px 24px;
  border-right: 1px solid var(--border);
}
.param-field--full .param-field-label {
  border-right: none;
  border-bottom: 1px solid var(--border);
  padding: 16px 24px 12px;
}
.param-field-name {
  display: block;
  font-family: var(--font-display); font-size: .84rem; font-weight: 700;
  color: var(--dark); margin-bottom: 4px; cursor: pointer;
}
.param-field-desc { font-size: .76rem; color: var(--muted); margin: 0 0 6px; line-height: 1.4; }
.param-field-cle {
  font-family: 'Courier New', monospace; font-size: .65rem;
  color: var(--muted); background: var(--gray-bg);
  padding: 2px 7px; border-radius: 4px;
  border: 1px solid var(--border);
}

.param-field-control {
  padding: 16px 24px;
  display: flex; align-items: center;
}
.param-field--full .param-field-control { padding: 16px 24px; }

/* ── Inputs ── */
.param-input {
  width: 100%; padding: 9px 13px;
  border: 1.5px solid var(--border); border-radius: 10px;
  background: var(--gray-bg); color: var(--text);
  font-family: var(--font-body); font-size: .87rem;
  outline: none; transition: all var(--transition);
}
.param-input:focus {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(255,124,8,.1);
  background: #fff;
}
.param-input--dirty { border-color: var(--warning) !important; }

.param-input-wrap {
  position: relative; width: 100%;
  display: flex; align-items: center;
}
.param-input-prefix {
  position: absolute; left: 12px;
  color: var(--muted); display: flex; align-items: center;
  pointer-events: none;
}
.param-input--ico { padding-left: 36px; }

/* URL open link */
.param-social-row { display: flex; align-items: center; gap: 8px; width: 100%; }
.param-open-link {
  flex-shrink: 0; width: 36px; height: 36px;
  display: flex; align-items: center; justify-content: center;
  background: var(--gray-bg); border: 1.5px solid var(--border);
  border-radius: 9px; color: var(--muted); font-size: .85rem;
  text-decoration: none; transition: all var(--transition);
}
.param-open-link:hover { background: var(--primary-light); color: var(--primary); border-color: rgba(255,124,8,.3); }

/* Social icon prefix */
.param-social-icon { color: var(--muted); }

/* ── Toggle ── */
.param-toggle-wrap { display: flex; align-items: center; gap: 12px; }
.param-toggle { cursor: pointer; }
.param-toggle input { display: none; }
.param-toggle-track {
  display: block; width: 48px; height: 27px;
  border-radius: 99px; background: var(--border);
  position: relative; transition: background .25s;
  box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
}
.param-toggle-thumb {
  position: absolute;
  width: 21px; height: 21px; border-radius: 50%;
  background: #fff; top: 3px; left: 3px;
  transition: transform .25s cubic-bezier(.34,1.56,.64,1);
  box-shadow: 0 1px 5px rgba(0,0,0,.2);
}
.param-toggle input:checked + .param-toggle-track { background: var(--primary); }
.param-toggle input:checked + .param-toggle-track .param-toggle-thumb { transform: translateX(21px); }
.param-toggle-label { font-size: .82rem; color: var(--muted); font-weight: 600; }

/* ── Compteur ── */
.param-counter { display: flex; align-items: center; gap: 6px; }
.param-counter-btn {
  width: 32px; height: 32px; border-radius: 8px;
  background: var(--gray-bg); border: 1.5px solid var(--border);
  color: var(--text); cursor: pointer; font-size: 1rem;
  display: flex; align-items: center; justify-content: center;
  transition: all var(--transition);
}
.param-counter-btn:hover { background: var(--primary-light); color: var(--primary); border-color: rgba(255,124,8,.3); }
.param-counter-input { width: 90px !important; text-align: center; }
.param-unit { font-size: .8rem; color: var(--muted); font-weight: 700; margin-left: 4px; }

/* ── Quill dans param ── */
.quill-param-wrap {
  width: 100%;
  border: 1.5px solid var(--border);
  border-radius: 10px;
  overflow: hidden;
  transition: border-color var(--transition), box-shadow var(--transition);
  background: #fff;
}
.quill-param-wrap:focus-within {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(255,124,8,.1);
}
.quill-param-wrap .ql-toolbar.ql-snow {
  border: none !important;
  border-bottom: 1px solid var(--border) !important;
  background: var(--gray-bg);
  border-radius: 0 !important;
  padding: 6px 10px !important;
}
.quill-param-wrap .ql-container.ql-snow {
  border: none !important;
  font-family: var(--font-body) !important;
  font-size: .88rem !important;
}
.quill-param-wrap .ql-editor { min-height: 120px; color: var(--text); line-height: 1.75; }
.quill-param-wrap .ql-editor.ql-blank::before { color: var(--muted); font-style: normal !important; }
.quill-param-wrap .ql-toolbar .ql-stroke { stroke: var(--muted) !important; transition: stroke .15s; }
.quill-param-wrap .ql-toolbar .ql-fill   { fill:   var(--muted) !important; transition: fill .15s; }
.quill-param-wrap .ql-toolbar button:hover .ql-stroke,
.quill-param-wrap .ql-toolbar .ql-active .ql-stroke { stroke: var(--primary) !important; }
.quill-param-wrap .ql-toolbar button:hover .ql-fill,
.quill-param-wrap .ql-toolbar .ql-active .ql-fill   { fill:   var(--primary) !important; }
.quill-param-wrap .ql-toolbar .ql-picker-label       { color: var(--muted)   !important; }
.quill-param-wrap .ql-toolbar .ql-picker-label:hover { color: var(--primary) !important; }

/* ── Responsive ── */
@media (max-width: 960px) {
  .params-layout { grid-template-columns: 1fr; }
  .params-nav {
    position: static;
    display: flex; flex-direction: column;
  }
  .params-nav-inner { display: flex; flex-wrap: wrap; gap: 4px; padding: 8px; }
  .params-nav-label { display: none; }
  .params-nav-item { width: auto; flex: 0 0 auto; padding: 8px 12px; }
  .params-nav-text { display: none; }
  .params-nav-dot  { display: none; }
  .params-nav-arrow{ display: none; }
  .params-nav-footer { display: none; }
}
@media (max-width: 680px) {
  .params-header { padding: 20px; }
  .params-header-icon { display: none; }
  .param-field { grid-template-columns: 1fr; }
  .param-field-label { border-right: none; border-bottom: 1px solid var(--border); padding: 16px 20px 12px; }
  .param-field-control { padding: 12px 20px 16px; }
  .params-section-head { padding: 16px 18px; }
  .param-field-cle { display: none; }
}
</style>

@push('scripts')
<script>
/* ── Sync utilitaire ── */
function syncAllQuill() {
  (window._quillInstances || []).forEach(({ quill, hidden }) => {
    hidden.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
  });
}
document.getElementById('parametresForm')?.addEventListener('submit', () => syncAllQuill());

/* ── Switcher de groupe ── */
function switchGroup(groupe, btn) {
  document.querySelectorAll('.params-section').forEach(g => g.style.display = 'none');
  document.querySelectorAll('.params-nav-item').forEach(t => t.classList.remove('active'));
  document.getElementById('group-' + groupe).style.display = 'flex';
  btn.classList.add('active');
}

/* ── Compteur +/- ── */
function stepCounter(id, delta) {
  const el = document.getElementById(id);
  if (!el) return;
  const cur = parseInt(el.value) || 0;
  el.value = Math.max(0, cur + delta);
  el.dispatchEvent(new Event('input'));
}

/* ── Toggle label live ── */
document.querySelectorAll('.param-toggle input[type="checkbox"]').forEach(cb => {
  const id  = cb.id;
  const lbl = document.getElementById('toggle_label_' + id.replace('param_', ''));
  if (!lbl) return;
  cb.addEventListener('change', () => {
    lbl.textContent = cb.checked ? 'Activé' : 'Désactivé';
  });
});

/* ── Dirty indicator ── */
document.querySelectorAll('.param-input').forEach(input => {
  const original = input.value;
  input.addEventListener('input', function () {
    this.classList.toggle('param-input--dirty', this.value !== original);
  });
});

/* ── Enregistrer groupe via AJAX ── */
async function saveGroup(groupe) {
  syncAllQuill();

  const group  = document.getElementById('group-' + groupe);
  const inputs = group.querySelectorAll('[name^="parametres"]');
  const data   = {};

  inputs.forEach(input => {
    if (input.type === 'checkbox') {
      if (input.name.endsWith('[valeur]')) data[input.name] = input.checked ? '1' : '0';
    } else if (input.type === 'hidden') {
      if (!data[input.name]) data[input.name] = input.value;
    } else {
      data[input.name] = input.value;
    }
  });

  data['_token'] = document.querySelector('meta[name=csrf-token]').content;

  const btn = group.querySelector('.params-btn-group-save');
  const orig = btn.innerHTML;
  btn.innerHTML = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin .8s linear infinite"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Enregistrement…';
  btn.disabled = true;

  try {
    const res = await fetch('{{ route("parametres.update") }}', {
      method:  'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body:    new URLSearchParams(data).toString(),
    });

    if (res.ok || res.status === 302) {
      btn.innerHTML = '<i class="bi bi-check-lg"></i> Enregistré !';
      btn.style.cssText = 'background:rgba(16,185,129,.12);color:var(--success);border-color:rgba(16,185,129,.3)';
      if (window.showToast) showToast('Paramètres enregistrés avec succès.', 'success');
      setTimeout(() => {
        btn.innerHTML = orig; btn.style.cssText = ''; btn.disabled = false;
      }, 2200);
    } else { throw new Error('HTTP ' + res.status); }
  } catch (e) {
    btn.innerHTML = '<i class="bi bi-x-circle-fill"></i> Erreur';
    btn.style.color = 'var(--danger)';
    if (window.showToast) showToast('Une erreur est survenue, veuillez réessayer.', 'error');
    setTimeout(() => { btn.innerHTML = orig; btn.style.cssText = ''; btn.disabled = false; }, 2500);
    console.error(e);
  }
}

/* ── Bouton principal: feedback ── */
document.getElementById('parametresForm')?.addEventListener('submit', () => {
  const btn = document.getElementById('mainSaveBtn');
  if (btn) {
    btn.querySelector('span').textContent = 'Enregistrement…';
    btn.disabled = true;
  }
});
</script>
<style>@@keyframes spin { to { transform: rotate(360deg); } }</style>
@endpush
