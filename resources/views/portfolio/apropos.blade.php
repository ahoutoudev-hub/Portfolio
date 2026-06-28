@extends('layouts.master')

@section('title')

@section('page_css')
<link rel="stylesheet" href="{{ asset('assets/css/style_apropos.css') }}">
@endsection

@section('content')

{{-- ─── HERO À PROPOS ─── --}}
<section class="page-hero" id="top">
  <div class="page-hero-bg"></div>
  <div class="hero-deco-ring hero-deco-ring-1"></div>
  <div class="hero-deco-ring hero-deco-ring-2"></div>
  <div class="hero-deco-dot hero-deco-dot-1"></div>
  <div class="hero-deco-dot hero-deco-dot-2"></div>
  <div class="hero-deco-dot hero-deco-dot-3"></div>

  <div class="container">
    <div class="hero-grid-about">

      {{-- ── Colonne texte ── --}}
      <div class="hero-text-col">

        <div class="hero-badge"><i class="bi bi-hand-wave-fill"></i> Bonjour, je suis</div>

        @if($params['site_disponible'] ?? false)
          <div class="available-badge">
            <span class="avail-dot"></span>
            {{ $params['site_hero_badge'] ?? 'Disponible pour de nouveaux projets' }}
          </div>
        @endif

        <div class="hero-intro-line">Ma philosophie</div>

        <div class="about-bio-block">

          {{-- Citation --}}
          <div class="bio-quote">
            <span class="bio-quote-mark">"</span>
            <p class="bio-quote-text">
              Un développeur ce n'est pas celui qui maîtrise tous les langages de programmation
              par cœur mais celui qui est capable d'interpréter chaque ligne de code et d'avoir
              l'esprit créatif afin d'innover et de résoudre des problèmes.
            </p>
          </div>

          {{-- Biographie depuis paramètres --}}
          <div class="bio-paragraphs">
            @if($params['site_a_propos'] ?? null)
              {!! $params['site_a_propos'] !!}
            @else
              <p class="bio-p">
                Je suis <strong class="bio-name">
                  {{ ($params['site_prenom'] ?? '') . ' ' . ($params['site_nom'] ?? '') }}
                </strong>,
                développeur <span class="bio-tag">Full-Stack</span>
                basé à <span class="bio-tag">{{ $params['site_ville'] ?? 'Abidjan' }}, {{ $params['site_pays'] ?? 'Côte d\'Ivoire' }}</span>.
                Avec plus de <strong>{{ $params['stats_experience'] ?? '3' }} ans d'expérience</strong>,
                je crée des applications web modernes, performantes et pensées pour l'utilisateur.
              </p>
            @endif
          </div>

          <div class="bio-divider"></div>

          {{-- Points forts --}}
          <div class="bio-strengths">
            <div class="bio-strength-item">
              <div class="bio-strength-icon"><i class="bi bi-bullseye"></i></div>
              <div>
                <div class="bio-strength-label">Orienté résultat</div>
                <div class="bio-strength-desc">Livraison dans les délais, sans compromis sur la qualité</div>
              </div>
            </div>
            <div class="bio-strength-item">
              <div class="bio-strength-icon"><i class="bi bi-handshake"></i></div>
              <div>
                <div class="bio-strength-label">Communication claire</div>
                <div class="bio-strength-desc">Suivi régulier et transparence tout au long du projet</div>
              </div>
            </div>
            <div class="bio-strength-item">
              <div class="bio-strength-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
              <div>
                <div class="bio-strength-label">Toujours en veille</div>
                <div class="bio-strength-desc">Open-source, articles techniques, nouvelles technos</div>
              </div>
            </div>
          </div>

        </div>

        <br>

        {{-- Chips contact --}}
        <div class="info-chips">
          @if(($params['site_ville'] ?? null) || ($params['site_pays'] ?? null))
            <span class="info-chip">
              <span class="chip-icon"><i class="bi bi-geo-alt-fill"></i></span>
              {{ $params['site_ville'] ?? '' }}{{ ($params['site_ville'] && $params['site_pays']) ? ', ' : '' }}{{ $params['site_pays'] ?? '' }}
            </span>
          @endif
          @if($params['site_email'] ?? null)
            <span class="info-chip">
              <span class="chip-icon"><i class="bi bi-envelope-fill"></i></span>
              {{ $params['site_email'] }}
            </span>
          @endif
          @if($params['site_telephone'] ?? null)
            <span class="info-chip">
              <span class="chip-icon"><i class="bi bi-telephone-fill"></i></span>
              {{ $params['site_telephone'] }}
            </span>
          @endif
        </div>

        {{-- Boutons --}}
        <div class="hero-btns-ab">
          <a href="{{ route('accueil') }}#contact" class="btn-primary">
            <i class="bi bi-envelope-fill"></i> Me contacter
          </a>
          @if($params['site_cv'] ?? null)
            <a href="{{ $params['site_cv'] }}" class="btn-outline" target="_blank" download>
              <i class="bi bi-file-earmark-person-fill"></i> Télécharger CV
            </a>
          @endif
        </div>

      </div>

      {{-- ── Colonne visuelle ── --}}
      <div class="hero-visual-about">
        <div class="photo-frame-wrap">
          <div class="photo-halo"></div>
          <div class="photo-frame">
            <span class="frame-corner frame-corner-tl"></span>
            <span class="frame-corner frame-corner-tr"></span>
            <span class="frame-corner frame-corner-bl"></span>
            <span class="frame-corner frame-corner-br"></span>

            <div class="photo-inner">
              @if($user?->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}"
                  alt="{{ $user->nom_complet }}"
                  class="photo-img">
              @else
                <div class="photo-placeholder">
                  <span class="photo-placeholder-emoji"><i class="bi bi-person-workspace"></i></span>
                  @if($user)
                    <span class="photo-placeholder-hint">{{ $user->nom_complet }}</span>
                  @endif
                </div>
              @endif
            </div>

            {{-- Badge expérience --}}
            <div class="photo-badge photo-badge-exp">
              <span class="pb-num">{{ $params['stats_experience'] ?? '3' }}<span class="pb-plus">+</span></span>
              <span class="pb-label">Ans d'exp.</span>
            </div>

            {{-- Badge projets --}}
            <div class="photo-badge photo-badge-proj">
              <span class="pb-num">{{ $params['stats_projets'] ?? '0' }}<span class="pb-plus">+</span></span>
              <span class="pb-label">Projets</span>
            </div>

          </div>
        </div>

        {{-- Réseaux sociaux --}}
        <div class="about-socials">
          @if($params['social_github'] ?? null)
            <a href="{{ $params['social_github'] }}" target="_blank" class="soc-btn" aria-label="GitHub">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
              </svg>
            </a>
          @endif
          @if($params['social_linkedin'] ?? null)
            <a href="{{ $params['social_linkedin'] }}" target="_blank" class="soc-btn" aria-label="LinkedIn">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
              </svg>
            </a>
          @endif
          @php
            $waRaw  = $params['social_whatsapp'] ?? null;
            $waHref = null;
            if ($waRaw) {
              if (str_starts_with($waRaw, 'http')) {
                $waHref = $waRaw;
              } else {
                $num = preg_replace('/[^\d+]/', '', $waRaw);
                if (str_starts_with($num, '0')) $num = '225' . $num;
                $waHref = 'https://wa.me/' . $num;
              }
            }
          @endphp
          @if($waHref)
            <a href="{{ $waHref }}" target="_blank" class="soc-btn" aria-label="WhatsApp">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
              </svg>
            </a>
          @endif
          @if($params['social_facebook'] ?? null)
            <a href="{{ $params['social_facebook'] }}" target="_blank" class="soc-btn" aria-label="Facebook">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
              </svg>
            </a>
          @endif
          @if($params['social_instagram'] ?? null)
            <a href="{{ $params['social_instagram'] }}" target="_blank" class="soc-btn" aria-label="Instagram">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
              </svg>
            </a>
          @endif
        </div>

      </div>
    </div>
  </div>
