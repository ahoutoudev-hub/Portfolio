@extends('layouts_admin.master_admin')
@section('title', 'Tableau de bord')

@section('content')

{{-- ── Page Header ── --}}
<div class="page-header">
  <div>
    <p class="page-eyebrow">Vue d'ensemble</p>
    <h1 class="page-title">Bonjour, {{ $user->prenom }} <i class="bi bi-hand-wave-fill" style="color:var(--primary)"></i></h1>
    <p class="page-subtitle">Votre portfolio aujourd'hui — {{ now()->translatedFormat('l d F Y') }}.</p>
  </div>
  <div class="d-flex gap-2 flex-wrap">
    @if($stats['messages_non_lus'] > 0)
      <a href="{{ route('messages.index') }}" class="btn-dash-alert">
        <i class="bi bi-envelope-fill"></i>
        {{ $stats['messages_non_lus'] }} message{{ $stats['messages_non_lus'] > 1 ? 's' : '' }} non lu{{ $stats['messages_non_lus'] > 1 ? 's' : '' }}
      </a>
    @endif
    <a href="{{ route('projets.create') }}" class="btn-dash-primary">
      <i class="bi bi-plus-lg"></i> Nouveau projet
    </a>
  </div>
</div>

{{-- ══ STAT CARDS ══ --}}
<div class="row g-3 mb-4">

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon-box orange">
        <i class="bi bi-rocket-takeoff-fill"></i>
      </div>
      <div class="stat-body">
        <div class="stat-value">{{ $stats['projets_publies'] }}</div>
        <div class="stat-label">Projets publiés</div>
        <div class="stat-sub">{{ $stats['projets_total'] }} total · {{ $stats['projets_vedette'] }} en vedette</div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card {{ $stats['messages_non_lus'] > 0 ? 'stat-card--alert' : '' }}">
      <div class="stat-icon-box blue">
        <i class="bi bi-envelope-fill"></i>
        @if($stats['messages_non_lus'] > 0)
          <span class="stat-icon-badge">{{ $stats['messages_non_lus'] }}</span>
        @endif
      </div>
      <div class="stat-body">
        <div class="stat-value">{{ $stats['messages_total'] }}</div>
        <div class="stat-label">Messages reçus</div>
        <div class="stat-sub {{ $stats['messages_non_lus'] > 0 ? 'stat-sub--alert' : '' }}">
          @if($stats['messages_non_lus'] > 0)
            {{ $stats['messages_non_lus'] }} non lu{{ $stats['messages_non_lus'] > 1 ? 's' : '' }}
          @else
            Tous lus ✓
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon-box green">
        <i class="bi bi-eye-fill"></i>
      </div>
      <div class="stat-body">
        <div class="stat-value">{{ number_format($vueMoisActuel) }}</div>
        <div class="stat-label">Vues ce mois</div>
        <div class="stat-trend {{ $evolutionVues >= 0 ? 'trend-up' : 'trend-down' }}">
          <i class="bi bi-arrow-{{ $evolutionVues >= 0 ? 'up' : 'down' }}-short"></i>
          {{ $evolutionVues >= 0 ? '+' : '' }}{{ $evolutionVues }}% vs mois dernier
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-icon-box yellow">
        <i class="bi bi-lightning-charge-fill"></i>
      </div>
      <div class="stat-body">
        <div class="stat-value">{{ $stats['competences'] }}</div>
        <div class="stat-label">Compétences</div>
        <div class="stat-sub">{{ $stats['experiences'] }} exp. · {{ $stats['certificats'] }} certif.</div>
      </div>
    </div>
  </div>

</div>

