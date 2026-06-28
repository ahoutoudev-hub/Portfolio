<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body {
  font-family: 'DejaVu Sans', sans-serif;
  font-size: 10px;
  color: #333;
  background: #fff;
  line-height: 1.6;
}
@php
  $primary = $params['apparence_primary'] ?? '#ff7c08';
  $dark    = '#1a2e4a';
@endphp

/* ══ MODÈLE CLASSIQUE ══ */
.lettre-wrap { padding: 50px 55px; min-height: 100vh; position: relative; }

/* En-tête */
.lettre-header { display: table; width: 100%; margin-bottom: 36px; }
.lettre-header-left { display: table-cell; vertical-align: top; }
.lettre-header-right { display: table-cell; text-align: right; vertical-align: top; width: 200px; }

.lettre-emetteur-nom {
  font-size: 18px;
  font-weight: bold;
  color: {{ $dark }};
  margin-bottom: 3px;
}
.lettre-emetteur-poste {
  font-size: 10px;
  color: {{ $primary }};
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 10px;
}
.lettre-emetteur-info {
  font-size: 9px;
  color: #555;
  line-height: 1.7;
}
.lettre-date-lieu {
  font-size: 9.5px;
  color: #555;
  line-height: 1.7;
}

/* Séparateur */
.lettre-divider {
  height: 2px;
  background: linear-gradient(to right, {{ $primary }}, transparent);
  margin: 20px 0;
}
.lettre-divider-thin {
  height: 1px;
  background: #e9ecef;
  margin: 16px 0;
}

/* Destinataire */
.lettre-destinataire {
  margin-bottom: 28px;
}
.lettre-dest-label {
  font-size: 8.5px;
  color: #999;
  text-transform: uppercase;
  letter-spacing: .07em;
  margin-bottom: 6px;
}
.lettre-dest-box {
  background: #f8f9fb;
  border-left: 3px solid {{ $primary }};
  padding: 10px 14px;
  display: inline-block;
  min-width: 200px;
}
.lettre-dest-nom {
  font-size: 10px;
  font-weight: bold;
  color: {{ $dark }};
}
.lettre-dest-info {
  font-size: 9px;
  color: #555;
  line-height: 1.6;
}

/* Objet */
.lettre-objet {
  margin-bottom: 22px;
}
.lettre-objet-label {
  font-size: 9px;
  color: #999;
  text-transform: uppercase;
  letter-spacing: .07em;
}
.lettre-objet-text {
  font-size: 11px;
  font-weight: bold;
  color: {{ $dark }};
}

/* Corps */
.lettre-corps p {
  font-size: 10px;
  color: #333;
  line-height: 1.85;
  margin-bottom: 14px;
  text-align: justify;
}
.lettre-corps p strong {
  color: {{ $dark }};
  font-weight: bold;
}
.lettre-accent {
  color: {{ $primary }};
  font-weight: bold;
}

/* Signature */
.lettre-signature {
  margin-top: 30px;
  text-align: right;
}
.lettre-sign-formule {
  font-size: 10px;
  color: #333;
  margin-bottom: 8px;
  font-style: italic;
}
.lettre-sign-nom {
  font-size: 12px;
  font-weight: bold;
  color: {{ $dark }};
}
.lettre-sign-trait {
  width: 120px;
  height: 2px;
  background: {{ $primary }};
  display: inline-block;
  margin: 6px 0;
}
.lettre-sign-poste {
  font-size: 8.5px;
  color: {{ $primary }};
  text-transform: uppercase;
  letter-spacing: .05em;
}

/* Pied de page */
.lettre-footer {
  position: absolute;
  bottom: 30px;
  left: 55px;
  right: 55px;
  border-top: 1px solid #e9ecef;
  padding-top: 10px;
  display: table;
  width: calc(100% - 110px);
}
.lettre-footer-info {
  font-size: 7.5px;
  color: #aaa;
  display: table-cell;
}
.lettre-footer-right {
  font-size: 7.5px;
  color: #aaa;
  display: table-cell;
  text-align: right;
}

