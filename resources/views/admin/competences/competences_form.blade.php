@extends('layouts_admin.master_admin')
@section('title', isset($competence) ? 'Modifier · ' . $competence->nom : 'Nouvelle compétence')

@section('content')
@php $isEdit = isset($competence); @endphp
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">{{ $isEdit ? 'Modifier' : 'Ajouter' }}</div>
    <h4 class="page-title mb-1">{{ $isEdit ? $competence->nom : 'Nouvelle compétence' }}</h4>
    <p class="text-muted small mb-0">{{ $isEdit ? 'Modifiez les informations de cette compétence.' : 'Ajoutez une nouvelle compétence à votre stack.' }}</p>
  </div>
  <a href="{{ route('competences.index') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Retour
  </a>
</div>

<form method="POST"
  action="{{ $isEdit ? route('competences.update', $competence) : route('competences.store') }}"
  id="compForm" novalidate>
  @csrf
  @if($isEdit)  @endif

  <div class="row g-4 justify-content-center">
    <div class="col-lg-7">

      {{-- Catégorie --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-folder-fill"></i></span><span class="f-card-titre">Catégorie</span></div>
        <div class="f-card-body">
          <div class="cat-selector">
            @foreach($categories as $cat)
              @php $sel = old('categorie_id', $competence->categorie_id ?? request('categorie')) == $cat->id; @endphp
              <label class="cat-option {{ $sel ? 'cat-option--active' : '' }}" style="--cc:{{ $cat->couleur }}">
                <input type="radio" name="categorie_id" value="{{ $cat->id }}" {{ $sel ? 'checked' : '' }}>
                <span class="cat-dot" style="background:{{ $cat->couleur }}"></span>
                {{ $cat->nom }}
              </label>
            @endforeach
          </div>
          @error('categorie_id')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
          <p class="f-hint mt-2">
            Pas la bonne catégorie ?
            <a href="{{ route('competences.categories') }}" style="color:var(--primary)">Gérer les catégories →</a>
          </p>
        </div>
      </div>

      {{-- Nom + Icône --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-pencil-fill"></i></span><span class="f-card-titre">Informations</span></div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Nom de la compétence <span class="f-req">*</span></label>
            <input type="text" name="nom" id="nom"
              class="f-input @error('nom') f-input--err @enderror"
              placeholder="Ex : Laravel, Vue.js, MySQL..."
              value="{{ old('nom', $competence->nom ?? '') }}"
              required>
            @error('nom')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field mb-0">
            <label class="f-label">
              Icône
              <span class="f-label-hint">— Nom Simple Icons (ex: laravel, vuedotjs, mysql)</span>
            </label>
            <div class="icone-wrap">
              <div class="icone-preview" id="iconePreview">
                @if($isEdit && $competence->icone)
                  <img id="iconeImg"
                    src="https://cdn.simpleicons.org/{{ $competence->icone }}/374151"
                    alt="{{ $competence->icone }}"
                    onerror="this.style.display='none'">
                @else
                  <span id="iconeEmoji"><i class="bi bi-lightning-charge-fill"></i></span>
                @endif
              </div>
              <input type="text" name="icone" id="icone"
                class="f-input"
                placeholder="laravel · vuedotjs · mysql · php..."
                value="{{ old('icone', $competence->icone ?? '') }}"
                oninput="updateIconePreview(this.value)">
            </div>
            <p class="f-hint">
              Consultez
              <a href="https://simpleicons.org" target="_blank" style="color:var(--primary)">simpleicons.org</a>
              pour trouver le nom exact (en minuscules, sans espace).
            </p>
          </div>

        </div>
      </div>

      {{-- Niveau --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-bar-chart-fill"></i></span><span class="f-card-titre">Niveau de maîtrise</span></div>
        <div class="f-card-body">

          {{-- Aperçu --}}
          <div class="niveau-preview">
            <div class="niveau-preview-bar">
              <div class="niveau-preview-fill" id="niveauFill"
                style="width:{{ old('niveau', $competence->niveau ?? 80) }}%">
              </div>
            </div>
            <div class="niveau-preview-num" id="niveauNum">
              {{ old('niveau', $competence->niveau ?? 80) }}%
            </div>
            <div class="niveau-preview-label" id="niveauLabel">
              @php $n = old('niveau', $competence->niveau ?? 80); @endphp
              @if($n >= 90) Expert @elseif($n >= 75) Avancé @elseif($n >= 50) Intermédiaire @else Débutant @endif
            </div>
          </div>

          {{-- Slider --}}
          <input type="range" name="niveau" id="niveauRange"
            class="niveau-range"
            min="0" max="100" step="5"
            value="{{ old('niveau', $competence->niveau ?? 80) }}"
            oninput="updateNiveauPreview(this.value)">

          {{-- Boutons rapides --}}
          <div class="niveau-shortcuts">
            <button type="button" class="niveau-shortcut" onclick="setNiveau(25)">25% — Débutant</button>
            <button type="button" class="niveau-shortcut" onclick="setNiveau(50)">50% — Intermédiaire</button>
            <button type="button" class="niveau-shortcut" onclick="setNiveau(75)">75% — Avancé</button>
            <button type="button" class="niveau-shortcut" onclick="setNiveau(90)">90% — Expert</button>
          </div>

          @error('niveau')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror

        </div>
      </div>

      {{-- Ordre --}}
      <div class="f-card mb-4">
        <div class="f-card-head"><span class="f-card-ico"><i class="bi bi-arrow-down-up"></i></span><span class="f-card-titre">Ordre</span></div>
        <div class="f-card-body">
          <input type="number" name="ordre" class="f-input" min="0"
            value="{{ old('ordre', $competence->ordre ?? 0) }}"
            style="max-width:140px">
          <p class="f-hint mt-2">Plus petit = affiché en premier dans la catégorie.</p>
        </div>
      </div>

      {{-- Actions --}}
      <div class="f-actions">
        <button type="submit" class="f-btn-submit">
          {!! $isEdit ? '<i class="bi bi-floppy-fill"></i> Enregistrer' : '<i class="bi bi-check-circle-fill"></i> Créer la compétence' !!}
        </button>
        <a href="{{ route('competences.index') }}" class="f-btn-cancel">Annuler</a>
      </div>

    </div>
  </div>
</form>
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
.f-card-body{padding:18px}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-label-hint{font-size:.72rem;color:var(--muted);font-weight:400}
.f-req{color:var(--primary)}
.f-hint{font-size:.73rem;color:var(--muted);margin-top:5px;margin-bottom:0}
.f-err-msg{font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.f-input--err{border-color:var(--danger)!important;box-shadow:0 0 0 4px rgba(239,68,68,.08)!important}

/* Catégorie selector */
.cat-selector{display:flex;flex-wrap:wrap;gap:8px}
.cat-option{display:inline-flex;align-items:center;gap:8px;padding:9px 16px;border-radius:99px;border:1.5px solid var(--border);cursor:pointer;font-family:var(--font-body);font-size:.82rem;font-weight:600;color:var(--text);transition:all var(--transition);background:#fff;user-select:none}
.cat-option input{display:none}
.cat-option:hover{border-color:var(--cc,var(--primary))}
.cat-option--active{background:var(--cc,var(--primary));border-color:var(--cc,var(--primary));color:#fff}
.cat-option--active .cat-dot{background:rgba(255,255,255,.5)!important}
.cat-dot{width:9px;height:9px;border-radius:50%;flex-shrink:0}

/* Icône */
.icone-wrap{display:flex;align-items:center;gap:12px}
.icone-preview{width:44px;height:44px;border-radius:11px;border:1.5px solid var(--border);background:var(--gray-bg);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;overflow:hidden}
.icone-preview img{width:26px;height:26px;object-fit:contain}

/* Niveau */
.niveau-preview{display:flex;align-items:center;gap:14px;background:var(--gray-bg);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;margin-bottom:16px}
.niveau-preview-bar{flex:1;height:8px;background:var(--border);border-radius:99px;overflow:hidden}
.niveau-preview-fill{height:100%;background:linear-gradient(90deg,var(--primary),#ffb347);border-radius:99px;transition:width .4s ease}
.niveau-preview-num{font-family:var(--font-display);font-size:1.1rem;font-weight:800;color:var(--primary);flex-shrink:0;min-width:42px;text-align:right}
.niveau-preview-label{font-family:var(--font-display);font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:99px;background:var(--primary-light);color:var(--primary);flex-shrink:0}

.niveau-range{width:100%;height:6px;-webkit-appearance:none;appearance:none;background:linear-gradient(to right,var(--primary) var(--nv,80%),var(--border) var(--nv,80%));border-radius:99px;outline:none;cursor:pointer;margin-bottom:14px}
.niveau-range::-webkit-slider-thumb{-webkit-appearance:none;width:20px;height:20px;border-radius:50%;background:var(--primary);border:3px solid #fff;box-shadow:0 2px 8px rgba(255,124,8,.4);cursor:grab;transition:transform var(--transition)}
.niveau-range::-webkit-slider-thumb:active{transform:scale(1.2);cursor:grabbing}

.niveau-shortcuts{display:flex;flex-wrap:wrap;gap:7px}
.niveau-shortcut{padding:6px 12px;border-radius:99px;background:var(--gray-bg);border:1.5px solid var(--border);color:var(--muted);font-family:var(--font-display);font-size:.72rem;font-weight:700;cursor:pointer;transition:all var(--transition)}
.niveau-shortcut:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-light)}

.f-actions{display:flex;flex-direction:column;gap:10px}
.f-btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px)}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:all var(--transition)}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}
</style>


@push('scripts')
<script>
/* ── Catégorie selector ── */
document.querySelectorAll('.cat-option input').forEach(r => {
  r.addEventListener('change', function () {
    document.querySelectorAll('.cat-option').forEach(o => o.classList.remove('cat-option--active'));
    this.closest('.cat-option').classList.add('cat-option--active');
  });
});

/* ── Aperçu icône ── */
let iconeTimer;
function updateIconePreview(val) {
  clearTimeout(iconeTimer);
  iconeTimer = setTimeout(() => {
    const preview = document.getElementById('iconePreview');
    if (!val.trim()) {
      preview.innerHTML = '<span id="iconeEmoji"><i class="bi bi-lightning-charge-fill"></i></span>';
      return;
    }
    const slug  = val.trim().toLowerCase();
    const color = '374151';
    preview.innerHTML = `
      <img src="https://cdn.simpleicons.org/${slug}/${color}" alt="${slug}"
        onerror="this.style.display='none';document.getElementById('iconePreview').innerHTML='<i class=\'bi bi-question-circle-fill\'></i>'">
    `;
  }, 500);
}

/* ── Niveau range ── */
function updateNiveauPreview(val) {
  const n = parseInt(val);
  document.getElementById('niveauFill').style.width = n + '%';
  document.getElementById('niveauNum').textContent   = n + '%';

  const range = document.getElementById('niveauRange');
  range.style.setProperty('--nv', n + '%');

  const labelEl = document.getElementById('niveauLabel');
  if (n >= 90)      { labelEl.textContent = 'Expert';        labelEl.style.background='rgba(16,185,129,.12)'; labelEl.style.color='#10b981'; }
  else if (n >= 75) { labelEl.textContent = 'Avancé';        labelEl.style.background='rgba(59,130,246,.12)'; labelEl.style.color='#3b82f6'; }
  else if (n >= 50) { labelEl.textContent = 'Intermédiaire'; labelEl.style.background='rgba(245,158,11,.12)'; labelEl.style.color='#f59e0b'; }
  else              { labelEl.textContent = 'Débutant';      labelEl.style.background='rgba(156,163,175,.12)';labelEl.style.color='#9ca3af'; }

  // Mettre à jour la couleur de la preview bar
  const pct = n / 100;
  const r1=255,g1=124,b1=8, r2=255,g2=179,b2=71;
  const r=Math.round(r1+(r2-r1)*pct), g=Math.round(g1+(g2-g1)*pct), b=Math.round(b1+(b2-b1)*pct);
  document.getElementById('niveauFill').style.background = `rgb(${r},${g},${b})`;
}

function setNiveau(val) {
  document.getElementById('niveauRange').value = val;
  updateNiveauPreview(val);
}

// Init
updateNiveauPreview(document.getElementById('niveauRange').value);
</script>
@endpush
