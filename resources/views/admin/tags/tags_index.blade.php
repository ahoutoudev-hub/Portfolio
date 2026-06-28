@extends('layouts_admin.master_admin')
@section('title', 'Tags')

@section('content')

{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Projets</div>
    <h4 class="page-title mb-1">Tags / Technologies</h4>
    <p class="text-muted small mb-0">Gérez les étiquettes associées à vos projets.</p>
  </div>
  <button type="button" class="btn-add" onclick="openCreateForm()">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
    </svg>
    Nouveau tag
  </button>
</div>

<div class="row g-4">

  {{-- ══ Liste des tags ══ --}}
  <div class="col-lg-7">
    <div class="f-card">
      <div class="f-card-head">
        <span class="f-card-ico"><i class="bi bi-tag-fill"></i></span>
        <span class="f-card-titre">{{ $tags->count() }} tag{{ $tags->count() > 1 ? 's' : '' }}</span>
      </div>
      <div class="f-card-body p-0">

        @forelse($tags as $tag)
        <div class="tag-row" id="tag-row-{{ $tag->id }}">

          {{-- Aperçu pill --}}
          <span class="tag-pill-preview"
            style="background:{{ $tag->couleur }}18;color:{{ $tag->couleur }};border-color:{{ $tag->couleur }}30">
            {{ $tag->nom }}
          </span>

          {{-- Infos --}}
          <div class="tag-row-info">
            <code class="tag-slug">{{ $tag->slug }}</code>
            <span class="tag-row-count">
              <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
              </svg>
              {{ $tag->projets_count }} projet{{ $tag->projets_count > 1 ? 's' : '' }}
            </span>
          </div>

          {{-- Dot couleur --}}
          <div class="tag-color-dot" style="background:{{ $tag->couleur }}"></div>

          {{-- Actions --}}
          <div class="tag-row-actions">
            <button class="tag-btn-edit"
              onclick="openEditForm({{ $tag->id }}, '{{ addslashes($tag->nom) }}', '{{ $tag->couleur }}')"
              title="Modifier">
              <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            @if($tag->projets_count === 0)
              <button class="tag-btn-del"
                onclick="confirmDelete('{{ route('tags.destroy', $tag) }}', '{{ addslashes($tag->nom) }}')"
                title="Supprimer">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
                </svg>
              </button>
            @else
              <span class="tag-btn-locked" title="Utilisé par {{ $tag->projets_count }} projet(s) — non supprimable"><i class="bi bi-lock-fill"></i></span>
            @endif
          </div>

        </div>
        @empty
        <div class="dash-empty-sm">
          <div style="font-size:2rem;margin-bottom:8px;opacity:.35"><i class="bi bi-tag-fill"></i></div>
          <p>Aucun tag. Créez votre premier tag.</p>
        </div>
        @endforelse

      </div>
    </div>
  </div>

  {{-- ══ Formulaire création / édition ══ --}}
  <div class="col-lg-5">
    <div class="f-card" id="tagFormCard">
      <div class="f-card-head">
        <span class="f-card-ico" id="formIco"><i class="bi bi-plus-lg"></i></span>
        <span class="f-card-titre" id="formTitre">Nouveau tag</span>
      </div>
      <div class="f-card-body">

        {{-- Aperçu live --}}
        <div class="tag-live-preview mb-4">
          <span id="livePreview"
            class="tag-pill-preview"
            style="background:#ff7c0818;color:#ff7c08;border-color:#ff7c0830;font-size:.95rem;padding:6px 18px">
            Aperçu du tag
          </span>
        </div>

        <form method="POST" id="tagForm" novalidate>
          @csrf
          <input type="hidden" name="_method" id="tagMethod" value="POST">
          <input type="hidden" name="tag_id"  id="tagId"     value="">

          <div class="f-field">
            <label class="f-label">Nom <span class="f-req">*</span></label>
            <input type="text" name="nom" id="tagNom"
              class="f-input" placeholder="Ex : Laravel, Vue.js, Docker..."
              oninput="updateLivePreview()" required>
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Couleur</label>
            <div class="color-picker-wrap">
              <input type="color" name="couleur" id="tagCouleur"
                class="color-input" value="#ff7c08"
                oninput="syncHex(this.value); updateLivePreview()">
              <input type="text" id="tagCouleurHex"
                class="f-input color-hex-input"
                placeholder="#ff7c08"
                oninput="syncColor(this.value)">
            </div>
            <div class="color-presets mt-2">
              @foreach([
                '#ef4444','#f97316','#ff7c08','#f59e0b','#eab308',
                '#84cc16','#10b981','#06b6d4','#3b82f6','#8b5cf6',
                '#ec4899','#6366f1','#14b8a6','#f43f5e','#64748b',
              ] as $c)
                <button type="button" class="color-preset"
                  style="background:{{ $c }}"
                  onclick="setColor('{{ $c }}')">
                </button>
              @endforeach
            </div>
          </div>

          <div class="f-actions mt-4">
            <button type="submit" class="f-btn-submit" id="tagSubmitBtn">
              <i class="bi bi-plus-lg"></i> Créer le tag
            </button>
            <button type="button" class="f-btn-cancel" id="tagCancelBtn"
              style="display:none" onclick="resetForm()">
              Annuler
            </button>
          </div>

        </form>

      </div>
    </div>

    {{-- Stats rapides --}}
    <div class="tags-stats mt-3">
      <div class="tags-stat-item">
        <span class="tags-stat-num">{{ $tags->count() }}</span>
        <span class="tags-stat-lbl">Tags total</span>
      </div>
      <div class="tags-stat-sep"></div>
      <div class="tags-stat-item">
        <span class="tags-stat-num">{{ $tags->where('projets_count', '>', 0)->count() }}</span>
        <span class="tags-stat-lbl">Utilisés</span>
      </div>
      <div class="tags-stat-sep"></div>
      <div class="tags-stat-item">
        <span class="tags-stat-num">{{ $tags->where('projets_count', 0)->count() }}</span>
        <span class="tags-stat-lbl">Inutilisés</span>
      </div>
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script>
const storeUrl  = '{{ route('tags.store') }}';
const updateUrl = id => `{{ route('tags.update', ':id') }}`.replace(':id', id);

/* ── Aperçu live ── */
function updateLivePreview() {
  const nom     = document.getElementById('tagNom').value.trim() || 'Aperçu du tag';
  const couleur = document.getElementById('tagCouleurHex').value || '#ff7c08';
  const preview = document.getElementById('livePreview');
  preview.textContent        = nom;
  preview.style.background   = couleur + '18';
  preview.style.color        = couleur;
  preview.style.borderColor  = couleur + '30';
}

/* ── Couleur ── */
function setColor(hex) {
  document.getElementById('tagCouleur').value    = hex;
  document.getElementById('tagCouleurHex').value = hex;
  updateLivePreview();
}
function syncHex(hex) {
  document.getElementById('tagCouleurHex').value = hex;
  updateLivePreview();
}
function syncColor(hex) {
  if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
    document.getElementById('tagCouleur').value = hex;
    updateLivePreview();
  }
}
document.getElementById('tagCouleur').addEventListener('input', function() { syncHex(this.value); });
document.getElementById('tagCouleurHex').value = document.getElementById('tagCouleur').value;

