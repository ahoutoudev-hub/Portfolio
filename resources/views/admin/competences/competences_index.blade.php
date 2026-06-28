@extends('layouts_admin.master_admin')
@section('title', 'Compétences')

@section('content')
{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Stack technique</div>
    <h4 class="page-title mb-1">Compétences</h4>
    <p class="text-muted small mb-0">Gérez vos compétences et leur niveau de maîtrise.</p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('competences.categories') }}" class="btn-hd-secondary">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
      </svg>
      Catégories
    </a>
    <a href="{{ route('competences.create') }}" class="btn-add">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Ajouter
    </a>
  </div>
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['total'] }}</div><div class="kpi-label">Total compétences</div></div>
      <div class="kpi-stripe" style="--c:var(--primary)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--info)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['categories'] }}</div><div class="kpi-label">Catégories</div></div>
      <div class="kpi-stripe" style="--c:var(--info)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--success)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['moy_niveau'] }}%</div><div class="kpi-label">Niveau moyen</div></div>
      <div class="kpi-stripe" style="--c:var(--success)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--warning)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['expert'] }}</div><div class="kpi-label">Niveau expert (≥80%)</div></div>
      <div class="kpi-stripe" style="--c:var(--warning)"></div>
    </div>
  </div>
</div>

{{-- Filtres --}}
<div class="filter-panel mb-4">
  <div class="statut-tabs">
    <a href="{{ route('competences.index') }}"
       class="statut-tab {{ !request('categorie') ? 'statut-tab--active' : '' }}">
      Toutes <span class="statut-tab-pill">{{ $stats['total'] }}</span>
    </a>
    @foreach($categories as $cat)
      <a href="{{ route('competences.index', ['categorie' => $cat->id]) }}"
         class="statut-tab {{ request('categorie') == $cat->id ? 'statut-tab--active' : '' }}"
         style="{{ request('categorie') == $cat->id ? '--tab-clr:'.$cat->couleur : '' }}">
        {{ $cat->nom }}
        <span class="statut-tab-pill">{{ $cat->competences_count ?? $cat->competences->count() }}</span>
      </a>
    @endforeach
  </div>

  <form method="GET" action="{{ route('competences.index') }}" class="filter-form">
    @if(request('categorie'))
      <input type="hidden" name="categorie" value="{{ request('categorie') }}">
    @endif
    <div class="search-box">
      <svg class="search-box-ico" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="search" class="search-box-input"
        placeholder="Rechercher une compétence..."
        value="{{ request('search') }}">
      @if(request('search'))
        <a href="{{ route('competences.index', request()->except('search')) }}" class="search-box-clear"><i class="bi bi-x"></i></a>
      @endif
    </div>
    <button type="submit" class="btn-filtre">Filtrer</button>
    @if(request()->hasAny(['search','categorie']))
      <a href="{{ route('competences.index') }}" class="btn-reset">Réinitialiser</a>
    @endif
  </form>
</div>

