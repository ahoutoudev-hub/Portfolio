@extends('layouts_admin.master_admin')
@section('title', 'Message de ' . $message->nom_complet)

@section('content')

{{-- En-tête --}}
<div class="d-flex align-items-center justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Messages</div>
    <h4 class="page-title mb-1">Message de {{ $message->nom_complet }}</h4>
    <p class="text-muted small mb-0">{{ $message->created_at->translatedFormat('l d F Y à H:i') }}</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    <a href="{{ route('messages.index') }}" class="btn-hd-back">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
      </svg>
      Retour
    </a>
  </div>
</div>

<div class="row g-4">

  {{-- ══ Message principal ══ --}}
  <div class="col-lg-8">
    <div class="msg-detail-card">

      {{-- Header --}}
      <div class="msg-detail-head">
        <div class="msg-detail-avatar">{{ $message->initiales }}</div>
        <div class="msg-detail-meta">
          <div class="msg-detail-nom">{{ $message->nom_complet }}</div>
          <div class="msg-detail-email">
            <a href="mailto:{{ $message->email }}" class="msg-detail-email-link">
              {{ $message->email }}
            </a>
            @if($message->telephone)
              <span class="msg-detail-sep">·</span>
              <a href="tel:{{ $message->telephone }}" class="msg-detail-email-link">
                {{ $message->telephone }}
              </a>
            @endif
          </div>
        </div>
        <div class="msg-detail-head-badges">
          @if(!$message->lu)
            <span class="msg-detail-badge msg-detail-badge--unread">Non lu</span>
          @endif
          @if($message->important)
            <span class="msg-detail-badge msg-detail-badge--star">⭐ Important</span>
          @endif
          @if($message->repondu)
            <span class="msg-detail-badge msg-detail-badge--ok">✓ Répondu</span>
          @endif
        </div>
      </div>

      {{-- Sujet --}}
      @if($message->sujet)
      <div class="msg-detail-sujet">
        <span class="msg-detail-sujet-label">Sujet :</span>
        {{ $message->sujet }}
      </div>
      @endif

      {{-- Corps du message --}}
      <div class="msg-detail-body">
        {!! nl2br(e($message->message)) !!}
      </div>

      {{-- Footer date --}}
      <div class="msg-detail-footer">
        <div class="msg-detail-date">
          <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
          </svg>
          Envoyé {{ $message->created_at->diffForHumans() }}
          ({{ $message->created_at->translatedFormat('d F Y à H:i') }})
        </div>
        @if($message->lu && $message->lu_le)
          <div class="msg-detail-date" style="color:var(--success)">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Lu {{ $message->lu_le->diffForHumans() }}
          </div>
        @endif
      </div>

    </div>

    {{-- Navigation précédent / suivant --}}
    <div class="msg-nav">
      @if($precedent)
        <a href="{{ route('messages.show', $precedent) }}" class="msg-nav-btn">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
          </svg>
          <span>
            <span class="msg-nav-label">Précédent</span>
            <span class="msg-nav-nom">{{ $precedent->nom_complet }}</span>
          </span>
        </a>
      @else
        <div></div>
      @endif
      @if($suivant)
        <a href="{{ route('messages.show', $suivant) }}" class="msg-nav-btn msg-nav-btn--next">
          <span>
            <span class="msg-nav-label">Suivant</span>
            <span class="msg-nav-nom">{{ $suivant->nom_complet }}</span>
          </span>
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-7-7 7 7-7 7"/>
          </svg>
        </a>
      @endif
    </div>
  </div>

  {{-- ══ Sidebar actions ══ --}}
  <div class="col-lg-4">

    {{-- Répondre --}}
    <div class="action-card mb-3">
      <div class="action-card-title"><i class="bi bi-envelope-fill"></i> Répondre</div>
      <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->sujet ?: 'Votre message') }}"
         class="btn-reply">
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
        </svg>
        Ouvrir dans la messagerie
      </a>
      <p class="action-card-hint">
        Ouvre votre client mail avec le destinataire pré-rempli.
      </p>
    </div>

    {{-- Actions --}}
    <div class="action-card mb-3">
      <div class="action-card-title"><i class="bi bi-gear-fill"></i> Actions</div>

      <button class="action-btn {{ $message->lu ? 'action-btn--active' : '' }}"
        id="btnLu" data-id="{{ $message->id }}" onclick="toggleLu(this)">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19"/>
        </svg>
        <span id="lblLu">{{ $message->lu ? 'Marquer comme non lu' : 'Marquer comme lu' }}</span>
      </button>

      <button class="action-btn {{ $message->important ? 'action-btn--star' : '' }}"
        id="btnStar" data-id="{{ $message->id }}" onclick="toggleStar(this)">
        <svg width="14" height="14" fill="{{ $message->important ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="starSvg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
        <span id="lblStar">{{ $message->important ? 'Retirer des importants' : 'Marquer comme important' }}</span>
      </button>

      <button class="action-btn {{ $message->repondu ? 'action-btn--ok' : '' }}"
        id="btnRepondu" data-id="{{ $message->id }}" onclick="toggleRepondu(this)">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span id="lblRepondu">{{ $message->repondu ? 'Marquer non répondu' : 'Marquer comme répondu' }}</span>
      </button>

      <button class="action-btn action-btn--danger mt-2"
        onclick="confirmDelete('{{ route('messages.destroy', $message) }}', '{{ addslashes($message->nom_complet) }}')">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <polyline points="3 6 5 6 21 6"/>
          <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
        </svg>
        Supprimer ce message
      </button>
    </div>

    {{-- Infos expéditeur --}}
    <div class="action-card">
      <div class="action-card-title"><i class="bi bi-person-fill"></i> Expéditeur</div>
      <div class="sender-row">
        <div class="sender-label">Nom</div>
        <div class="sender-val">{{ $message->nom_complet }}</div>
      </div>
      <div class="sender-row">
        <div class="sender-label">Email</div>
        <div class="sender-val">
          <a href="mailto:{{ $message->email }}" class="msg-detail-email-link">{{ $message->email }}</a>
        </div>
      </div>
      @if($message->telephone)
      <div class="sender-row">
        <div class="sender-label">Tél</div>
        <div class="sender-val">{{ $message->telephone }}</div>
      </div>
      @endif
      @if($message->ip)
      <div class="sender-row">
        <div class="sender-label">IP</div>
        <div class="sender-val" style="font-family:'Courier New',monospace;font-size:.78rem">{{ $message->ip }}</div>
      </div>
      @endif
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name=csrf-token]').content;