/* ── Soumettre le formulaire ── */
document.getElementById('tagForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const id  = document.getElementById('tagId').value;
  const url = id ? updateUrl(id) : storeUrl;

  const res = await fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
      'Content-Type': 'application/x-www-form-urlencoded',
      'Accept': 'application/json',
    },
    body: new URLSearchParams({
      _method: id ? 'POST' : 'POST',
      nom:     document.getElementById('tagNom').value,
      couleur: document.getElementById('tagCouleurHex').value || document.getElementById('tagCouleur').value,
    })
  });

  if (res.ok || res.redirected) {
    window.location.reload();
  } else {
    const data = await res.json().catch(() => ({}));
    if (window.showToast) window.showToast(data.message || 'Erreur lors de la sauvegarde.', 'error');
  }
});

/* ── Ouvrir formulaire création ── */
function openCreateForm() {
  resetForm();
  document.getElementById('tagFormCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
  setTimeout(() => document.getElementById('tagNom').focus(), 300);
}

/* ── Ouvrir formulaire édition ── */
function openEditForm(id, nom, couleur) {
  document.getElementById('tagId').value   = id;
  document.getElementById('tagNom').value  = nom;
  setColor(couleur || '#ff7c08');

  document.getElementById('formIco').innerHTML      = '<i class="bi bi-pencil-fill"></i>';
  document.getElementById('formTitre').textContent  = 'Modifier le tag';
  document.getElementById('tagSubmitBtn').innerHTML = '<i class="bi bi-floppy-fill"></i> Enregistrer';
  document.getElementById('tagCancelBtn').style.display = 'block';

  updateLivePreview();
  document.getElementById('tagFormCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
  setTimeout(() => document.getElementById('tagNom').focus(), 300);
}

/* ── Reset formulaire ── */
function resetForm() {
  document.getElementById('tagId').value    = '';
  document.getElementById('tagNom').value   = '';
  setColor('#ff7c08');
  document.getElementById('formIco').innerHTML      = '<i class="bi bi-plus-lg"></i>';
  document.getElementById('formTitre').textContent  = 'Nouveau tag';
  document.getElementById('tagSubmitBtn').innerHTML = '<i class="bi bi-plus-lg"></i> Créer le tag';
  document.getElementById('tagCancelBtn').style.display = 'none';
  updateLivePreview();
}

</script>
@endpush

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-add{display:inline-flex;align-items:center;gap:8px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 20px;border-radius:var(--radius);border:none;cursor:pointer;text-decoration:none;box-shadow:0 4px 14px rgba(255,124,8,.35);transition:all var(--transition)}
.btn-add:hover{background:var(--primary-dark);color:#fff;transform:translateY(-2px)}

/* Cards */
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:.95rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark)}
.f-card-body{padding:18px}
.f-card-body.p-0{padding:0}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-req{color:var(--primary)}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}

