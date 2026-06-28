@extends('layouts_admin.master_admin')
@section('title', 'Témoignages')

@section('content')

{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Portfolio</div>
    <h4 class="page-title mb-1">Témoignages</h4>
    <p class="text-muted small mb-0">Gérez les avis de vos clients affichés sur le portfolio.</p>
  </div>
  <a href="{{ route('temoignages.create') }}" class="btn-add">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Ajouter un témoignage
  </a>
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-4">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['total'] }}</div><div class="kpi-label">Total</div></div>
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
      <div><div class="kpi-num">{{ $stats['actifs'] }}</div><div class="kpi-label">Visibles</div></div>
      <div class="kpi-stripe" style="--c:var(--success)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-4">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--warning)">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
          <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['moy'] }}<span style="font-size:1.1rem">/5</span></div><div class="kpi-label">Note moyenne</div></div>
      <div class="kpi-stripe" style="--c:var(--warning)"></div>
    </div>
  </div>
</div>

{{-- Liste --}}
@if($temoignages->isNotEmpty())
<div class="temo-grid">
  @foreach($temoignages as $temo)
  <div class="temo-card {{ !$temo->actif ? 'temo-card--inactive' : '' }}" id="temo-{{ $temo->id }}">

    {{-- Header --}}
    <div class="temo-card-head">
      <div class="temo-avatar">{{ $temo->initiales }}</div>
      <div class="temo-info">
        <div class="temo-nom">{{ $temo->nom }}</div>
        @if($temo->poste || $temo->entreprise)
          <div class="temo-poste">
            {{ $temo->poste }}@if($temo->poste && $temo->entreprise) · @endif{{ $temo->entreprise }}
          </div>
        @endif
      </div>
      <div class="temo-card-actions">
        <button class="temo-btn-toggle {{ $temo->actif ? 'temo-btn-toggle--on' : '' }}"
          data-id="{{ $temo->id }}"
          title="{{ $temo->actif ? 'Masquer' : 'Afficher' }}">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            @if($temo->actif)
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            @else
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
            @endif
          </svg>
        </button>
        <a href="{{ route('temoignages.edit', $temo) }}" class="temo-btn-edit" title="Modifier">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </a>
        <button class="temo-btn-del"
          onclick="confirmDelete('{{ route('temoignages.destroy', $temo) }}', '{{ addslashes($temo->nom) }}')"
          title="Supprimer">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
          </svg>
        </button>
      </div>
    </div>

    {{-- Étoiles --}}
    <div class="temo-stars">
      @for($i = 1; $i <= 5; $i++)
        <svg width="16" height="16" fill="{{ $i <= $temo->note ? '#f59e0b' : 'none' }}"
          viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2" style="opacity:{{ $i <= $temo->note ? 1 : .3 }}">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
      @endfor
      <span class="temo-note-num">{{ $temo->note }}/5</span>
    </div>

    {{-- Contenu --}}
    <blockquote class="temo-contenu">
      "{{ Str::limit($temo->contenu, 140) }}"
    </blockquote>

    {{-- Footer --}}
    <div class="temo-card-footer">
      @if(!$temo->actif)
        <span class="temo-badge-inactive">Masqué</span>
      @else
        <span class="temo-badge-active">Visible</span>
      @endif
      <span class="temo-ordre">#{{ $temo->ordre + 1 }}</span>
    </div>

  </div>
  @endforeach
</div>

@else
<div class="empty-state">
  <div class="empty-state-icon"><i class="bi bi-chat-fill"></i></div>
  <div class="empty-state-title">Aucun témoignage pour l'instant</div>
  <p class="empty-state-sub">Ajoutez des avis clients pour renforcer votre crédibilité.</p>
  <a href="{{ route('temoignages.create') }}" class="btn-add mt-3">
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Ajouter un témoignage
  </a>
</div>
@endif

@endsection

@push('scripts')
<script>
document.querySelectorAll('.temo-btn-toggle').forEach(btn => {
  btn.addEventListener('click', async function() {
    const id  = this.dataset.id;
    const res = await fetch(`/admin/temoignages/${id}/toggle`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
    });
    const data = await res.json();
    this.classList.toggle('temo-btn-toggle--on', data.actif);
    document.getElementById('temo-' + id).classList.toggle('temo-card--inactive', !data.actif);
    if (window.showToast) window.showToast(data.message, 'success');
  });
});
</script>
@endpush

@push('styles')
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

/* Grille */
.temo-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:18px}

/* Card */
.temo-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:20px;box-shadow:var(--shadow);display:flex;flex-direction:column;gap:14px;transition:transform var(--transition),box-shadow var(--transition)}
.temo-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.temo-card--inactive{opacity:.5}

.temo-card-head{display:flex;align-items:flex-start;gap:12px}
.temo-avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ffb347);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:.88rem;color:#fff;flex-shrink:0}
.temo-info{flex:1;min-width:0}
.temo-nom{font-family:var(--font-display);font-size:.92rem;font-weight:700;color:var(--dark)}
.temo-poste{font-size:.75rem;color:var(--muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.temo-card-actions{display:flex;gap:4px;flex-shrink:0}

.temo-btn-toggle,.temo-btn-edit,.temo-btn-del{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition);text-decoration:none}
.temo-btn-toggle{background:rgba(156,163,175,.1);color:var(--muted)}
.temo-btn-toggle:hover{background:rgba(156,163,175,.2)}
.temo-btn-toggle--on{background:rgba(16,185,129,.1);color:var(--success)}
.temo-btn-toggle--on:hover{background:rgba(16,185,129,.2)}
.temo-btn-edit{background:rgba(59,130,246,.08);color:var(--info)}
.temo-btn-edit:hover{background:rgba(59,130,246,.18);color:var(--info)}
.temo-btn-del{background:rgba(239,68,68,.08);color:var(--danger)}
.temo-btn-del:hover{background:rgba(239,68,68,.18)}

.temo-stars{display:flex;align-items:center;gap:3px}
.temo-note-num{font-family:var(--font-display);font-size:.72rem;font-weight:700;color:var(--warning);margin-left:6px}

.temo-contenu{font-size:.86rem;color:var(--text);line-height:1.75;margin:0;font-style:italic;border-left:3px solid var(--primary-light);padding-left:12px;flex:1}

.temo-card-footer{display:flex;align-items:center;justify-content:space-between;padding-top:10px;border-top:1px solid var(--border)}
.temo-badge-active{background:rgba(16,185,129,.1);color:var(--success);font-family:var(--font-display);font-size:.66rem;font-weight:700;padding:2px 8px;border-radius:99px}
.temo-badge-inactive{background:rgba(156,163,175,.12);color:var(--muted);font-family:var(--font-display);font-size:.66rem;font-weight:700;padding:2px 8px;border-radius:99px}
.temo-ordre{font-family:var(--font-display);font-size:.7rem;font-weight:800;color:var(--muted)}

.empty-state{text-align:center;padding:70px 24px;background:#fff;border:1.5px dashed var(--border);border-radius:var(--radius)}
.empty-state-icon{font-size:3rem;margin-bottom:14px;opacity:.38}
.empty-state-title{font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--text);margin-bottom:7px}
.empty-state-sub{font-size:.86rem;color:var(--muted)}
.modal-delete{border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
.modal-delete-titre{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.modal-delete-txt{font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto}
.btn-annuler{padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition)}
.btn-annuler:hover{background:var(--border)}
.btn-confirmer-suppr{display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition)}
.btn-confirmer-suppr:hover{background:#dc2626;transform:translateY(-1px)}
@media(max-width:576px){.temo-grid{grid-template-columns:1fr}}
</style>
@endpush
