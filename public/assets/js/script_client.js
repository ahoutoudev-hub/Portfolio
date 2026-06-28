/* ══════════════════════════════════════════════
   THÈME SOMBRE
══════════════════════════════════════════════ */
const themeBtn = document.getElementById('themeToggle');
let dark = localStorage.getItem('theme') === 'dark';

function applyTheme() {
  document.documentElement.setAttribute('data-theme', dark ? 'dark' : 'light');
  if (themeBtn) {
    const moon = themeBtn.querySelector('.icon-moon');
    const sun  = themeBtn.querySelector('.icon-sun');
    if (moon) moon.style.display = dark ? 'none' : '';
    if (sun)  sun.style.display  = dark ? ''     : 'none';
    themeBtn.setAttribute('aria-label', dark ? 'Passer en mode clair' : 'Passer en mode sombre');
  }
}
applyTheme();

if (themeBtn) {
  themeBtn.addEventListener('click', () => {
    dark = !dark;
    localStorage.setItem('theme', dark ? 'dark' : 'light');
    applyTheme();
  });
}

/* ══════════════════════════════════════════════
   NAVBAR — scroll · masquage · burger · progression
══════════════════════════════════════════════ */
const navbar      = document.getElementById('navbar');
const burger      = document.getElementById('burger');
const navLinks    = document.getElementById('navLinks');
const navOverlay  = document.getElementById('navOverlay');
const navProgress = document.getElementById('nav-progress');

let lastScrollY = 0;
let rafPending  = false;

function onScroll() {
  const sy    = window.scrollY;
  const total = document.documentElement.scrollHeight - window.innerHeight;

  if (navProgress && total > 0) {
    const pct = Math.min(100, (sy / total) * 100);
    navProgress.style.width = pct + '%';
    navProgress.setAttribute('aria-valuenow', Math.round(pct));
  }

  if (navbar) {
    navbar.classList.toggle('scrolled', sy > 40);
  }

  lastScrollY = sy <= 0 ? 0 : sy;
  rafPending  = false;
}

window.addEventListener('scroll', () => {
  if (!rafPending) { rafPending = true; requestAnimationFrame(onScroll); }
}, { passive: true });

/* ── Menu mobile ── */
function openMenu() {
  if (!navLinks || !burger) return;
  navLinks.classList.add('open');
  burger.classList.add('open');
  burger.setAttribute('aria-expanded', 'true');
  burger.setAttribute('aria-label', 'Fermer le menu');
  if (navOverlay) { navOverlay.classList.add('visible'); navOverlay.removeAttribute('aria-hidden'); }
  document.body.style.overflow = 'hidden';
}

function closeMenu() {
  if (!navLinks || !burger) return;
  navLinks.classList.remove('open');
  burger.classList.remove('open');
  burger.setAttribute('aria-expanded', 'false');
  burger.setAttribute('aria-label', 'Ouvrir le menu');
  if (navOverlay) { navOverlay.classList.remove('visible'); navOverlay.setAttribute('aria-hidden', 'true'); }
  document.body.style.overflow = '';
}

if (burger) {
  burger.addEventListener('click', () =>
    navLinks?.classList.contains('open') ? closeMenu() : openMenu()
  );
}
if (navOverlay) navOverlay.addEventListener('click', closeMenu);
if (navLinks)   navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', closeMenu));
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });

/* ══════════════════════════════════════════════
   REVEAL AU SCROLL
══════════════════════════════════════════════ */
document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale, .reveal-blur').forEach(el => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      e.target.querySelectorAll('.skill-fill').forEach(bar => {
        bar.style.width = (bar.dataset.w || 0) + '%';
      });
    }
  }, { threshold: 0.08 }).observe(el);
});

/* ══════════════════════════════════════════════
   BARRES DE COMPÉTENCES
══════════════════════════════════════════════ */
document.querySelectorAll('.skills-category').forEach(sec => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) {
      sec.querySelectorAll('.skill-fill').forEach(b => {
        setTimeout(() => { b.style.width = (b.dataset.w || 0) + '%'; }, 200);
      });
    }
  }, { threshold: 0.2 }).observe(sec);
});

