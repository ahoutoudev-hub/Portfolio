<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex,nofollow">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Portfolio AHOUTOU') | AHOUTOU</title>

  {{-- Bootstrap 5 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  {{-- SweetAlert2 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet">
  {{-- Custom CSS --}}
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  @stack('styles')
</head>
<body>

{{-- Overlay sidebar mobile --}}
<div id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="dash-wrapper">

  {{-- SIDEBAR --}}
  @include('layouts_admin.sidebar')

  {{-- MAIN AREA --}}
  <div class="main-area">

    {{-- TOPBAR --}}
    @include('layouts_admin.topbar')

    {{-- PAGE CONTENT --}}
    <div class="page-content" id="main-content">
      @yield('content')
    </div>

  </div>

</div>

{{-- Toast container --}}
<div class="toast-container-custom" id="toastContainer" aria-live="polite"></div>

{{-- Flash sessions → SweetAlert --}}
@if(session('sweet_error'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    SwalBase.fire({
      icon:              "{{ session('sweet_error.icon') }}",
      iconColor:         "{{ session('sweet_error.icon') === 'warning' ? '#f59e0b' : '#ef4444' }}",
      title:             "{{ session('sweet_error.title') }}",
      text:              "{{ session('sweet_error.message') }}",
      confirmButtonText: 'OK',
    });
  });
</script>
@endif

@if(session('toast_success'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    window.showToast("{{ session('toast_success') }}", 'success');
  });
</script>
@endif

@if(session('toast_error'))
<script>
  document.addEventListener('DOMContentLoaded', () => {
    window.showToast("{{ session('toast_error') }}", 'error');
  });
</script>
@endif

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<script>
/* ═══════════════════════════════════════════
   SWEETALERT BASE CONFIG
═══════════════════════════════════════════ */
const SwalBase = Swal.mixin({
  background:         '#2c2850',
  color:              '#ffffff',
  confirmButtonColor: '#ff7c08',
  customClass: { popup: 'swal-popup', confirmButton: 'swal-btn' }
});

/* ═══════════════════════════════════════════
   TOAST SYSTEM
═══════════════════════════════════════════ */
const _toastIcos = {
  success: '<i class="bi bi-check-circle-fill"></i>',
  error:   '<i class="bi bi-x-circle-fill"></i>',
  warning: '<i class="bi bi-exclamation-triangle-fill"></i>',
  info:    '<i class="bi bi-info-circle-fill"></i>'
};
const _toastColors = {
  success: '#10b981', error: '#ef4444', warning: '#f59e0b', info: '#3b82f6'
};

window.showToast = function(msg, type = 'success', duration = 4000) {
  const container = document.getElementById('toastContainer');
  const el = document.createElement('div');
  el.className = `toast-item toast-${type}`;
  el.innerHTML = `
    <span class="toast-ico">${_toastIcos[type]}</span>
    <span class="toast-msg">${msg}</span>
    <button class="toast-close" onclick="this.closest('.toast-item').remove()"><i class="bi bi-x"></i></button>
  `;
  container.appendChild(el);
  setTimeout(() => { el.classList.add('toast-out'); setTimeout(() => el.remove(), 320); }, duration);
};

/* ═══════════════════════════════════════════
   SIDEBAR MOBILE
═══════════════════════════════════════════ */
function openSidebar() {
  document.querySelector('.sidebar')?.classList.add('open');
  document.getElementById('sidebarOverlay').style.display = 'block';
  document.body.style.overflow = 'hidden';
}
function closeSidebar() {
  document.querySelector('.sidebar')?.classList.remove('open');
  document.getElementById('sidebarOverlay').style.display = 'none';
  document.body.style.overflow = '';
}

/* ═══════════════════════════════════════════
   CONFIRM DELETE — SweetAlert global
═══════════════════════════════════════════ */
window.confirmDelete = function(url, name) {
  SwalBase.fire({
    title: 'Supprimer ?',
    html: `Voulez-vous vraiment supprimer <strong style="color:#fff">"${name}"</strong> ?<br>
           <small style="opacity:.55;font-size:.82rem">Cette action est irréversible.</small>`,
    icon: 'warning',
    iconColor: '#ef4444',
    showCancelButton: true,
    confirmButtonColor: '#ef4444',
    cancelButtonColor: 'rgba(255,255,255,.12)',
    confirmButtonText: 'Oui, supprimer',
    cancelButtonText:  'Annuler',
    reverseButtons: true,
    customClass: {
      cancelButton: 'swal-cancel-btn'
    }
  }).then(result => {
    if (!result.isConfirmed) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML =
      `<input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
       <input type="hidden" name="_method" value="DELETE">`;
    document.body.appendChild(form);
    form.submit();
  });
};

/* ═══════════════════════════════════════════
   MAINTENANCE — SweetAlert global
═══════════════════════════════════════════ */
window.confirmMaintenance = function(isCurrentlyDown) {
  if (isCurrentlyDown) {
    SwalBase.fire({
      title: 'Remettre en ligne ?',
      html: `Le site est actuellement en maintenance.<br>
             <small style="opacity:.55;font-size:.82rem">Les visiteurs pourront à nouveau y accéder.</small>`,
      icon: 'question',
      iconColor: '#10b981',
      showCancelButton: true,
      confirmButtonColor: '#10b981',
      cancelButtonColor: 'rgba(255,255,255,.12)',
      confirmButtonText: '<i class="bi bi-globe"></i> Oui, remettre en ligne',
      cancelButtonText: 'Annuler',
      reverseButtons: true,
      customClass: { cancelButton: 'swal-cancel-btn' }
    }).then(r => { if (r.isConfirmed) document.getElementById('maintenanceForm').submit(); });
  } else {
    SwalBase.fire({
      title: 'Mettre en maintenance ?',
      html: `Le front sera inaccessible aux visiteurs.<br>
             <small style="opacity:.55;font-size:.82rem">Vous pourrez toujours accéder à l'admin normalement.</small>`,
      icon: 'warning',
      iconColor: '#f59e0b',
      showCancelButton: true,
      confirmButtonColor: '#f59e0b',
      cancelButtonColor: 'rgba(255,255,255,.12)',
      confirmButtonText: '<i class="bi bi-cone-striped"></i> Oui, mettre en maintenance',
      cancelButtonText: 'Annuler',
      reverseButtons: true,
      customClass: { cancelButton: 'swal-cancel-btn' }
    }).then(r => { if (r.isConfirmed) document.getElementById('maintenanceForm').submit(); });
  }
};

/* ═══════════════════════════════════════════
   CONFIRM LOGOUT — SweetAlert global
═══════════════════════════════════════════ */
window.confirmLogout = function() {
  SwalBase.fire({
    title: 'Déconnexion',
    html: `Voulez-vous vraiment vous déconnecter ?<br>
           <small style="opacity:.55;font-size:.82rem">Vous devrez vous reconnecter pour accéder à l'administration.</small>`,
    icon: 'question',
    iconColor: '#ff7c08',
    showCancelButton: true,
    confirmButtonColor: '#ff7c08',
    cancelButtonColor: 'rgba(255,255,255,.12)',
    confirmButtonText: '<i class="bi bi-box-arrow-right"></i> Oui, déconnecter',
    cancelButtonText:  'Annuler',
    reverseButtons: true,
    customClass: { cancelButton: 'swal-cancel-btn' }
  }).then(result => {
    if (result.isConfirmed) {
      document.getElementById('logoutForm').submit();
    }
  });
};

/* ═══════════════════════════════════════════
   DARK MODE
═══════════════════════════════════════════ */
(function() {
  if (localStorage.getItem('admin-theme') === 'dark') {
    document.documentElement.setAttribute('data-theme', 'dark');
  }
})();

window.toggleDarkMode = function() {
  const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
  document.documentElement.setAttribute('data-theme', isDark ? 'light' : 'dark');
  localStorage.setItem('admin-theme', isDark ? 'light' : 'dark');
  const ico = document.getElementById('darkModeIco');
  if (ico) ico.className = isDark ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
};
</script>

<style>
/* ─── SweetAlert thème ─── */
.swal2-popup.swal-popup { border-radius:20px!important;border:1px solid rgba(255,255,255,.08)!important;box-shadow:0 24px 80px rgba(0,0,0,.55)!important }
.swal2-title           { font-family:'Outfit',sans-serif!important;font-size:20px!important;font-weight:700!important }
.swal2-html-container  { font-family:'DM Sans',sans-serif!important;font-size:14px!important;color:rgba(255,255,255,.6)!important }
.swal2-confirm.swal-btn{ border-radius:10px!important;font-family:'Outfit',sans-serif!important;font-weight:600!important;padding:10px 28px!important;box-shadow:0 6px 20px rgba(255,124,8,.35)!important }
.swal2-cancel.swal-cancel-btn{ border-radius:10px!important;font-family:'Outfit',sans-serif!important;font-weight:600!important;padding:10px 28px!important;color:#fff!important;border:1px solid rgba(255,255,255,.2)!important }
.swal2-timer-progress-bar { background:#ff7c08!important }

/* ─── Toast ─── */
.toast-container-custom { position:fixed;bottom:24px;right:24px;z-index:9999;display:flex;flex-direction:column;gap:10px;max-width:360px }
.toast-item { display:flex;align-items:center;gap:10px;background:#fff;border:1px solid #e9ecef;border-radius:14px;padding:13px 16px;box-shadow:0 8px 32px rgba(0,0,0,.12);animation:toastIn .3s ease;font-family:'DM Sans',sans-serif;font-size:.86rem;font-weight:600;color:#231f40 }
.toast-item.toast-success { border-left:4px solid #10b981 }
.toast-item.toast-error   { border-left:4px solid #ef4444 }
.toast-item.toast-warning { border-left:4px solid #f59e0b }
.toast-item.toast-info    { border-left:4px solid #3b82f6 }
.toast-ico { font-size:1rem;flex-shrink:0 }
.toast-msg { flex:1 }
.toast-close { margin-left:auto;background:none;border:none;cursor:pointer;color:#9ca3af;font-size:.75rem;padding:2px 5px;border-radius:5px;transition:all .2s }
.toast-close:hover { background:#f3f4f6;color:#374151 }
.toast-out { animation:toastOut .32s ease forwards }
@keyframes toastIn  { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:translateX(0)} }
@keyframes toastOut { to{opacity:0;transform:translateX(24px);max-height:0;padding:0;margin:0} }

/* ─── Overlay sidebar ─── */
#sidebarOverlay { display:none;position:fixed;inset:0;z-index:190;background:rgba(0,0,0,.45);backdrop-filter:blur(3px) }
</style>

@stack('scripts')

<script>
/* ═══════════════════════════════════════════════════════════
   QUILL AUTO-INIT GLOBAL
   Tout élément [data-quill-target="fieldId"] devient un
   éditeur Quill qui synchronise vers l'input hidden #fieldId
═══════════════════════════════════════════════════════════ */
window._quillInstances = window._quillInstances || [];

(function initGlobalQuill() {
  const TOOLBAR = [
    [{ header: [1, 2, 3, false] }],
    ['bold', 'italic', 'underline', 'strike'],
    [{ color: [] }, { background: [] }],
    [{ list: 'ordered' }, { list: 'bullet' }],
    [{ indent: '-1' }, { indent: '+1' }],
    ['link', 'image', 'blockquote', 'code-block'],
    ['clean']
  ];

  document.querySelectorAll('[data-quill-target]').forEach(container => {
    if (container._quillInit) return;
    container._quillInit = true;

    const targetId = container.dataset.quillTarget;
    const hidden   = document.getElementById(targetId);
    if (!hidden) return;

    const wrap = document.createElement('div');
    wrap.className = 'quill-param-wrap';
    container.parentNode.insertBefore(wrap, container);
    wrap.appendChild(container);

    const quill = new Quill(container, {
      theme: 'snow',
      modules: { toolbar: TOOLBAR },
      placeholder: container.dataset.placeholder || 'Rédigez votre texte...',
    });

    if (hidden.value && hidden.value.trim()) {
      quill.root.innerHTML = hidden.value;
    }

    quill.on('text-change', () => {
      hidden.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
    });

    window._quillInstances.push({ quill, hidden });
  });

  /* Sync tous les Quill avant soumission de n'importe quel form */
  document.querySelectorAll('form').forEach(form => {
    if (form._quillSyncBound) return;
    form._quillSyncBound = true;
    form.addEventListener('submit', () => {
      window._quillInstances.forEach(({ quill, hidden }) => {
        hidden.value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
      });
    }, true);
  });
})();
</script>

</body>
</html>