async function toggleLu(btn) {
  const res  = await fetch(`/admin/messages/${btn.dataset.id}/lu`, {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
  });
  const data = await res.json();
  btn.classList.toggle('action-btn--active', data.lu);
  document.getElementById('lblLu').textContent = data.lu ? 'Marquer comme non lu' : 'Marquer comme lu';
  if (window.showToast) window.showToast(data.message, 'success');
}

async function toggleStar(btn) {
  const res  = await fetch(`/admin/messages/${btn.dataset.id}/important`, {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
  });
  const data = await res.json();
  btn.classList.toggle('action-btn--star', data.important);
  document.getElementById('lblStar').textContent    = data.important ? 'Retirer des importants' : 'Marquer comme important';
  document.getElementById('starSvg').querySelector('path').setAttribute('fill', data.important ? 'currentColor' : 'none');
  if (window.showToast) window.showToast(data.message, 'success');
}

async function toggleRepondu(btn) {
  const res  = await fetch(`/admin/messages/${btn.dataset.id}/repondu`, {
    method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
  });
  const data = await res.json();
  btn.classList.toggle('action-btn--ok', data.repondu);
  document.getElementById('lblRepondu').textContent = data.repondu ? 'Marquer non répondu' : 'Marquer comme répondu';
  if (window.showToast) window.showToast(data.message, 'success');
}
</script>
@endpush

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border);text-decoration:none;transition:all var(--transition)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}

/* Message card */
.msg-detail-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);margin-bottom:16px}
.msg-detail-head{display:flex;align-items:flex-start;gap:14px;padding:20px 22px;border-bottom:1px solid var(--border);flex-wrap:wrap}
.msg-detail-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ffb347);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:.95rem;color:#fff;flex-shrink:0}
.msg-detail-meta{flex:1;min-width:0}
.msg-detail-nom{font-family:var(--font-display);font-size:1rem;font-weight:800;color:var(--dark);margin-bottom:3px}
.msg-detail-email{font-size:.82rem;color:var(--muted);display:flex;align-items:center;flex-wrap:wrap;gap:5px}
.msg-detail-email-link{color:var(--info);text-decoration:none;font-weight:600}
.msg-detail-email-link:hover{color:var(--primary)}
.msg-detail-sep{color:var(--border)}
.msg-detail-head-badges{display:flex;flex-wrap:wrap;gap:5px;margin-left:auto}
.msg-detail-badge{font-family:var(--font-display);font-size:.68rem;font-weight:700;padding:3px 9px;border-radius:99px}
.msg-detail-badge--unread{background:rgba(59,130,246,.12);color:var(--info)}
.msg-detail-badge--star{background:rgba(245,158,11,.12);color:var(--warning)}
.msg-detail-badge--ok{background:rgba(16,185,129,.12);color:var(--success)}

