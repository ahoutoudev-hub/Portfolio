@extends('layouts_admin.master_admin')
@section('title', 'Projets')

@section('content')
  {{-- ══════════════════════════════════════
      EN-TÊTE
  ══════════════════════════════════════ --}}
  <div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
    <div>
      <div class="page-eyebrow">Portfolio</div>
      <h4 class="page-title mb-1">Mes projets</h4>
      <p class="text-muted small mb-0">Gérez vos réalisations publiées sur le portfolio.</p>
    </div>
    <a href="{{ route('projets.create') }}" class="btn-add-projet">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
      </svg>
      Nouveau projet
    </a>
  </div>

  {{-- ══════════════════════════════════════
      KPI CARDS
  ══════════════════════════════════════ --}}
  <div class="row g-3 mb-4">

    <div class="col-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-icon" style="--c:var(--primary)">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
          </svg>
        </div>
        <div>
          <div class="kpi-num">{{ $stats['total'] }}</div>
          <div class="kpi-label">Total projets</div>
        </div>
        <div class="kpi-stripe" style="--c:var(--primary)"></div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-icon" style="--c:var(--success)">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
        </div>
        <div>
          <div class="kpi-num">{{ $stats['publies'] }}</div>
          <div class="kpi-label">Publiés</div>
        </div>
        <div class="kpi-stripe" style="--c:var(--success)"></div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-icon" style="--c:var(--warning)">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
          </svg>
        </div>
        <div>
          <div class="kpi-num">{{ $stats['brouillon'] }}</div>
          <div class="kpi-label">Brouillons</div>
        </div>
        <div class="kpi-stripe" style="--c:var(--warning)"></div>
      </div>
    </div>

    <div class="col-6 col-xl-3">
      <div class="kpi-card">
        <div class="kpi-icon" style="--c:var(--muted)">
          <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8"/>
          </svg>
        </div>
        <div>
          <div class="kpi-num">{{ $stats['archive'] }}</div>
          <div class="kpi-label">Archivés</div>
        </div>
        <div class="kpi-stripe" style="--c:var(--muted)"></div>
      </div>
    </div>

  </div>

  {{-- ══════════════════════════════════════
      FILTER PANEL
  ══════════════════════════════════════ --}}
  <div class="filter-panel mb-4">

    <div class="statut-tabs">
      <a href="{{ route('projets.index') }}"
        class="statut-tab {{ !request('statut') ? 'statut-tab--active' : '' }}">
        Tous <span class="statut-tab-pill">{{ $stats['total'] }}</span>
      </a>
      <a href="{{ route('projets.index', ['statut' => 'publié']) }}"
        class="statut-tab {{ request('statut') === 'publié' ? 'statut-tab--active statut-tab--success' : '' }}">
        Publiés <span class="statut-tab-pill">{{ $stats['publies'] }}</span>
      </a>
      <a href="{{ route('projets.index', ['statut' => 'brouillon']) }}"
        class="statut-tab {{ request('statut') === 'brouillon' ? 'statut-tab--active statut-tab--warning' : '' }}">
        Brouillons <span class="statut-tab-pill">{{ $stats['brouillon'] }}</span>
      </a>
      <a href="{{ route('projets.index', ['statut' => 'archivé']) }}"
        class="statut-tab {{ request('statut') === 'archivé' ? 'statut-tab--active statut-tab--muted' : '' }}">
        Archivés <span class="statut-tab-pill">{{ $stats['archive'] }}</span>
      </a>
    </div>

    <form method="GET" action="{{ route('projets.index') }}" class="filter-form">
      @if(request('statut'))
        <input type="hidden" name="statut" value="{{ request('statut') }}">
      @endif
      <div class="search-box">
        <svg class="search-box-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="m21 21-4.35-4.35"/>
        </svg>
        <input type="text" name="search" class="search-box-input"
          placeholder="Rechercher un projet..."
          value="{{ request('search') }}">
        @if(request('search'))
          <a href="{{ route('projets.index', request()->except('search')) }}" class="search-box-clear"><i class="bi bi-x"></i></a>
        @endif
      </div>
      <button type="submit" class="btn-filtre">Filtrer</button>
      @if(request()->hasAny(['search','statut']))
        <a href="{{ route('projets.index') }}" class="btn-reset">Réinitialiser</a>
      @endif
    </form>

  </div>

  {{-- ══════════════════════════════════════
      GRILLE PROJETS
  ══════════════════════════════════════ --}}
  @if($projets->isNotEmpty())

  <div class="projets-grid">
    @foreach($projets as $projet)
    <article class="pcard">

      {{-- Thumbnail --}}
      <div class="pcard-thumb">
        @if($projet->image)
          <img src="{{ asset('storage/' . $projet->image) }}" alt="{{ $projet->titre }}">
        @else
          <div class="pcard-emoji"><i class="bi bi-rocket-takeoff-fill"></i></div>
        @endif

        @if($projet->en_vedette)
          <span class="pcard-badge-vedette"><i class="bi bi-star-fill"></i> Vedette</span>
        @endif

        <span class="pcard-badge-statut pcard-badge-statut--{{ $projet->statut }}">
          {{ ucfirst($projet->statut) }}
        </span>

        <div class="pcard-overlay">
          <a href="{{ route('projets.edit', $projet) }}" class="pcard-ol-btn">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Modifier
          </a>
          @if($projet->url_demo)
            <a href="{{ $projet->url_demo }}" target="_blank" class="pcard-ol-btn">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
              </svg>
              Démo
            </a>
          @endif
        </div>
      </div>

      {{-- Body --}}
      <div class="pcard-body">

        <div class="pcard-tags">
          @foreach($projet->tags->take(3) as $tag)
            <span class="pcard-tag" style="background:{{ $tag->couleur }}18;color:{{ $tag->couleur }}">
              {{ $tag->nom }}
            </span>
          @endforeach
          @if($projet->tags->count() > 3)
            <span class="pcard-tag pcard-tag--more">+{{ $projet->tags->count() - 3 }}</span>
          @endif
        </div>

        <a href="{{ route('projets.edit', $projet) }}" class="pcard-titre">
          {{ $projet->titre }}
        </a>

        <p class="pcard-desc">{{ Str::limit(strip_tags($projet->description), 85) }}</p>

        <div class="pcard-footer">
          <div class="pcard-meta">
            <span class="pcard-meta-item">
              <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              {{ number_format($projet->vues) }}
            </span>
            @if($projet->date_fin)
              <span class="pcard-meta-item">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
                {{ $projet->date_fin->format('M Y') }}
              </span>
            @endif
          </div>

          <div class="pcard-actions">
            <button class="btn-vedette {{ $projet->en_vedette ? 'btn-vedette--on' : '' }}"
              data-id="{{ $projet->id }}"
              title="{{ $projet->en_vedette ? 'Retirer de la vedette' : 'Mettre en vedette' }}">
              <i class="bi bi-star-fill"></i>
            </button>
            <button class="btn-suppr"
              onclick="confirmDelete('{{ route('projets.destroy', $projet) }}', '{{ addslashes($projet->titre) }}')"
              title="Supprimer">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m5 0V4a1 1 0 011-1h2a1 1 0 011 1v2"/>
              </svg>
            </button>
          </div>
        </div>

      </div>
    </article>
    @endforeach
  </div>

  @if($projets->hasPages())
    <div class="d-flex justify-content-center mt-5">
      {{ $projets->links() }}
    </div>
  @endif

  @else

  <div class="empty-projets">
    <div class="empty-projets-icon"><i class="bi bi-folder-fill"></i></div>
    <div class="empty-projets-titre">
      @if(request()->hasAny(['search','statut']))
        Aucun projet ne correspond à votre recherche
      @else
        Aucun projet pour l'instant
      @endif
    </div>
    <p class="empty-projets-sub">
      @if(request()->hasAny(['search','statut']))
        Essayez de modifier vos filtres ou
        <a href="{{ route('projets.index') }}">réinitialisez la recherche</a>.
      @else
        Commencez par créer votre premier projet.
      @endif
    </p>
    @if(!request()->hasAny(['search','statut']))
      <a href="{{ route('projets.create') }}" class="btn-add-projet" style="margin-top:1.5rem">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Créer un projet
      </a>
    @endif
  </div>

  @endif

