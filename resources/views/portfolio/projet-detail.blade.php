@extends('layouts.master')

@section('title')

@section('page_css')
<link rel="stylesheet" href="{{ asset('assets/css/style_detail_projet.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Caveat:wght@500;700&display=swap" rel="stylesheet">
@endsection

@section('content')

{{-- ─── HERO ─── --}}
<section class="detail-hero">
  <div class="container" style="position:relative;z-index:1">

    <h1 class="detail-title">{{ $projet->titre }}</h1>

  </div>

</section>

{{-- ─── CORPS + SIDEBAR ─── --}}
<section class="detail-content">
  <div class="container">
    <div class="detail-layout">

      {{-- ══ CONTENU PRINCIPAL ══ --}}
      <div class="detail-body reveal-left">

        {{-- Contenu riche TinyMCE --}}
        @if($projet->contenu)
          <div class="projet-richtext">
            {!! $projet->contenu !!}
          </div>
        @else
          <h2>À propos de ce projet</h2>
          <div class="projet-short-desc">{!! $projet->description !!}</div>
        @endif

        {{-- ── Fonctionnalités ── --}}
        @if($projet->fonctionnalites && count($projet->fonctionnalites) > 0)
          <div class="detail-feature-block">
            <div class="detail-block-title">
              <span class="detail-block-ico"><i class="bi bi-lightning-charge-fill"></i></span>
              Fonctionnalités principales
            </div>
            <div class="features-grid">
              @foreach($projet->fonctionnalites as $feat)
                <div class="feature-item">
                  <span class="feature-check"><i class="bi bi-check-lg"></i></span>
                  <span>{{ $feat }}</span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- ── Défis & Solutions ── --}}
        @if($projet->defis && count($projet->defis) > 0)
          <div class="detail-feature-block">
            <div class="detail-block-title">
              <span class="detail-block-ico"><i class="bi bi-tools"></i></span>
              Défis & Solutions
            </div>
            @foreach($projet->defis as $defi)
              <div class="defi-item">
                @if(is_array($defi))
                  <div class="defi-challenge">
                    <span class="defi-label defi-label--challenge">Défi</span>
                    {{ $defi['challenge'] ?? '' }}
                  </div>
                  <div class="defi-solution">
                    <span class="defi-label defi-label--solution">Solution</span>
                    {{ $defi['solution'] ?? '' }}
                  </div>
                @else
                  <p>{{ $defi }}</p>
                @endif
              </div>
            @endforeach
          </div>
        @endif

        {{-- ── Technologies ── --}}
        @if($projet->tags->isNotEmpty())
          <div class="detail-feature-block">
            <div class="detail-block-title">
              <span class="detail-block-ico"><i class="bi bi-tag-fill"></i></span>
              Technologies utilisées
            </div>
            <div class="tech-tags">
              @foreach($projet->tags as $tag)
                <span class="tech-tag"
                  style="background:{{ $tag->couleur }}15;color:{{ $tag->couleur }};border:1px solid {{ $tag->couleur }}35">
                  @if($tag->icone)
                    <img src="https://cdn.simpleicons.org/{{ $tag->icone }}/{{ ltrim($tag->couleur,'#') }}"
                      width="14" height="14" alt="" style="vertical-align:middle;margin-right:5px"
                      onerror="this.style.display='none'">
                  @endif
                  {{ $tag->nom }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- ── Galerie images ── --}}
        @if($projet->images->isNotEmpty())
          <div class="gallery-title">Galerie du projet</div>
          <div class="gallery-grid">
            @foreach($projet->images as $img)
              <div class="gallery-item"
                onclick="openLightbox('{{ asset('storage/' . $img->image) }}', '{{ addslashes($img->legende ?? $projet->titre) }}')">
                <img src="{{ asset('storage/' . $img->image) }}"
                  alt="{{ $img->legende ?? $projet->titre }}"
                  loading="lazy">
                @if($img->legende)
                  <div class="gallery-item-caption">{{ $img->legende }}</div>
                @endif
              </div>
            @endforeach
          </div>
        @endif

      </div>

      {{-- ══ SIDEBAR ══ --}}
      <div class="detail-sidebar reveal-right">

        <div class="info-card">
          <div class="info-card-header">
            <div class="info-card-title"><i class="bi bi-info-circle-fill"></i> Informations du projet</div>
          </div>
          <div class="info-card-body">

          @if($projet->type_projet)
          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-tag-fill"></i></div>
            <div>
              <div class="info-lbl">Type</div>
              <div class="info-val">{{ $projet->type_projet }}</div>
            </div>
          </div>
          @endif

          @if($projet->date_debut || $projet->date_fin)
          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-calendar3"></i></div>
            <div>
              <div class="info-lbl">Période</div>
              <div class="info-val">
                @if($projet->date_debut) {{ $projet->date_debut->translatedFormat('M Y') }} @endif
                @if($projet->date_debut && $projet->date_fin) – @endif
                @if($projet->date_fin)   {{ $projet->date_fin->translatedFormat('M Y') }}   @endif
              </div>
            </div>
          </div>
          @endif

          @if($projet->duree)
          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-stopwatch-fill"></i></div>
            <div>
              <div class="info-lbl">Durée</div>
              <div class="info-val">{{ $projet->duree }}</div>
            </div>
          </div>
          @endif

          @if($projet->role)
          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-person-workspace"></i></div>
            <div>
              <div class="info-lbl">Mon rôle</div>
              <div class="info-val">{{ $projet->role }}</div>
            </div>
          </div>
          @endif

          @if($projet->client)
          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-handshake"></i></div>
            <div>
              <div class="info-lbl">Client</div>
              <div class="info-val">{{ $projet->client }}</div>
            </div>
          </div>
          @endif

          <div class="info-row">
            <div class="info-icon-box"><i class="bi bi-check-circle-fill" style="color:var(--success)"></i></div>
            <div>
              <div class="info-lbl">Statut</div>
              <div class="info-val" style="color:var(--success)">
                <span style="display:inline-block;width:7px;height:7px;background:var(--success);border-radius:50%;margin-right:5px;animation:pulse 1.5s infinite"></span>
                Publié
              </div>
            </div>
          </div>



          </div>{{-- /info-card-body --}}

          <div class="sidebar-btns">
            @if($projet->url_demo)
              <a href="{{ $projet->url_demo }}" target="_blank" class="btn-primary-f">
                <i class="bi bi-link-45deg"></i> Voir la démo
              </a>
            @endif
            @if($projet->url_github)
              <a href="{{ $projet->url_github }}" target="_blank" class="btn-outline-f">
                <i class="bi bi-code-slash"></i> Code source
              </a>
            @endif
          </div>
        </div>

        {{-- ── Partager ── --}}
        @if($params['site_url'] ?? null)
        <div class="share-card">
          <div class="share-title"><i class="bi bi-share-fill"></i> Partager</div>
          <div class="share-btns">
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(($params['site_url'] ?? '') . '/projets/' . $projet->slug) }}"
              target="_blank" class="share-btn share-btn--linkedin" title="Partager sur LinkedIn">
              <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
              </svg>
              LinkedIn
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($projet->titre) }}&url={{ urlencode(($params['site_url'] ?? '') . '/projets/' . $projet->slug) }}"
              target="_blank" class="share-btn share-btn--twitter" title="Partager sur X">
              <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
              </svg>
              X
            </a>
            <button onclick="copyLink('{{ ($params['site_url'] ?? '') . '/projets/' . $projet->slug }}')"
              class="share-btn share-btn--copy" id="copyBtn" title="Copier le lien">
              <i class="bi bi-link-45deg"></i> Copier
            </button>
          </div>
        </div>
        @endif

        {{-- ── CTA ── --}}
        <div class="cta-mini">
          <p>Un projet similaire en tête ?</p>
          <a href="{{ route('accueil') }}#contact" class="btn-cta-w"><i class="bi bi-envelope-fill"></i> Discutons-en</a>
        </div>

      </div>

    </div>
  </div>