.msg-detail-sujet{padding:12px 22px;background:var(--gray-bg);border-bottom:1px solid var(--border);font-size:.85rem;color:var(--text);font-weight:600}
.msg-detail-sujet-label{color:var(--muted);font-weight:500;margin-right:6px}
.msg-detail-body{padding:22px;font-size:.95rem;color:var(--text);line-height:1.85;white-space:pre-wrap;word-break:break-word}
.msg-detail-footer{display:flex;flex-wrap:wrap;gap:14px;align-items:center;padding:14px 22px;border-top:1px solid var(--border);background:var(--gray-bg)}
.msg-detail-date{display:flex;align-items:center;gap:5px;font-size:.76rem;color:var(--muted)}

/* Navigation */
.msg-nav{display:flex;justify-content:space-between;gap:12px}
.msg-nav-btn{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius);background:#fff;border:1px solid var(--border);text-decoration:none;transition:all var(--transition);box-shadow:var(--shadow);flex:1}
.msg-nav-btn:hover{border-color:var(--primary);box-shadow:var(--shadow-md);transform:translateY(-2px)}
.msg-nav-btn--next{justify-content:flex-end}
.msg-nav-label{display:block;font-size:.7rem;color:var(--muted);font-family:var(--font-display);font-weight:700;text-transform:uppercase;letter-spacing:.08em}
.msg-nav-nom{display:block;font-family:var(--font-display);font-size:.82rem;font-weight:700;color:var(--dark)}
.msg-nav-btn svg{flex-shrink:0;color:var(--primary)}

/* Action cards */
.action-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;box-shadow:var(--shadow)}
.action-card-title{font-family:var(--font-display);font-size:.84rem;font-weight:800;color:var(--dark);margin-bottom:14px;display:flex;align-items:center;gap:7px}
.action-card-hint{font-size:.74rem;color:var(--muted);margin:8px 0 0}

.btn-reply{display:flex;align-items:center;gap:8px;width:100%;padding:11px 16px;border-radius:var(--radius);background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;border:none;cursor:pointer;text-decoration:none;transition:all var(--transition);box-shadow:0 4px 14px rgba(255,124,8,.3)}
.btn-reply:hover{background:var(--primary-dark);color:#fff;transform:translateY(-1px)}

.action-btn{display:flex;align-items:center;gap:9px;width:100%;padding:10px 14px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:600;font-size:.83rem;border:1.5px solid var(--border);cursor:pointer;margin-bottom:7px;transition:all var(--transition);text-align:left}
.action-btn:last-child{margin-bottom:0}
.action-btn:hover{border-color:var(--primary);background:var(--primary-light);color:var(--primary)}
.action-btn--active{border-color:var(--info);background:rgba(59,130,246,.08);color:var(--info)}
.action-btn--star{border-color:var(--warning);background:rgba(245,158,11,.08);color:var(--warning)}
.action-btn--ok{border-color:var(--success);background:rgba(16,185,129,.08);color:var(--success)}
.action-btn--danger{border-color:rgba(239,68,68,.25);background:rgba(239,68,68,.06);color:var(--danger)}
.action-btn--danger:hover{border-color:var(--danger);background:rgba(239,68,68,.12);color:var(--danger)}

.sender-row{display:flex;gap:12px;padding:8px 0;border-bottom:1px solid var(--border);font-size:.82rem}
.sender-row:last-child{border-bottom:none;padding-bottom:0}
.sender-label{width:48px;flex-shrink:0;color:var(--muted);font-weight:600}
.sender-val{color:var(--text);word-break:break-all}

.modal-delete{border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
.modal-delete-titre{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.modal-delete-txt{font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto}
.btn-annuler{padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition)}
.btn-annuler:hover{background:var(--border)}
.btn-confirmer-suppr{display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition)}
.btn-confirmer-suppr:hover{background:#dc2626;transform:translateY(-1px)}
</style>
@endpush