</main>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-vedette').forEach(btn => {
  btn.addEventListener('click', async function () {
    const id = this.dataset.id;
    try {
      const res = await fetch(`/admin/projets/${id}/vedette`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
          'Accept': 'application/json',
        }
      });
      if (!res.ok) throw new Error();
      const data = await res.json();
      this.classList.toggle('btn-vedette--on', data.en_vedette);

      const thumb = this.closest('.pcard').querySelector('.pcard-thumb');
      const badge = thumb.querySelector('.pcard-badge-vedette');
      if (data.en_vedette && !badge) {
        const b = document.createElement('span');
        b.className = 'pcard-badge-vedette';
        b.textContent = '⭐ Vedette';
        thumb.prepend(b);
      } else if (!data.en_vedette && badge) {
        badge.remove();
      }

      if (window.showToast) window.showToast(data.message, 'success');
    } catch {
      if (window.showToast) window.showToast('Une erreur est survenue.', 'error');
    }
  });
});
</script>
@endpush


<style>
/* ═══════════════════════════════════════
   EYEBROW + TITRE PAGE
═══════════════════════════════════════ */
.page-eyebrow {
  display: inline-flex; align-items: center; gap: 7px;
  font-family: var(--font-display); font-size: .72rem; font-weight: 700;
  text-transform: uppercase; letter-spacing: .12em;
  color: var(--primary); margin-bottom: 5px;
}
.page-eyebrow::before {
  content: ''; width: 18px; height: 2px;
  background: var(--primary); border-radius: 2px;
}
.page-title {
  font-family: var(--font-display); font-size: 1.55rem;
  font-weight: 800; color: var(--dark); line-height: 1.2;
}

