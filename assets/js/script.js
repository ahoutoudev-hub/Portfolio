/**
 * PORTFOLIO ADMIN DASHBOARD — assets/js/script.js
 * Bootstrap 5 · Frontend template only · No backend logic
 * ============================================================
 * Sections :
 *   1. Sidebar toggle (mobile)
 *   2. Topbar scroll shadow
 *   3. Toast notifications
 *   4. Progress bars animation (IntersectionObserver)
 *   5. Image upload preview
 *   6. Confirm delete helper
 *   7. Form validation helpers
 *   8. Generic table search/filter
 *   9. Skill level range preview
 *  10. Password strength meter
 *  11. Chart.js initializers
 *  12. Counters animation
 */

(function () {
  'use strict';

  /* ─────────────────────────────────────────
     1. SIDEBAR TOGGLE (mobile)
  ───────────────────────────────────────── */
  const sidebar        = document.querySelector('.sidebar');
  const sidebarToggle  = document.querySelector('.sidebar-toggle');
  const sidebarOverlay = document.getElementById('sidebarOverlay');

  if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      if (sidebarOverlay) sidebarOverlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
    });
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener('click', () => {
      sidebar?.classList.remove('open');
      sidebarOverlay.style.display = 'none';
    });
  }

  /* ─────────────────────────────────────────
     2. TOPBAR SHADOW ON SCROLL
  ───────────────────────────────────────── */
  const topbar = document.querySelector('.topbar');
  if (topbar) {
    window.addEventListener('scroll', () => {
      topbar.style.boxShadow = window.scrollY > 10
        ? '0 4px 16px rgba(0,0,0,.1)'
        : '0 1px 3px rgba(0,0,0,.08)';
    }, { passive: true });
  }

  /* ─────────────────────────────────────────
     3. TOAST NOTIFICATIONS
  ───────────────────────────────────────── */
  window.showToast = function (msg, type = 'info') {
    const icons = {
      success: '<i class="bi bi-check-circle-fill"></i>',
      error:   '<i class="bi bi-x-circle-fill"></i>',
      info:    '<i class="bi bi-info-circle-fill"></i>',
      warn:    '<i class="bi bi-exclamation-triangle-fill"></i>'
    };

    let container = document.querySelector('.toast-container-custom');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container-custom';
      document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast-item ${type}`;
    toast.innerHTML = `<span>${icons[type] || '<i class="bi bi-info-circle-fill"></i>'}</span><span>${msg}</span>`;
    container.appendChild(toast);

    setTimeout(() => {
      toast.classList.add('toast-out');
      setTimeout(() => toast.remove(), 300);
    }, 3500);
  };

  /* ─────────────────────────────────────────
     4. PROGRESS BARS ANIMATION
  ───────────────────────────────────────── */
  function animateBars(container) {
    container.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
      bar.style.width = bar.dataset.width + '%';
    });
  }

  const progressContainers = document.querySelectorAll('.skill-card, .skills-section');

  if ('IntersectionObserver' in window && progressContainers.length) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          animateBars(e.target);
          observer.unobserve(e.target);
        }
      });
    }, { threshold: 0.2 });

    progressContainers.forEach(c => observer.observe(c));
  } else {
    document.querySelectorAll('.progress-bar[data-width]').forEach(bar => {
      bar.style.width = bar.dataset.width + '%';
    });
  }

  /* ─────────────────────────────────────────
     5. IMAGE UPLOAD PREVIEW
  ───────────────────────────────────────── */
  document.querySelectorAll('[data-upload-input]').forEach(input => {
    const previewId = input.getAttribute('data-upload-input');
    const preview   = document.getElementById(previewId);
    if (!preview) return;

    input.addEventListener('change', () => {
      if (!input.files?.length) return;
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(input.files[0]);
    });
  });

  // Click-to-upload zone
  document.querySelectorAll('.upload-zone').forEach(zone => {
    const input = zone.querySelector('input[type="file"]');
    zone.addEventListener('click', e => {
      if (e.target !== input) input?.click();
    });
  });

  /* ─────────────────────────────────────────
     6. CONFIRM DELETE HELPER
  ───────────────────────────────────────── */
  window.confirmDelete = function (name, callback) {
    const modal = document.getElementById('confirmModal');
    if (!modal) { if (callback) callback(); return; }

    document.getElementById('confirmTargetName').textContent = name || 'cet élément';
    document.getElementById('confirmOkBtn').onclick = () => {
      bootstrap.Modal.getInstance(modal)?.hide();
      if (callback) callback();
    };
    new bootstrap.Modal(modal).show();
  };

  /* ─────────────────────────────────────────
     7. FORM VALIDATION HELPERS
  ───────────────────────────────────────── */
  window.validateForm = function (formEl) {
    let valid = true;
    formEl.querySelectorAll('[data-required]').forEach(input => {
      const err = formEl.querySelector(`[data-err="${input.name}"]`);
      if (!input.value.trim()) {
        input.classList.add('is-err');
        if (err) { err.textContent = 'Ce champ est requis.'; err.classList.add('show'); }
        valid = false;
      } else {
        input.classList.remove('is-err');
        if (err) err.classList.remove('show');
        // Email check
        if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
          input.classList.add('is-err');
          if (err) { err.textContent = 'Email invalide.'; err.classList.add('show'); }
          valid = false;
        }
      }
    });
    return valid;
  };

  // Live clear errors
  document.querySelectorAll('.form-inp[data-required]').forEach(input => {
    input.addEventListener('input', () => {
      input.classList.remove('is-err');
      const form = input.closest('form') || input.closest('[role="dialog"]');
      const err  = form?.querySelector(`[data-err="${input.name}"]`);
      if (err) err.classList.remove('show');
    });
  });

  /* ─────────────────────────────────────────
     8. TABLE SEARCH / FILTER
  ───────────────────────────────────────── */
  document.querySelectorAll('[data-table-search]').forEach(input => {
    const tableId = input.dataset.tableSearch;
    const table   = document.getElementById(tableId);
    if (!table) return;

    input.addEventListener('input', () => {
      const q = input.value.toLowerCase();
      table.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
      });
    });
  });

  /* ─────────────────────────────────────────
     9. SKILL LEVEL RANGE PREVIEW
  ───────────────────────────────────────── */
  const levelRange  = document.getElementById('skillLevel');
  const levelDisplay= document.getElementById('skillLevelDisplay');
  const levelBar    = document.getElementById('skillLevelBar');

  if (levelRange) {
    function updateLevel() {
      const v = levelRange.value;
      if (levelDisplay) levelDisplay.textContent = v + '%';
      if (levelBar)     levelBar.style.width = v + '%';
    }
    levelRange.addEventListener('input', updateLevel);
    updateLevel();
  }

  /* ─────────────────────────────────────────
     10. PASSWORD STRENGTH METER
  ───────────────────────────────────────── */
  const passInput   = document.getElementById('newPassword');
  const passBar     = document.getElementById('passStrengthBar');
  const passLabel   = document.getElementById('passStrengthLabel');

  if (passInput) {
    passInput.addEventListener('input', () => {
      const v = passInput.value;
      let score = 0;
      if (v.length >= 8)         score++;
      if (/[A-Z]/.test(v))       score++;
      if (/[0-9]/.test(v))       score++;
      if (/[^A-Za-z0-9]/.test(v))score++;

      const levels = [
        { w: '0%',   c: 'var(--danger)',  t: 'Entrez un mot de passe' },
        { w: '25%',  c: 'var(--danger)',  t: 'Très faible' },
        { w: '50%',  c: 'var(--warning)', t: 'Moyen' },
        { w: '75%',  c: 'var(--info)',    t: 'Fort' },
        { w: '100%', c: 'var(--success)', t: 'Très fort ✓' },
      ];
      const l = levels[score];
      if (passBar)   { passBar.style.width = l.w; passBar.style.background = l.c; }
      if (passLabel) { passLabel.textContent = l.t; passLabel.style.color = l.c; }
    });
  }

  /* ─────────────────────────────────────────
     11. CHART.JS INITIALIZERS
  ───────────────────────────────────────── */

  // ── Visitors Line Chart ──
  const visitorsCanvas = document.getElementById('visitorsChart');
  if (visitorsCanvas && typeof Chart !== 'undefined') {
    const ctx = visitorsCanvas.getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(255,124,8,.22)');
    grad.addColorStop(1, 'rgba(255,124,8,0)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan','Fév','Mar','Avr','Mai','Jun','Jul','Aoû','Sep','Oct','Nov','Déc'],
        datasets: [{
          label: 'Visiteurs',
          data: [320, 410, 480, 510, 690, 820, 780, 900, 950, 1010, 1080, 1250],
          fill: true,
          backgroundColor: grad,
          borderColor: '#ff7c08',
          borderWidth: 2.5,
          tension: 0.4,
          pointBackgroundColor: '#fff',
          pointBorderColor: '#ff7c08',
          pointBorderWidth: 2.5,
          pointRadius: 4,
          pointHoverRadius: 6,
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
            cornerRadius: 8,
            displayColors: false,
          }
        },
        scales: {
          x: {
            grid: { display: false },
            ticks: { color: '#9ca3af', font: { size: 11 } }
          },
          y: {
            grid: { color: 'rgba(0,0,0,.04)', drawBorder: false },
            ticks: { color: '#9ca3af', font: { size: 11 } }
          }
        }
      }
    });
  }

  // ── Technologies Doughnut Chart ──
  const techCanvas = document.getElementById('techChart');
  if (techCanvas && typeof Chart !== 'undefined') {
    new Chart(techCanvas.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Laravel', 'React', 'Flutter', 'MySQL', 'Autres'],
        datasets: [{
          data: [30, 25, 20, 15, 10],
          backgroundColor: ['#ff7c08', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'],
          borderColor: '#fff',
          borderWidth: 3,
          hoverOffset: 6,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '66%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              color: '#374151',
              padding: 14,
              font: { size: 12 },
              usePointStyle: true,
              pointStyleWidth: 10,
            }
          },
          tooltip: {
            backgroundColor: '#231f40',
            titleColor: '#fff',
            bodyColor: 'rgba(255,255,255,.7)',
            padding: 10,
            cornerRadius: 8,
          }
        }
      }
    });
  }

  // ── Projects by Year Bar Chart ──
  const yearCanvas = document.getElementById('yearChart');
  if (yearCanvas && typeof Chart !== 'undefined') {
    new Chart(yearCanvas.getContext('2d'), {
      type: 'bar',
      data: {
        labels: ['2020', '2021', '2022', '2023', '2024'],
        datasets: [{
          label: 'Projets',
          data: [3, 5, 8, 12, 7],
          backgroundColor: ['rgba(255,124,8,.8)', 'rgba(59,130,246,.8)', 'rgba(16,185,129,.8)', 'rgba(245,158,11,.8)', 'rgba(139,92,246,.8)'],
          borderRadius: 7,
          borderSkipped: false,
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
            padding: 10,
            cornerRadius: 8,
            displayColors: false,
          }
        },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#9ca3af', font: { size: 12 } } },
          y: {
            grid: { color: 'rgba(0,0,0,.04)', drawBorder: false },
            ticks: { color: '#9ca3af', font: { size: 11 }, stepSize: 2 }
          }
        }
      }
    });
  }

  // ── Monthly mini chart (dashboard widget) ──
  const miniCanvas = document.getElementById('miniVisitorsChart');
  if (miniCanvas && typeof Chart !== 'undefined') {
    const ctx2 = miniCanvas.getContext('2d');
    const grad2 = ctx2.createLinearGradient(0, 0, 0, 100);
    grad2.addColorStop(0, 'rgba(255,124,8,.18)');
    grad2.addColorStop(1, 'rgba(255,124,8,0)');
    new Chart(ctx2, {
      type: 'line',
      data: {
        labels: ['Jan','Fév','Mar','Avr','Mai','Jun'],
        datasets: [{
          data: [420, 580, 510, 680, 750, 920],
          fill: true,
          backgroundColor: grad2,
          borderColor: '#ff7c08',
          borderWidth: 2,
          tension: 0.4,
          pointRadius: 0,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { enabled: false } },
        scales: { x: { display: false }, y: { display: false } },
        animation: { duration: 1000 }
      }
    });
  }

  /* ─────────────────────────────────────────
     12. COUNTER ANIMATION
  ───────────────────────────────────────── */
  const counterEls = document.querySelectorAll('[data-counter]');
  if (counterEls.length) {
    const run = () => {
      counterEls.forEach(el => {
        const target = parseInt(el.dataset.counter, 10);
        const dur = 1600;
        const start = performance.now();
        const step = (now) => {
          const t = Math.min((now - start) / dur, 1);
          el.textContent = Math.round((1 - Math.pow(1 - t, 3)) * target);
          if (t < 1) requestAnimationFrame(step);
          else el.textContent = target;
        };
        requestAnimationFrame(step);
      });
    };

    if ('IntersectionObserver' in window) {
      const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) { run(); obs.disconnect(); }
      }, { threshold: 0.3 });
      obs.observe(counterEls[0].closest('section') || counterEls[0]);
    } else {
      run();
    }
  }

})();
