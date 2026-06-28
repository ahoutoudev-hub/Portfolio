<header class="topbar" role="banner">

  {{-- Burger mobile --}}
  <button class="topbar-icon-btn sidebar-toggle" onclick="openSidebar()" aria-label="Ouvrir le menu">
    <i class="bi bi-list" aria-hidden="true"></i>
  </button>

  {{-- Brand (visible mobile uniquement) --}}
  <span class="topbar-brand d-lg-none">AHOUTOU<span>.</span>Admin</span>

  {{-- Breadcrumb --}}
  <nav class="topbar-breadcrumb d-none d-lg-flex" aria-label="Breadcrumb">
    <span>AHOUTOU</span>
    <span class="sep" aria-hidden="true">/</span>
    <span class="crumb-active">@yield('title', 'Dashboard')</span>
  </nav>

  <div class="topbar-spacer"></div>

  {{-- Voir le portfolio --}}
  <a href="/" target="_blank" class="topbar-btn-portfolio d-none d-md-flex" title="Voir le portfolio">
    <i class="bi bi-box-arrow-up-right"></i>
    <span>Portfolio</span>
  </a>

  {{-- Maintenance toggle --}}
  @php $isMaintenance = app()->isDownForMaintenance(); @endphp
  <form method="POST" action="{{ route('maintenance.toggle') }}" style="margin:0" id="maintenanceForm">
    @csrf
    <button type="button"
      class="topbar-maintenance-btn {{ $isMaintenance ? 'topbar-maintenance-btn--on' : '' }}"
      onclick="confirmMaintenance({{ $isMaintenance ? 'true' : 'false' }})"
      title="{{ $isMaintenance ? 'Remettre en ligne' : 'Mettre en maintenance' }}">
      @if($isMaintenance)
        <i class="bi bi-cone-striped"></i>
        <span class="d-none d-lg-inline">En ligne</span>
      @else
        <i class="bi bi-cone-striped"></i>
        <span class="d-none d-lg-inline">Maintenance</span>
      @endif
    </button>
  </form>

  {{-- Notifications --}}
  <a href=""
     class="topbar-icon-btn topbar-notif"
     aria-label="Messages">
    <i class="bi bi-bell" aria-hidden="true"></i>
    @php $nonLusTopbar = \App\Models\Message::where('lu', false)->count(); @endphp
    @if($nonLusTopbar > 0)
      <span class="notif-dot" aria-hidden="true">{{ $nonLusTopbar > 9 ? '9+' : $nonLusTopbar }}</span>
    @endif
  </a>

  {{-- Avatar --}}
  @auth
  <div class="topbar-avatar" title="{{ Auth::user()->nom }} {{ Auth::user()->prenom }}" aria-label="Profil">
    @if(Auth::user()->avatar)
      <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->prenom }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
    @else
      {{ strtoupper(substr(Auth::user()->nom, 0, 1) . substr(Auth::user()->prenom, 0, 1)) }}
    @endif
  </div>
  @endauth

</header>