{{-- Grille compétences groupées par catégorie --}}
@if($competences->isNotEmpty())

  @php
    $grouped = $competences->groupBy('categorie_id');
  @endphp

  @foreach($categories as $cat)
    @if(isset($grouped[$cat->id]))
    <div class="comp-group mb-4">

      {{-- Header catégorie --}}
      <div class="comp-group-header">
        <div class="comp-group-left">
          <span class="comp-group-dot" style="background:{{ $cat->couleur }}"></span>
          <span class="comp-group-nom">{{ $cat->nom }}</span>
          <span class="comp-group-count">{{ $grouped[$cat->id]->count() }} compétence{{ $grouped[$cat->id]->count() > 1 ? 's' : '' }}</span>
        </div>
        <a href="{{ route('competences.create', ['categorie' => $cat->id]) }}" class="comp-group-add">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
          </svg>
          Ajouter dans {{ $cat->nom }}
        </a>
      </div>

      {{-- Cards compétences --}}
      <div class="comp-grid">
        @foreach($grouped[$cat->id]->sortBy('ordre') as $comp)
        <div class="comp-card" data-id="{{ $comp->id }}">

          {{-- Icône + nom --}}
          <div class="comp-card-top">
            <div class="comp-icone">
              @if($comp->icone)
                <img src="https://cdn.simpleicons.org/{{ $comp->icone }}/{{ ltrim($cat->couleur, '#') }}"
                     alt="{{ $comp->nom }}"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                <span class="comp-icone-fallback" style="display:none"><i class="bi bi-lightning-charge-fill"></i></span>
              @else
                <span><i class="bi bi-lightning-charge-fill"></i></span>
              @endif
            </div>
            <div class="comp-actions">
              <a href="{{ route('competences.edit', $comp) }}" class="comp-btn-edit" title="Modifier">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
              </a>
              <button class="comp-btn-delete"
                onclick="confirmDelete('{{ route('competences.destroy', $comp) }}', '{{ addslashes($comp->nom) }}')"
                title="Supprimer">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
                </svg>
              </button>
            </div>
          </div>

          {{-- Nom --}}
          <div class="comp-nom">{{ $comp->nom }}</div>

          {{-- Barre de niveau --}}
          <div class="comp-niveau-wrap">
            <div class="comp-niveau-bar">
              <div class="comp-niveau-fill"
                style="width:{{ $comp->niveau }}%;background:{{ $cat->couleur }}"
                data-niveau="{{ $comp->niveau }}">
              </div>
            </div>
          </div>

          {{-- Pied : niveau + label --}}
          <div class="comp-card-footer">
            <span class="comp-niveau-num" style="color:{{ $cat->couleur }}">
              {{ $comp->niveau }}%
            </span>
            <span class="comp-niveau-label"
              style="background:{{ $comp->niveau_color }}18;color:{{ $comp->niveau_color }}">
              {{ $comp->niveau_label }}
            </span>
          </div>

          {{-- Input niveau inline --}}
          <input type="range" class="comp-range"
            min="0" max="100" step="5"
            value="{{ $comp->niveau }}"
            data-id="{{ $comp->id }}"
            style="--rc:{{ $cat->couleur }}"
            title="Glissez pour modifier le niveau">

        </div>
        @endforeach
      </div>

    </div>
    @endif
  @endforeach

  @if($competences->hasPages())
    <div class="d-flex justify-content-center mt-4">{{ $competences->links() }}</div>
  @endif

@else
  <div class="empty-state">
    <div class="empty-state-icon"><i class="bi bi-lightning-charge-fill"></i></div>
    <div class="empty-state-title">
      @if(request()->hasAny(['search','categorie']))
        Aucune compétence ne correspond
      @else
        Aucune compétence pour l'instant
      @endif
    </div>
    <p class="empty-state-sub">
      @if(request()->hasAny(['search','categorie']))
        <a href="{{ route('competences.index') }}">Réinitialiser</a>
      @else
        Ajoutez votre première compétence.
      @endif
    </p>
    @if(!request()->hasAny(['search','categorie']))
      <a href="{{ route('competences.create') }}" class="btn-add mt-3">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter une compétence
      </a>
    @endif
  </div>
@endif

</main>
@endsection