</section>

  <!-- ─── EXPÉRIENCES ─── -->
  <section class="section exp-section" id="experiences">
    <div class="container">
      <div class="reveal" style="text-align:center;margin-bottom:20px">
        <div class="section-label" style="justify-content:center">Parcours</div>
        <h2 class="section-title" style="text-align:center">Mon expérience &amp; formation</h2>
        <p class="section-sub" style="margin:0 auto">Mon chemin professionnel et académique.</p>
      </div>
      <div class="exp-tabs reveal" style="justify-content:center;margin-top:40px">
        <button class="exp-tab active" data-panel="travail" onclick="switchExp('travail',this)">
          <i class="bi bi-briefcase-fill"></i> Expériences professionnelles
        </button>
        <button class="exp-tab" data-panel="formation" onclick="switchExp('formation',this)">
          <i class="bi bi-mortarboard-fill"></i> Formations
        </button>
      </div>

      {{-- Travail --}}
      <div class="exp-panel active" id="panel-travail">
        <div class="tl-wrap">
          <div class="timeline">
            @foreach($experiencesTravail as $exp)
            <div class="tl-item">
              <div class="tl-dot"></div>
              <div class="tl-card">
                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;margin-bottom:10px">
                  <span class="tl-period">
                    <i class="bi bi-calendar3"></i> {{ $exp->date_debut->translatedFormat('M Y') }}
                    — {{ $exp->en_cours ? 'Présent' : $exp->date_fin?->translatedFormat('M Y') }}
                  </span>
                  @if($exp->en_cours)
                    <span class="en-cours">En cours</span>
                  @endif
                </div>
                <div class="tl-title">{{ $exp->titre }}</div>
                <div class="tl-place">
                  <i class="bi bi-building"></i> {{ $exp->entreprise }}
                  @if($exp->localisation)
                    · <i class="bi bi-geo-alt-fill"></i> {{ $exp->localisation }}
                  @endif
                </div>
                @if($exp->description)
                  <div class="tl-desc">{!! $exp->description !!}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Formation --}}
      <div class="exp-panel" id="panel-formation">
        <div class="tl-wrap">
          <div class="timeline">
            @foreach($experiencesFormation as $exp)
            <div class="tl-item">
              <div class="tl-dot"></div>
              <div class="tl-card">
                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;margin-bottom:10px">
                  <span class="tl-period">
                    <i class="bi bi-calendar3"></i> {{ $exp->date_debut->translatedFormat('M Y') }}
                    — {{ $exp->en_cours ? 'Présent' : $exp->date_fin?->translatedFormat('M Y') }}
                  </span>
                  @if($exp->en_cours)
                    <span class="en-cours">En cours</span>
                  @endif
                </div>
                <div class="tl-title">{{ $exp->titre }}</div>
                <div class="tl-place">
                  <i class="bi bi-mortarboard-fill"></i> {{ $exp->entreprise }}
                  @if($exp->localisation)
                    · <i class="bi bi-geo-alt-fill"></i> {{ $exp->localisation }}
                  @endif
                </div>
                @if($exp->description)
                  <div class="tl-desc">{!! $exp->description !!}</div>
                @endif
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </section>