{{-- ══ LIGNE 2 : Graphique + Activité ══ --}}
<div class="row g-3 mb-3">

  {{-- Graphique visites --}}
  <div class="col-lg-8">
    <div class="dash-card h-100">
      <div class="dash-card-header">
        <span class="dash-card-title">
          <i class="bi bi-graph-up-arrow text-primary"></i>
          Visites — 7 derniers jours
        </span>
        <div class="dash-card-header-right">
          <span class="dash-chart-total">
            {{ $visitesChart->sum('count') }} visites
          </span>
          <a href="{{ route('stats.index') }}" class="btn-dash-ghost" style="padding:6px 14px;font-size:.76rem">
            Détails <i class="bi bi-arrow-right ms-1"></i>
          </a>
        </div>
      </div>
      <div class="dash-card-body">
        <div style="height:230px;position:relative">
          <canvas id="visitorsChart" aria-label="Graphique des visites"></canvas>
        </div>
      </div>
    </div>
  </div>

  {{-- Activité récente --}}
  <div class="col-lg-4">
    <div class="dash-card h-100">
      <div class="dash-card-header">
        <span class="dash-card-title">
          <i class="bi bi-clock-history text-warning"></i>
          Activité récente
        </span>
      </div>
      <div class="dash-card-body">
        @forelse($activite as $item)
          <div class="activity-item">
            <div class="activity-dot" style="background:{{ $item['color'] }}18">
              {{ $item['ico'] }}
            </div>
            <div class="activity-info">
              <div class="activity-text">{{ $item['titre'] }}</div>
              <div class="activity-sub">{{ $item['sub'] }}</div>
              <div class="activity-time">
                {{ \Carbon\Carbon::parse($item['date'])->diffForHumans() }}
              </div>
            </div>
          </div>
        @empty
          <div class="dash-empty-sm">
            <i class="bi bi-calendar-x" style="font-size:1.8rem;opacity:.3"></i>
            <p>Aucune activité récente.</p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

</div>

{{-- ══ LIGNE 3 : Projets récents + Top compétences ══ --}}
<div class="row g-3">

  {{-- Projets récents --}}
  <div class="col-lg-7">
    <div class="dash-card">
      <div class="dash-card-header">
        <span class="dash-card-title">
          <i class="bi bi-rocket text-primary"></i>
          Projets récents
        </span>
        <a href="{{ route('projets.index') }}" class="btn-dash-ghost" style="padding:6px 14px;font-size:.78rem">
          Voir tous <i class="bi bi-arrow-right ms-1"></i>
        </a>
      </div>
      <div class="dash-card-body p0">
        <div class="table-responsive">
          <table class="dash-table" aria-label="Projets récents">
            <thead>
              <tr>
                <th>Projet</th>
                <th>Tags</th>
                <th>Statut</th>
                <th>Vues</th>
              </tr>
            </thead>
            <tbody>
              @forelse($projetsRecents as $projet)
              <tr>
                <td>
                  <div class="tbl-cell-info">
                    <div class="tbl-thumb"
                      style="{{ $projet->image ? 'padding:0;overflow:hidden' : 'background:linear-gradient(135deg,var(--dark-3),var(--dark))' }}">
                      @if($projet->image)
                        <img src="{{ asset('storage/' . $projet->image) }}" alt="{{ $projet->titre }}"
                          style="width:100%;height:100%;object-fit:cover">
                      @else
                        <i class="bi bi-rocket-takeoff-fill" style="color:rgba(255,255,255,.4)"></i>
                      @endif
                    </div>
                    <div>
                      <a href="{{ route('projets.edit', $projet) }}" class="tbl-name">
                        {{ Str::limit($projet->titre, 28) }}
                      </a>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex flex-wrap gap-1">
                    @foreach($projet->tags->take(2) as $tag)
                      <span class="badge-tag-sm" style="background:{{ $tag->couleur }}18;color:{{ $tag->couleur }}">
                        {{ $tag->nom }}
                      </span>
                    @endforeach
                  </div>
                </td>
                <td>
                  @if($projet->statut === 'publié')
                    <span class="badge-status badge-published">Publié</span>
                  @elseif($projet->statut === 'brouillon')
                    <span class="badge-status badge-draft">Brouillon</span>
                  @else
                    <span class="badge-status badge-secondary">Archivé</span>
                  @endif
                </td>
                <td class="tbl-vues">{{ number_format($projet->vues) }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center py-4 text-muted" style="font-size:.85rem">
                  Aucun projet.
                  <a href="{{ route('projets.create') }}" style="color:var(--primary)">Créer →</a>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- Top compétences --}}
  <div class="col-lg-5">
    <div class="dash-card h-100">
      <div class="dash-card-header">
        <span class="dash-card-title">
          <i class="bi bi-lightning-charge text-warning"></i>
          Top compétences
        </span>
        <a href="{{ route('competences.index') }}" class="btn-dash-ghost" style="padding:6px 14px;font-size:.78rem">
          Gérer
        </a>
      </div>
      <div class="dash-card-body">
        @forelse($topProjets->take(5) as $proj)
          {{-- fallback si pas de compétences : afficher top projets par vues --}}
        @empty
        @endforelse

        {{-- Vraies compétences depuis la BDD --}}
        @php
          $topComps = \App\Models\Competence::with('categorie')
            ->orderByDesc('niveau')
            ->take(5)
            ->get();
        @endphp

        @forelse($topComps as $comp)
          <div class="q-bar-item">
            <span class="q-bar-label">{{ $comp->nom }}</span>
            <div class="q-bar-track">
              <div class="q-bar-fill"
                style="width:{{ $comp->niveau }}%;background:{{ $comp->categorie?->couleur ?? 'var(--primary)' }}"
                data-w="{{ $comp->niveau }}">
              </div>
            </div>
            <span class="q-bar-val">{{ $comp->niveau }}%</span>
          </div>
        @empty
          <div class="dash-empty-sm">
            <i class="bi bi-lightning" style="font-size:1.8rem;opacity:.3"></i>
            <p>Aucune compétence.
              <a href="{{ route('competences.create') }}" style="color:var(--primary)">Ajouter →</a>
            </p>
          </div>
        @endforelse
      </div>
    </div>
  </div>