/* ═══════════════════════════════════════
   BOUTON AJOUTER
═══════════════════════════════════════ */
.btn-add-projet {
  display: inline-flex; align-items: center; gap: 8px;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  padding: 11px 22px; border-radius: var(--radius);
  border: none; cursor: pointer; text-decoration: none;
  box-shadow: 0 4px 16px rgba(255,124,8,.35);
  transition: background var(--transition), transform var(--transition), box-shadow var(--transition);
}
.btn-add-projet:hover {
  background: var(--primary-dark); color: #fff;
  transform: translateY(-2px); box-shadow: 0 8px 24px rgba(255,124,8,.45);
}

/* ═══════════════════════════════════════
   KPI CARDS
═══════════════════════════════════════ */
.kpi-card {
  background: #fff; border: 1px solid var(--border);
  border-radius: var(--radius); padding: 18px 16px 14px;
  display: flex; align-items: center; gap: 14px;
  position: relative; overflow: hidden;
  box-shadow: var(--shadow);
  transition: transform var(--transition), box-shadow var(--transition);
}
.kpi-card:hover {
  transform: translateY(-3px); box-shadow: var(--shadow-md);
}
.kpi-icon {
  width: 46px; height: 46px; border-radius: 11px; flex-shrink: 0;
  background: rgba(255,255,255,0);
  /* Simuler rgba avec la var couleur via box-shadow interne */
  box-shadow: inset 0 0 0 46px color-mix(in srgb, var(--c) 12%, transparent);
  color: var(--c);
  display: flex; align-items: center; justify-content: center;
}
.kpi-num {
  font-family: var(--font-display); font-size: 1.8rem; font-weight: 800;
  color: var(--dark); line-height: 1;
}
.kpi-label {
  font-size: .76rem; font-weight: 500; color: var(--muted); margin-top: 2px;
}
.kpi-stripe {
  position: absolute; bottom: 0; left: 0; right: 0;
  height: 3px; background: var(--c); opacity: .4;
}

/* ═══════════════════════════════════════
   FILTER PANEL
═══════════════════════════════════════ */
.filter-panel {
  display: flex; align-items: center; justify-content: space-between;
  flex-wrap: wrap; gap: 12px;
  background: #fff; border: 1px solid var(--border);
  border-radius: var(--radius); padding: 10px 16px;
  box-shadow: var(--shadow);
}

