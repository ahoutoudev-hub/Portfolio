@extends('layouts_admin.master_admin')
@section('title', 'Messages')

@section('content')

{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Contact</div>
    <h4 class="page-title mb-1">
      Messages
      @if($stats['non_lus'] > 0)
        <span class="title-badge-unread">{{ $stats['non_lus'] }} non lu{{ $stats['non_lus'] > 1 ? 's' : '' }}</span>
      @endif
    </h4>
    <p class="text-muted small mb-0">Messages reçus depuis le formulaire de contact.</p>
  </div>
  @if($stats['non_lus'] > 0)
    <form method="POST" action="{{ route('messages.tous-lus') }}" style="margin:0">
      @csrf
      <button type="submit" class="btn-mark-all">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Tout marquer comme lu
      </button>
    </form>
  @endif
</div>

{{-- KPI --}}
<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['total'] }}</div><div class="kpi-label">Total</div></div>
      <div class="kpi-stripe" style="--c:var(--primary)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card {{ $stats['non_lus'] > 0 ? 'kpi-card--alert' : '' }}">
      <div class="kpi-icon-wrap" style="--c:var(--info)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['non_lus'] }}</div><div class="kpi-label">Non lus</div></div>
      <div class="kpi-stripe" style="--c:var(--info)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--warning)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['importants'] }}</div><div class="kpi-label">Importants</div></div>
      <div class="kpi-stripe" style="--c:var(--warning)"></div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="kpi-card">
      <div class="kpi-icon-wrap" style="--c:var(--success)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <div><div class="kpi-num">{{ $stats['repondus'] }}</div><div class="kpi-label">Répondus</div></div>
      <div class="kpi-stripe" style="--c:var(--success)"></div>
    </div>
  </div>
</div>

{{-- Filtres --}}
<div class="filter-panel mb-4">
  <div class="statut-tabs">
    <a href="{{ route('messages.index') }}"
       class="statut-tab {{ !request('statut') ? 'statut-tab--active' : '' }}">
      Tous <span class="statut-tab-pill">{{ $stats['total'] }}</span>
    </a>
    <a href="{{ route('messages.index', ['statut' => 'non_lu']) }}"
       class="statut-tab {{ request('statut') === 'non_lu' ? 'statut-tab--active statut-tab--info' : '' }}">
      Non lus <span class="statut-tab-pill">{{ $stats['non_lus'] }}</span>
    </a>
    <a href="{{ route('messages.index', ['statut' => 'important']) }}"
       class="statut-tab {{ request('statut') === 'important' ? 'statut-tab--active statut-tab--warning' : '' }}">
      ⭐ Importants <span class="statut-tab-pill">{{ $stats['importants'] }}</span>
    </a>
    <a href="{{ route('messages.index', ['statut' => 'repondu']) }}"
       class="statut-tab {{ request('statut') === 'repondu' ? 'statut-tab--active statut-tab--success' : '' }}">
      Répondus <span class="statut-tab-pill">{{ $stats['repondus'] }}</span>
    </a>
  </div>

  <form method="GET" action="{{ route('messages.index') }}" class="filter-form">
    @if(request('statut')) <input type="hidden" name="statut" value="{{ request('statut') }}"> @endif
    <div class="search-box">
      <svg class="search-box-ico" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" name="search" class="search-box-input"
        placeholder="Nom, email, sujet..."
        value="{{ request('search') }}">
      @if(request('search'))
        <a href="{{ route('messages.index', request()->except('search')) }}" class="search-box-clear"><i class="bi bi-x"></i></a>
      @endif
    </div>
    <button type="submit" class="btn-filtre">Filtrer</button>
    @if(request()->hasAny(['search','statut']))
      <a href="{{ route('messages.index') }}" class="btn-reset">Réinitialiser</a>
    @endif
  </form>
</div>