</div>

@endsection

@push('styles')
<style>
/* ── Page header ── */
.page-eyebrow {
  font-family:var(--font-display);font-size:.72rem;font-weight:700;
  text-transform:uppercase;letter-spacing:.12em;
  color:var(--primary);margin-bottom:4px;
  display:flex;align-items:center;gap:7px;
}
.page-eyebrow::before { content:'';width:16px;height:2px;background:var(--primary);border-radius:2px }
.page-header {
  display:flex;align-items:flex-start;justify-content:space-between;
  flex-wrap:wrap;gap:16px;margin-bottom:28px;
}
.page-title   { font-family:var(--font-display);font-size:1.55rem;font-weight:800;color:var(--dark);margin:0 0 4px }
.page-subtitle{ font-size:.84rem;color:var(--muted);margin:0 }

/* Boutons header */
.btn-dash-primary {
  display:inline-flex;align-items:center;gap:7px;
  background:var(--primary);color:#fff;
  font-family:var(--font-display);font-weight:700;font-size:.84rem;
  padding:10px 20px;border-radius:var(--radius);border:none;
  text-decoration:none;cursor:pointer;
  box-shadow:0 4px 14px rgba(255,124,8,.35);
  transition:all var(--transition);
}
.btn-dash-primary:hover { background:var(--primary-dark);color:#fff;transform:translateY(-2px) }
.btn-dash-ghost {
  display:inline-flex;align-items:center;gap:6px;
  background:transparent;color:var(--muted);
  font-family:var(--font-display);font-weight:600;font-size:.82rem;
  padding:8px 14px;border-radius:9px;
  border:1.5px solid var(--border);text-decoration:none;
  transition:all var(--transition);
}
.btn-dash-ghost:hover { background:var(--gray-bg);color:var(--text) }
.btn-dash-alert {
  display:inline-flex;align-items:center;gap:7px;
  background:rgba(59,130,246,.1);color:var(--info);
  font-family:var(--font-display);font-weight:700;font-size:.8rem;
  padding:9px 16px;border-radius:99px;
  border:1px solid rgba(59,130,246,.2);text-decoration:none;
  transition:all var(--transition);
}
.btn-dash-alert:hover { background:rgba(59,130,246,.18);color:var(--info) }

/* ── Stat cards ── */
.stat-card {
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);
  padding:20px;display:flex;align-items:flex-start;gap:14px;
  box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition);
  position:relative;overflow:hidden;
}
.stat-card:hover { transform:translateY(-3px);box-shadow:var(--shadow-md) }
.stat-card--alert { border-color:rgba(59,130,246,.25) }
[data-theme="dark"] .stat-card { background:var(--dark-2) }

