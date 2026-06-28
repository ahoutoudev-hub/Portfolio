@extends('layouts_admin.master_admin')
@section('title', 'Statistiques')

@section('content')
{{-- ══ EN-TÊTE ══ --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Analyse</div>
    <h4 class="page-title mb-1">Statistiques</h4>
    <p class="text-muted small mb-0">Vue d'ensemble des performances de votre portfolio.</p>
  </div>

  {{-- Sélecteur de période --}}
  <div class="periode-tabs">
    @foreach(['7' => '7 jours', '30' => '30 jours', '90' => '90 jours', '365' => '1 an'] as $val => $label)
      <a href="{{ route('stats.index', ['periode' => $val]) }}"
         class="periode-tab {{ $periode == $val ? 'periode-tab--active' : '' }}">
        {{ $label }}
      </a>
    @endforeach
  </div>
</div>

{{-- ══ RECAP CARDS ══ --}}
<div class="row g-3 mb-4">

  <div class="col-6 col-lg">
    <div class="recap-card">
      <div class="recap-card-ico" style="--c:var(--primary)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
      </div>
      <div class="recap-num">{{ number_format($visitesTotalPeriode) }}</div>
      <div class="recap-label">Visites (période)</div>
      <div class="recap-trend {{ $evolutionVisites >= 0 ? 'recap-trend--up' : 'recap-trend--down' }}">
        {{ $evolutionVisites >= 0 ? '↑' : '↓' }} {{ abs($evolutionVisites) }}%
      </div>
    </div>
  </div>

  <div class="col-6 col-lg">
    <div class="recap-card">
      <div class="recap-card-ico" style="--c:var(--success)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div class="recap-num">{{ number_format($recap['visites_auj']) }}</div>
      <div class="recap-label">Visites aujourd'hui</div>
      <div class="recap-sub">{{ $recap['visites_semaine'] }} cette semaine</div>
    </div>
  </div>

  <div class="col-6 col-lg">
    <div class="recap-card">
      <div class="recap-card-ico" style="--c:var(--info)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
        </svg>
      </div>
      <div class="recap-num">{{ $recap['projets_publie'] }}</div>
      <div class="recap-label">Projets publiés</div>
      <div class="recap-sub">{{ number_format($recap['total_vues']) }} vues cumulées</div>
    </div>
  </div>

  <div class="col-6 col-lg">
    <div class="recap-card {{ $messagesStats['non_lus'] > 0 ? 'recap-card--alert' : '' }}">
      <div class="recap-card-ico" style="--c:var(--warning)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>
      <div class="recap-num">{{ $messagesStats['total'] }}</div>
      <div class="recap-label">Messages reçus</div>
      <div class="recap-sub">
        @if($messagesStats['non_lus'] > 0)
          <span style="color:var(--info)">{{ $messagesStats['non_lus'] }} non lu{{ $messagesStats['non_lus'] > 1 ? 's' : '' }}</span>
        @else
          Tous lus ✓
        @endif
      </div>
    </div>
  </div>

  <div class="col-6 col-lg">
    <div class="recap-card">
      <div class="recap-card-ico" style="--c:var(--danger)">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>
        </svg>
      </div>
      <div class="recap-num">{{ number_format($recap['total_visites']) }}</div>
      <div class="recap-label">Visites totales</div>
      <div class="recap-sub">Depuis le lancement</div>
    </div>
  </div>

</div>

{{-- ══ GRAPHIQUE VISITES + APPAREILS ══ --}}
<div class="row g-4 mb-4">

  {{-- Visites / jour --}}
  <div class="col-lg-8">
    <div class="stat-card">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Évolution des visites</div>
          <div class="stat-card-sub">Sur les {{ $periode }} derniers jours</div>
        </div>
        <div class="stat-chart-badge">
          {{ $visitesParJour->sum('count') }} visites
        </div>
      </div>
      <canvas id="chartVisites" height="85"></canvas>
    </div>
  </div>

  {{-- Donut appareils --}}
  <div class="col-lg-4">
    <div class="stat-card h-100">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Appareils</div>
          <div class="stat-card-sub">Période sélectionnée</div>
        </div>
      </div>

      @php $totalApp = array_sum($appareils); @endphp

      <div class="donut-wrap">
        <canvas id="chartAppareils"></canvas>
        <div class="donut-center">
          <div class="donut-num">{{ $totalApp }}</div>
          <div class="donut-lbl">Visites</div>
        </div>
      </div>

      <div class="donut-legend">
        @foreach(['desktop' => ['<i class="bi bi-display-fill"></i>', '#ff7c08'], 'mobile' => ['<i class="bi bi-phone-fill"></i>', '#3b82f6'], 'tablette' => ['<i class="bi bi-tablet-fill"></i>', '#10b981']] as $key => [$ico, $clr])
          <div class="donut-legend-row">
            <span class="donut-dot" style="background:{{ $clr }}"></span>
            <span>{{ ucfirst($key) }}</span>
            <span class="donut-val">{{ $appareils[$key] }}</span>
            <span class="donut-pct">
              {{ $totalApp > 0 ? round($appareils[$key] / $totalApp * 100) : 0 }}%
            </span>
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

{{-- ══ VISITES PAR HEURE + MESSAGES PAR MOIS ══ --}}
<div class="row g-4 mb-4">

  {{-- Visites par heure (aujourd'hui) --}}
  <div class="col-lg-6">
    <div class="stat-card">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Visites par heure</div>
          <div class="stat-card-sub">Aujourd'hui — {{ now()->translatedFormat('d F Y') }}</div>
        </div>
        <span class="stat-live-badge">
          <span class="stat-live-dot"></span>Live
        </span>
      </div>
      <canvas id="chartHeures" height="110"></canvas>
    </div>
  </div>

  {{-- Messages par mois --}}
  <div class="col-lg-6">
    <div class="stat-card">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Messages reçus</div>
          <div class="stat-card-sub">6 derniers mois</div>
        </div>
        <a href="#" class="stat-card-link">Voir tout →</a>
      </div>
      <canvas id="chartMessages" height="110"></canvas>
    </div>
  </div>

</div>

{{-- ══ TOP PROJETS + TOP PAGES ══ --}}
<div class="row g-4 mb-4">

  {{-- Top projets par vues --}}
  <div class="col-lg-6">
    <div class="stat-card">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Top projets</div>
          <div class="stat-card-sub">Classés par nombre de vues</div>
        </div>
        <a href="{{ route('projets.index') }}" class="stat-card-link">Gérer →</a>
      </div>

      @forelse($topProjets as $i => $proj)
        <div class="top-row">
          <div class="top-rank">{{ $i + 1 }}</div>
          <div class="top-thumb">
            @if($proj->image)
              <img src="{{ asset('storage/' . $proj->image) }}" alt="{{ $proj->titre }}">
            @else
              <i class="bi bi-rocket-takeoff-fill" style="color:rgba(255,255,255,.4)"></i>
            @endif
          </div>
          <div class="top-info">
            <div class="top-titre">{{ $proj->titre }}</div>
            @if($proj->date_fin)
              <div class="top-meta">{{ $proj->date_fin->format('M Y') }}</div>
            @endif
          </div>
          <div class="top-vues-wrap">
            <div class="top-vues-num">{{ number_format($proj->vues) }}</div>
            <div class="top-bar-bg">
              <div class="top-bar-fill"
                style="width:{{ $maxVues > 0 ? round($proj->vues / $maxVues * 100) : 0 }}%"></div>
            </div>
          </div>
        </div>
      @empty
        <div class="stat-empty">
          <div class="stat-empty-ico"><i class="bi bi-bar-chart-fill"></i></div>
          <p>Aucun projet publié.</p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- Top pages --}}
  <div class="col-lg-6">
    <div class="stat-card">
      <div class="stat-card-head">
        <div>
          <div class="stat-card-title">Pages les plus visitées</div>
          <div class="stat-card-sub">{{ $periode }} derniers jours</div>
        </div>
      </div>

      @forelse($topPages as $i => $page)
        @php $pct = $topPages->max('total') > 0 ? round($page->total / $topPages->max('total') * 100) : 0; @endphp
        <div class="top-row">
          <div class="top-rank">{{ $i + 1 }}</div>
          <div class="top-info">
            <div class="top-titre top-titre--mono">{{ Str::limit($page->page, 38) }}</div>
          </div>
          <div class="top-vues-wrap">
            <div class="top-vues-num">{{ number_format($page->total) }}</div>
            <div class="top-bar-bg">
              <div class="top-bar-fill" style="width:{{ $pct }}%;background:var(--info)"></div>
            </div>
          </div>
        </div>
      @empty
        <div class="stat-empty">
          <div class="stat-empty-ico"><i class="bi bi-file-earmark"></i></div>
          <p>Aucune visite enregistrée sur cette période.</p>
        </div>
      @endforelse
    </div>
  </div>

</div>

{{-- ══ RÉSUMÉ MESSAGES ══ --}}
<div class="row g-3">
  @foreach([
    ['icon' => '<i class="bi bi-envelope-fill"></i>',        'num' => $messagesStats['total'],      'label' => 'Total messages',        'c' => 'var(--primary)'],
    ['icon' => '<i class="bi bi-envelope-open-fill"></i>',  'num' => $messagesStats['non_lus'],    'label' => 'Non lus',               'c' => 'var(--info)'],
    ['icon' => '<i class="bi bi-check-circle-fill"></i>',   'num' => $messagesStats['repondus'],   'label' => 'Répondus',              'c' => 'var(--success)'],
    ['icon' => '<i class="bi bi-star-fill"></i>',           'num' => $messagesStats['importants'], 'label' => 'Importants',            'c' => 'var(--warning)'],
    ['icon' => '<i class="bi bi-calendar3"></i>',           'num' => $messagesStats['ce_mois'],   'label' => 'Ce mois-ci',            'c' => 'var(--danger)'],
  ] as $item)
  <div class="col-6 col-lg">
    <div class="msg-recap-card">
      <div class="msg-recap-ico" style="color:{{ $item['c'] }}">{!! $item['icon'] !!}</div>
      <div class="msg-recap-num" style="color:{{ $item['c'] }}">{{ $item['num'] }}</div>
      <div class="msg-recap-label">{{ $item['label'] }}</div>
    </div>
  </div>
  @endforeach
</div>
</main>
@endsection

<style>
/* ── Page header ── */
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}

/* ── Période tabs ── */
.periode-tabs{display:flex;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:4px;gap:3px;box-shadow:var(--shadow)}
.periode-tab{display:inline-flex;align-items:center;padding:7px 16px;border-radius:9px;font-family:var(--font-display);font-size:.78rem;font-weight:700;color:var(--muted);text-decoration:none;transition:all var(--transition)}
.periode-tab:hover{background:var(--gray-bg);color:var(--text)}
.periode-tab--active{background:var(--dark);color:#fff;box-shadow:0 2px 6px rgba(0,0,0,.1)}

/* ── Recap cards ── */
.recap-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px 16px;box-shadow:var(--shadow);position:relative;overflow:hidden;transition:transform var(--transition),box-shadow var(--transition)}
.recap-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.recap-card--alert{border-color:rgba(59,130,246,.25)}
.recap-card-ico{width:40px;height:40px;border-radius:10px;box-shadow:inset 0 0 0 40px color-mix(in srgb,var(--c) 12%,transparent);color:var(--c);display:flex;align-items:center;justify-content:center;margin-bottom:12px}
.recap-num{font-family:var(--font-display);font-size:1.8rem;font-weight:800;color:var(--dark);line-height:1;margin-bottom:3px}
.recap-label{font-size:.76rem;font-weight:600;color:var(--text);margin-bottom:5px}
.recap-sub{font-size:.72rem;color:var(--muted)}
.recap-trend{display:inline-flex;align-items:center;font-family:var(--font-display);font-size:.72rem;font-weight:800;padding:2px 7px;border-radius:99px}
.recap-trend--up{background:rgba(16,185,129,.1);color:var(--success)}
.recap-trend--down{background:rgba(239,68,68,.1);color:var(--danger)}

/* ── Stat cards (graphiques) ── */
.stat-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:22px;box-shadow:var(--shadow)}
.stat-card-head{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;gap:12px}
.stat-card-title{font-family:var(--font-display);font-size:.92rem;font-weight:800;color:var(--dark)}
.stat-card-sub{font-size:.74rem;color:var(--muted);margin-top:2px}
.stat-card-link{font-size:.76rem;font-weight:700;color:var(--primary);text-decoration:none;font-family:var(--font-display);white-space:nowrap;transition:color var(--transition)}
.stat-card-link:hover{color:var(--primary-dark)}
.stat-chart-badge{background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-size:.74rem;font-weight:700;padding:4px 12px;border-radius:99px;border:1px solid rgba(255,124,8,.2);white-space:nowrap}

/* Live badge */
.stat-live-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(16,185,129,.1);color:var(--success);font-family:var(--font-display);font-size:.72rem;font-weight:700;padding:4px 10px;border-radius:99px}
.stat-live-dot{width:6px;height:6px;border-radius:50%;background:var(--success);animation:livePulse 1.5s infinite}
@keyframes livePulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(1.4)}}