/* ══════════════════════════════════════════════
   COMPTEURS (lit data-target depuis le HTML)
══════════════════════════════════════════════ */
function countUp(el, target) {
  if (!el || !target) return;
  const dur = 1800, start = performance.now();
  const step = now => {
    const p = Math.min((now - start) / dur, 1);
    el.textContent = Math.round((1 - Math.pow(1 - p, 3)) * target);
    if (p < 1) requestAnimationFrame(step);
    else el.textContent = target;
  };
  requestAnimationFrame(step);
}

function startCounters() {
  ['s1','s2','s3','s4','h1','h2','h3'].forEach(id => {
    const el = document.getElementById(id);
    if (el) countUp(el, parseInt(el.dataset.target || 0));
  });
}

const statsSection = document.getElementById('stats');
if (statsSection) {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) startCounters();
  }, { threshold: 0.3 }).observe(statsSection);
}

// Hero counters dès le chargement
setTimeout(() => {
  ['h1','h2','h3'].forEach(id => {
    const el = document.getElementById(id);
    if (el) countUp(el, parseInt(el.dataset.target || 0));
  });
}, 600);

/* ══════════════════════════════════════════════
   TABS EXPÉRIENCES
══════════════════════════════════════════════ */
function switchExp(panel, btn) {
  document.querySelectorAll('.exp-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.exp-tab').forEach(b => b.classList.remove('active'));
  const target = document.getElementById('panel-' + panel);
  if (target) target.classList.add('active');
  if (btn)    btn.classList.add('active');
}

/* ══════════════════════════════════════════════
   FILTRES PROJETS
══════════════════════════════════════════════ */
function filterProjects(filter, btn) {
  document.querySelectorAll('.filter-pill').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');

  const cards = document.querySelectorAll('.project-card');
  let visible = 0;

  cards.forEach(card => {
    const tags = card.dataset.tags || '';
    const show = filter === 'all' || tags.split(' ').includes(filter);
    if (show) {
      card.style.display = '';
      card.style.animation = 'scaleIn .35s cubic-bezier(.34,1.56,.64,1) both';
    } else {
      card.style.display = 'none';
      card.style.animation = '';
    }
    if (show) visible++;
  });

  const count = document.getElementById('visibleCount');
  if (count) count.textContent = visible;

  const empty = document.getElementById('emptyState');
  if (empty) empty.style.display = visible === 0 ? 'block' : 'none';
}

/* ══════════════════════════════════════════════
   AUTO-STAGGER — grilles de cartes
══════════════════════════════════════════════ */
(function setStagger() {
  const grids = [
    '.services-grid',
    '.projects-grid',
    '.temo-grid',
    '.about-cards',
    '.contact-items',
    '.stats-grid',
    '.stack-grid',
    '.cert-grid',
    '.exp-list',
  ];
  grids.forEach(sel => {
    document.querySelectorAll(sel).forEach(grid => {
      const children = grid.querySelectorAll(':scope > *');
      children.forEach((child, i) => child.style.setProperty('--i', i));
    });
  });
})();

/* ══════════════════════════════════════════════
   TIMELINE — stagger au scroll
══════════════════════════════════════════════ */
document.querySelectorAll('.timeline').forEach(tl => {
  const items = tl.querySelectorAll('.tl-item');
  items.forEach((item, i) => item.style.setProperty('--i', i));
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) {
      items.forEach(item => item.classList.add('tl-visible'));
    }
  }, { threshold: 0.1 }).observe(tl);
});