.stat-icon-box {
  width:46px;height:46px;border-radius:12px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;position:relative;
}
.stat-icon-box.orange { background:rgba(255,124,8,.12);  color:var(--primary) }
.stat-icon-box.blue   { background:rgba(59,130,246,.1);  color:var(--info) }
.stat-icon-box.green  { background:rgba(16,185,129,.1);  color:var(--success) }
.stat-icon-box.yellow { background:rgba(245,158,11,.1);  color:var(--warning) }

.stat-icon-badge {
  position:absolute;top:-5px;right:-5px;
  width:18px;height:18px;border-radius:50%;
  background:var(--info);color:#fff;
  font-size:.58rem;font-weight:800;
  display:flex;align-items:center;justify-content:center;
  border:2px solid #fff;
}
.stat-body { flex:1 }
.stat-value {
  font-family:var(--font-display);font-size:2rem;font-weight:800;
  color:var(--dark);line-height:1;margin-bottom:4px;
}
.stat-label { font-size:.8rem;font-weight:600;color:var(--text);margin-bottom:4px }
.stat-sub   { font-size:.72rem;color:var(--muted) }
.stat-sub--alert { color:var(--info);font-weight:600 }
.stat-trend { font-size:.74rem;font-weight:700;display:flex;align-items:center;gap:2px }
.trend-up   { color:var(--success) }
.trend-down { color:var(--danger) }

