<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- SEO dynamique --}}
  @php
    use App\Models\Parametre;
    use App\Models\User;
    $p = Parametre::pluck('valeur','cle');
    $adminUser = User::where('role', 'admin')->first();
  @endphp

  <meta name="description" content="{{ $p['seo_description'] ?? $p['site_description'] ?? 'Portfolio · Développeur Full-Stack' }}">
  <meta name="keywords"    content="{{ $p['seo_keywords'] ?? '' }}">
  <meta name="author"      content="{{ $p['seo_author'] ?? ($p['site_prenom'] ?? '') . ' ' . ($p['site_nom'] ?? '') }}">

  {{-- Open Graph --}}
  <meta property="og:title"       content="@yield('title', $p['seo_titre'] ?? 'Portfolio')">
  <meta property="og:description" content="{{ $p['seo_description'] ?? '' }}">
  <meta property="og:type"        content="website">
  @if($p['site_url'] ?? null)
    <meta property="og:url" content="{{ $p['site_url'] }}">
  @endif

  <title>@yield('title', $p['seo_titre'] ?? ($p['site_prenom'] ?? '') . ' ' . ($p['site_nom'] ?? '') . ' AHOUTOU')</title>

  {{-- Favicon --}}
  @if($p['site_favicon'] ?? null)
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $p['site_favicon']) }}">
  @endif

  {{-- Fonts + Icons --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style_client.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/animations.css') }}">
  <style>
    :root {
      --font-display: 'Plus Jakarta Sans', sans-serif;
      --font-body:    'Plus Jakarta Sans', sans-serif;
    }
  </style>

  {{-- Couleur principale dynamique --}}
  @if(($p['apparence_primary'] ?? null) && $p['apparence_primary'] !== '#ff7c08')
  <style>
    :root { --primary: {{ $p['apparence_primary'] }}; }
  </style>
  @endif

  @yield('page_css')
</head>
<body>

{{-- ─── LOADER ─── --}}
<div id="page-loader" aria-hidden="true">
  <div class="loader-inner">

    {{-- Anneau SVG --}}
    <div class="loader-ring-wrap">
      <svg class="loader-ring-svg" viewBox="0 0 100 100" fill="none">
        <circle class="loader-ring-track" cx="50" cy="50" r="42"/>
        <circle class="loader-ring-spin"  cx="50" cy="50" r="42"/>
      </svg>
      <div class="loader-logo-letter">A</div>
    </div>

    {{-- Nom --}}
    <div class="loader-brand">Ahoutou<span>.dev</span></div>

    {{-- Barre de progression --}}
    <div class="loader-progress-wrap">
      <div class="loader-progress-bar"></div>
    </div>

  </div>
</div>

{{-- ─── NAVBAR ─── --}}
@include('layouts.navbar', ['p' => $p])

{{-- ─── CONTENU ─── --}}
@yield('content')

{{-- ─── FOOTER ─── --}}
@include('layouts.footer', ['p' => $p])

{{-- ─── BOTTOM NAV MOBILE ─── --}}
@php $currentRoute = request()->route()?->getName(); @endphp
<nav class="mob-bottom-nav" id="mobBottomNav" aria-label="Navigation mobile">
  <a href="{{ route('accueil') }}"
     class="mob-nav-item {{ in_array($currentRoute, ['accueil']) ? 'active' : '' }}">
    <i class="bi bi-house-fill"></i>
    <span>Accueil</span>
  </a>
  <a href="{{ route('apropos') }}"
     class="mob-nav-item {{ $currentRoute === 'apropos' ? 'active' : '' }}">
    <i class="bi bi-person-fill"></i>
    <span>À propos</span>
  </a>
  <a href="{{ route('accueil') }}#services" class="mob-nav-item mob-nav-center">
    <div class="mob-nav-center-btn">
      <i class="bi bi-lightning-charge-fill"></i>
    </div>
    <span>Services</span>
  </a>
  <a href="{{ route('client.projets') }}"
     class="mob-nav-item {{ in_array($currentRoute, ['client.projets','projet.detail']) ? 'active' : '' }}">
    <i class="bi bi-grid-fill"></i>
    <span>Projets</span>
  </a>
  <a href="{{ route('accueil') }}#contact" class="mob-nav-item">
    <i class="bi bi-envelope-fill"></i>
    <span>Contact</span>
  </a>
</nav>

{{-- ─── WELCOME MODAL (accueil uniquement) ─── --}}
@if(request()->routeIs('accueil'))
<div id="welcomeModal" class="wlc-overlay" role="dialog" aria-modal="true" aria-label="Message de bienvenue">
  <canvas id="confettiCanvas" class="wlc-canvas" aria-hidden="true"></canvas>
  <div class="wlc-card">
    <div class="wlc-avatar">
      @if($adminUser?->avatar)
        <img src="{{ asset('storage/' . $adminUser->avatar) }}" alt="{{ $adminUser->prenom ?? '' }}">
      @else
        <i class="bi bi-person-fill" style="font-size:2.2rem;color:var(--primary)"></i>
      @endif
    </div>
    <div class="wlc-wave">👋</div>
    <h2 class="wlc-title">Bienvenue !</h2>
    <p class="wlc-sub">
      Je suis <strong>{{ $p['site_nom'] ?? 'Josué' }}</strong>,<br>
      {{ $p['site_metier'] ?? 'Développeur Full-Stack' }}.<br>
      Ravi de vous voir ici !
    </p>
    <div class="wlc-actions">
      <a href="#contact" class="wlc-btn-primary" id="wlcContact">
        <i class="bi bi-envelope-fill"></i> Me contacter
      </a>
      <button class="wlc-btn-ghost" id="wlcClose">
        Explorer le portfolio
      </button>
    </div>
  </div>
</div>
@endif

{{-- ─── SCRIPTS ─── --}}
<script src="{{ asset('assets/js/script_client.js') }}"></script>

{{-- Dark mode : restaurer le thème sauvegardé --}}
<script>
  (function() {
    const saved = localStorage.getItem('theme');
    const defaultDark = {{ ($p['apparence_dark_mode'] ?? '1') === '1' ? 'true' : 'false' }};
    const dark = saved ? saved === 'dark' : defaultDark;
    if (dark) document.documentElement.setAttribute('data-theme', 'dark');
  })();
</script>

@yield('page_js')
</body>
</html>