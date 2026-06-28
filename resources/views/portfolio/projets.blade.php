@extends('layouts.master')

@section('title')

@section('page_css')
<link rel="stylesheet" href="{{ asset('assets/css/style_projets.css') }}">
@endsection

@section('content')

{{-- ─── HERO ─── --}}
<section class="page-hero" id="top">
  <div class="container page-hero-inner">
    <div>
      <div class="section-label">Portfolio</div>
      <h1 class="section-title" style="animation:fadeUp .7s ease both">Mes réalisations</h1>
      <p class="section-sub" style="animation:fadeUp .7s .1s ease both">
        Des solutions concrètes, du code propre, des résultats mesurables.
      </p>
    </div>
  </div>
</section>

{{-- ─── FILTRES + GRILLE ─── --}}
<section class="section" style="padding-top:50px">
  <div class="container">


    {{-- Compteur --}}
    <div class="projects-count reveal">
      Tous <span>{{ $projets->count() }}</span>
    </div>

    {{-- Grille de projets --}}
    <div class="projects-grid" id="projectsGrid">

      @forelse($projets as $i => $projet)
      @php $tagSlugs = $projet->tags->pluck('slug')->implode(' '); @endphp

      <article class="project-card reveal"
        style="transition-delay:{{ $i * 0.07 }}s"
        data-tags="{{ $tagSlugs }}">

        <div class="project-thumb">

          {{-- Badge vedette --}}
          @if($projet->en_vedette)
            <div class="vedette-badge"><i class="bi bi-star-fill"></i> En vedette</div>
          @endif

          {{-- Image ou placeholder --}}
          <div class="project-thumb-inner"
            style="{{ $projet->image ? '' : 'background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);display:flex;align-items:center;justify-content:center' }}">
            @if($projet->image)
              <img src="{{ asset('storage/' . $projet->image) }}"
                alt="{{ $projet->titre }}"
                onerror="this.parentElement.style.cssText='background:linear-gradient(135deg,#1a1a2e,#0f3460);display:flex;align-items:center;justify-content:center';this.outerHTML='<div class=\'project-ph-icon\'><i class=\'bi bi-rocket-takeoff-fill\'></i></div>'">
            @else
              <div class="project-ph-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
            @endif
          </div>

          {{-- Overlay actions --}}
          <div class="project-overlay">
            @if($projet->url_demo)
              <a href="{{ $projet->url_demo }}" target="_blank" class="btn-icon" title="Voir la démo"><i class="bi bi-link-45deg"></i></a>
            @endif
            @if($projet->url_github)
              <a href="{{ $projet->url_github }}" target="_blank" class="btn-icon" title="Code source"><i class="bi bi-code-slash"></i></a>
            @endif
            <a href="{{ route('projet.detail', $projet->slug) }}" class="btn-icon" title="Voir les détails"><i class="bi bi-eye"></i></a>
          </div>

        </div>

        <div class="project-body">

          {{-- Tags --}}
          <div class="project-tags">
            @foreach($projet->tags->take(4) as $tag)
              <span class="tag-c"
                style="background:{{ $tag->couleur }}22;color:{{ $tag->couleur }}">
                {{ $tag->nom }}
              </span>
            @endforeach
          </div>

          {{-- Titre --}}
          <a href="{{ route('projet.detail', $projet->slug) }}" class="project-title">
            {{ $projet->titre }}
          </a>

          {{-- Description --}}
          <p class="project-desc">{{ Str::limit(strip_tags($projet->description), 120) }}</p>

          {{-- Meta --}}
          <div class="project-meta">
            @if($projet->date_fin)
              <span class="meta-item"><i class="bi bi-calendar3"></i> {{ $projet->date_fin->translatedFormat('M Y') }}</span>
            @endif
            <span class="meta-item"><i class="bi bi-tag-fill"></i> Web</span>
          </div>

          {{-- Actions --}}
          <div class="project-actions">
            @if($projet->url_demo)
              <a href="{{ $projet->url_demo }}" target="_blank" class="btn-sm btn-sm-primary">
                <i class="bi bi-link-45deg"></i> Voir
              </a>
            @endif
            <a href="{{ route('projet.detail', $projet->slug) }}" class="btn-sm btn-sm-ghost">
              <i class="bi bi-eye"></i> Détails
            </a>
          </div>

        </div>
      </article>
      @empty
      <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
        <div class="empty-title">Aucun projet publié pour l'instant</div>
        <p style="color:var(--muted);font-size:.88rem;margin-top:8px">
          Revenez bientôt !
        </p>
      </div>
      @endforelse

      {{-- Message filtre vide --}}
      <div class="empty-state" id="emptyState" style="display:none">
        <div class="empty-icon"><i class="bi bi-search"></i></div>
        <div class="empty-title">Aucun projet dans cette catégorie</div>
        <p style="color:var(--muted);font-size:.88rem;margin-top:8px">
          Essayez un autre filtre.
        </p>
        <button onclick="filterProjects('all', document.querySelector('[data-filter=all]'))"
          style="margin-top:20px;padding:11px 24px;border-radius:var(--radius);background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.88rem;cursor:pointer;border:none">
          Voir tous les projets
        </button>
      </div>

    </div>
  </div>
</section>

{{-- ─── CTA ─── --}}
<section class="section" style="background:var(--gray-bg)">
  <div class="container">
    <div class="cta-box reveal">
      <div class="section-label" style="justify-content:center">Collaboration</div>
      <h2>Vous avez un projet similaire ?</h2>
      <p>Discutons de vos besoins et voyons comment je peux vous aider.</p>
      <div class="cta-btns">
        <a href="{{ route('accueil') }}#contact" class="btn-primary"><i class="bi bi-envelope-fill"></i> Démarrer un projet</a>
        <a href="{{ route('apropos') }}" class="btn-outline"><i class="bi bi-person-workspace"></i> En savoir plus</a>
      </div>
    </div>
  </div>
</section>

@endsection

@section('page_js')
<script>
/* ═══════════════════════════════════════
   FILTRES PAR TAG — JavaScript pur
═══════════════════════════════════════ */
function filterProjects(filter, btn) {
  /* ── Activer le bon bouton ── */
  document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const cards   = document.querySelectorAll('.project-card');
  const empty   = document.getElementById('emptyState');
  let   visible = 0;

  cards.forEach(card => {
    const tags = card.dataset.tags || '';
    const show = filter === 'all' || tags.split(' ').includes(filter);
    card.style.display   = show ? '' : 'none';
    card.style.animation = show ? 'fadeUp .4s ease both' : '';
    if (show) visible++;
  });

  document.getElementById('visibleCount').textContent = visible;
  empty.style.display = visible === 0 ? 'block' : 'none';
}

/* ── Reveal au scroll ── */
document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) el.classList.add('visible');
  }, { threshold: 0.1 }).observe(el);
});
</script>
@endsection
