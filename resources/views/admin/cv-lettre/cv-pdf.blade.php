<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
@php
  $accent = '#ff7c08';
  $dark   = '#1a2e4a';
  $dark2  = '#0f1e32';
  $text   = '#2d3748';
  $muted  = '#718096';
  $border = '#e2e8f0';
  $gray   = '#f7f8fa';
@endphp

* { margin:0; padding:0; box-sizing:border-box; }

body {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 9pt;
  color: {{ $text }};
  background: #fff;
  line-height: 1.5;
}

.page { width: 210mm; min-height: 297mm; position: relative; background: #fff; }

/* ════ SIDEBAR ════ */
.sb {
  position: absolute;
  top: 0; left: 0;
  width: 64mm;
  min-height: 297mm;
  background: {{ $dark }};
}

/* ════ MAIN ════ */
.mn {
  margin-left: 64mm;
  padding: 0 8mm 10mm 9mm;
  background: #fff;
  min-height: 297mm;
}

/* ──── SIDEBAR ──── */
.sb-top {
  background: {{ $dark2 }};
  padding: 8mm 5mm 6mm;
  text-align: center;
  border-bottom: 3px solid {{ $accent }};
}
.sb-avatar {
  width: 25mm; height: 25mm;
  border-radius: 50%;
  border: 2.5px solid {{ $accent }};
  object-fit: cover;
  display: block;
  margin: 0 auto 3mm;
}
.sb-avatar-ph {
  width: 25mm; height: 25mm;
  border-radius: 50%;
  background: rgba(255,255,255,.08);
  border: 2.5px solid {{ $accent }};
  margin: 0 auto 3mm;
}
.sb-name {
  font-size: 11pt;
  font-weight: bold;
  color: #fff;
  line-height: 1.25;
  margin-bottom: 1.5mm;
}
.sb-prenom { color: {{ $accent }}; }
.sb-poste {
  font-size: 7pt;
  color: rgba(255,255,255,.5);
  text-transform: uppercase;
  letter-spacing: .07em;
  line-height: 1.4;
}

.sb-sec { padding: 4mm 5mm 3mm; border-bottom: 1px solid rgba(255,255,255,.06); }
.sb-sec-title {
  font-size: 7pt;
  font-weight: bold;
  color: {{ $accent }};
  text-transform: uppercase;
  letter-spacing: .09em;
  border-bottom: 1px solid rgba(255,124,8,.2);
  padding-bottom: 1mm;
  margin-bottom: 2.5mm;
}

.sb-info { margin-bottom: 2.5mm; }
.sb-info-lbl {
  font-size: 6pt;
  color: rgba(255,255,255,.35);
  text-transform: uppercase;
  letter-spacing: .07em;
  display: block;
  margin-bottom: .4mm;
}
.sb-info-val {
  font-size: 7.5pt;
  color: rgba(255,255,255,.78);
  line-height: 1.4;
  word-break: break-all;
}

/* Compétence dots - version ASCII */
.sb-item { margin-bottom: 2.5mm; }
.sb-item-name { font-size: 8pt; color: rgba(255,255,255,.82); margin-bottom: .8mm; }
.sb-item-sub  { font-size: 6.5pt; color: rgba(255,255,255,.4); margin-bottom: 1mm; line-height: 1.3; }

/* Barre niveau sidebar */
.sb-bar-wrap  { background: rgba(255,255,255,.12); height: 4px; border-radius: 2px; width: 100%; }
.sb-bar-fill  { height: 4px; border-radius: 2px; background: {{ $accent }}; }
.sb-bar-pct   { font-size: 6pt; color: rgba(255,255,255,.35); text-align: right; margin-top: .5mm; }

/* Langue */
.sb-lang { margin-bottom: 2.5mm; }
.sb-lang-name { font-size: 8pt; color: rgba(255,255,255,.82); margin-bottom: 1mm; }
.sb-lang-lvl  { font-size: 6.5pt; color: rgba(255,255,255,.38); margin-left: 1mm; }

/* Niveau étoiles — utilise des tirets et étoiles ASCII */
.star-full  { color: {{ $accent }};           font-size: 9pt; }
.star-empty { color: rgba(255,255,255,.15);   font-size: 9pt; }

/* Listes */
.sb-li {
  font-size: 7.5pt;
  color: rgba(255,255,255,.7);
  margin-bottom: 1.8mm;
  padding-left: 4mm;
  position: relative;
  line-height: 1.4;
}
.sb-li::before {
  content: '-';
  color: {{ $accent }};
  position: absolute;
  left: 0;
  font-weight: bold;
}

/* ──── MAIN ──── */
.mn-header {
  background: {{ $dark }};
  margin: 0 -9mm 5mm -9mm;
  padding: 7mm 9mm 6mm;
  position: relative;
}
.mn-header-triangle {
  position: absolute;
  top: 0; right: 0;
  width: 0; height: 0;
  border-style: solid;
  border-width: 0 22mm 22mm 0;
  border-color: transparent rgba(255,124,8,.2) transparent transparent;
}
.mn-header-name {
  font-size: 20pt;
  font-weight: bold;
  color: #fff;
  letter-spacing: .01em;
  line-height: 1.15;
}
.mn-header-prenom { color: {{ $accent }}; }
.mn-header-poste {
  font-size: 7.5pt;
  color: rgba(255,255,255,.5);
  text-transform: uppercase;
  letter-spacing: .1em;
  margin-top: 2mm;
}
.mn-bar {
  width: 16mm; height: 2.5px;
  background: {{ $accent }};
  margin-top: 3mm;
  border-radius: 2px;
}

/* Sections */
.sec { margin-bottom: 5mm; }
.sec-title {
  font-size: 8.5pt;
  font-weight: bold;
  color: {{ $dark }};
  text-transform: uppercase;
  letter-spacing: .08em;
  border-bottom: 2px solid {{ $accent }};
  padding-bottom: 1.5mm;
  margin-bottom: 3.5mm;
  display: block;
}

/* Profil */
.profil {
  font-size: 8.5pt;
  color: #4a5568;
  line-height: 1.8;
  text-align: justify;
}

/* Expérience */
.exp { margin-bottom: 4mm; padding-bottom: 3.5mm; border-bottom: .5px solid {{ $border }}; }
.exp:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.exp-date {
  display: inline-block;
  background: rgba(255,124,8,.1);
  color: {{ $accent }};
  font-size: 7pt;
  font-weight: bold;
  padding: 1px 5px 1px 6px;
  border-left: 2.5px solid {{ $accent }};
  margin-bottom: 1.5mm;
}
.exp-titre {
  font-size: 9pt;
  font-weight: bold;
  color: {{ $dark }};
  margin-bottom: .5mm;
  line-height: 1.3;
}
.exp-lieu {
  font-size: 7.5pt;
  color: {{ $muted }};
  font-style: italic;
  margin-bottom: 1.5mm;
}
.exp-desc { font-size: 8pt; color: #4a5568; line-height: 1.65; }

/* Compétences barre (main) */
.comp-sec { margin-bottom: 4mm; }
.comp-cat-name {
  font-size: 8.5pt;
  font-weight: bold;
  color: {{ $dark }};
  margin-bottom: 1mm;
}
.comp-items {
  font-size: 7pt;
  color: {{ $muted }};
  font-style: italic;
  margin-bottom: 1.5mm;
}
.comp-bar-wrap { background: {{ $border }}; height: 5px; border-radius: 99px; }
.comp-bar-fill { height: 5px; border-radius: 99px; background: {{ $accent }}; }
.comp-bar-footer { display: block; text-align: right; font-size: 6.5pt; color: {{ $muted }}; margin-top: .5mm; }

/* Réalisation */
.real { margin-bottom: 1.8mm; padding-left: 4mm; position: relative; }
.real::before { content: '>'; color: {{ $accent }}; position: absolute; left: 0; font-weight: bold; font-size: 8pt; }
.real-title { font-size: 8.5pt; font-weight: bold; color: {{ $dark }}; }
.real-desc  { font-size: 7.5pt; color: {{ $muted }}; }

/* Certificat / diplôme */
.cert { margin-bottom: 3mm; padding-bottom: 2.5mm; border-bottom: .5px solid {{ $border }}; }
.cert:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.cert-date  { font-size: 7.5pt; color: {{ $accent }}; font-weight: bold; margin-bottom: .5mm; }
.cert-title { font-size: 8.5pt; font-weight: bold; color: {{ $dark }}; line-height: 1.3; }
.cert-org   { font-size: 7.5pt; color: {{ $muted }}; font-style: italic; }
.cert-desc  { font-size: 7.5pt; color: #4a5568; margin-top: .4mm; }

/* Grille 2 colonnes */
.g2l { float: left;  width: 48%; }
.g2r { float: right; width: 48%; }
.clr::after { content:''; display:block; clear:both; }

/* Footer QR */
.footer { margin-top: 5mm; padding-top: 3mm; border-top: 1px solid {{ $border }}; }
.footer-qr  { float: left; width: 18mm; }
.footer-qr svg { width: 16mm; height: 16mm; }
.footer-txt {
  margin-left: 21mm;
  font-size: 6.5pt;
  color: #a0aec0;
  font-style: italic;
  line-height: 1.6;
  padding-top: 1mm;
}
.footer-url { color: {{ $accent }}; font-weight: bold; font-style: normal; }
</style>
</head>
<body>
<div class="page">

@php
  $prenom  = $user->prenom  ?? ($params['site_prenom'] ?? 'N\'da Josué');
  $nom     = $user->nom     ?? ($params['site_nom']    ?? 'AHOUTOU');
  $poste   = $cvInfo->titre_professionnel ?? ($params['site_poste'] ?? 'Développeur Full-Stack');
  $email   = $params['site_email']     ?? ($user->email ?? '');
  $tel     = $params['site_telephone'] ?? '';
  $ville   = $params['site_ville']     ?? '';
  $pays    = $params['site_pays']      ?? '';
  $siteUrl = $params['site_url']       ?? url('/');

  $avatarPath = null;
  foreach ([
    !empty($user->avatar)              ? storage_path('app/public/'.$user->avatar)              : null,
    !empty($params['site_avatar'])     ? storage_path('app/public/'.$params['site_avatar'])     : null,
  ] as $p) { if ($p && file_exists($p)) { $avatarPath = $p; break; } }
@endphp

{{-- ════ SIDEBAR ════ --}}
<div class="sb">

  <div class="sb-top">
    @if($avatarPath)
      <img src="{{ $avatarPath }}" class="sb-avatar" alt="">
    @else
      <div class="sb-avatar-ph"></div>
    @endif
    <div class="sb-name">
      <span class="sb-prenom">{{ $prenom }}</span><br>{{ $nom }}
    </div>
    <div class="sb-poste">{{ $poste }}</div>
  </div>

  {{-- Infos --}}
  <div class="sb-sec">
    <div class="sb-sec-title">Informations</div>
    @if($email)
      <div class="sb-info">
        <span class="sb-info-lbl">Email</span>
        <div class="sb-info-val">{{ $email }}</div>
      </div>
    @endif
    @if($tel)
      <div class="sb-info">
        <span class="sb-info-lbl">Telephone</span>
        <div class="sb-info-val">{{ $tel }}</div>
      </div>
    @endif
    @if($ville || $pays)
      <div class="sb-info">
        <span class="sb-info-lbl">Adresse</span>
        <div class="sb-info-val">{{ $ville }}{{ $ville && $pays ? ', ' : '' }}{{ $pays }}</div>
      </div>
    @endif
    @if($cvInfo->date_naissance)
      <div class="sb-info">
        <span class="sb-info-lbl">Naissance</span>
        <div class="sb-info-val">{{ $cvInfo->date_naissance->translatedFormat('d F Y') }}</div>
      </div>
    @endif
    @if($cvInfo->genre)
      <div class="sb-info">
        <span class="sb-info-lbl">Genre</span>
        <div class="sb-info-val">{{ ucfirst($cvInfo->genre) }}</div>
      </div>
    @endif
    @if($cvInfo->nationalite)
      <div class="sb-info">
        <span class="sb-info-lbl">Nationalite</span>
        <div class="sb-info-val">{{ $cvInfo->nationalite }}</div>
      </div>
    @endif
    @if($cvInfo->situation_matrimoniale)
      <div class="sb-info">
        <span class="sb-info-lbl">Situation</span>
        <div class="sb-info-val">{{ ucfirst($cvInfo->situation_matrimoniale) }}</div>
      </div>
    @endif
    @if($cvInfo->permis)
      <div class="sb-info">
        <span class="sb-info-lbl">Permis</span>
        <div class="sb-info-val">{{ $cvInfo->permis }}</div>
      </div>
    @endif
    @if($siteUrl)
      <div class="sb-info">
        <span class="sb-info-lbl">Portfolio</span>
        <div class="sb-info-val">{{ str_replace(['https://','http://'], '', rtrim($siteUrl,'/')) }}</div>
      </div>
    @endif
    @if($params['social_linkedin'] ?? null)
      <div class="sb-info">
        <span class="sb-info-lbl">LinkedIn</span>
        <div class="sb-info-val">{{ str_replace(['https://www.linkedin.com/in/','https://linkedin.com/in/'],'',rtrim($params['social_linkedin'],'/')) }}</div>
      </div>
    @endif
  </div>

  {{-- Competences --}}
  @if($categoriesCompetences->isNotEmpty())
  <div class="sb-sec">
    <div class="sb-sec-title">Competences</div>
    @foreach($categoriesCompetences as $cat)
      @php
        $moy  = $cat->competences->avg('niveau') ?? 0;
        $pct  = intval(round($moy));
        $noms = $cat->competences->pluck('nom')->implode(', ');
      @endphp
      <div class="sb-item">
        <div class="sb-item-name">{{ $cat->nom }}</div>
        <div class="sb-item-sub">{{ $noms }}</div>
        <div class="sb-bar-wrap">
          <div class="sb-bar-fill" style="width:{{ $pct }}%"></div>
        </div>
        <div class="sb-bar-pct">{{ $pct }}%</div>
      </div>
    @endforeach
  </div>
  @endif

  {{-- Langues --}}
  @if($langues->isNotEmpty())
  <div class="sb-sec">
    <div class="sb-sec-title">Langues</div>
    @foreach($langues as $l)
      <div class="sb-lang">
        <div class="sb-lang-name">
          {{ $l->langue }}
          <span class="sb-lang-lvl">— {{ $l->niveau_label }}</span>
        </div>
        <div class="sb-bar-wrap">
          <div class="sb-bar-fill" style="width:{{ ($l->niveau_stars / 5) * 100 }}%"></div>
        </div>
      </div>
    @endforeach
  </div>
  @endif

  {{-- Centres d'interet --}}
  @if($interets->isNotEmpty())
  <div class="sb-sec">
    <div class="sb-sec-title">Centres d'interet</div>
    @foreach($interets as $item)
      <div class="sb-li">{{ $item->interet }}</div>
    @endforeach
  </div>
  @endif

  {{-- Qualites --}}
  @if($qualites->isNotEmpty())
  <div class="sb-sec">
    <div class="sb-sec-title">Qualites</div>
    @foreach($qualites as $q)
      <div class="sb-li">{{ $q->qualite }}</div>
    @endforeach
  </div>
  @endif

</div>{{-- /sb --}}

{{-- ════ MAIN ════ --}}
<div class="mn">

  {{-- Header --}}
  <div class="mn-header">
    <div class="mn-header-triangle"></div>
    <div class="mn-header-name">
      <span class="mn-header-prenom">{{ $prenom }}</span> {{ $nom }}
    </div>
    <div class="mn-header-poste">{{ $poste }}</div>
    <div class="mn-bar"></div>
  </div>

  {{-- PROFIL --}}
  <div class="sec">
    <span class="sec-title">Profil</span>
    <div class="profil">{{ strip_tags($params['site_a_propos'] ?? $params['site_description'] ?? '') }}</div>
  </div>

  {{-- EXPERIENCES --}}
  @if($experiencesTravail->isNotEmpty())
  <div class="sec">
    <span class="sec-title">Experiences Professionnelles</span>
    @foreach($experiencesTravail as $exp)
      <div class="exp">
        <div class="exp-date">
          {{ $exp->date_debut?->translatedFormat('M Y') ?? '' }}
          {{ ($exp->date_debut) ? ' au ' : '' }}
          {{ $exp->en_cours ? 'present' : ($exp->date_fin?->translatedFormat('M Y') ?? '') }}
        </div>
        <div class="exp-titre">{{ strtoupper($exp->titre) }}</div>
        <div class="exp-lieu">{{ $exp->entreprise }}{{ $exp->localisation ? ' - '.$exp->localisation : '' }}</div>
        @if($exp->description)
          <div class="exp-desc">{{ Str::limit(strip_tags($exp->description), 220) }}</div>
        @endif
      </div>
    @endforeach
  </div>
  @endif



  {{-- CERTIFICATS --}}
  @if($certificats->isNotEmpty())
  <div class="sec">
    <span class="sec-title">Certificats</span>
    <div>
      @foreach($certificats as $idx => $cert)
        <div class="{{ $idx % 2 === 0 ? 'g2l' : 'g2r' }}">
          <div class="cert">
            <div class="cert-date">{{ $cert->date_obtention?->translatedFormat('M Y') }}</div>
            <div class="cert-title">{{ $cert->titre }}</div>
            <div class="cert-org">{{ $cert->organisme }}</div>
          </div>
        </div>
        @if($idx % 2 === 1)<div class="clr"></div>@endif
      @endforeach
      <div class="clr"></div>
    </div>
  </div>
  @endif

  {{-- DIPLOMES --}}
  @if($experiencesFormation->isNotEmpty())
  <div class="sec">
    <span class="sec-title">Diplomes Obtenus</span>
    @foreach($experiencesFormation as $exp)
      <div class="cert">
        <div class="cert-date">
          {{ $exp->date_debut?->format('Y') }}{{ !$exp->en_cours && $exp->date_fin ? ' - '.$exp->date_fin->format('Y') : ($exp->en_cours ? ' - present' : '') }}
        </div>
        <div class="cert-title">{{ strtoupper($exp->titre) }}</div>
        <div class="cert-org">{{ $exp->entreprise }}{{ $exp->localisation ? ' - '.$exp->localisation : '' }}</div>
        @if($exp->description)<div class="cert-desc">{{ strip_tags($exp->description) }}</div>@endif
      </div>
    @endforeach
  </div>
  @endif

  {{-- FOOTER QR --}}
  <div class="footer clr">
    <div class="footer-qr">{!! $qrCode !!}</div>
    <div class="footer-txt">
      <strong style="font-size:7pt;color:#4a5568;font-style:normal">Scannez pour acceder a mon portfolio</strong><br>
      <span class="footer-url">{{ str_replace(['https://','http://'],'',rtrim($siteUrl,'/')) }}</span><br>
      J accepte que mes donnees personnelles soient traitees dans le cadre du processus de recrutement.
    </div>
    <div class="clr"></div>
  </div>

</div>{{-- /mn --}}
</div>{{-- /page --}}
</body>
</html>