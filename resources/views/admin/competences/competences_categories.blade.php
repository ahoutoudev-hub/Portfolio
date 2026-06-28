@extends('layouts_admin.master_admin')
@section('title', 'Catégories de compétences')

@section('content')
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Compétences</div>
    <h4 class="page-title mb-1">Catégories</h4>
    <p class="text-muted small mb-0">Organisez vos compétences par catégorie.</p>
  </div>
  <a href="{{ route('competences.index') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Retour aux compétences
  </a>
</div>

<div class="row g-4">

  {{-- Liste des catégories --}}
  <div class="col-lg-7">
    <div class="f-card">
      <div class="f-card-head">
        <span class="f-card-ico"><i class="bi bi-folder-fill"></i></span>
        <span class="f-card-titre">Catégories existantes</span>
        <span class="f-card-head-hint">{{ $categories->count() }} catégorie{{ $categories->count() > 1 ? 's' : '' }}</span>
      </div>
      <div class="f-card-body p-0">
        @forelse($categories as $cat)
        <div class="cat-row" id="cat-row-{{ $cat->id }}">
          <div class="cat-row-left">
            <span class="cat-color-dot" style="background:{{ $cat->couleur }}"></span>
            <div>
              <div class="cat-row-nom">{{ $cat->nom }}</div>
              <div class="cat-row-meta">
                {{ $cat->competences_count }} compétence{{ $cat->competences_count > 1 ? 's' : '' }}
                · Ordre : {{ $cat->ordre }}
                @if($cat->icone) · <code class="cat-icone-code">{{ $cat->icone }}</code> @endif
              </div>
            </div>
          </div>
          <div class="cat-row-actions">
            <button class="comp-btn-edit" onclick="editCategorie({{ $cat->id }}, '{{ addslashes($cat->nom) }}', '{{ $cat->icone }}', '{{ $cat->couleur }}', {{ $cat->ordre }})" title="Modifier">
              <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </button>
            @if($cat->competences_count === 0)
            <button class="comp-btn-delete" onclick="confirmDeleteCat('{{ route('competences.categories.destroy', $cat) }}', '{{ addslashes($cat->nom) }}')" title="Supprimer">
              <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
              </svg>
            </button>
            @else
            <span class="cat-no-delete" title="Supprimez d'abord les compétences de cette catégorie"><i class="bi bi-lock-fill"></i></span>
            @endif
          </div>
        </div>
        @empty
        <div class="dash-empty">
          <div style="font-size:2rem;margin-bottom:10px;opacity:.38"><i class="bi bi-folder-fill"></i></div>
          <p style="font-size:.85rem;color:var(--muted)">Aucune catégorie. Créez-en une.</p>
        </div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Formulaire création / édition --}}
  <div class="col-lg-5">
    <div class="f-card" id="catFormCard">
      <div class="f-card-head">
        <span class="f-card-ico" id="catFormIco"><i class="bi bi-plus-lg"></i></span>
        <span class="f-card-titre" id="catFormTitre">Nouvelle catégorie</span>
      </div>
      <div class="f-card-body">
        <form method="POST" id="catForm" novalidate>
          @csrf
          <input type="hidden" name="_method" id="catMethod" value="POST">
          <input type="hidden" name="cat_id" id="catId" value="">

          <div class="f-field">
            <label class="f-label">Nom <span class="f-req">*</span></label>
            <input type="text" name="nom" id="catNom"
              class="f-input" placeholder="Ex : Frontend, Backend..."
              required>
          </div>

          <div class="f-field">
            <label class="f-label">Couleur</label>
            <div class="color-picker-wrap">
              <input type="color" name="couleur" id="catCouleur"
                class="color-input" value="#ff7c08">
              <input type="text" id="catCouleurHex"
                class="f-input color-hex-input"
                placeholder="#ff7c08"
                oninput="syncColor(this.value)">
              <div class="color-presets">
                @foreach(['#ff7c08','#3b82f6','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4','#ec4899'] as $c)
                  <button type="button" class="color-preset" style="background:{{ $c }}" onclick="setColor('{{ $c }}')"></button>
                @endforeach
              </div>
            </div>
          </div>

          <div class="f-field">
            <label class="f-label">Icône <span class="f-label-hint">— nom Simple Icons</span></label>
            <input type="text" name="icone" id="catIcone"
              class="f-input" placeholder="monitor, server, database...">
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Ordre d'affichage</label>
            <input type="number" name="ordre" id="catOrdre"
              class="f-input" min="0" value="0" style="max-width:120px">
          </div>

          <div class="f-actions mt-4">
            <button type="submit" class="f-btn-submit" id="catSubmitBtn">
              <i class="bi bi-plus-lg"></i> Créer la catégorie
            </button>
            <button type="button" class="f-btn-cancel" id="catCancelBtn"
              style="display:none" onclick="resetCatForm()">
              Annuler
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>

</main>
@endsection

<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;cursor:pointer;transition:all var(--transition);text-decoration:none;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:.95rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark)}
.f-card-head-hint{font-size:.72rem;color:var(--muted);margin-left:3px}
.f-card-body{padding:18px}
.f-card-body.p-0{padding:0}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-label-hint{font-size:.72rem;color:var(--muted);font-weight:400}
.f-req{color:var(--primary)}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}