</section>

{{-- ─── PROJETS LIÉS ─── --}}
@if($projetsLies->isNotEmpty())
<section class="section related-section">
  <div class="container">
    <div class="related-head">
      <h2>Autres projets</h2>
      <a href="{{ route('client.projets') }}" class="btn-back">← Voir tous les projets</a>
    </div>
    <div class="related-grid">
      @foreach($projetsLies as $p)
      <div class="related-card reveal">
        <div class="related-thumb"
          style="{{ $p->image ? 'padding:0;overflow:hidden' : 'background:linear-gradient(135deg,#1a1a2e,#0f3460);display:flex;align-items:center;justify-content:center' }}">
          @if($p->image)
            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->titre }}"
              style="width:100%;height:100%;object-fit:cover">
          @else
            <i class="bi bi-rocket-takeoff-fill" style="font-size:2rem;color:rgba(255,255,255,.4)"></i>
          @endif
        </div>
        <div class="related-body">
          <div class="related-tags">
            @foreach($p->tags->take(3) as $tag)
              <span class="related-tag" style="background:{{ $tag->couleur }}22;color:{{ $tag->couleur }}">
                {{ $tag->nom }}
              </span>
            @endforeach
          </div>
          <a href="{{ route('projet.detail', $p->slug) }}" class="related-title">{{ $p->titre }}</a>
          <p class="related-desc">{{ Str::limit(strip_tags($p->description), 90) }}</p>
          <a href="{{ route('projet.detail', $p->slug) }}" class="btn-detail">Voir le projet →</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLightboxOutside(event)">
  <button class="lightbox-close" onclick="closeLightbox()" aria-label="Fermer"><i class="bi bi-x-lg"></i></button>
  <div class="lightbox-inner">
    <img id="lightboxImg" src="" alt="Aperçu">
    <p id="lightboxCaption" class="lightbox-caption"></p>
  </div>