/* ── Donut ── */
.donut-wrap{position:relative;width:150px;height:150px;margin:0 auto 16px}
.donut-center{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none}
.donut-num{font-family:var(--font-display);font-size:1.4rem;font-weight:800;color:var(--dark);line-height:1}
.donut-lbl{font-size:.7rem;color:var(--muted)}
.donut-legend{display:flex;flex-direction:column;gap:8px}
.donut-legend-row{display:flex;align-items:center;gap:8px;font-size:.8rem;color:var(--text)}
.donut-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
.donut-val{margin-left:auto;font-family:var(--font-display);font-weight:700;color:var(--dark);font-size:.82rem}
.donut-pct{font-size:.72rem;color:var(--muted);min-width:32px;text-align:right}

/* ── Top rows ── */
.top-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--border)}
.top-row:last-child{border-bottom:none;padding-bottom:0}
.top-rank{font-family:var(--font-display);font-weight:800;font-size:.78rem;color:var(--muted);width:18px;text-align:center;flex-shrink:0}
.top-thumb{width:34px;height:34px;border-radius:8px;overflow:hidden;background:linear-gradient(135deg,var(--dark-3),var(--dark));display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0}
.top-thumb img{width:100%;height:100%;object-fit:cover}
.top-info{flex:1;min-width:0}
.top-titre{font-size:.83rem;font-weight:600;color:var(--dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.top-titre--mono{font-family:'Courier New',monospace;font-size:.76rem;font-weight:500;color:var(--text)}
.top-meta{font-size:.71rem;color:var(--muted);margin-top:1px}
.top-vues-wrap{display:flex;flex-direction:column;align-items:flex-end;gap:5px;flex-shrink:0;min-width:80px}
.top-vues-num{font-family:var(--font-display);font-size:.8rem;font-weight:800;color:var(--dark)}
.top-bar-bg{width:80px;height:4px;background:var(--border);border-radius:99px;overflow:hidden}
.top-bar-fill{height:100%;background:linear-gradient(90deg,var(--primary),#ffb347);border-radius:99px;transition:width 1s ease}

/* ── Stat empty ── */
.stat-empty{text-align:center;padding:32px 16px}
.stat-empty-ico{font-size:2rem;margin-bottom:8px;opacity:.35}
.stat-empty p{font-size:.84rem;color:var(--muted);margin:0}

/* ── Message recap ── */
.msg-recap-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:18px;text-align:center;box-shadow:var(--shadow);transition:transform var(--transition),box-shadow var(--transition)}
.msg-recap-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md)}
.msg-recap-ico{font-size:1.6rem;margin-bottom:8px}
.msg-recap-num{font-family:var(--font-display);font-size:1.6rem;font-weight:800;line-height:1;margin-bottom:4px}
.msg-recap-label{font-size:.74rem;color:var(--muted);font-weight:500}

@media(max-width:768px){
  .periode-tabs{flex-wrap:wrap}
  .top-vues-wrap{min-width:60px}
  .top-bar-bg{width:60px}
}
</style>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
/* ── Données PHP → JS ── */
const visitesData   = @json($visitesParJour);
const appareilsData = @json($appareils);
const heuresData    = @json($visitesParHeure);
const messagesData  = @json($messagesParMois);

/* ── Options tooltip globales ── */
const tooltipDefaults = {
  backgroundColor: '#231f40',
  titleColor: '#fff',
  bodyColor: 'rgba(255,255,255,.7)',
  padding: 12,
  cornerRadius: 10,
  borderColor: 'rgba(255,255,255,.06)',
  borderWidth: 1,
};

/* ── 1. Visites par jour ── */
new Chart(document.getElementById('chartVisites'), {
  type: 'line',
  data: {
    labels: visitesData.map(v => v.date),
    datasets: [{
      label: 'Visites',
      data: visitesData.map(v => v.count),
      borderColor: '#ff7c08',
      backgroundColor: ctx => {
        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 220);
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
    plugins: {
      legend: { display: false },
      tooltip: { ...tooltipDefaults, callbacks: { label: c => ` ${c.parsed.y} visite${c.parsed.y > 1 ? 's' : ''}` } }
    },
    scales: {
      x: { grid: { display: false }, ticks: { font: { family: 'DM Sans', size: 10 }, color: '#9ca3af', maxTicksLimit: 12 }, border: { display: false } },
      y: { beginAtZero: true, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9ca3af', stepSize: 1, callback: v => Number.isInteger(v) ? v : null }, grid: { color: '#f3f4f6' }, border: { display: false } }
    }
  }
});

/* ── 2. Appareils donut ── */
new Chart(document.getElementById('chartAppareils'), {
  type: 'doughnut',
  data: {
    labels: ['Desktop', 'Mobile', 'Tablette'],
    datasets: [{
      data: [appareilsData.desktop, appareilsData.mobile, appareilsData.tablette],
      backgroundColor: ['#ff7c08', '#3b82f6', '#10b981'],
      borderColor: '#fff',
      borderWidth: 3,
      hoverOffset: 6,
    }]
  },
  options: {
    responsive: true,
    cutout: '70%',
    plugins: {
      legend: { display: false },
      tooltip: {
        ...tooltipDefaults,
        callbacks: {
          label: ctx => {
            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
            const pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
            return ` ${ctx.parsed} (${pct}%)`;
          }
        }
      }
    }
  }
});

/* ── 3. Visites par heure (barres) ── */
new Chart(document.getElementById('chartHeures'), {
  type: 'bar',
  data: {
    labels: heuresData.map(h => h.heure),
    datasets: [{
      label: 'Visites',
      data: heuresData.map(h => h.count),
      backgroundColor: ctx => {
        const max = Math.max(...heuresData.map(h => h.count));
        const val = ctx.dataset.data[ctx.dataIndex];
        return val === max && max > 0 ? '#ff7c08' : 'rgba(255,124,8,.25)';
      },
      borderRadius: 5,
      borderSkipped: false,
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { ...tooltipDefaults, callbacks: { label: c => ` ${c.parsed.y} visite${c.parsed.y > 1 ? 's' : ''}` } }
    },
    scales: {
      x: { grid: { display: false }, ticks: { font: { family: 'DM Sans', size: 9 }, color: '#9ca3af', maxTicksLimit: 12 }, border: { display: false } },
      y: { beginAtZero: true, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9ca3af', stepSize: 1, callback: v => Number.isInteger(v) ? v : null }, grid: { color: '#f3f4f6' }, border: { display: false } }
    }
  }
});

/* ── 4. Messages par mois (barres) ── */
new Chart(document.getElementById('chartMessages'), {
  type: 'bar',
  data: {
    labels: messagesData.map(m => m.label),
    datasets: [{
      label: 'Messages',
      data: messagesData.map(m => m.count),
      backgroundColor: ctx => {
        const max = Math.max(...messagesData.map(m => m.count));
        const val = ctx.dataset.data[ctx.dataIndex];
        return val === max && max > 0 ? '#3b82f6' : 'rgba(59,130,246,.25)';
      },
      borderRadius: 5,
      borderSkipped: false,
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: { ...tooltipDefaults, callbacks: { label: c => ` ${c.parsed.y} message${c.parsed.y > 1 ? 's' : ''}` } }
    },
    scales: {
      x: { grid: { display: false }, ticks: { font: { family: 'DM Sans', size: 10 }, color: '#9ca3af' }, border: { display: false } },
      y: { beginAtZero: true, ticks: { font: { family: 'DM Sans', size: 11 }, color: '#9ca3af', stepSize: 1, callback: v => Number.isInteger(v) ? v : null }, grid: { color: '#f3f4f6' }, border: { display: false } }
    }
  }
});

/* ── Animer les barres top projets ── */
document.querySelectorAll('.top-bar-fill').forEach(bar => {
  const w = bar.style.width;
  bar.style.width = '0%';
  setTimeout(() => { bar.style.width = w; }, 300);
});
</script>
@endpush