/* Tabs statut */
.statut-tabs { display: flex; gap: 3px; }
.statut-tab {
  display: inline-flex; align-items: center; gap: 7px;
  padding: 7px 13px; border-radius: 9px;
  font-family: var(--font-body); font-size: .82rem; font-weight: 600;
  color: var(--muted); text-decoration: none;
  transition: all var(--transition);
}
.statut-tab:hover { background: var(--gray-bg); color: var(--text); }
.statut-tab--active               { background: var(--dark);    color: #fff; }
.statut-tab--active.statut-tab--success { background: rgba(16,185,129,.12); color: var(--success); }
.statut-tab--active.statut-tab--warning { background: rgba(245,158,11,.12); color: var(--warning); }
.statut-tab--active.statut-tab--muted   { background: rgba(156,163,175,.12); color: var(--muted);  }
.statut-tab-pill {
  background: rgba(0,0,0,.06); color: inherit; opacity: .75;
  padding: 1px 8px; border-radius: 99px;
  font-size: .7rem; font-weight: 800;
}
.statut-tab--active .statut-tab-pill { background: rgba(255,255,255,.18); opacity: 1; }

/* Search box */
.filter-form { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.search-box {
  position: relative; display: flex; align-items: center;
  background: var(--gray-bg); border: 1.5px solid var(--border);
  border-radius: 10px; padding: 0 12px 0 36px;
  transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
}
.search-box:focus-within {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(255,124,8,.1);
  background: #fff;
}
.search-box-ico {
  position: absolute; left: 11px; color: var(--muted); pointer-events: none;
}
.search-box-input {
  border: none; background: transparent; outline: none;
  font-family: var(--font-body); font-size: .85rem; color: var(--text);
  padding: 9px 0; width: 210px;
}
.search-box-input::placeholder { color: var(--muted); }
.search-box-clear {
  color: var(--muted); font-size: .8rem; text-decoration: none; padding: 3px;
  transition: color var(--transition);
}
.search-box-clear:hover { color: var(--danger); }
.btn-filtre {
  padding: 9px 18px; border-radius: 9px;
  background: var(--dark); color: #fff;
  font-family: var(--font-display); font-size: .82rem; font-weight: 700;
  border: none; cursor: pointer;
  transition: background var(--transition), transform var(--transition);
}
.btn-filtre:hover { background: var(--dark-2); transform: translateY(-1px); }
.btn-reset {
  font-size: .8rem; color: var(--muted); text-decoration: none;
  padding: 9px 4px; transition: color var(--transition);
}
.btn-reset:hover { color: var(--danger); }

/* ═══════════════════════════════════════
   GRILLE PROJETS
═══════════════════════════════════════ */
.projets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(296px, 1fr));
  gap: 22px;
}

/* ── PCARD ── */
.pcard {
  background: #fff; border: 1px solid var(--border);
  border-radius: var(--radius); overflow: hidden;
  box-shadow: var(--shadow);
  display: flex; flex-direction: column;
  transition: transform var(--transition), box-shadow var(--transition);
}
.pcard:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }

/* Thumb */
.pcard-thumb {
  height: 188px; position: relative; overflow: hidden;
  background: linear-gradient(135deg, var(--dark-3) 0%, var(--dark) 100%);
  display: flex; align-items: center; justify-content: center;
}
.pcard-thumb img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .45s ease;
}
.pcard:hover .pcard-thumb img { transform: scale(1.06); }
.pcard-emoji {
  font-size: 3.8rem;
  filter: drop-shadow(0 4px 14px rgba(0,0,0,.35));
}

/* Badges sur la thumb */
.pcard-badge-vedette {
  position: absolute; top: 10px; left: 10px; z-index: 2;
  background: var(--primary); color: #fff;
  font-family: var(--font-display); font-size: .66rem; font-weight: 800;
  padding: 4px 10px; border-radius: 99px;
  box-shadow: 0 3px 10px rgba(255,124,8,.45);
}
.pcard-badge-statut {
  position: absolute; top: 10px; right: 10px; z-index: 2;
  font-family: var(--font-display); font-size: .66rem; font-weight: 700;
  padding: 4px 10px; border-radius: 99px;
  backdrop-filter: blur(6px);
}
.pcard-badge-statut--publié    { background: rgba(16,185,129,.18);  color: var(--success); }
.pcard-badge-statut--brouillon { background: rgba(245,158,11,.18);  color: var(--warning); }
.pcard-badge-statut--archivé   { background: rgba(156,163,175,.18); color: var(--muted); }

/* Overlay hover */
.pcard-overlay {
  position: absolute; inset: 0; z-index: 3;
  background: rgba(35,31,64,.72); backdrop-filter: blur(4px);
  display: flex; align-items: center; justify-content: center; gap: 10px;
  opacity: 0; transition: opacity var(--transition);
}
.pcard:hover .pcard-overlay { opacity: 1; }
.pcard-ol-btn {
  display: inline-flex; align-items: center; gap: 6px;
  background: #fff; color: var(--dark);
  font-family: var(--font-display); font-size: .78rem; font-weight: 700;
  padding: 9px 18px; border-radius: 9px; text-decoration: none;
  transition: background var(--transition), color var(--transition), transform var(--transition);
  box-shadow: 0 3px 10px rgba(0,0,0,.18);
}
.pcard-ol-btn:hover {
  background: var(--primary); color: #fff; transform: translateY(-2px);
}

/* Body */
.pcard-body {
  padding: 16px 18px 14px; flex: 1;
  display: flex; flex-direction: column;
}