</div>

@endsection


<style>
/* ── Contenu riche ── */
.projet-richtext h2{font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--dark);margin:32px 0 12px}
.projet-richtext h2:first-child{margin-top:0}
.projet-richtext h3{font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--dark);margin:24px 0 10px}
.projet-richtext p{font-size:1rem;color:var(--text);line-height:1.9;margin-bottom:16px}
.projet-richtext ul,.projet-richtext ol{padding-left:20px;margin-bottom:16px}
.projet-richtext li{font-size:.97rem;color:var(--text);line-height:1.8;margin-bottom:5px}
.projet-richtext strong{color:var(--primary)}
.projet-richtext code{background:var(--gray-bg);border:1px solid var(--border);border-radius:5px;padding:2px 7px;font-family:'Courier New',monospace;font-size:.85em;color:var(--primary)}
.projet-richtext img{max-width:100%;border-radius:var(--radius);margin:16px 0;box-shadow:var(--shadow-md);cursor:zoom-in}
.projet-richtext blockquote{border-left:3px solid var(--primary);padding:12px 18px;background:var(--primary-light);border-radius:0 9px 9px 0;margin:16px 0;font-style:italic}

/* ── Blocs fonctionnalités / défis ── */
.detail-feature-block{margin-top:36px;padding-top:28px;border-top:1px solid var(--border)}
.detail-block-title{display:flex;align-items:center;gap:10px;font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:18px}
.detail-block-ico{font-size:1.1rem}
.features-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:10px}
.feature-item{display:flex;align-items:flex-start;gap:10px;background:var(--gray-bg);border:1px solid var(--border);border-radius:10px;padding:11px 14px;font-size:.88rem;color:var(--text);line-height:1.5}
.feature-check{width:20px;height:20px;border-radius:50%;background:rgba(16,185,129,.12);color:var(--success);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;flex-shrink:0;margin-top:1px}

