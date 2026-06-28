@extends('layouts_admin.master_admin')
@section('title', 'Expériences & Formations')

@section('content')
{{-- ── En-tête ── --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Parcours</div>
    <h4 class="page-title mb-1">Expériences &amp; Formations</h4>
    <p class="text-muted small mb-0">Gérez votre parcours professionnel et académique.</p>
  </div>
  <a href="{{ route('experiences.create') }}" class="btn-add">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Ajouter
  </a>
</div>

{{-- ── KPI ── --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="kpi-card kpi-primary">
      <div class="kpi-icon-wrap" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
      </div>
      <div class="kpi-num">{{ $stats['total'] }}</div>
      <div class="kpi-label">Total</div>
      <div class="kpi-stripe" style="--c:var(--primary)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--info)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <div class="kpi-num">{{ $stats['travail'] }}</div>
      <div class="kpi-label">Expériences pro</div>
      <div class="kpi-stripe" style="--c:var(--info)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--success)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
        </svg>
      </div>
      <div class="kpi-num">{{ $stats['formation'] }}</div>
      <div class="kpi-label">Formations</div>
      <div class="kpi-stripe" style="--c:var(--success)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--warning)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/>
          <polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div class="kpi-num">{{ $stats['en_cours'] }}</div>
      <div class="kpi-label">En cours</div>
      <div class="kpi-stripe" style="--c:var(--warning)"></div>
    </div>
  </div>
</div>

{{-- ── Filtres ── --}}
<div class="filter-panel mb-4">
  <div class="statut-tabs">
    <a href="{{ route('experiences.index') }}"
       class="statut-tab {{ !request('type') ? 'statut-tab--active' : '' }}">
      Tous <span class="statut-tab-pill">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('experiences.index', ['type' => 'travail']) }}"
       class="statut-tab {{ request('type') === 'travail' ? 'statut-tab--active statut-tab--info' : '' }}">
      <i class="bi bi-briefcase-fill"></i> Travail <span class="statut-tab-pill">{{ $stats['travail'] }}</span>
    </a>
    <a href="{{ route('experiences.index', ['type' => 'formation']) }}"
       class="statut-tab {{ request('type') === 'formation' ? 'statut-tab--active statut-tab--success' : '' }}">
      <i class="bi bi-mortarboard-fill"></i> Formation <span class="statut-tab-pill">{{ $stats['formation'] }}</span>
    </a>
  </div>

  <form method="GET" action="{{ route('experiences.index') }}" class="filter-form">
    @if(request('type'))
      <input type="hidden" name="type" value="{{ request('type') }}">
    @endif
    <div class="search-box">
      <svg class="search-box-ico" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="search" class="search-box-input"
        placeholder="Titre ou établissement..."
        value="{{ request('search') }}">
      @if(request('search'))
        <a href="{{ route('experiences.index', request()->except('search')) }}" class="search-box-clear"><i class="bi bi-x"></i></a>
      @endif
    </div>
    <button type="submit" class="btn-filtre">Filtrer</button>
    @if(request()->hasAny(['search','type']))
      <a href="{{ route('experiences.index') }}" class="btn-reset">Réinitialiser</a>
    @endif
  </form>
</div>

{{-- ── Timeline / Cartes ── --}}
@if($experiences->isNotEmpty())

  {{-- Regroupement par type --}}
  @php
    $grouped = $experiences->groupBy('type');
    $ordre   = ['travail', 'formation'];
  @endphp

  @foreach($ordre as $type)
    @if(isset($grouped[$type]) && !request()->filled('type') || request('type') === $type)
      @php $items = $grouped[$type] ?? $experiences->where('type', $type); @endphp
      @if($items->count())

      <div class="exp-group mb-4">
        <div class="exp-group-header">
          <span class="exp-group-ico">{!! $type === 'travail' ? '<i class="bi bi-briefcase-fill"></i>' : '<i class="bi bi-mortarboard-fill"></i>' !!}</span>
          <span class="exp-group-titre">{{ $type === 'travail' ? 'Expériences professionnelles' : 'Formations' }}</span>
          <span class="exp-group-count">{{ $items->count() }}</span>
        </div>

        <div class="exp-list">
          @foreach($items as $exp)
          <div class="exp-card {{ !$exp->actif ? 'exp-card--inactive' : '' }}">

            {{-- Logo --}}
            <div class="exp-logo">
              @if($exp->logo)
                <img src="{{ asset('storage/' . $exp->logo) }}" alt="{{ $exp->entreprise }}">
              @else
                <span>{!! $type === 'travail' ? '<i class="bi bi-building-fill"></i>' : '<i class="bi bi-mortarboard-fill"></i>' !!}</span>
              @endif
            </div>

            {{-- Infos --}}
            <div class="exp-info">
              <div class="exp-top">
                <div class="exp-titre">{{ $exp->titre }}</div>
                @if($exp->en_cours)
                  <span class="exp-badge-encours">
                    <span class="exp-dot-pulse"></span>En cours
                  </span>
                @endif
                @if(!$exp->actif)
                  <span class="exp-badge-inactive">Masqué</span>
                @endif
              </div>
              <div class="exp-entreprise">
                {{ $exp->entreprise }}
                @if($exp->localisation)
                  <span class="exp-sep">·</span>
                  <span class="exp-localisation">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $exp->localisation }}
                  </span>
                @endif
              </div>
              <div class="exp-periode">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ $exp->periode }}
              </div>
              @if($exp->description)
                <p class="exp-desc">{{ Str::limit(strip_tags($exp->description), 100) }}</p>
              @endif
            </div>

            {{-- Ordre --}}
            <div class="exp-ordre">
              <span class="exp-ordre-num" title="Ordre d'affichage">{{ $exp->ordre }}</span>
            </div>

            {{-- Actions --}}
            <div class="exp-actions">
              <button class="exp-toggle-actif {{ $exp->actif ? 'exp-toggle-actif--on' : '' }}"
                data-id="{{ $exp->id }}"
                title="{{ $exp->actif ? 'Masquer' : 'Afficher' }}">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  @if($exp->actif)
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  @else
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                  @endif
                </svg>
              </button>
              <a href="{{ route('experiences.edit', $exp) }}" class="exp-btn-edit" title="Modifier">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
              </a>
              <button class="exp-btn-delete"
                onclick="confirmDelete('{{ route('experiences.destroy', $exp) }}', '{{ addslashes($exp->titre) }}')"
                title="Supprimer">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
                </svg>
              </button>
            </div>

          </div>
          @endforeach
        </div>
      </div>

      @endif
    @endif
  @endforeach

  @if($experiences->hasPages())
    <div class="d-flex justify-content-center mt-4">
      {{ $experiences->links() }}
    </div>
  @endif