/* ══ MODÈLE MODERNE (bandeau coloré) ══ */
.lettre-modern .lettre-bandeau {
  background: {{ $dark }};
  margin: -50px -55px 30px;
  padding: 30px 55px;
}
.lettre-modern .lettre-emetteur-nom { color: #fff; }
.lettre-modern .lettre-emetteur-poste { color: {{ $primary }}; }
.lettre-modern .lettre-emetteur-info { color: rgba(255,255,255,.65); }

/* ══ MODÈLE COLORÉ ══ */
.lettre-colore .lettre-accent-bar {
  width: 50px;
  height: 4px;
  background: {{ $primary }};
  margin-bottom: 20px;
  border-radius: 2px;
}
</style>
</head>
<body>

@php
  $prenom    = $user->prenom ?? ($params['site_prenom'] ?? '');
  $nom       = $user->nom    ?? ($params['site_nom']    ?? '');
  $poste     = $params['site_poste'] ?? 'Développeur Web & Mobile';
  $email     = $params['site_email'] ?? $user->email ?? '';
  $telephone = $params['site_telephone'] ?? '';
  $ville     = $params['site_ville'] ?? '';
  $siteUrl   = $params['site_url'] ?? '';

  $entreprise = $lettre->entreprise;
  $recruteur  = $lettre->recruteur;
  $lePoste    = $lettre->poste;
  $contrat    = $lettre->type_contrat_label;
  $villeLet   = $lettre->ville ?: $ville;
  $dateLet    = $lettre->date_lettre->translatedFormat('d F Y');
  $infos      = $lettre->infos_complementaires;
  $modele     = $lettre->modele;

  // Contenu adapté selon le type de contrat
  $intro = match(strtolower($lettre->type_contrat)) {
    'stage'      => "dans le cadre de mes études, je suis à la recherche d'un stage en tant que <strong>{$lePoste}</strong>",
    'alternance' => "dans le cadre de mon cursus, je suis à la recherche d'une alternance en tant que <strong>{$lePoste}</strong>",
    'freelance'  => "je vous propose mes services en tant que freelance pour le poste de <strong>{$lePoste}</strong>",
    'mission'    => "je me permets de vous soumettre ma candidature pour une mission en tant que <strong>{$lePoste}</strong>",
    'cdd'        => "je vous adresse ma candidature pour le poste de <strong>{$lePoste}</strong> dans le cadre d'un CDD",
    default      => "je vous adresse ma candidature pour le poste de <strong>{$lePoste}</strong>",
  };
@endphp

<div class="lettre-wrap {{ $modele === 'moderne' ? 'lettre-modern' : ($modele === 'colore' ? 'lettre-colore' : '') }}">

  @if($modele === 'moderne')
  <div class="lettre-bandeau">
    <div class="lettre-emetteur-nom">{{ $prenom }} {{ $nom }}</div>
    <div class="lettre-emetteur-poste">{{ $poste }}</div>
    <div class="lettre-emetteur-info">
      {{ $email }} @if($telephone) &nbsp;·&nbsp; {{ $telephone }} @endif
      @if($siteUrl) &nbsp;·&nbsp; {{ str_replace(['https://','http://'], '', $siteUrl) }} @endif
    </div>
  </div>
  @else
  {{-- En-tête classique / coloré --}}
  <div class="lettre-header">
    <div class="lettre-header-left">
      @if($modele === 'colore')<div class="lettre-accent-bar"></div>@endif
      <div class="lettre-emetteur-nom">{{ $prenom }} {{ $nom }}</div>
      <div class="lettre-emetteur-poste">{{ $poste }}</div>
      <div class="lettre-emetteur-info">
        @if($email) {{ $email }}<br> @endif
        @if($telephone) {{ $telephone }}<br> @endif
        @if($siteUrl) {{ str_replace(['https://','http://'], '', $siteUrl) }} @endif
      </div>
    </div>
    <div class="lettre-header-right">
      <div class="lettre-date-lieu">
        {{ $villeLet ? $villeLet . ', le ' : 'Le ' }}{{ $dateLet }}
      </div>
    </div>
  </div>
  <div class="lettre-divider"></div>
  @endif

  @if($modele === 'moderne')
  <div style="text-align:right;margin-bottom:20px">
    <div class="lettre-date-lieu" style="color:#555">
      {{ $villeLet ? $villeLet . ', le ' : 'Le ' }}{{ $dateLet }}
    </div>
  </div>
  @endif

  {{-- Destinataire --}}
  <div class="lettre-destinataire">
    <div class="lettre-dest-label">Destinataire</div>
    <div class="lettre-dest-box">
      @if($recruteur)
        <div class="lettre-dest-nom">{{ $recruteur }}</div>
      @else
        <div class="lettre-dest-nom">Le/La Responsable RH</div>
      @endif
      <div class="lettre-dest-info">
        {{ $entreprise }}<br>
        {{ $villeLet }}
      </div>
    </div>
  </div>

  {{-- Objet --}}
  <div class="lettre-objet">
    <div class="lettre-objet-label">Objet :</div>
    <div class="lettre-objet-text">
      Candidature — {{ $lePoste }} ({{ $contrat }}) — {{ $entreprise }}
    </div>
  </div>
  <div class="lettre-divider-thin"></div>

  {{-- Corps de la lettre --}}
  <div class="lettre-corps">

    <p>
      @if($recruteur)
        Madame, Monsieur <strong>{{ $recruteur }}</strong>,
      @else
        Madame, Monsieur,
      @endif
    </p>

    <p>
      C'est avec un vif intérêt que {!! $intro !!} au sein de <strong class="lettre-accent">{{ $entreprise }}</strong>.
      Passionné par le développement web et mobile, je mets mon expertise au service de projets innovants
      et ambitieux depuis plusieurs années.
    </p>

    <p>
      Fort de mon expérience en développement Full-Stack — notamment avec <strong>Laravel, PHP, JavaScript</strong>
      et <strong>Flutter</strong> — j'ai eu l'opportunité de concevoir et déployer des applications web et mobiles
      complètes, des plateformes e-commerce, des systèmes de gestion et diverses solutions sur mesure.
      Ma maîtrise des CMS (<strong>WordPress, WooCommerce</strong>) ainsi que des bases de données
      (<strong>MySQL, PostgreSQL</strong>) complète mon profil technique.
    </p>

    <p>
      Ce qui m'attire particulièrement chez <strong class="lettre-accent">{{ $entreprise }}</strong>,
      c'est @if($infos) {{ $infos }} @else l'opportunité de contribuer à des projets à fort impact
      et de collaborer avec une équipe dynamique partageant une vision ambitieuse du numérique @endif.
      Je suis convaincu que mes compétences techniques et mon esprit d'initiative pourront apporter
      une réelle valeur ajoutée à vos équipes.
    </p>

    <p>
      Rigoureux, créatif et doté d'un excellent esprit d'équipe, je suis autonome tout en sachant m'intégrer
      dans un environnement collaboratif. Mon parcours académique — <strong>Master Big Data Analytics</strong>
      à l'UVCI — renforce mon approche analytique des problématiques métier.
    </p>

    <p>
      Je me tiens disponible pour un entretien à votre convenance, et reste joignable par email ou téléphone
      pour tout échange complémentaire. Vous trouverez mon portfolio en ligne à l'adresse
      @if($siteUrl) <strong>{{ str_replace(['https://','http://'], '', $siteUrl) }}</strong> @endif,
      où figurent mes réalisations les plus récentes.
    </p>

    <p>Dans l'attente de votre retour, je vous adresse mes sincères salutations.</p>

  </div>

  {{-- Signature --}}
  <div class="lettre-signature">
    <div class="lettre-sign-formule">Cordialement,</div>
    <div class="lettre-sign-trait"></div><br>
    <div class="lettre-sign-nom">{{ $prenom }} {{ $nom }}</div>
    <div class="lettre-sign-poste">{{ $poste }}</div>
  </div>

  {{-- Pied de page --}}
  <div class="lettre-footer">
    <div class="lettre-footer-info">
      {{ $email }}
      @if($telephone) &nbsp;·&nbsp; {{ $telephone }} @endif
    </div>
    <div class="lettre-footer-right">
      @if($siteUrl) {{ str_replace(['https://','http://'], '', $siteUrl) }} @endif
    </div>
  </div>

</div>
</body>
</html>
