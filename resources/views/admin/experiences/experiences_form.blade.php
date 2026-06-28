@extends('layouts_admin.master_admin')
@section('title', isset($experience) ? 'Modifier · ' . $experience->titre : 'Nouvelle expérience')

@section('content')
@php $isEdit = isset($experience); @endphp
{{-- ── En-tête ── --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">{{ $isEdit ? 'Modifier' : 'Nouveau' }}</div>
    <h4 class="page-title mb-1">
      {{ $isEdit ? $experience->titre : 'Nouvelle expérience' }}
    </h4>
    <p class="text-muted small mb-0">
      {{ $isEdit ? 'Mettez à jour les informations.' : 'Ajoutez une expérience professionnelle ou une formation.' }}
    </p>
  </div>
  <a href="{{ route('experiences.index') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Retour
  </a>
</div>

<form method="POST"
  action="{{ $isEdit ? route('experiences.update', $experience) : route('experiences.store') }}"
  enctype="multipart/form-data"
  id="expForm"
  novalidate>
  @csrf
  @if($isEdit)  @endif

  <div class="row g-4">

    {{-- ══ COLONNE GAUCHE ══ --}}
    <div class="col-lg-8">

      {{-- Type --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-tag-fill"></i></span>
          <span class="f-card-titre">Type d'expérience</span>
        </div>
        <div class="f-card-body">
          <div class="type-selector">
            <label class="type-option {{ old('type', $experience->type ?? 'travail') === 'travail' ? 'type-option--active' : '' }}">
              <input type="radio" name="type" value="travail"
                {{ old('type', $experience->type ?? 'travail') === 'travail' ? 'checked' : '' }}>
              <div class="type-option-ico"><i class="bi bi-briefcase-fill"></i></div>
              <div class="type-option-titre">Expérience professionnelle</div>
              <div class="type-option-sub">Emploi, stage, freelance, mission...</div>
            </label>
            <label class="type-option {{ old('type', $experience->type ?? '') === 'formation' ? 'type-option--active' : '' }}">
              <input type="radio" name="type" value="formation"
                {{ old('type', $experience->type ?? '') === 'formation' ? 'checked' : '' }}>
              <div class="type-option-ico"><i class="bi bi-mortarboard-fill"></i></div>
              <div class="type-option-titre">Formation</div>
              <div class="type-option-sub">Diplôme, certification, cours...</div>
            </label>
          </div>
          @error('type')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Informations principales --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-clipboard-fill"></i></span>
          <span class="f-card-titre">Informations principales</span>
        </div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Poste / Diplôme <span class="f-req">*</span></label>
            <input type="text" name="titre" id="titre"
              class="f-input @error('titre') f-input--err @enderror"
              placeholder="Ex : Développeur Full-Stack · Master 2 Big Data..."
              value="{{ old('titre', $experience->titre ?? '') }}"
              required>
            @error('titre')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field">
            <label class="f-label">Entreprise / Établissement <span class="f-req">*</span></label>
            <input type="text" name="entreprise"
              class="f-input @error('entreprise') f-input--err @enderror"
              placeholder="Ex : Agence XYZ · Université de Cocody..."
              value="{{ old('entreprise', $experience->entreprise ?? '') }}"
              required>
            @error('entreprise')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Localisation</label>
            <div class="f-input-ico-wrap">
              <svg class="f-input-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              <input type="text" name="localisation"
                class="f-input f-input-with-ico"
                placeholder="Ex : Abidjan, CI"
                value="{{ old('localisation', $experience->localisation ?? '') }}">
            </div>
          </div>

        </div>
      </div>

      {{-- Description --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-file-text-fill"></i></span>
          <span class="f-card-titre">Description</span>
          <span class="f-card-head-hint">optionnelle</span>
        </div>
        <div class="f-card-body">
          <input type="hidden" name="description" id="exp_description"
            value="{{ old('description', $experience->description ?? '') }}">
          <div data-quill-target="exp_description"
            data-placeholder="Décrivez vos missions, responsabilités, compétences acquises..."></div>
          @error('description')<p class="f-err-msg">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Logo --}}
      <div class="f-card">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-image-fill"></i></span>
          <span class="f-card-titre">Logo de l'entreprise</span>
          <span class="f-card-head-hint">optionnel</span>
        </div>
        <div class="f-card-body">

          @if($isEdit && $experience->logo)
            <div class="logo-current" id="logoCurrentWrap">
              <img src="{{ asset('storage/' . $experience->logo) }}" alt="{{ $experience->entreprise }}" id="logoPreview">
              <label class="f-img-remove">
                <input type="checkbox" name="supprimer_logo" value="1" onchange="toggleLogoPreview(this)">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Supprimer le logo actuel
              </label>
            </div>
          @endif

          <div id="newLogoPreviewWrap" style="display:none" class="logo-current mb-3">
            <img id="newLogoPreview" src="" alt="Nouveau logo">
            <button type="button" class="f-img-remove" onclick="clearLogoInput()">
              <i class="bi bi-x"></i> Retirer
            </button>
          </div>

          <div class="f-upload" id="uploadZone">
            <input type="file" name="logo" id="logoInput"
              accept="image/jpeg,image/png,image/webp,image/svg+xml"
              class="f-upload-input @error('logo') f-input--err @enderror"
              onchange="handleLogoChange(this)">
            <div class="f-upload-body">
              <div class="f-upload-ico">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
              <p class="f-upload-txt">Logo <span class="f-upload-browse">parcourir</span></p>
              <p class="f-upload-hint">JPG, PNG, WEBP, SVG · max 1 Mo</p>
            </div>
          </div>
          @error('logo')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror

        </div>
      </div>

    </div>

    {{-- ══ COLONNE DROITE ══ --}}
    <div class="col-lg-4">

      {{-- Période --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-calendar3"></i></span>
          <span class="f-card-titre">Période</span>
        </div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Date de début <span class="f-req">*</span></label>
            <input type="date" name="date_debut"
              class="f-input @error('date_debut') f-input--err @enderror"
              value="{{ old('date_debut', isset($experience->date_debut) ? $experience->date_debut->format('Y-m-d') : '') }}"
              required>
            @error('date_debut')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field" id="datefinWrap">
            <label class="f-label">Date de fin</label>
            <input type="date" name="date_fin" id="date_fin"
              class="f-input @error('date_fin') f-input--err @enderror"
              value="{{ old('date_fin', isset($experience->date_fin) ? $experience->date_fin->format('Y-m-d') : '') }}">
            @error('date_fin')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field mb-0">
            <div class="f-toggle-row">
              <div>
                <div class="f-toggle-label">
                  <span class="f-dot-pulse"></span>
                  En cours
                </div>
                <div class="f-toggle-hint">Poste / formation actuel(le)</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="en_cours" value="0">
                <input type="checkbox" name="en_cours" value="1" id="enCours"
                  {{ old('en_cours', $experience->en_cours ?? false) ? 'checked' : '' }}
                  onchange="toggleDateFin(this)">
                <span class="f-toggle-track">
                  <span class="f-toggle-thumb"></span>
                </span>
              </label>
            </div>
          </div>

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
                <div class="f-toggle-label"><i class="bi bi-eye"></i> Visible</div>
                <div class="f-toggle-hint">Affiché sur le portfolio</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1"
                  {{ old('actif', $experience->actif ?? true) ? 'checked' : '' }}>
                <span class="f-toggle-track">
                  <span class="f-toggle-thumb"></span>
                </span>
              </label>
            </div>
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Ordre d'affichage</label>
            <input type="number" name="ordre" class="f-input" min="0"
              value="{{ old('ordre', $experience->ordre ?? 0) }}">
            <p class="f-hint">Plus petit = affiché en premier dans son groupe.</p>
          </div>

        </div>
      </div>

      {{-- Actions --}}
      <div class="f-actions">
        <button type="submit" class="f-btn-submit">
          {!! $isEdit ? '<i class="bi bi-floppy-fill"></i> Enregistrer' : '<i class="bi bi-check-circle-fill"></i> Créer l\'expérience' !!}
        </button>
        <a href="{{ route('experiences.index') }}" class="f-btn-cancel">Annuler</a>
      </div>

    </div>
  </div>
</form>
</main>

@endsection


<style>
.page-eyebrow { display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px }
.page-eyebrow::before { content:'';width:18px;height:2px;background:var(--primary);border-radius:2px }
.page-title { font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark) }

.btn-hd-back { display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;cursor:pointer;transition:all var(--transition);text-decoration:none;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border) }
.btn-hd-back:hover { background:var(--border);color:var(--dark) }

/* Cards */
.f-card { background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow) }
.f-card-head { display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg) }
.f-card-ico { font-size:.95rem;line-height:1 }
.f-card-titre { font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark) }
.f-card-head-hint { font-size:.72rem;color:var(--muted);margin-left:3px }
.f-card-body { padding:18px }

/* Type selector */
.type-selector { display:grid;grid-template-columns:1fr 1fr;gap:12px }
.type-option { border:1.5px solid var(--border);border-radius:var(--radius);padding:16px;cursor:pointer;transition:all var(--transition);text-align:center;background:#fff }
.type-option input { display:none }
.type-option:hover { border-color:var(--primary);background:var(--primary-light) }
.type-option--active { border-color:var(--primary);background:var(--primary-light) }
.type-option-ico { font-size:1.8rem;margin-bottom:8px }
.type-option-titre { font-family:var(--font-display);font-size:.85rem;font-weight:700;color:var(--dark);margin-bottom:3px }
.type-option-sub { font-size:.73rem;color:var(--muted) }

/* Champs */
.f-field { margin-bottom:16px }
.f-field.mb-0 { margin-bottom:0 }
.f-label { display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px }
.f-req { color:var(--primary) }
.f-hint { font-size:.73rem;color:var(--muted);margin-top:5px;margin-bottom:0 }
.f-err-msg { font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0 }
.f-input { width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition);-webkit-appearance:none;appearance:none }
.f-input:focus { border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff }
.f-input--err { border-color:var(--danger)!important;box-shadow:0 0 0 4px rgba(239,68,68,.08)!important }
.f-textarea { resize:vertical;min-height:100px }
.f-input-ico-wrap { position:relative }
.f-input-ico { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none }
.f-input-with-ico { padding-left:38px }

/* Toggle */
.f-toggle-row { display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 14px }
.f-toggle-label { font-family:var(--font-body);font-size:.87rem;font-weight:600;color:var(--dark);display:flex;align-items:center;gap:7px }
.f-toggle-hint { font-size:.74rem;color:var(--muted);margin-top:1px }
.f-toggle { flex-shrink:0;cursor:pointer }
.f-toggle input { display:none }
.f-toggle-track { display:block;width:44px;height:25px;border-radius:99px;background:var(--border);position:relative;transition:background var(--transition) }
.f-toggle-thumb { position:absolute;width:19px;height:19px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform var(--transition);box-shadow:0 1px 4px rgba(0,0,0,.2) }
.f-toggle input:checked + .f-toggle-track { background:var(--primary) }
.f-toggle input:checked + .f-toggle-track .f-toggle-thumb { transform:translateX(19px) }
.f-dot-pulse { width:7px;height:7px;border-radius:50%;background:var(--success);animation:pvPulse 1.5s infinite }

/* Upload */
.logo-current { margin-bottom:14px;display:flex;align-items:center;gap:12px }
.logo-current img { width:64px;height:64px;border-radius:12px;object-fit:contain;object-position:center;border:1px solid var(--border);background:#fff;padding:6px;box-shadow:0 1px 4px rgba(0,0,0,.06) }
.f-img-remove { display:inline-flex;align-items:center;gap:6px;font-size:.8rem;color:var(--danger);cursor:pointer;font-family:var(--font-body);border:none;background:none;padding:0 }
.f-img-remove input { accent-color:var(--danger) }
.f-upload { border:2px dashed var(--border);border-radius:var(--radius);padding:24px 16px;text-align:center;cursor:pointer;position:relative;transition:all var(--transition) }
.f-upload:hover,.f-upload.drag-active { border-color:var(--primary);background:var(--primary-light) }
.f-upload-input { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100% }
.f-upload-body { pointer-events:none }
.f-upload-ico { width:44px;height:44px;border-radius:12px;background:var(--gray-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);margin:0 auto 10px }
.f-upload:hover .f-upload-ico { background:rgba(255,124,8,.1);border-color:rgba(255,124,8,.3);color:var(--primary) }
.f-upload-txt { font-size:.86rem;color:var(--text);margin-bottom:3px }
.f-upload-browse { color:var(--primary);font-weight:700 }
.f-upload-hint { font-size:.74rem;color:var(--muted);margin:0 }

/* Boutons */
.f-actions { display:flex;flex-direction:column;gap:10px }
.f-btn-submit { width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition) }
.f-btn-submit:hover { background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 22px rgba(255,124,8,.45) }
.f-btn-cancel { display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:all var(--transition) }
.f-btn-cancel:hover { background:var(--border);color:var(--text) }

@keyframes pvPulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.3)} }
@media(max-width:768px) { .type-selector { grid-template-columns:1fr } }
</style>


