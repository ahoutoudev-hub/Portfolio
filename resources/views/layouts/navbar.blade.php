@php
  if (!isset($p)) {
    $p = \App\Models\Parametre::pluck('valeur','cle');
  }
  $logo        = $p['site_logo']       ?? 'Portfolio';
  $logoImg     = $p['site_logo_image'] ?? null;
  $disponible  = ($p['site_disponible'] ?? '0') === '1';
  $currentRoute = request()->route()?->getName();
@endphp

{{-- Barre de progression de lecture --}}
<div id="nav-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" aria-label="Progression de lecture"></div>

{{-- Fond sombre mobile --}}
<div class="nav-overlay" id="navOverlay" aria-hidden="true"></div>

<nav id="navbar" role="navigation" aria-label="Navigation principale">
  <div class="container nav-inner">

    {{-- ── Logo ── --}}
    <a href="{{ route('accueil') }}" class="nav-logo" aria-label="Retour à l'accueil">
      @if($logoImg)
        <img src="{{ asset('storage/' . $logoImg) }}" alt="{{ $logo }}" class="nav-logo-img">
      @else
        @php
          $parts  = explode('.', $logo);
          $before = $parts[0] ?? $logo;
          $after  = isset($parts[1]) ? '.' . $parts[1] : '';
        @endphp
        {{ $before }}<span>{{ $after ?: '.' }}</span>
      @endif
      @if($disponible)
        <span class="nav-avail-dot" title="Disponible pour des projets" aria-label="Disponible"></span>
      @endif
    </a>

    {{-- ── Liens ── --}}
    <ul class="nav-links" id="navLinks" role="list">
      <li>
        <a href="{{ route('accueil') }}"
           class="{{ in_array($currentRoute, ['accueil']) ? 'active' : '' }}"
           @if(in_array($currentRoute, ['accueil'])) aria-current="page" @endif>
          Accueil
        </a>
      </li>
      <li>
        <a href="{{ route('apropos') }}"
           class="{{ $currentRoute === 'apropos' ? 'active' : '' }}"
           @if($currentRoute === 'apropos') aria-current="page" @endif>
          À propos
        </a>
      </li>
      <li>
        <a href="{{ route('accueil') }}#services">Services</a>
      </li>
      <li>
        <a href="{{ route('client.projets') }}"
           class="{{ in_array($currentRoute, ['client.projets','projet.detail']) ? 'active' : '' }}"
           @if(in_array($currentRoute, ['client.projets','projet.detail'])) aria-current="page" @endif>
          Projets
        </a>
      </li>
      <li>
        <a href="{{ route('accueil') }}#contact">Contact</a>
      </li>
      {{-- Visible uniquement dans le menu mobile --}}
      <li class="nav-mobile-cta">
        @guest
          <a href="{{ route('accueil') }}#contact" class="btn-nav">Demander un devis</a>
        @endguest
        @auth
          <a href="{{ route('TableauDeBord') }}" class="btn-nav">Tableau de bord</a>
        @endauth
      </li>
    </ul>

    {{-- ── Actions ── --}}
    <div class="nav-actions">

      {{-- Thème --}}
      <button class="btn-theme" id="themeToggle" aria-label="Passer en mode sombre">
        <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
        </svg>
        <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none">
          <circle cx="12" cy="12" r="5"/>
          <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
          <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
      </button>

      @guest
        <a href="{{ route('accueil') }}#contact" class="btn-nav">Demander un devis</a>
      @endguest
      @auth
        <a href="{{ route('TableauDeBord') }}" class="btn-nav">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2.5" aria-hidden="true">
            <rect x="3"  y="3"  width="7" height="7" rx="1.5"/>
            <rect x="14" y="3"  width="7" height="7" rx="1.5"/>
            <rect x="3"  y="14" width="7" height="7" rx="1.5"/>
            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
          </svg>
          Admin
        </a>
      @endauth

      {{-- Burger --}}
      <button class="burger" id="burger"
              aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="navLinks">
        <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
      </button>

    </div>
  </div>
</nav>
