@extends('layouts_admin.master_admin')
@section('title', 'Certificats')

@section('content')
{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Parcours</div>
    <h4 class="page-title mb-1">Certificats</h4>
    <p class="text-muted small mb-0">Gérez vos certifications et diplômes affichés sur le portfolio.</p>
  </div>
  <a href="{{ route('certificats.create') }}" class="btn-add">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Ajouter un certificat
  </a>
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-4">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
        </svg>
      </div>
      <div>
        <div class="kpi-num">{{ $stats['total'] }}</div>
        <div class="kpi-label">Total certificats</div>
      </div>
      <div class="kpi-stripe" style="--c:var(--primary)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--success)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
      </div>
      <div>
        <div class="kpi-num">{{ $stats['actifs'] }}</div>
        <div class="kpi-label">Visibles</div>
      </div>
      <div class="kpi-stripe" style="--c:var(--success)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--info)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
        </svg>
      </div>
      <div>
        <div class="kpi-num">{{ $stats['avec_lien'] }}</div>
        <div class="kpi-label">Avec lien de vérification</div>
      </div>
      <div class="kpi-stripe" style="--c:var(--info)"></div>
    </div>
  </div>
</div>

{{-- Filtres --}}
<div class="filter-panel mb-4">
  <div class="statut-tabs">
    <a href="{{ route('certificats.index') }}"
       class="statut-tab {{ !request('actif') ? 'statut-tab--active' : '' }}">
      Tous <span class="statut-tab-pill">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('certificats.index', ['actif' => 1]) }}"
       class="statut-tab {{ request('actif') === '1' ? 'statut-tab--active statut-tab--success' : '' }}">
      Visibles <span class="statut-tab-pill">{{ $stats['actifs'] }}</span>
    </a>
    <a href="{{ route('certificats.index', ['actif' => 0]) }}"
       class="statut-tab {{ request('actif') === '0' ? 'statut-tab--active statut-tab--muted' : '' }}">
      Masqués <span class="statut-tab-pill">{{ $stats['total'] - $stats['actifs'] }}</span>
    </a>
  </div>

  <form method="GET" action="{{ route('certificats.index') }}" class="filter-form">
    @if(request('actif') !== null && request('actif') !== '') <input type="hidden" name="actif" value="{{ request('actif') }}"> @endif
    <div class="search-box">
      <svg class="search-box-ico" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="search" class="search-box-input"
        placeholder="Titre ou organisme..."
        value="{{ request('search') }}">
      @if(request('search'))
        <a href="{{ route('certificats.index', request()->except('search')) }}" class="search-box-clear"><i class="bi bi-x"></i></a>
      @endif
    </div>
    <button type="submit" class="btn-filtre">Filtrer</button>
    @if(request()->hasAny(['search','actif']))
      <a href="{{ route('certificats.index') }}" class="btn-reset">Réinitialiser</a>
    @endif
  </form>
</div>

{{-- Grille certificats --}}
@if($certificats->isNotEmpty())
<div class="cert-grid">
  @foreach($certificats as $cert)
  <div class="cert-card {{ !$cert->actif ? 'cert-card--inactive' : '' }}">

    {{-- Header de la card --}}
    <div class="cert-card-head">
      <div class="cert-trophee"><i class="bi bi-trophy-fill"></i></div>
      <div class="cert-card-head-actions">
        <button class="btn-toggle-actif {{ $cert->actif ? 'btn-toggle-actif--on' : '' }}"
          data-id="{{ $cert->id }}"
          title="{{ $cert->actif ? 'Masquer' : 'Afficher' }}">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            @if($cert->actif)
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            @else
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            @endif
          </svg>
        </button>
        <a href="{{ route('certificats.edit', $cert) }}" class="cert-btn-edit" title="Modifier">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </a>
        <button class="cert-btn-delete"
          onclick="confirmDelete('{{ route('certificats.destroy', $cert) }}', '{{ addslashes($cert->titre) }}')"
          title="Supprimer">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
          </svg>
        </button>
      </div>
    </div>

    {{-- Contenu --}}
    <div class="cert-card-body">
      <div class="cert-titre">{{ $cert->titre }}</div>
      <div class="cert-organisme">
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        {{ $cert->organisme }}
      </div>
      <div class="cert-date">
        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        {{ $cert->date_formatee }}
      </div>
    </div>

    {{-- Footer --}}
    <div class="cert-card-footer">
      @if($cert->url_credential)
        <a href="{{ $cert->url_credential }}" target="_blank" class="cert-btn-verify">
          <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
          </svg>
          Vérifier
        </a>
      @else
        <span class="cert-no-link">Pas de lien</span>
      @endif

      <div class="cert-ordre-badge">
        #{{ $cert->ordre + 1 }}
      </div>

      @if(!$cert->actif)
        <span class="cert-badge-inactive">Masqué</span>
      @endif
    </div>

  </div>
  @endforeach
</div>

@if($certificats->hasPages())
  <div class="d-flex justify-content-center mt-5">
    {{ $certificats->links() }}
  </div>
@endif

@else
<div class="empty-state">
  <div class="empty-state-icon"><i class="bi bi-trophy-fill"></i></div>
  <div class="empty-state-title">
    @if(request()->hasAny(['search','actif']))
      Aucun certificat ne correspond
    @else
      Aucun certificat pour l'instant
    @endif
  </div>
  <p class="empty-state-sub">
    @if(request()->hasAny(['search','actif']))
      <a href="{{ route('certificats.index') }}">Réinitialiser les filtres</a>
    @else
      Ajoutez votre première certification.
    @endif
  </p>
  @if(!request()->hasAny(['search','actif']))
    <a href="{{ route('certificats.create') }}" class="btn-add mt-3">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Ajouter un certificat
    </a>
  @endif