/* ══════════════════════════════════════════════
   RIPPLE — effet vague sur les boutons
══════════════════════════════════════════════ */
document.addEventListener('click', e => {
  const btn = e.target.closest(
    '.btn-primary,.btn-outline,.btn-sm,.btn-submit,.btn-nav,.btn-nav-outline,.filter-pill,.exp-tab'
  );
  if (!btn) return;
  const r = Math.max(btn.clientWidth, btn.clientHeight);
  const ripple = document.createElement('span');
  ripple.className = 'ripple';
  ripple.style.cssText = `--rw:${r}px;top:${e.clientY - btn.getBoundingClientRect().top}px;left:${e.clientX - btn.getBoundingClientRect().left}px`;
  btn.appendChild(ripple);
  ripple.addEventListener('animationend', () => ripple.remove());
});

/* ══════════════════════════════════════════════
   TILT 3D — cards au survol
══════════════════════════════════════════════ */
document.querySelectorAll('.project-card, .temo-card').forEach(card => {
  card.addEventListener('mousemove', e => {
    const r = card.getBoundingClientRect();
    const x = (e.clientX - r.left) / r.width  - .5;
    const y = (e.clientY - r.top)  / r.height - .5;
    card.style.transform = `perspective(600px) rotateY(${x * 8}deg) rotateX(${-y * 8}deg) translateY(-4px)`;
  });
  card.addEventListener('mouseleave', () => {
    card.style.transform = '';
  });
});

/* ══════════════════════════════════════════════
   PARTICULES HERO
══════════════════════════════════════════════ */
(function injectParticles() {
  const hero = document.querySelector('.hero');
  if (!hero) return;
  const COUNT = 12;
  for (let i = 0; i < COUNT; i++) {
    const p = document.createElement('span');
    p.className = 'hero-particle';
    const size = Math.random() * 5 + 3;
    const x = Math.random() * 100;
    const y = Math.random() * 100;
    const dur  = (Math.random() * 6 + 5).toFixed(1);
    const delay= (Math.random() * 5).toFixed(1);
    const dx   = ((Math.random() - .5) * 80).toFixed(0);
    const dy   = (-(Math.random() * 60 + 30)).toFixed(0);
    const op   = (Math.random() * .12 + .06).toFixed(2);
    p.style.cssText = `
      width:${size}px;height:${size}px;
      left:${x}%;top:${y}%;
      --dur:${dur}s;--delay:${delay}s;
      --dx:${dx}px;--dy:${dy}px;--op:${op};
    `;
    hero.appendChild(p);
  }
})();

/* ══════════════════════════════════════════════
   TYPING EFFECT — hero-title
══════════════════════════════════════════════ */
(function typingEffect() {
  const el = document.querySelector('.hero-title');
  if (!el) return;

  const fullText = el.textContent.trim();
  el.textContent = '';

  const cursor = document.createElement('span');
  cursor.className = 'typing-cursor';
  el.appendChild(cursor);

  let i = 0;
  const speed = 55; // ms par caractère

  function type() {
    if (i < fullText.length) {
      el.insertBefore(document.createTextNode(fullText[i]), cursor);
      i++;
      setTimeout(type, speed);
    }
  }

  // Démarre après 0.8s (le temps que le hero soit visible)
  setTimeout(type, 800);
})();

/* ══════════════════════════════════════════════
   INDICATEUR DE SCROLL dans le hero
══════════════════════════════════════════════ */
(function scrollHint() {
  const hero = document.querySelector('.hero');
  if (!hero) return;
  const hint = document.createElement('div');
  hint.className = 'hero-scroll-hint';
  hint.setAttribute('aria-hidden', 'true');
  hint.innerHTML = '<div class="scroll-mouse"></div><span class="scroll-label">Défiler</span>';
  hint.addEventListener('click', () => {
    const about = document.getElementById('about') || document.querySelector('.section');
    if (about) about.scrollIntoView({ behavior:'smooth' });
  });
  hero.appendChild(hint);

  const hide = () => {
    if (window.scrollY > 80) hint.style.opacity = '0';
    else hint.style.opacity = '';
  };
  window.addEventListener('scroll', hide, { passive:true });
})();