/* Tags */
.pcard-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 9px; }
.pcard-tag {
  padding: 3px 9px; border-radius: 99px;
  font-family: var(--font-body); font-size: .68rem; font-weight: 700;
  letter-spacing: .03em;
}
.pcard-tag--more {
  background: var(--gray-bg); color: var(--muted);
}

/* Titre */
.pcard-titre {
  font-family: var(--font-display); font-size: .98rem; font-weight: 700;
  color: var(--dark); text-decoration: none; margin-bottom: 6px; display: block;
  transition: color var(--transition);
}
.pcard-titre:hover { color: var(--primary); }

/* Desc */
.pcard-desc {
  font-size: .82rem; color: var(--muted); line-height: 1.65;
  flex: 1; margin-bottom: 14px;
  display: -webkit-box; -webkit-line-clamp: 2;
  -webkit-box-orient: vertical; overflow: hidden;
}

/* Footer */
.pcard-footer {
  display: flex; align-items: center; justify-content: space-between;
  padding-top: 11px; border-top: 1px solid var(--border); gap: 8px;
}
.pcard-meta { display: flex; align-items: center; gap: 11px; }
.pcard-meta-item {
  display: flex; align-items: center; gap: 4px;
  font-size: .74rem; color: var(--muted);
}
.pcard-actions { display: flex; align-items: center; gap: 6px; }

/* Vedette */
.btn-vedette {
  background: none; border: none; cursor: pointer;
  font-size: .95rem; opacity: .3; padding: 4px;
  transition: opacity var(--transition), transform var(--transition);
}
.btn-vedette:hover { opacity: .65; }
.btn-vedette--on   { opacity: 1; transform: scale(1.18); }

/* Supprimer */
.btn-suppr {
  width: 30px; height: 30px; border-radius: 8px;
  background: rgba(239,68,68,.08); color: var(--danger);
  border: none; cursor: pointer;
  display: flex; align-items: center; justify-content: center;
  transition: background var(--transition), transform var(--transition);
}
.btn-suppr:hover { background: rgba(239,68,68,.18); transform: scale(1.1); }

/* ═══════════════════════════════════════
   EMPTY STATE
═══════════════════════════════════════ */
.empty-projets {
  text-align: center; padding: 80px 24px;
  background: #fff; border: 1.5px dashed var(--border);
  border-radius: var(--radius);
}
.empty-projets-icon   { font-size: 3.5rem; margin-bottom: 16px; opacity: .4; }
.empty-projets-titre  {
  font-family: var(--font-display); font-size: 1.1rem;
  font-weight: 700; color: var(--text); margin-bottom: 7px;
}
.empty-projets-sub    { font-size: .87rem; color: var(--muted); }
.empty-projets-sub a  { color: var(--primary); font-weight: 600; text-decoration: none; }

/* ═══════════════════════════════════════
   MODAL SUPPRESSION
═══════════════════════════════════════ */
.modal-delete {
  border: none; border-radius: 20px;
  box-shadow: var(--shadow-lg);
}
.modal-delete-ico   { font-size: 2.8rem; margin-bottom: 12px; }
.modal-delete-titre {
  font-family: var(--font-display); font-size: 1.15rem;
  font-weight: 800; color: var(--dark); margin-bottom: 8px;
}
.modal-delete-txt {
  font-size: .86rem; color: var(--muted);
  max-width: 300px; margin: 0 auto; line-height: 1.65;
}
.btn-annuler {
  padding: 10px 22px; border-radius: 9px;
  background: var(--gray-bg); color: var(--text);
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  border: 1px solid var(--border); cursor: pointer;
  transition: background var(--transition), transform var(--transition);
}
.btn-annuler:hover { background: var(--border); transform: translateY(-1px); }
.btn-confirmer-suppr {
  display: inline-flex; align-items: center;
  background: var(--danger); color: #fff;
  font-family: var(--font-display); font-weight: 700; font-size: .85rem;
  padding: 10px 24px; border-radius: 9px; border: none; cursor: pointer;
  box-shadow: 0 4px 14px rgba(239,68,68,.3);
  transition: background var(--transition), transform var(--transition);
}
.btn-confirmer-suppr:hover { background: #dc2626; transform: translateY(-1px); }

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media (max-width: 768px) {
  .projets-grid      { grid-template-columns: 1fr; }
  .filter-panel      { flex-direction: column; align-items: stretch; }
  .filter-form       { flex-direction: column; }
  .search-box        { width: 100%; }
  .search-box-input  { width: 100%; }
  .statut-tabs       { overflow-x: auto; padding-bottom: 4px; flex-wrap: nowrap; }
}
</style>