@push('scripts')
<script>
/* ── Range slider → update niveau en AJAX ── */
let debounceTimer;
document.querySelectorAll('.comp-range').forEach(range => {
  range.addEventListener('input', function () {
    const id      = this.dataset.id;
    const niveau  = this.value;
    const card    = this.closest('.comp-card');

    // Mise à jour UI immédiate
    card.querySelector('.comp-niveau-fill').style.width  = niveau + '%';
    card.querySelector('.comp-niveau-fill').dataset.niveau = niveau;
    card.querySelector('.comp-niveau-num').textContent   = niveau + '%';

    // Label
    const label = card.querySelector('.comp-niveau-label');
    const n = parseInt(niveau);
    if (n >= 90)      { label.textContent = 'Expert';        label.style.background = '#10b98118'; label.style.color = '#10b981'; }
    else if (n >= 75) { label.textContent = 'Avancé';        label.style.background = '#3b82f618'; label.style.color = '#3b82f6'; }
    else if (n >= 50) { label.textContent = 'Intermédiaire'; label.style.background = '#f59e0b18'; label.style.color = '#f59e0b'; }
    else              { label.textContent = 'Débutant';      label.style.background = '#9ca3af18'; label.style.color = '#9ca3af'; }

    // Envoi AJAX après 600ms
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(async () => {
      try {
        await fetch(`/admin/competences/${id}/niveau`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify({ niveau })
        });
        if (window.showToast) window.showToast('Niveau mis à jour.', 'success');
      } catch {
        if (window.showToast) window.showToast('Erreur lors de la mise à jour.', 'error');
      }
    }, 600);
  });
});

/* ── Animate bars on load ── */
document.querySelectorAll('.comp-niveau-fill').forEach(bar => {
  const w = bar.dataset.niveau;
  bar.style.width = '0%';
  setTimeout(() => { bar.style.width = w + '%'; }, 200);
});
</script>
@endpush


<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}

.btn-add{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 20px;border-radius:var(--radius);border:none;cursor:pointer;text-decoration:none;box-shadow:0 4px 14px rgba(255,124,8,.35);transition:all var(--transition)}
.btn-add:hover{background:var(--primary-dark);color:#fff;transform:translateY(-2px)}
.btn-hd-secondary{display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border);text-decoration:none;transition:all var(--transition)}
.btn-hd-secondary:hover{background:var(--border);color:var(--dark)}

/* KPI */
.kpi-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition)}
.kpi-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.kpi-icon-wrap{width:44px;height:44px;border-radius:11px;flex-shrink:0;box-shadow:inset 0 0 0 44px color-mix(in srgb,var(--c) 12%,transparent);color:var(--c);display:flex;align-items:center;justify-content:center}
.kpi-num{font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--dark);line-height:1}
.kpi-label{font-size:.76rem;color:var(--muted);font-weight:500;margin-top:2px}
.kpi-stripe{position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--c);opacity:.4}

/* Filter panel */
.filter-panel{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:10px 16px;box-shadow:var(--shadow)}
.statut-tabs{display:flex;gap:3px;flex-wrap:wrap}
.statut-tab{display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:9px;font-family:var(--font-body);font-size:.82rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all var(--transition)}
.statut-tab:hover{background:var(--gray-bg);color:var(--text)}
.statut-tab--active{background:var(--dark);color:#fff}
.statut-tab-pill{background:rgba(0,0,0,.06);padding:1px 8px;border-radius:99px;font-size:.7rem;font-weight:800}
.statut-tab--active .statut-tab-pill{background:rgba(255,255,255,.18)}
.filter-form{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.search-box{position:relative;display:flex;align-items:center;background:var(--gray-bg);border:1.5px solid var(--border);border-radius:10px;padding:0 12px 0 34px;transition:all var(--transition)}
.search-box:focus-within{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.search-box-ico{position:absolute;left:11px;color:var(--muted);pointer-events:none}
.search-box-input{border:none;background:transparent;outline:none;font-family:var(--font-body);font-size:.85rem;color:var(--text);padding:9px 0;width:200px}
.search-box-input::placeholder{color:var(--muted)}
.search-box-clear{color:var(--muted);font-size:.78rem;text-decoration:none;padding:3px;transition:color var(--transition)}
.search-box-clear:hover{color:var(--danger)}
.btn-filtre{padding:9px 16px;border-radius:9px;background:var(--dark);color:#fff;font-family:var(--font-display);font-size:.82rem;font-weight:700;border:none;cursor:pointer;transition:background var(--transition)}
.btn-filtre:hover{background:var(--dark-2)}
.btn-reset{font-size:.8rem;color:var(--muted);text-decoration:none;padding:9px 4px;transition:color var(--transition)}
.btn-reset:hover{color:var(--danger)}

/* Groupe */
.comp-group-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px}
.comp-group-left{display:flex;align-items:center;gap:10px}
.comp-group-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.comp-group-nom{font-family:var(--font-display);font-size:.9rem;font-weight:800;color:var(--dark)}
.comp-group-count{background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-size:.68rem;font-weight:800;padding:2px 8px;border-radius:99px}
.comp-group-add{display:inline-flex;align-items:center;gap:5px;font-size:.75rem;font-weight:700;color:var(--primary);text-decoration:none;font-family:var(--font-display);transition:gap var(--transition)}
.comp-group-add:hover{gap:8px}

/* Grille cartes */
.comp-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:14px}

/* Comp card */
.comp-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:16px;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition);position:relative}
.comp-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.comp-card-top{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:12px}
.comp-icone{width:38px;height:38px;border-radius:10px;background:var(--gray-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:1.2rem;overflow:hidden}
.comp-icone img{width:22px;height:22px;object-fit:contain}
.comp-icone-fallback{width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:1.2rem}
.comp-actions{display:flex;gap:4px}
.comp-btn-edit,.comp-btn-delete{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition);text-decoration:none}
.comp-btn-edit{background:rgba(59,130,246,.08);color:var(--info)}
.comp-btn-edit:hover{background:rgba(59,130,246,.18);color:var(--info)}
.comp-btn-delete{background:rgba(239,68,68,.08);color:var(--danger)}
.comp-btn-delete:hover{background:rgba(239,68,68,.18)}