.defi-item{background:var(--gray-bg);border:1px solid var(--border);border-radius:12px;padding:16px;margin-bottom:12px}
.defi-challenge,.defi-solution{display:flex;align-items:flex-start;gap:10px;font-size:.88rem;color:var(--text);line-height:1.6}
.defi-challenge{margin-bottom:10px}
.defi-label{font-family:var(--font-display);font-size:.65rem;font-weight:800;padding:3px 8px;border-radius:99px;flex-shrink:0;margin-top:2px}
.defi-label--challenge{background:rgba(239,68,68,.1);color:var(--danger)}
.defi-label--solution{background:rgba(16,185,129,.1);color:var(--success)}

/* ── Technologies ── */
.tech-tags{display:flex;flex-wrap:wrap;gap:8px}
.tech-tag{display:inline-flex;align-items:center;padding:7px 16px;border-radius:99px;font-family:var(--font-display);font-size:.82rem;font-weight:700}

/* ── Galerie améliorée ── */
.gallery-item{position:relative;overflow:hidden}
.gallery-item-caption{position:absolute;bottom:0;left:0;right:0;background:linear-gradient(transparent,rgba(0,0,0,.7));color:#fff;font-size:.74rem;padding:18px 10px 8px;opacity:0;transition:opacity .2s}
.gallery-item:hover .gallery-item-caption{opacity:1}

/* ── Partager ── */
.share-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow);margin-top:16px}
.share-title{font-family:var(--font-display);font-size:.85rem;font-weight:800;color:var(--dark);margin-bottom:12px}
.share-btns{display:flex;gap:8px;flex-wrap:wrap}
.share-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 14px;border-radius:9px;font-family:var(--font-display);font-weight:700;font-size:.76rem;text-decoration:none;border:none;cursor:pointer;transition:all .2s}
.share-btn--linkedin{background:#0A66C222;color:#0A66C2}
.share-btn--linkedin:hover{background:#0A66C2;color:#fff}
.share-btn--twitter{background:#00000015;color:#000}
.share-btn--twitter:hover{background:#000;color:#fff}
.share-btn--copy{background:var(--primary-light);color:var(--primary)}
.share-btn--copy:hover{background:var(--primary);color:#fff}

/* ── Lightbox améliorée ── */
.lightbox{position:fixed;inset:0;background:rgba(0,0,0,.92);z-index:9999;display:none;align-items:center;justify-content:center;padding:24px;flex-direction:column;gap:12px}
.lightbox.open{display:flex}
.lightbox-inner{display:flex;flex-direction:column;align-items:center;gap:12px;max-width:90vw}
.lightbox-inner img{max-width:100%;max-height:80vh;border-radius:var(--radius);box-shadow:0 20px 60px rgba(0,0,0,.5)}
.lightbox-caption{color:rgba(255,255,255,.65);font-size:.84rem;text-align:center}
.lightbox-close{position:absolute;top:20px;right:24px;width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.1);color:#fff;display:grid;place-items:center;font-size:1.2rem;cursor:pointer;border:none;transition:background .2s}
.lightbox-close:hover{background:rgba(255,255,255,.2)}
</style>


@section('page_js')
<script>
/* ── Reveal ── */
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) el.classList.add('visible');
  }, { threshold: 0.12 }).observe(el);
});

/* ── Lightbox ── */
function openLightbox(src, caption) {
  document.getElementById('lightboxImg').src     = src;
  document.getElementById('lightboxCaption').textContent = caption || '';
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}
function closeLightboxOutside(e) {
  if (e.target === document.getElementById('lightbox')) closeLightbox();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

/* ── Images richtext → lightbox ── */
document.querySelectorAll('.projet-richtext img').forEach(img => {
  img.addEventListener('click', () => openLightbox(img.src, img.alt));
});

/* ── Copier le lien ── */
function copyLink(url) {
  navigator.clipboard.writeText(url).then(() => {
    const btn = document.getElementById('copyBtn');
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copié !';
    setTimeout(() => { btn.innerHTML = '<i class="bi bi-link-45deg"></i> Copier'; }, 2000);
  });
}
</script>
@endsection