{{-- ─── COMPÉTENCES ─── --}}
<section class="section skills" id="competences">
  <div class="container">
    <div class="skills-head reveal-left">
      <div>
        <div class="section-label">Compétences</div>
        <h2 class="section-title">Mon stack technique</h2>
      </div>
      <p class="section-sub" style="max-width:340px">
        Les technologies que je maîtrise pour construire vos projets.
      </p>
    </div>
    <div class="skills-grid">
      @forelse($categoriesCompetences as $cat)
      <div class="skills-category reveal">
        <h3>{{ $cat->nom }}</h3>
        @foreach($cat->competences as $comp)
        <div class="skill-item">
          <div class="skill-top">
            <span class="skill-name">{{ $comp->nom }}</span>
            <span class="skill-pct">{{ $comp->niveau }}%</span>
          </div>
          <div class="skill-bar">
            <div class="skill-fill"
              data-w="{{ $comp->niveau }}"
              style="background:{{ $cat->couleur }}">
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @empty
      <p style="color:var(--muted)">Aucune compétence renseignée.</p>
      @endforelse
    </div>
  </div>
</section>

{{-- ─── CERTIFICATS ─── --}}
<section class="section cert-section" id="certificats">
  <div class="container">
    <div class="reveal" style="text-align:center;margin-bottom:52px">
      <div class="section-label" style="justify-content:center">Certificats</div>
      <h2 class="section-title" style="text-align:center">Certifications obtenues</h2>
    </div>
    <div class="cert-grid">
      @forelse($certificats as $cert)
      <div class="cert-card reveal">
        <div class="cert-icon"><i class="bi bi-trophy-fill"></i></div>
        <div>
          <div class="cert-title">{{ $cert->titre }}</div>
          <div class="cert-org">{{ $cert->organisme }}</div>
          <div class="cert-date">{{ $cert->date_obtention?->translatedFormat('M Y') }}</div>
          @if($cert->url_credential)
            <a href="{{ $cert->url_credential }}" target="_blank"
              style="font-size:.74rem;color:var(--primary);font-weight:700;text-decoration:none;margin-top:4px;display:inline-flex;align-items:center;gap:4px">
              <i class="bi bi-link-45deg"></i> Vérifier
            </a>
          @endif
        </div>
      </div>
      @empty
      <div class="cert-card reveal" style="border-style:dashed;opacity:.5">
        <div class="cert-icon" style="background:var(--border)"><i class="bi bi-plus-circle-fill"></i></div>
        <div>
          <div class="cert-title" style="color:var(--muted)">Ajoutez vos certificats</div>
          <div class="cert-org" style="color:var(--muted)">via le tableau de bord</div>
        </div>
      </div>
      @endforelse
    </div>
  </div>
</section>


{{-- ─── CTA ─── --}}
<section class="cta-section">
  <div class="cta-deco cta-deco--1" aria-hidden="true"></div>
  <div class="cta-deco cta-deco--2" aria-hidden="true"></div>
  <div class="cta-deco cta-deco--3" aria-hidden="true"></div>
  <div class="container" style="position:relative;z-index:1">

    <div class="cta-badge reveal">
      <span class="cta-badge-dot"></span>
      @if($params['site_disponible'] ?? false)
        Disponible pour des projets
      @else
        Ouverte aux opportunités
      @endif
    </div>

    <h2 class="cta-title reveal">Un projet en tête ?</h2>
    <p class="cta-sub reveal">
      @if($params['site_disponible'] ?? false)
        Je suis disponible pour de nouvelles collaborations.<br>Discutons de votre projet et construisons quelque chose d'exceptionnel.
      @else
        N'hésitez pas à me contacter pour discuter de votre prochain projet.
      @endif
    </p>

    <div class="cta-btns reveal">
      <a href="{{ route('accueil') }}#contact" class="btn-cta-w">
        <i class="bi bi-envelope-fill"></i> Démarrer un projet
      </a>
      <a href="{{ route('client.projets') }}" class="btn-cta-b">
        <i class="bi bi-rocket-takeoff-fill"></i> Voir mes projets
      </a>
    </div>

  </div>
</section>

@endsection