{{-- Liste messages --}}
@if($messages->isNotEmpty())
<div class="msg-list">
  @foreach($messages as $message)
  <div class="msg-item {{ !$message->lu ? 'msg-item--unread' : '' }} {{ $message->important ? 'msg-item--important' : '' }}"
    id="msg-{{ $message->id }}">

    {{-- Avatar --}}
    <a href="{{ route('messages.show', $message) }}" class="msg-avatar-link">
      <div class="msg-avatar">{{ $message->initiales }}</div>
    </a>

    {{-- Corps --}}
    <div class="msg-body">
      <div class="msg-meta">
        <a href="{{ route('messages.show', $message) }}" class="msg-nom">
          {{ $message->nom_complet }}
          @if(!$message->lu)
            <span class="msg-dot-unread"></span>
          @endif
        </a>
        <span class="msg-email">{{ $message->email }}</span>
      </div>
      <a href="{{ route('messages.show', $message) }}" class="msg-sujet">
        {{ $message->sujet ?: '(Aucun sujet)' }}
      </a>
      <p class="msg-preview">{{ Str::limit($message->message, 90) }}</p>
    </div>

    {{-- Badges --}}
    <div class="msg-badges">
      @if($message->important)
        <span class="msg-badge msg-badge--star"><i class="bi bi-star-fill"></i></span>
      @endif
      @if($message->repondu)
        <span class="msg-badge msg-badge--ok">✓ Répondu</span>
      @endif
    </div>

    {{-- Date + actions --}}
    <div class="msg-side">
      <div class="msg-date">{{ $message->created_at->diffForHumans() }}</div>
      <div class="msg-actions">
        <button class="msg-btn msg-btn--lu {{ $message->lu ? 'msg-btn--on' : '' }}"
          data-id="{{ $message->id }}" title="{{ $message->lu ? 'Marquer non lu' : 'Marquer lu' }}">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19"/>
          </svg>
        </button>
        <button class="msg-btn msg-btn--star {{ $message->important ? 'msg-btn--on' : '' }}"
          data-id="{{ $message->id }}" title="Important">
          <svg width="13" height="13" fill="{{ $message->important ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
          </svg>
        </button>
        <button class="msg-btn msg-btn--del"
          onclick="confirmDelete('{{ route('messages.destroy', $message) }}', '{{ addslashes($message->nom_complet) }}')"
          title="Supprimer">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <polyline points="3 6 5 6 21 6"/>
            <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
          </svg>
        </button>
      </div>
    </div>

  </div>
  @endforeach
</div>

@if($messages->hasPages())
  <div class="d-flex justify-content-center mt-4">{{ $messages->links() }}</div>
@endif

@else
<div class="empty-state">
  <div class="empty-state-icon"><i class="bi bi-mailbox"></i></div>
  <div class="empty-state-title">
    @if(request()->hasAny(['search','statut'])) Aucun message ne correspond @else Aucun message reçu pour l'instant @endif
  </div>
  <p class="empty-state-sub">
    @if(request()->hasAny(['search','statut']))
      <a href="{{ route('messages.index') }}">Réinitialiser les filtres</a>
    @else
      Les messages du formulaire de contact apparaîtront ici.
    @endif
  </p>
</div>
@endif

@endsection

@push('scripts')
<script>
/* ── Toggle lu ── */
document.querySelectorAll('.msg-btn--lu').forEach(btn => {
  btn.addEventListener('click', async function() {
    const id  = this.dataset.id;
    const res = await fetch(`/admin/messages/${id}/lu`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
    });
    const data = await res.json();
    this.classList.toggle('msg-btn--on', data.lu);
    const item = document.getElementById('msg-' + id);
    item.classList.toggle('msg-item--unread', !data.lu);
    if (window.showToast) window.showToast(data.message, 'success');
  });
});

/* ── Toggle important ── */
document.querySelectorAll('.msg-btn--star').forEach(btn => {
  btn.addEventListener('click', async function() {
    const id  = this.dataset.id;
    const res = await fetch(`/admin/messages/${id}/important`, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
    });
    const data = await res.json();
    this.classList.toggle('msg-btn--on', data.important);
    const svg = this.querySelector('path');
    if (svg) svg.setAttribute('fill', data.important ? 'currentColor' : 'none');
    const item = document.getElementById('msg-' + id);
    item.classList.toggle('msg-item--important', data.important);
    if (window.showToast) window.showToast(data.message, 'success');
  });
});
</script>
@endpush

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark);display:flex;align-items:center;gap:10px}
.title-badge-unread{background:var(--info);color:#fff;font-size:.65rem;font-weight:800;padding:3px 10px;border-radius:99px;vertical-align:middle}
.btn-mark-all{display:inline-flex;align-items:center;gap:7px;background:rgba(16,185,129,.1);color:var(--success);font-family:var(--font-display);font-weight:700;font-size:.82rem;padding:9px 16px;border-radius:99px;border:1px solid rgba(16,185,129,.2);cursor:pointer;transition:all var(--transition)}
.btn-mark-all:hover{background:rgba(16,185,129,.18)}

.kpi-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;display:flex;align-items:center;gap:14px;position:relative;overflow:hidden;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition)}
.kpi-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.kpi-card--alert{border-color:rgba(59,130,246,.25)}
.kpi-icon-wrap{width:44px;height:44px;border-radius:11px;flex-shrink:0;box-shadow:inset 0 0 0 44px color-mix(in srgb,var(--c) 12%,transparent);color:var(--c);display:flex;align-items:center;justify-content:center}
.kpi-num{font-family:var(--font-display);font-size:1.75rem;font-weight:800;color:var(--dark);line-height:1}
.kpi-label{font-size:.76rem;color:var(--muted);font-weight:500;margin-top:2px}
.kpi-stripe{position:absolute;bottom:0;left:0;right:0;height:3px;background:var(--c);opacity:.4}