@else
  <div class="empty-state">
    <div class="empty-state-icon"><i class="bi bi-clipboard-fill"></i></div>
    <div class="empty-state-title">
      @if(request()->hasAny(['search','type']))
        Aucune expérience ne correspond à votre recherche
      @else
        Aucune expérience pour l'instant
      @endif
    </div>
    <p class="empty-state-sub">
      @if(request()->hasAny(['search','type']))
        <a href="{{ route('experiences.index') }}">Réinitialiser les filtres</a>
      @else
        Ajoutez votre première expérience professionnelle ou formation.
      @endif
    </p>
    @if(!request()->hasAny(['search','type']))
      <a href="{{ route('experiences.create') }}" class="btn-add mt-3">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter une expérience
      </a>
    @endif
  </div>
@endif

</main>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.exp-toggle-actif').forEach(btn => {
  btn.addEventListener('click', async function () {
    const id = this.dataset.id;
    try {
      const res = await fetch(`/admin/experiences/${id}/toggle`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
        }
      });
      const data = await res.json();
      this.classList.toggle('exp-toggle-actif--on', data.actif);
      const card = this.closest('.exp-card');
      card.classList.toggle('exp-card--inactive', !data.actif);

      // Mettre à jour le badge "Masqué"
      const badge = card.querySelector('.exp-badge-inactive');
      if (!data.actif && !badge) {
        const b = document.createElement('span');
        b.className = 'exp-badge-inactive';
        b.textContent = 'Masqué';
        card.querySelector('.exp-top').appendChild(b);
      } else if (data.actif && badge) {
        badge.remove();
      }

      if (window.showToast) window.showToast(data.message, 'success');
    } catch {
      if (window.showToast) window.showToast('Une erreur est survenue.', 'error');
    }
  });
});
</script>
@endpush