/* ── Dash cards ── */
.dash-card { background:#fff;border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow) }
[data-theme="dark"] .dash-card { background:var(--dark-2) }
.dash-card-header {
  display:flex;align-items:center;justify-content:space-between;
  padding:16px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;
}
.dash-card-title { font-family:var(--font-display);font-size:.88rem;font-weight:800;color:var(--dark);display:flex;align-items:center;gap:7px }
.dash-card-body  { padding:18px 20px }
.dash-card-body.p0 { padding:0 }
.dash-card-header-right { display:flex;align-items:center;gap:10px }
.dash-chart-total {
  background:var(--primary-light);color:var(--primary);
  font-family:var(--font-display);font-size:.73rem;font-weight:700;
  padding:4px 12px;border-radius:99px;
  border:1px solid rgba(255,124,8,.2);
}

/* ── Activity ── */
.activity-item {
  display:flex;align-items:flex-start;gap:12px;
  padding:10px 0;border-bottom:1px solid var(--border);
}
.activity-item:last-child { border-bottom:none;padding-bottom:0 }
.activity-dot {
  width:36px;height:36px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:1rem;
}
.activity-info { flex:1;min-width:0 }
.activity-text { font-size:.83rem;font-weight:600;color:var(--dark) }
.activity-sub  { font-size:.75rem;color:var(--muted);margin-top:1px }
.activity-time { font-size:.72rem;color:var(--muted);margin-top:2px }

/* ── Table ── */
.dash-table { width:100%;border-collapse:collapse }
.dash-table th {
  padding:10px 16px;font-family:var(--font-display);font-size:.72rem;
  font-weight:800;text-transform:uppercase;letter-spacing:.07em;
  color:var(--muted);border-bottom:1px solid var(--border);white-space:nowrap;
  background:var(--gray-bg);
}
.dash-table td {
  padding:11px 16px;font-size:.84rem;color:var(--text);
  border-bottom:1px solid var(--border);vertical-align:middle;
}
.dash-table tr:last-child td { border-bottom:none }
.dash-table tr:hover td { background:rgba(255,124,8,.02) }
.tbl-cell-info { display:flex;align-items:center;gap:11px }
.tbl-thumb {
  width:38px;height:38px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:1.1rem;
}
.tbl-name {
  font-family:var(--font-display);font-size:.85rem;font-weight:700;
  color:var(--dark);text-decoration:none;
}
.tbl-name:hover { color:var(--primary) }
.tbl-vues { font-family:var(--font-display);font-size:.8rem;font-weight:700;color:var(--muted) }
.badge-tag-sm { padding:2px 8px;border-radius:99px;font-size:.68rem;font-weight:700 }

/* Badges status */
.badge-status {
  display:inline-flex;align-items:center;gap:4px;
  padding:3px 10px;border-radius:99px;
  font-family:var(--font-display);font-size:.68rem;font-weight:700;
}
.badge-published { background:rgba(16,185,129,.12);color:var(--success) }
.badge-draft     { background:rgba(245,158,11,.12);color:var(--warning) }
.badge-secondary { background:rgba(156,163,175,.12);color:var(--muted) }
.badge-primary   { background:var(--primary-light);color:var(--primary) }

/* ── Barres compétences ── */
.q-bar-item  { display:flex;align-items:center;gap:10px;margin-bottom:14px }
.q-bar-item:last-child { margin-bottom:0 }
.q-bar-label { font-family:var(--font-display);font-size:.82rem;font-weight:700;color:var(--dark);width:90px;flex-shrink:0 }
.q-bar-track { flex:1;height:7px;background:var(--border);border-radius:99px;overflow:hidden }
.q-bar-fill  { height:100%;border-radius:99px;width:0;transition:width 1.2s cubic-bezier(.4,0,.2,1) }
.q-bar-val   { font-family:var(--font-display);font-size:.76rem;font-weight:800;color:var(--primary);width:34px;text-align:right;flex-shrink:0 }

/* ── Empty state sm ── */
.dash-empty-sm { text-align:center;padding:24px;color:var(--muted);font-size:.84rem }
.dash-empty-sm p { margin-top:8px;margin-bottom:0 }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script>
/* ── Données PHP → JS ── */
const visitesData = @json($visitesChart);

/* ── Graphique visites ── */
new Chart(document.getElementById('visitorsChart'), {
  type: 'line',
  data: {
    labels: visitesData.map(v => v.date),
    datasets: [{
      label: 'Visites',
      data: visitesData.map(v => v.count),
      borderColor: '#ff7c08',
      backgroundColor: ctx => {
        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 230);
        g.addColorStop(0, 'rgba(255,124,8,.18)');
        g.addColorStop(1, 'rgba(255,124,8,.01)');
        return g;
      },
      borderWidth: 2.5,
      pointBackgroundColor: '#ff7c08',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
      pointRadius: 4,
      pointHoverRadius: 7,
      fill: true,
      tension: 0.4,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#231f40',
        titleColor: '#fff',
        bodyColor: 'rgba(255,255,255,.7)',
        padding: 12,
        cornerRadius: 10,
        callbacks: { label: c => ` ${c.parsed.y} visite${c.parsed.y > 1 ? 's' : ''}` }
      }
    },
    scales: {
      x: {
        grid: { display: false },
        ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9ca3af' },
        border: { display: false }
      },
      y: {
        beginAtZero: true,
        ticks: {
          font: { family: 'DM Sans', size: 11 }, color: '#9ca3af',
          stepSize: 1, callback: v => Number.isInteger(v) ? v : null
        },
        grid: { color: '#f3f4f6' },
        border: { display: false }
      }
    }
  }
});

/* ── Animer les barres compétences ── */
document.querySelectorAll('.q-bar-fill').forEach(bar => {
  const w = bar.style.width;
  bar.style.width = '0%';
  setTimeout(() => { bar.style.width = w; }, 400);
});
</script>
@endpush