.filter-panel{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:10px 16px;box-shadow:var(--shadow)}
.statut-tabs{display:flex;gap:3px;flex-wrap:wrap}
.statut-tab{display:inline-flex;align-items:center;gap:7px;padding:7px 13px;border-radius:9px;font-family:var(--font-body);font-size:.82rem;font-weight:600;color:var(--muted);text-decoration:none;transition:all var(--transition)}
.statut-tab:hover{background:var(--gray-bg);color:var(--text)}
.statut-tab--active{background:var(--dark);color:#fff}
.statut-tab--info{background:rgba(59,130,246,.12);color:var(--info)}
.statut-tab--warning{background:rgba(245,158,11,.12);color:var(--warning)}
.statut-tab--success{background:rgba(16,185,129,.12);color:var(--success)}
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

/* Liste messages */
.msg-list{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.msg-item{display:flex;align-items:center;gap:14px;padding:14px 18px;border-bottom:1px solid var(--border);transition:background var(--transition)}
.msg-item:last-child{border-bottom:none}
.msg-item:hover{background:rgba(255,124,8,.018)}
.msg-item--unread{background:rgba(59,130,246,.03);border-left:3px solid var(--info)}
.msg-item--important{background:rgba(245,158,11,.03)}

.msg-avatar-link{text-decoration:none;flex-shrink:0}
.msg-avatar{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ffb347);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:.88rem;color:#fff}

.msg-body{flex:1;min-width:0}
.msg-meta{display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-bottom:3px}
.msg-nom{font-family:var(--font-display);font-size:.88rem;font-weight:700;color:var(--dark);text-decoration:none;display:flex;align-items:center;gap:6px}
.msg-nom:hover{color:var(--primary)}
.msg-dot-unread{width:7px;height:7px;border-radius:50%;background:var(--info);flex-shrink:0}
.msg-email{font-size:.76rem;color:var(--muted)}
.msg-sujet{display:block;font-size:.85rem;font-weight:600;color:var(--text);text-decoration:none;margin-bottom:3px}
.msg-sujet:hover{color:var(--primary)}
.msg-preview{font-size:.78rem;color:var(--muted);margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:400px}

.msg-badges{display:flex;flex-direction:column;align-items:flex-end;gap:4px;flex-shrink:0}
.msg-badge{font-size:.68rem;font-weight:700;padding:2px 7px;border-radius:99px;font-family:var(--font-display)}
.msg-badge--star{background:rgba(245,158,11,.15);color:var(--warning)}
.msg-badge--ok{background:rgba(16,185,129,.12);color:var(--success)}

.msg-side{display:flex;flex-direction:column;align-items:flex-end;gap:8px;flex-shrink:0}
.msg-date{font-size:.72rem;color:var(--muted);white-space:nowrap}
.msg-actions{display:flex;gap:4px}
.msg-btn{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition)}
.msg-btn--lu{background:rgba(59,130,246,.08);color:var(--muted)}
.msg-btn--lu:hover,.msg-btn--lu.msg-btn--on{background:rgba(59,130,246,.15);color:var(--info)}
.msg-btn--star{background:rgba(245,158,11,.08);color:var(--muted)}
.msg-btn--star:hover,.msg-btn--star.msg-btn--on{background:rgba(245,158,11,.18);color:var(--warning)}
.msg-btn--del{background:rgba(239,68,68,.08);color:var(--danger)}
.msg-btn--del:hover{background:rgba(239,68,68,.18)}

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

@media(max-width:768px){.msg-preview,.msg-badges{display:none}.filter-panel{flex-direction:column;align-items:stretch}.filter-form{flex-direction:column}.search-box-input{width:100%}}
</style>
@endpush