@push('scripts')
<script>
/* ── Type selector ── */
document.querySelectorAll('.type-option input').forEach(radio => {
  radio.addEventListener('change', function () {
    document.querySelectorAll('.type-option').forEach(o => o.classList.remove('type-option--active'));
    this.closest('.type-option').classList.add('type-option--active');
  });
});

/* ── Toggle date de fin ── */
function toggleDateFin(cb) {
  const wrap = document.getElementById('datefinWrap');
  const input = document.getElementById('date_fin');
  if (cb.checked) {
    wrap.style.opacity = '.4';
    wrap.style.pointerEvents = 'none';
    input.value = '';
  } else {
    wrap.style.opacity = '1';
    wrap.style.pointerEvents = 'auto';
  }
}
// Init au chargement
const enCours = document.getElementById('enCours');
if (enCours?.checked) toggleDateFin(enCours);

/* ── Logo ── */
function handleLogoChange(input) {
  if (!input.files?.[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('newLogoPreview').src = e.target.result;
    document.getElementById('newLogoPreviewWrap').style.display = 'flex';
  };
  reader.readAsDataURL(input.files[0]);
}
function clearLogoInput() {
  document.getElementById('logoInput').value = '';
  document.getElementById('newLogoPreviewWrap').style.display = 'none';
}
function toggleLogoPreview(cb) {
  const img = document.querySelector('#logoCurrentWrap img');
  if (img) img.style.opacity = cb.checked ? '.25' : '1';
}

/* ── Drag & drop ── */
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-active'); });
zone.addEventListener('dragleave', ()  => zone.classList.remove('drag-active'));
zone.addEventListener('drop',      e  => {
  e.preventDefault(); zone.classList.remove('drag-active');
  const file = e.dataTransfer.files[0];
  if (file?.type.startsWith('image/')) {
    const dt = new DataTransfer(); dt.items.add(file);
    const input = document.getElementById('logoInput');
    input.files = dt.files; handleLogoChange(input);
  }
});
</script>
@endpush
