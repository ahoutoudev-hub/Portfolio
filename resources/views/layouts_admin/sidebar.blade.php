<aside class="sidebar" id="sidebar">

  {{-- ── Brand ── --}}
  <div class="sidebar-brand">
    <div class="brand-icon" aria-hidden="true">
      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
      </svg>
    </div>
    <div class="brand-name">AHOUTOU<span>.</span>Admin</div>
    <span class="brand-badge">v1.0</span>
  </div>

  {{-- ── Navigation ── --}}
  <nav class="sidebar-nav" aria-label="Navigation principale">

    {{-- ── PRINCIPAL ── --}}
    <div class="nav-group-label">Principal</div>

    <a href="{{ route('TableauDeBord') }}"
       class="nav-link-item {{ request()->routeIs('TableauDeBord') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-grid-1x2-fill"></i></span>
      Tableau de bord
    </a>

    <a href="{{ route('messages.index') }}"
       class="nav-link-item {{ request()->routeIs('messages.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-envelope-fill"></i></span>
      Messages
      @php $nonLus = \App\Models\Message::where('lu', false)->count(); @endphp
      @if($nonLus > 0)
        <span class="nav-badge nav-badge--danger">{{ $nonLus }}</span>
      @endif
    </a>

    <a href="{{ route('stats.index') }}"
       class="nav-link-item {{ request()->routeIs('stats.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-bar-chart-line-fill"></i></span>
      Statistiques
    </a>

    {{-- ── PORTFOLIO ── --}}
    <div class="nav-group-label">Portfolio</div>

    <a href="{{ route('projets.index') }}"
       class="nav-link-item {{ request()->routeIs('projets.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-rocket-takeoff-fill"></i></span>
      Projets
    </a>

    <a href="{{ route('experiences.index') }}"
       class="nav-link-item {{ request()->routeIs('experiences.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-briefcase-fill"></i></span>
      Expériences & Formations
    </a>

    <a href="{{ route('competences.index') }}"
       class="nav-link-item {{ request()->routeIs('competences.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-lightning-charge-fill"></i></span>
      Compétences
    </a>

    <a href="{{ route('certificats.index') }}"
       class="nav-link-item {{ request()->routeIs('certificats.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-patch-check-fill"></i></span>
      Certificats
    </a>

    <a href="{{ route('temoignages.index') }}"
       class="nav-link-item {{ request()->routeIs('temoignages.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-chat-quote-fill"></i></span>
      Témoignages
    </a>

    <a href="{{ route('tags.index') }}"
       class="nav-link-item {{ request()->routeIs('tags.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-tags-fill"></i></span>
      Tags
    </a>

    {{-- ── COMPTE ── --}}
    <div class="nav-group-label">Compte</div>

    <a href="{{ route('profil.index') }}"
      class="nav-link-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-person-fill"></i></span>
      Mon profil
    </a>

    <a href="{{ route('admin.cv-lettre.index') }}"
      class="nav-link-item {{ request()->routeIs('admin.cv-lettre.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-file-earmark-person-fill"></i></span>
      CV & Lettre de motivation
    </a>

    <a href="{{ route('parametres.index') }}"
       class="nav-link-item {{ request()->routeIs('parametres.*') ? 'active' : '' }}">
      <span class="nav-icon"><i class="bi bi-gear-fill"></i></span>
      Paramètres
    </a>

    <form method="POST" action="{{ route('auth.logout') }}" id="logoutForm" style="margin:0">
      @csrf
      <button type="button" class="nav-link-item nav-link-item--logout" onclick="confirmLogout()">
        <span class="nav-icon"><i class="bi bi-box-arrow-right"></i></span>
        Déconnexion
      </button>
    </form>

  </nav>

  {{-- ── Footer user ── --}}
  @auth
  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="user-av">
        @if(Auth::user()->avatar)
          <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->prenom }}">
        @else
          {{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}
        @endif
      </div>
      <div class="user-info">
        <div class="user-name">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
        <div class="user-role">Administrateur</div>
      </div>
    </div>
  </div>
  @endauth

</aside>