</div>
@endif

</main>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-toggle-actif').forEach(btn => {
  btn.addEventListener('click', async function () {
    const id = this.dataset.id;
    const res = await fetch(`/admin/certificats/${id}/toggle`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
        'Accept': 'application/json',
      }
    });
    const data = await res.json();
    this.classList.toggle('btn-toggle-actif--on', data.actif);
    const card = this.closest('.cert-card');
    card.classList.toggle('cert-card--inactive', !data.actif);

    // Badge masqué
    const badge = card.querySelector('.cert-badge-inactive');
    if (!data.actif && !badge) {
      const b = document.createElement('span');
      b.className = 'cert-badge-inactive';
      b.textContent = 'Masqué';
      card.querySelector('.cert-card-footer').appendChild(b);
    } else if (data.actif && badge) {
      badge.remove();
    }

    // Rebuild eye icon
    this.innerHTML = data.actif
      ? `<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`
      : `<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;

    if (window.showToast) window.showToast(data.message, 'success');
  });
});
</script>
@endpush


<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-add{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 20px;border-radius:var(--radius);border:none;cursor:pointer;text-decoration:none;box-shadow:0 4px 14px rgba(255,124,8,.35);transition:all var(--transition)}
.btn-add:hover{background:var(--primary-dark);color:#fff;transform:translateY(-2px)}

.kpi-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition)}
.kpi-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.kpi-icon-wrap{width:44px;height:44px;border-radius:11px;flex-shrink:0;box-shadow:inset 0 0 0 44px color-mix(in srgb,var(--c) 12%,transparent);color:var(--c);display:flex;align-items:center;justify-content:center}
.kpi-num{font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--dark);line-height:1}
.kpi-label{font-size:.76rem;color:var(--muted);font-weight:500;margin-top:2px}
.kpi-stripe{position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--c);opacity:.4}

.filter-panel{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:10px 16px;box-shadow:var(--shadow)}
.statut-tabs{display:flex;gap:3px}
.statut-tab{display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:9px;font-family:var(--font-body);font-size:.82rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all var(--transition)}
.statut-tab:hover{background:var(--gray-bg);color:var(--text)}
.statut-tab--active{background:var(--dark);color:#fff}
.statut-tab--success{background:rgba(16,185,129,.12);color:var(--success)}
.statut-tab--muted{background:rgba(156,163,175,.12);color:var(--muted)}
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

/* Grille certificats */
.cert-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:18px}

.cert-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow);display:flex;flex-direction:column;transition:transform var(--transition),box-shadow var(--transition)}
.cert-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
.cert-card--inactive{opacity:.55}

.cert-card-head{display:flex;align-items:center;justify-content:space-between;padding:14px 16px;background:linear-gradient(135deg,var(--dark-3),var(--dark));border-bottom:1px solid var(--border)}
.cert-trophee{font-size:1.8rem;filter:drop-shadow(0 2px 6px rgba(0,0,0,.3))}
.cert-card-head-actions{display:flex;gap:5px}

.btn-toggle-actif,.cert-btn-edit,.cert-btn-delete{width:30px;height:30px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition);text-decoration:none}
.btn-toggle-actif{background:rgba(255,255,255,.1);color:rgba(255,255,255,.4)}
.btn-toggle-actif:hover{background:rgba(255,255,255,.2);color:rgba(255,255,255,.8)}
.btn-toggle-actif--on{background:rgba(16,185,129,.2);color:#10b981}
.cert-btn-edit{background:rgba(255,255,255,.1);color:rgba(255,255,255,.6)}
.cert-btn-edit:hover{background:rgba(255,255,255,.2);color:#fff}
.cert-btn-delete{background:rgba(239,68,68,.15);color:#fca5a5}
.cert-btn-delete:hover{background:rgba(239,68,68,.3)}

.cert-card-body{padding:16px;flex:1}
.cert-titre{font-family:var(--font-display);font-size:.95rem;font-weight:700;color:var(--dark);margin-bottom:8px;line-height:1.3}
.cert-organisme,.cert-date{display:flex;align-items:center;gap:6px;font-size:.8rem;color:var(--muted);margin-bottom:5px}
.cert-organisme svg,.cert-date svg{flex-shrink:0;color:var(--primary)}

.cert-card-footer{display:flex;align-items:center;gap:8px;padding:12px 16px;border-top:1px solid var(--border);background:var(--gray-bg);flex-wrap:wrap}
.cert-btn-verify{display:inline-flex;align-items:center;gap:5px;font-size:.75rem;font-weight:700;color:var(--info);font-family:var(--font-display);text-decoration:none;transition:color var(--transition)}
.cert-btn-verify:hover{color:var(--primary)}
.cert-no-link{font-size:.73rem;color:var(--muted)}
.cert-ordre-badge{margin-left:auto;background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-size:.68rem;font-weight:800;padding:2px 8px;border-radius:99px}
.cert-badge-inactive{background:rgba(156,163,175,.15);color:var(--muted);font-family:var(--font-display);font-size:.66rem;font-weight:700;padding:2px 8px;border-radius:99px}

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

@media(max-width:768px){.cert-grid{grid-template-columns:repeat(2,1fr)}.filter-panel{flex-direction:column;align-items:stretch}.filter-form{flex-direction:column}.search-box-input{width:100%}}
</style>