.comp-nom{font-family:var(--font-display);font-size:.9rem;font-weight:700;color:var(--dark);margin-bottom:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

.comp-niveau-wrap{margin-bottom:10px}
.comp-niveau-bar{height:6px;background:var(--border);border-radius:99px;overflow:hidden}
.comp-niveau-fill{height:100%;border-radius:99px;width:0;transition:width 1.2s cubic-bezier(.4,0,.2,1)}

.comp-card-footer{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
.comp-niveau-num{font-family:var(--font-display);font-size:.82rem;font-weight:800}
.comp-niveau-label{font-size:.68rem;font-weight:700;padding:2px 8px;border-radius:99px}

/* Range slider custom */
.comp-range{
  width:100%;height:4px;-webkit-appearance:none;appearance:none;
  background:linear-gradient(to right,var(--rc,var(--primary)) var(--rv,0%),var(--border) var(--rv,0%));
  border-radius:99px;outline:none;cursor:pointer;
  transition:height var(--transition);
}
.comp-range:hover{height:6px}
.comp-range::-webkit-slider-thumb{
  -webkit-appearance:none;width:16px;height:16px;border-radius:50%;
  background:var(--rc,var(--primary));border:2px solid #fff;
  box-shadow:0 1px 4px rgba(0,0,0,.2);cursor:grab;
  transition:transform var(--transition);
}
.comp-range::-webkit-slider-thumb:active{transform:scale(1.3);cursor:grabbing}

/* Empty + modal */
.empty-state{text-align:center;padding:70px 24px;background:#fff;border:1.5px dashed var(--border);border-radius:var(--radius)}
.empty-state-icon{font-size:3rem;margin-bottom:14px;opacity:.38}
.empty-state-title{font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:7px}
.empty-state-sub{font-size:.86rem;color:var(--muted)}
.empty-state-sub a{color:var(--primary);font-weight:600;text-decoration:none}
.modal-delete{border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
.modal-delete-titre{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.modal-delete-txt{font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto}
.btn-annuler{padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition)}
.btn-annuler:hover{background:var(--border)}
.btn-confirmer-suppr{display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition)}
.btn-confirmer-suppr:hover{background:#dc2626;transform:translateY(-1px)}

@media(max-width:768px){.comp-grid{grid-template-columns:repeat(2,1fr)}.filter-panel{flex-direction:column;align-items:stretch}.filter-form{flex-direction:column}.search-box-input{width:100%}}
</style>