<style>
/* ── Page header ── */
.page-eyebrow { display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px }
.page-eyebrow::before { content:'';width:18px;height:2px;background:var(--primary);border-radius:2px }
.page-title { font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark) }

/* ── Bouton ajouter ── */
.btn-add { display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 20px;border-radius:var(--radius);border:none;cursor:pointer;text-decoration:none;box-shadow:0 4px 14px rgba(255,124,8,.35);transition:all var(--transition) }
.btn-add:hover { background:var(--primary-dark);color:#fff;transform:translateY(-2px);box-shadow:0 8px 22px rgba(255,124,8,.45) }

/* ── KPI ── */
.kpi-card { background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition) }
.kpi-card:hover { transform:translateY(-3px);box-shadow:var(--shadow-md) }
.kpi-icon-wrap { width:44px;height:44px;border-radius:11px;flex-shrink:0;background:rgba(255,255,255,0);box-shadow:inset 0 0 0 44px color-mix(in srgb,var(--c) 12%,transparent);color:var(--c);display:flex;align-items:center;justify-content:center }
.kpi-num { font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--dark);line-height:1 }
.kpi-label { font-size:.76rem;color:var(--muted);font-weight:500;margin-top:2px }
.kpi-stripe { position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--c);opacity:.4 }

/* ── Filtres ── */
.filter-panel { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:10px 16px;box-shadow:var(--shadow) }
.statut-tabs { display:flex;gap:3px }
.statut-tab { display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:9px;font-family:var(--font-body);font-size:.82rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all var(--transition) }
.statut-tab:hover { background:var(--gray-bg);color:var(--text) }
.statut-tab--active { background:var(--dark);color:#fff }
.statut-tab--info    { background:rgba(59,130,246,.12);color:var(--info) }
.statut-tab--success { background:rgba(16,185,129,.12);color:var(--success) }
.statut-tab-pill { background:rgba(0,0,0,.06);padding:1px 8px;border-radius:99px;font-size:.7rem;font-weight:800 }
.statut-tab--active .statut-tab-pill { background:rgba(255,255,255,.18) }
.filter-form { display:flex;align-items:center;gap:8px;flex-wrap:wrap }
.search-box { position:relative;display:flex;align-items:center;background:var(--gray-bg);border:1.5px solid var(--border);border-radius:10px;padding:0 12px 0 34px;transition:all var(--transition) }
.search-box:focus-within { border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff }
.search-box-ico { position:absolute;left:11px;color:var(--muted);pointer-events:none }
.search-box-input { border:none;background:transparent;outline:none;font-family:var(--font-body);font-size:.85rem;color:var(--text);padding:9px 0;width:200px }
.search-box-input::placeholder { color:var(--muted) }
.search-box-clear { color:var(--muted);font-size:.78rem;text-decoration:none;padding:3px;transition:color var(--transition) }
.search-box-clear:hover { color:var(--danger) }
.btn-filtre { padding:9px 16px;border-radius:9px;background:var(--dark);color:#fff;font-family:var(--font-display);font-size:.82rem;font-weight:700;border:none;cursor:pointer;transition:background var(--transition) }
.btn-filtre:hover { background:var(--dark-2) }
.btn-reset { font-size:.8rem;color:var(--muted);text-decoration:none;padding:9px 4px;transition:color var(--transition) }
.btn-reset:hover { color:var(--danger) }

/* ── Groupe ── */
.exp-group-header { display:flex;align-items:center;gap:10px;margin-bottom:14px }
.exp-group-ico { font-size:1.1rem }
.exp-group-titre { font-family:var(--font-display);font-size:.88rem;font-weight:800;color:var(--dark) }
.exp-group-count { background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-size:.7rem;font-weight:800;padding:2px 8px;border-radius:99px }

/* ── Exp card ── */
.exp-list { display:flex;flex-direction:column;gap:10px }
.exp-card {
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);
  padding:16px 18px;display:flex;align-items:flex-start;gap:16px;
  box-shadow:var(--shadow);transition:all var(--transition);
}
.exp-card:hover { box-shadow:var(--shadow-md);transform:translateX(3px) }
.exp-card--inactive { opacity:.55;background:var(--gray-bg) }

/* Logo */
.exp-logo {
  width:48px;height:48px;border-radius:11px;flex-shrink:0;overflow:hidden;
  background:#fff;
  display:flex;align-items:center;justify-content:center;font-size:1.4rem;
  border:1px solid var(--border);
  box-shadow:0 1px 4px rgba(0,0,0,.06);
  padding:5px;
}
.exp-logo img { width:100%;height:100%;object-fit:contain;object-position:center }

/* Infos */
.exp-info { flex:1;min-width:0 }
.exp-top { display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:4px }
.exp-titre { font-family:var(--font-display);font-size:.95rem;font-weight:700;color:var(--dark) }
.exp-badge-encours {
  display:inline-flex;align-items:center;gap:5px;
  background:rgba(16,185,129,.12);color:var(--success);
  font-family:var(--font-display);font-size:.66rem;font-weight:800;
  padding:3px 9px;border-radius:99px;
}
.exp-dot-pulse {
  width:6px;height:6px;border-radius:50%;background:var(--success);
  animation:pvPulse 1.5s infinite;flex-shrink:0;
}
.exp-badge-inactive {
  background:rgba(156,163,175,.15);color:var(--muted);
  font-family:var(--font-display);font-size:.66rem;font-weight:700;
  padding:3px 9px;border-radius:99px;
}
.exp-entreprise { font-size:.84rem;font-weight:600;color:var(--text);margin-bottom:4px;display:flex;align-items:center;flex-wrap:wrap;gap:5px }
.exp-sep { color:var(--border) }
.exp-localisation { display:inline-flex;align-items:center;gap:3px;font-size:.78rem;color:var(--muted);font-weight:400 }
.exp-periode { display:inline-flex;align-items:center;gap:5px;font-size:.76rem;color:var(--muted);margin-bottom:6px }
.exp-desc { font-size:.82rem;color:var(--muted);line-height:1.6;margin:0 }

/* Ordre */
.exp-ordre { flex-shrink:0;margin-top:2px }
.exp-ordre-num { width:28px;height:28px;border-radius:7px;background:var(--gray-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-size:.72rem;font-weight:800;color:var(--muted) }

/* Actions */
.exp-actions { display:flex;align-items:center;gap:6px;flex-shrink:0;margin-top:2px }
.exp-toggle-actif, .exp-btn-edit, .exp-btn-delete {
  width:32px;height:32px;border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  border:none;cursor:pointer;transition:all var(--transition);
  text-decoration:none;
}
.exp-toggle-actif { background:rgba(156,163,175,.1);color:var(--muted) }
.exp-toggle-actif:hover { background:rgba(156,163,175,.2) }
.exp-toggle-actif--on { background:rgba(16,185,129,.1);color:var(--success) }
.exp-toggle-actif--on:hover { background:rgba(16,185,129,.2) }
.exp-btn-edit { background:rgba(59,130,246,.08);color:var(--info) }
.exp-btn-edit:hover { background:rgba(59,130,246,.18);color:var(--info) }
.exp-btn-delete { background:rgba(239,68,68,.08);color:var(--danger) }
.exp-btn-delete:hover { background:rgba(239,68,68,.18);transform:scale(1.08) }

/* ── Empty state ── */
.empty-state { text-align:center;padding:70px 24px;background:#fff;border:1.5px dashed var(--border);border-radius:var(--radius) }
.empty-state-icon { font-size:3rem;margin-bottom:14px;opacity:.38 }
.empty-state-title { font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:7px }
.empty-state-sub { font-size:.86rem;color:var(--muted) }
.empty-state-sub a { color:var(--primary);font-weight:600;text-decoration:none }

/* ── Modal delete ── */
.modal-delete { border:none;border-radius:20px;box-shadow:var(--shadow-lg) }
.modal-delete-titre { font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px }
.modal-delete-txt { font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto }
.btn-annuler { padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition) }
.btn-annuler:hover { background:var(--border) }
.btn-confirmer-suppr { display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition) }
.btn-confirmer-suppr:hover { background:#dc2626;transform:translateY(-1px) }

@keyframes pvPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.3)} }
</style>

