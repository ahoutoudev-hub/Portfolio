@extends('layouts_admin.master_admin')
@section('title', isset($certificat) ? 'Modifier · ' . $certificat->titre : 'Nouveau certificat')

@section('content')
@php $isEdit = isset($certificat); @endphp
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">{{ $isEdit ? 'Modifier' : 'Ajouter' }}</div>
    <h4 class="page-title mb-1">{{ $isEdit ? $certificat->titre : 'Nouveau certificat' }}</h4>
    <p class="text-muted small mb-0">{{ $isEdit ? 'Modifiez les informations de cette certification.' : 'Ajoutez une nouvelle certification à votre portfolio.' }}</p>
  </div>
  <a href="{{ route('certificats.index') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Retour
  </a>
</div>

<div class="row g-4 justify-content-center">
  <div class="col-lg-7">
    <form method="POST"
      action="{{ $isEdit ? route('certificats.update', $certificat) : route('certificats.store') }}"
      novalidate>
      @csrf
      @if($isEdit)  @endif

      {{-- Aperçu live --}}
      <div class="cert-preview-card mb-4">
        <div class="cert-preview-head">
          <div class="cert-preview-trophee"><i class="bi bi-trophy-fill"></i></div>
          <div class="cert-preview-actions-fake">
            <div class="cert-preview-dot" style="background:rgba(16,185,129,.3)"></div>
            <div class="cert-preview-dot" style="background:rgba(255,255,255,.1)"></div>
            <div class="cert-preview-dot" style="background:rgba(239,68,68,.15)"></div>
          </div>
        </div>
        <div class="cert-preview-body">
          <div class="cert-preview-titre" id="prevTitre">
            {{ $isEdit ? $certificat->titre : 'Titre du certificat' }}
          </div>
          <div class="cert-preview-org" id="prevOrg">
            {{ $isEdit ? $certificat->organisme : 'Organisme' }}
          </div>
          <div class="cert-preview-date" id="prevDate">
            {{ $isEdit ? $certificat->date_formatee : 'Date d\'obtention' }}
          </div>
        </div>
        <div class="cert-preview-footer">
          <span class="cert-preview-link" id="prevLink" style="display:none"><i class="bi bi-link-45deg"></i> Vérifier le certificat</span>
          <span class="cert-preview-badge">Aperçu</span>
        </div>
      </div>

      {{-- Informations --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-clipboard-fill"></i></span>
          <span class="f-card-titre">Informations</span>
        </div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Titre / Intitulé <span class="f-req">*</span></label>
            <input type="text" name="titre" id="titre"
              class="f-input @error('titre') f-input--err @enderror"
              placeholder="Ex : Conception de la maquette 3D"
              value="{{ old('titre', $certificat->titre ?? '') }}"
              oninput="document.getElementById('prevTitre').textContent = this.value || 'Titre du certificat'"
              required>
            @error('titre')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field">
            <label class="f-label">Organisme / Plateforme <span class="f-req">*</span></label>
            <input type="text" name="organisme" id="organisme"
              class="f-input @error('organisme') f-input--err @enderror"
              placeholder="Ex : Udemy, Coursera, Google, Microsoft..."
              value="{{ old('organisme', $certificat->organisme ?? '') }}"
              oninput="document.getElementById('prevOrg').textContent = this.value || 'Organisme'"
              required>
            @error('organisme')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Date d'obtention <span class="f-req">*</span></label>
            <input type="date" name="date_obtention" id="date_obtention"
              class="f-input @error('date_obtention') f-input--err @enderror"
              value="{{ old('date_obtention', isset($certificat->date_obtention) ? $certificat->date_obtention->format('Y-m-d') : '') }}"
              oninput="updatePrevDate(this.value)"
              required>
            @error('date_obtention')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

        </div>
      </div>

      {{-- Lien de vérification --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-link-45deg"></i></span>
          <span class="f-card-titre">Lien de vérification</span>
          <span class="f-card-head-hint">optionnel</span>
        </div>
        <div class="f-card-body">
          <div class="f-input-ico-wrap">
            <svg class="f-input-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            <input type="url" name="url_credential" id="url_credential"
              class="f-input f-input-with-ico @error('url_credential') f-input--err @enderror"
              placeholder="https://www.credential.net/..."
              value="{{ old('url_credential', $certificat->url_credential ?? '') }}"
              oninput="updatePrevLink(this.value)">
          </div>
          @error('url_credential')<p class="f-err-msg">{{ $message }}</p>@enderror
          <p class="f-hint mt-2">URL permettant à vos visiteurs de vérifier l'authenticité du certificat.</p>
        </div>
      </div>

      {{-- Options --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-gear-fill"></i></span>
          <span class="f-card-titre">Options</span>
        </div>
        <div class="f-card-body">

          <div class="f-field">
            <div class="f-toggle-row">
              <div>
                <div class="f-toggle-label"><i class="bi bi-eye"></i> Visible sur le portfolio</div>
                <div class="f-toggle-hint">Affiché dans la section certifications</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1"
                  {{ old('actif', $certificat->actif ?? true) ? 'checked' : '' }}>
                <span class="f-toggle-track"><span class="f-toggle-thumb"></span></span>
              </label>
            </div>
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Ordre d'affichage</label>
            <input type="number" name="ordre" class="f-input" min="0"
              style="max-width:130px"
              value="{{ old('ordre', $certificat->ordre ?? 0) }}">
            <p class="f-hint mt-2">Plus petit = affiché en premier.</p>
          </div>

        </div>
      </div>

      <div class="f-actions">
        <button type="submit" class="f-btn-submit">
          {!! $isEdit ? '<i class="bi bi-floppy-fill"></i> Enregistrer les modifications' : '<i class="bi bi-trophy-fill"></i> Créer le certificat' !!}
        </button>
        <a href="{{ route('certificats.index') }}" class="f-btn-cancel">Annuler</a>
      </div>

    </form>
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

/* Aperçu live */
.cert-preview-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow-md)}
.cert-preview-head{display:flex;align-items:center;justify-content:space-between;padding:16px 18px;background:linear-gradient(135deg,var(--dark-3),var(--dark))}
.cert-preview-trophee{font-size:2rem;filter:drop-shadow(0 2px 6px rgba(0,0,0,.3))}
.cert-preview-actions-fake{display:flex;gap:5px}
.cert-preview-dot{width:22px;height:22px;border-radius:6px}
.cert-preview-body{padding:18px}
.cert-preview-titre{font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--dark);margin-bottom:6px;transition:all .2s}
.cert-preview-org{font-size:.82rem;color:var(--muted);margin-bottom:4px}
.cert-preview-date{font-size:.76rem;color:var(--primary);font-weight:700;font-family:var(--font-display)}
.cert-preview-footer{display:flex;align-items:center;justify-content:space-between;padding:10px 18px;border-top:1px solid var(--border);background:var(--gray-bg)}
.cert-preview-link{font-size:.75rem;font-weight:700;color:var(--info);font-family:var(--font-display)}
.cert-preview-badge{background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-size:.66rem;font-weight:800;padding:2px 8px;border-radius:99px;margin-left:auto}

/* Cards form */
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:.95rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark)}
.f-card-head-hint{font-size:.72rem;color:var(--muted);margin-left:3px}
.f-card-body{padding:18px}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-req{color:var(--primary)}
.f-hint{font-size:.73rem;color:var(--muted);margin-top:5px;margin-bottom:0}
.f-err-msg{font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.f-input--err{border-color:var(--danger)!important;box-shadow:0 0 0 4px rgba(239,68,68,.08)!important}
.f-input-ico-wrap{position:relative}
.f-input-ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none}
.f-input-with-ico{padding-left:38px}
.f-toggle-row{display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 14px}
.f-toggle-label{font-family:var(--font-body);font-size:.87rem;font-weight:600;color:var(--dark)}
.f-toggle-hint{font-size:.74rem;color:var(--muted);margin-top:1px}
.f-toggle{flex-shrink:0;cursor:pointer}
.f-toggle input{display:none}
.f-toggle-track{display:block;width:44px;height:25px;border-radius:99px;background:var(--border);position:relative;transition:background var(--transition)}
.f-toggle-thumb{position:absolute;width:19px;height:19px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform var(--transition);box-shadow:0 1px 4px rgba(0,0,0,.2)}
.f-toggle input:checked + .f-toggle-track{background:var(--primary)}
.f-toggle input:checked + .f-toggle-track .f-toggle-thumb{transform:translateX(19px)}
.f-actions{display:flex;flex-direction:column;gap:10px}
.f-btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px)}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:all var(--transition)}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}
</style>


@push('scripts')
<script>
function updatePrevDate(val) {
  if (!val) { document.getElementById('prevDate').textContent = "Date d'obtention"; return; }
  const d = new Date(val);
  document.getElementById('prevDate').textContent =
    d.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' });
}

function updatePrevLink(val) {
  const el = document.getElementById('prevLink');
  el.style.display = val.trim() ? 'inline' : 'none';
}

// Init
updatePrevDate(document.getElementById('date_obtention').value);
updatePrevLink(document.getElementById('url_credential').value);
</script>
@endpush