/* Cat rows */
.cat-row{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 18px;border-bottom:1px solid var(--border);transition:background var(--transition)}
.cat-row:last-child{border-bottom:none}
.cat-row:hover{background:var(--gray-bg)}
.cat-row-left{display:flex;align-items:center;gap:12px}
.cat-color-dot{width:12px;height:12px;border-radius:50%;flex-shrink:0}
.cat-row-nom{font-family:var(--font-display);font-size:.88rem;font-weight:700;color:var(--dark)}
.cat-row-meta{font-size:.73rem;color:var(--muted);margin-top:2px}
.cat-icone-code{background:var(--gray-bg);padding:1px 6px;border-radius:4px;font-size:.7rem;border:1px solid var(--border)}
.cat-row-actions{display:flex;gap:5px}
.comp-btn-edit,.comp-btn-delete{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all var(--transition);text-decoration:none}
.comp-btn-edit{background:rgba(59,130,246,.08);color:var(--info)}
.comp-btn-edit:hover{background:rgba(59,130,246,.18)}
.comp-btn-delete{background:rgba(239,68,68,.08);color:var(--danger)}
.comp-btn-delete:hover{background:rgba(239,68,68,.18)}
.cat-no-delete{font-size:.9rem;opacity:.4;cursor:not-allowed}
.dash-empty{text-align:center;padding:32px}

/* Color picker */
.color-picker-wrap{display:flex;flex-direction:column;gap:8px}
.color-input{width:42px;height:42px;border:1.5px solid var(--border);border-radius:9px;cursor:pointer;padding:2px;background:var(--gray-bg)}
.color-hex-input{max-width:130px}
.color-presets{display:flex;flex-wrap:wrap;gap:6px;margin-top:4px}
.color-preset{width:26px;height:26px;border-radius:7px;border:2px solid #fff;cursor:pointer;box-shadow:0 1px 3px rgba(0,0,0,.15);transition:transform var(--transition)}
.color-preset:hover{transform:scale(1.2)}

/* Actions */
.f-actions{display:flex;flex-direction:column;gap:10px}
.f-btn-submit{width:100%;padding:12px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.88rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 14px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px)}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:all var(--transition);text-decoration:none}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}

/* Modal */
.modal-delete{border:none;border-radius:20px;box-shadow:var(--shadow-lg)}
.modal-delete-titre{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.modal-delete-txt{font-size:.86rem;color:var(--muted);max-width:280px;margin:0 auto}
.btn-annuler{padding:10px 22px;border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1px solid var(--border);cursor:pointer;transition:all var(--transition)}
.btn-annuler:hover{background:var(--border)}
.btn-confirmer-suppr{display:inline-flex;align-items:center;background:var(--danger);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.85rem;padding:10px 24px;border-radius:9px;border:none;cursor:pointer;box-shadow:0 4px 14px rgba(239,68,68,.3);transition:all var(--transition)}
.btn-confirmer-suppr:hover{background:#dc2626}
</style>


@push('scripts')
<script>
const storeUrl  = '{{ route('competences.categories.store') }}';
const updateUrl = (id) => `{{ route('competences.categories.update', ':id') }}`.replace(':id', id);

/* ── Soumettre le formulaire ── */
document.getElementById('catForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const id     = document.getElementById('catId').value;
  const method = id ? 'POST' : 'POST';
  const url    = id ? updateUrl(id) : storeUrl;

  const formData = new FormData(this);
  formData.append('couleur', document.getElementById('catCouleurHex').value || document.getElementById('catCouleur').value);

  const res = await fetch(url, {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
      'Accept': 'application/json',
    },
    body: new URLSearchParams(Object.fromEntries(
      [...formData.entries()].concat([['_method', method]])
    ))
  });

  if (res.ok) {
    window.location.reload();
  } else {
    const data = await res.json();
    if (window.showToast) window.showToast(data.message || 'Erreur.', 'error');
  }
});

/* ── Éditer une catégorie ── */
function editCategorie(id, nom, icone, couleur, ordre) {
  document.getElementById('catId').value      = id;
  document.getElementById('catNom').value     = nom;
  document.getElementById('catIcone').value   = icone || '';
  document.getElementById('catOrdre').value   = ordre;
  setColor(couleur || '#ff7c08');

  document.getElementById('catFormIco').innerHTML     = '<i class="bi bi-pencil-fill"></i>';
  document.getElementById('catFormTitre').textContent = 'Modifier la catégorie';
  document.getElementById('catSubmitBtn').innerHTML   = '<i class="bi bi-floppy-fill"></i> Enregistrer';
  document.getElementById('catCancelBtn').style.display = 'block';

  document.getElementById('catFormCard').scrollIntoView({ behavior: 'smooth' });
}

function resetCatForm() {
  document.getElementById('catId').value    = '';
  document.getElementById('catForm').reset();
  setColor('#ff7c08');
  document.getElementById('catFormIco').innerHTML     = '<i class="bi bi-plus-lg"></i>';
  document.getElementById('catFormTitre').textContent = 'Nouvelle catégorie';
  document.getElementById('catSubmitBtn').innerHTML   = '<i class="bi bi-plus-lg"></i> Créer la catégorie';
  document.getElementById('catCancelBtn').style.display = 'none';
}

/* ── Supprimer catégorie ── */
function confirmDeleteCat(url, nom) {
  window.confirmDelete(url, nom + ' (et toutes ses compétences)');
}

/* ── Color picker ── */
function setColor(hex) {
  document.getElementById('catCouleur').value    = hex;
  document.getElementById('catCouleurHex').value = hex;
}
function syncColor(hex) {
  if (/^#[0-9A-Fa-f]{6}$/.test(hex)) {
    document.getElementById('catCouleur').value = hex;
  }
}
document.getElementById('catCouleur').addEventListener('input', function() {
  document.getElementById('catCouleurHex').value = this.value;
});
// Init hex field
document.getElementById('catCouleurHex').value = document.getElementById('catCouleur').value;
</script>
@endpush
