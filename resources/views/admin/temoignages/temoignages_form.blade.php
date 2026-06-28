@extends('layouts_admin.master_admin')
@section('title', isset($temoignage) ? 'Modifier · ' . $temoignage->nom : 'Nouveau témoignage')

@section('content')
@php $isEdit = isset($temoignage); @endphp

<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">{{ $isEdit ? 'Modifier' : 'Ajouter' }}</div>
    <h4 class="page-title mb-1">{{ $isEdit ? $temoignage->nom : 'Nouveau témoignage' }}</h4>
    <p class="text-muted small mb-0">{{ $isEdit ? 'Mettez à jour ce témoignage.' : 'Ajoutez un avis client à votre portfolio.' }}</p>
  </div>
  <a href="{{ route('temoignages.index') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Retour
  </a>
</div>

<div class="row g-4 justify-content-center">
  <div class="col-lg-8">

    <form method="POST"
      action="{{ $isEdit ? route('temoignages.update', $temoignage) : route('temoignages.store') }}"
      novalidate>
      @csrf
      @if($isEdit)  @endif

      {{-- Aperçu live --}}
      <div class="temo-preview mb-4">
        <div class="temo-preview-stars" id="prevStars"></div>
        <blockquote class="temo-preview-contenu" id="prevContenu">
          "Le témoignage apparaîtra ici..."
        </blockquote>
        <div class="temo-preview-author">
          <div class="temo-preview-avatar" id="prevAvatar">?</div>
          <div>
            <div class="temo-preview-nom" id="prevNom">Nom du client</div>
            <div class="temo-preview-poste" id="prevPoste">Poste · Entreprise</div>
          </div>
        </div>
      </div>

      {{-- Identité --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-person-fill"></i></span><span class="f-card-titre">Identité</span></div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Nom complet <span class="f-req">*</span></label>
            <input type="text" name="nom" id="nom"
              class="f-input @error('nom') f-input--err @enderror"
              placeholder="Ex : Marie Kouamé"
              value="{{ old('nom', $temoignage->nom ?? '') }}"
              oninput="updatePreview()"
              required>
            @error('nom')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field-row">
            <div class="f-field">
              <label class="f-label">Poste</label>
              <input type="text" name="poste" id="poste"
                class="f-input @error('poste') f-input--err @enderror"
                placeholder="Ex : Directrice Produit"
                value="{{ old('poste', $temoignage->poste ?? '') }}"
                oninput="updatePreview()">
              @error('poste')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>
            <div class="f-field">
              <label class="f-label">Entreprise</label>
              <input type="text" name="entreprise" id="entreprise"
                class="f-input @error('entreprise') f-input--err @enderror"
                placeholder="Ex : StartUp ABC"
                value="{{ old('entreprise', $temoignage->entreprise ?? '') }}"
                oninput="updatePreview()">
              @error('entreprise')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>
          </div>

        </div>
      </div>

      {{-- Note --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-star-fill"></i></span><span class="f-card-titre">Note</span></div>
        <div class="f-card-body">
          <div class="star-selector">
            @for($i = 1; $i <= 5; $i++)
              <label class="star-label" for="note_{{ $i }}">
                <input type="radio" name="note" id="note_{{ $i }}" value="{{ $i }}"
                  {{ old('note', $temoignage->note ?? 5) == $i ? 'checked' : '' }}
                  onchange="updatePreview()">
                <svg class="star-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
              </label>
            @endfor
            <span class="star-label-text" id="starLabel">
              @php $n = old('note', $temoignage->note ?? 5); @endphp
              {{ $n }}/5 — {{ ['','Mauvais','Passable','Bien','Très bien','Excellent'][$n] }}
            </span>
          </div>
          @error('note')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Contenu --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-chat-fill"></i></span><span class="f-card-titre">Témoignage</span></div>
        <div class="f-card-body">
          <textarea name="contenu" id="contenu" rows="5"
            class="f-input f-textarea @error('contenu') f-input--err @enderror"
            placeholder="Saisissez le témoignage du client..."
            oninput="updatePreview()">{{ old('contenu', $temoignage->contenu ?? '') }}</textarea>
          @error('contenu')<p class="f-err-msg">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- Options --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-gear-fill"></i></span><span class="f-card-titre">Options</span></div>
        <div class="f-card-body">

          <div class="f-field">
            <div class="f-toggle-row">
              <div>
                <div class="f-toggle-label"><i class="bi bi-eye"></i> Visible sur le portfolio</div>
                <div class="f-toggle-hint">Affiché dans la section témoignages</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1"
                  {{ old('actif', $temoignage->actif ?? true) ? 'checked' : '' }}>
                <span class="f-toggle-track"><span class="f-toggle-thumb"></span></span>
              </label>
            </div>
          </div>

          <div class="f-field mb-0">
            <label class="f-label">Ordre d'affichage</label>
            <input type="number" name="ordre" class="f-input" min="0"
              style="max-width:130px"
              value="{{ old('ordre', $temoignage->ordre ?? 0) }}">
            <p class="f-hint mt-2">Plus petit = affiché en premier.</p>
          </div>

        </div>
      </div>

      <div class="f-actions">
        <button type="submit" class="f-btn-submit">
          {!! $isEdit ? '<i class="bi bi-floppy-fill"></i> Enregistrer les modifications' : '<i class="bi bi-check-circle-fill"></i> Ajouter le témoignage' !!}
        </button>
        <a href="{{ route('temoignages.index') }}" class="f-btn-cancel">Annuler</a>
      </div>

    </form>
  </div>
</div>

@endsection

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border);text-decoration:none;transition:all var(--transition)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}

/* Aperçu live */
.temo-preview{background:linear-gradient(135deg,var(--dark-3),var(--dark));border-radius:var(--radius);padding:24px;position:relative;overflow:hidden}
.temo-preview::before{content:'❝';position:absolute;top:-10px;left:20px;font-size:8rem;color:rgba(255,124,8,.1);font-family:Georgia,serif;line-height:1;pointer-events:none}
.temo-preview-stars{display:flex;gap:4px;margin-bottom:14px}
.temo-preview-star{font-size:1rem}
.temo-preview-contenu{color:rgba(255,255,255,.85);font-size:.95rem;line-height:1.8;font-style:italic;margin:0 0 18px;border:none;padding:0;position:relative}
.temo-preview-author{display:flex;align-items:center;gap:12px}
.temo-preview-avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ffb347);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:.85rem;color:#fff;flex-shrink:0;transition:all .2s}
.temo-preview-nom{font-family:var(--font-display);font-size:.88rem;font-weight:700;color:#fff}
.temo-preview-poste{font-size:.76rem;color:rgba(255,255,255,.45);margin-top:2px}

/* Cards */
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:.95rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark)}
.f-card-body{padding:18px}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-req{color:var(--primary)}
.f-hint{font-size:.73rem;color:var(--muted);margin-bottom:0}
.f-err-msg{font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.f-input--err{border-color:var(--danger)!important}
.f-textarea{resize:vertical;min-height:110px}

/* Sélecteur étoiles */
.star-selector{display:flex;align-items:center;gap:6px;flex-wrap:wrap}
.star-label{cursor:pointer;display:flex;align-items:center}
.star-label input{display:none}
.star-svg{width:32px;height:32px;color:#d1d5db;transition:all .15s;fill:none}
.star-label:hover .star-svg,
.star-label:hover ~ .star-label .star-svg{color:#f59e0b}
.star-label input:checked ~ .star-label .star-svg{color:#d1d5db;fill:none}
.star-selector:has(.star-label:nth-child(1) input:checked) .star-label:nth-child(1) .star-svg{color:#f59e0b;fill:#f59e0b}
.star-selector:has(.star-label:nth-child(2) input:checked) .star-label:nth-child(-n+2) .star-svg{color:#f59e0b;fill:#f59e0b}
.star-selector:has(.star-label:nth-child(3) input:checked) .star-label:nth-child(-n+3) .star-svg{color:#f59e0b;fill:#f59e0b}
.star-selector:has(.star-label:nth-child(4) input:checked) .star-label:nth-child(-n+4) .star-svg{color:#f59e0b;fill:#f59e0b}
.star-selector:has(.star-label:nth-child(5) input:checked) .star-label:nth-child(-n+5) .star-svg{color:#f59e0b;fill:#f59e0b}
.star-label-text{font-family:var(--font-display);font-size:.8rem;font-weight:700;color:var(--warning);margin-left:8px}

/* Toggle */
.f-toggle-row{display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 14px}
.f-toggle-label{font-family:var(--font-body);font-size:.87rem;font-weight:600;color:var(--dark)}
.f-toggle-hint{font-size:.74rem;color:var(--muted);margin-top:1px}
.f-toggle{flex-shrink:0;cursor:pointer}
.f-toggle input{display:none}
.f-toggle-track{display:block;width:44px;height:25px;border-radius:99px;background:var(--border);position:relative;transition:background var(--transition)}
.f-toggle-thumb{position:absolute;width:19px;height:19px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform var(--transition);box-shadow:0 1px 4px rgba(0,0,0,.2)}
.f-toggle input:checked + .f-toggle-track{background:var(--primary)}
.f-toggle input:checked + .f-toggle-track .f-toggle-thumb{transform:translateX(19px)}

/* Actions */
.f-actions{display:flex;flex-direction:column;gap:10px}
.f-btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px)}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:all var(--transition)}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}

@media(max-width:576px){.f-field-row{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script>
const noteLabels = ['','Mauvais','Passable','Bien','Très bien','Excellent'];

function updatePreview() {
  const nom        = document.getElementById('nom').value.trim() || 'Nom du client';
  const poste      = document.getElementById('poste').value.trim();
  const entreprise = document.getElementById('entreprise').value.trim();
  const contenu    = document.getElementById('contenu').value.trim();
  const note       = parseInt(document.querySelector('[name=note]:checked')?.value || 5);

  // Avatar initiales
  const parts = nom.split(' ');
  const init  = parts.map(p => p[0]?.toUpperCase() || '').slice(0, 2).join('');
  document.getElementById('prevAvatar').textContent  = init || '?';
  document.getElementById('prevNom').textContent     = nom;
  document.getElementById('prevContenu').textContent = contenu ? `"${contenu}"` : '"Le témoignage apparaîtra ici..."';

  // Poste + entreprise
  let posteStr = '';
  if (poste && entreprise) posteStr = `${poste} · ${entreprise}`;
  else if (poste)      posteStr = poste;
  else if (entreprise) posteStr = entreprise;
  document.getElementById('prevPoste').textContent = posteStr || 'Poste · Entreprise';

  // Étoiles
  let starsHtml = '';
  for (let i = 1; i <= 5; i++) {
    starsHtml += `<span class="temo-preview-star" style="opacity:${i<=note?1:.25}">★</span>`;
  }
  document.getElementById('prevStars').innerHTML = starsHtml;

  // Label note
  document.getElementById('starLabel').textContent = `${note}/5 — ${noteLabels[note]}`;
}

// Init
document.querySelectorAll('[name=note]').forEach(r => r.addEventListener('change', updatePreview));
updatePreview();
</script>
@endpush