/* Tag rows */
.tag-row{display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid var(--border);transition:background var(--transition)}
.tag-row:last-child{border-bottom:none}
.tag-row:hover{background:rgba(255,124,8,.015)}

.tag-pill-preview{display:inline-flex;align-items:center;padding:4px 12px;border-radius:99px;font-family:var(--font-display);font-size:.78rem;font-weight:700;border:1px solid transparent;white-space:nowrap;transition:all .2s}

.tag-row-info{flex:1;min-width:0;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.tag-slug{font-family:'Courier New',monospace;font-size:.72rem;color:var(--muted);background:var(--gray-bg);padding:2px 7px;border-radius:5px;border:1px solid var(--border)}
.tag-row-count{display:flex;align-items:center;gap:4px;font-size:.73rem;color:var(--muted)}

.tag-color-dot{width:14px;height:14px;border-radius:50%;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.15)}

.tag-row-actions{display:flex;gap:4px;flex-shrink:0}
.tag-btn-edit,.tag-btn-del{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition)}
.tag-btn-edit{background:rgba(59,130,246,.08);color:var(--info)}
.tag-btn-edit:hover{background:rgba(59,130,246,.18);color:var(--info)}
.tag-btn-del{background:rgba(239,68,68,.08);color:var(--danger)}
.tag-btn-del:hover{background:rgba(239,68,68,.18)}
.tag-btn-locked{width:28px;height:28px;display:flex;align-items:center;justify-content:center;font-size:.8rem;opacity:.35;cursor:not-allowed}

/* Aperçu live */
.tag-live-preview{display:flex;align-items:center;justify-content:center;min-height:56px;background:var(--gray-bg);border-radius:10px;border:1px solid var(--border)}

/* Color picker */
.color-picker-wrap{display:flex;align-items:center;gap:10px}
.color-input{width:42px;height:42px;border:1.5px solid var(--border);border-radius:9px;cursor:pointer;padding:2px;background:var(--gray-bg);flex-shrink:0}
.color-hex-input{flex:1}
.color-presets{display:flex;flex-wrap:wrap;gap:6px}
.color-preset{width:24px;height:24px;border-radius:6px;border:2px solid #fff;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,.15);transition:transform var(--transition)}
.color-preset:hover{transform:scale(1.25)}

/* Actions */
.f-actions{display:flex;flex-direction:column;gap:8px}
.f-btn-submit{width:100%;padding:12px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.88rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 14px rgba(255,124,8,.32);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-1px)}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all var(--transition)}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}

/* Stats rapides */
.tags-stats{display:flex;align-items:center;justify-content:space-around;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:16px;box-shadow:var(--shadow)}
.tags-stat-item{text-align:center}
.tags-stat-num{display:block;font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark);line-height:1}
.tags-stat-lbl{display:block;font-size:.72rem;color:var(--muted);font-weight:500;margin-top:3px}
.tags-stat-sep{width:1px;height:36px;background:var(--border)}

/* Empty */
.dash-empty-sm{text-align:center;padding:32px;color:var(--muted);font-size:.84rem}
.dash-empty-sm p{margin:0}

/* Modal */
.modal-delete{border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
.modal-delete-titre{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.modal-delete-txt{font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto}
.btn-annuler{padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition)}
.btn-annuler:hover{background:var(--border)}
.btn-confirmer-suppr{display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition)}
.btn-confirmer-suppr:hover{background:#dc2626;transform:translateY(-1px)}
</style>
@endpush