/* ══════════════════════════════════════════════
   SECTION LABELS — révélation au scroll
══════════════════════════════════════════════ */
document.querySelectorAll('.section-label').forEach(el => {
  new IntersectionObserver(([e]) => {
    if (e.isIntersecting) el.classList.add('visible');
  }, { threshold:.5 }).observe(el);
});

/* ══════════════════════════════════════════════
   CONTACT ITEMS — stagger (reveal défini en HTML)
══════════════════════════════════════════════ */
document.querySelectorAll('.contact-items .contact-item').forEach((item, i) => {
  item.style.setProperty('--i', i);
});

/* ══════════════════════════════════════════════
   LOADER initial — retrait après fade-out
══════════════════════════════════════════════ */
(function removeLoader() {
  const loader = document.getElementById('page-loader');
  if (!loader) return;
  loader.addEventListener('animationend', e => {
    if (e.target === loader) loader.remove();
  });
})();

/* ══════════════════════════════════════════════
   WELCOME MODAL + CONFETTI
══════════════════════════════════════════════ */
(function welcomeModal() {
  const modal   = document.getElementById('welcomeModal');
  if (!modal) return;

  if (sessionStorage.getItem('wlc_shown')) { modal.remove(); return; }
  sessionStorage.setItem('wlc_shown', '1');

  /* ── Confetti ── */
  const canvas = document.getElementById('confettiCanvas');
  const ctx    = canvas.getContext('2d');
  let W, H, particles = [], raf;

  const COLORS = ['#ff7c08','#6c63ff','#25d366','#ff6b9d','#ffd700','#00c2ff','#f43f5e','#a78bfa'];
  const SHAPES = ['circle','rect','triangle'];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  function createParticle() {
    return {
      x:     Math.random() * W,
      y:     Math.random() * H - H,
      r:     Math.random() * 7 + 3,
      color: COLORS[Math.floor(Math.random() * COLORS.length)],
      shape: SHAPES[Math.floor(Math.random() * SHAPES.length)],
      vy:    Math.random() * 2.5 + 1.2,
      vx:    (Math.random() - .5) * 1.8,
      angle: Math.random() * 360,
      spin:  (Math.random() - .5) * 6,
      alpha: 1
    };
  }

  function drawParticle(p) {
    ctx.save();
    ctx.globalAlpha = p.alpha;
    ctx.fillStyle   = p.color;
    ctx.translate(p.x, p.y);
    ctx.rotate(p.angle * Math.PI / 180);
    if (p.shape === 'circle') {
      ctx.beginPath(); ctx.arc(0, 0, p.r, 0, Math.PI * 2); ctx.fill();
    } else if (p.shape === 'rect') {
      ctx.fillRect(-p.r, -p.r * .5, p.r * 2, p.r);
    } else {
      ctx.beginPath();
      ctx.moveTo(0, -p.r); ctx.lineTo(p.r, p.r); ctx.lineTo(-p.r, p.r);
      ctx.closePath(); ctx.fill();
    }
    ctx.restore();
  }

  function loop() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach((p, i) => {
      p.y     += p.vy;
      p.x     += p.vx;
      p.angle += p.spin;
      if (p.y > H * .85) p.alpha -= .02;
      drawParticle(p);
      if (p.alpha <= 0 || p.y > H + 20) particles[i] = createParticle();
    });
    raf = requestAnimationFrame(loop);
  }

  resize();
  window.addEventListener('resize', resize, { passive:true });
  for (let i = 0; i < 130; i++) {
    const p = createParticle();
    p.y = Math.random() * H;
    particles.push(p);
  }
  loop();

  /* ── Fermeture ── */
  function closeModal() {
    modal.classList.add('wlc-hide');
    cancelAnimationFrame(raf);
    setTimeout(() => modal.remove(), 380);
  }

  document.getElementById('wlcClose').addEventListener('click', closeModal);
  document.getElementById('wlcContact').addEventListener('click', closeModal);
  modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
})();