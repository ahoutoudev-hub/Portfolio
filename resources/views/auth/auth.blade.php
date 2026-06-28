
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion | AHOUTOU</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style_auth.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Fond + grille -->
<div class="bg"></div>
<div class="grid-floor"></div>

<!-- Logos 3D -->
<div class="logos">

  <!-- JS -->
  <div class="logo-3d l1">
    <svg width="74" height="74" viewBox="0 0 74 74"><rect width="74" height="74" rx="15" fill="#F0DB4F"/><rect width="74" height="6" rx="10" fill="rgba(255,255,255,.3)"/><text x="37" y="45" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="30" font-weight="900" fill="#231f40">JS</text></svg>
  </div>

  <!-- PHP -->
  <div class="logo-3d l2">
    <svg width="88" height="58" viewBox="0 0 88 58"><rect width="88" height="58" rx="13" fill="#4F5B93"/><rect width="88" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="44" y="33" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="26" font-weight="900" fill="#fff" letter-spacing="2">PHP</text></svg>
  </div>

  <!-- Python -->
  <div class="logo-3d l3">
    <svg width="70" height="70" viewBox="0 0 70 70"><defs><linearGradient id="pyg" x1="0" y1="0" x2="70" y2="70"><stop stop-color="#4B8BBE"/><stop offset="1" stop-color="#306998"/></linearGradient></defs><rect width="70" height="70" rx="14" fill="url(#pyg)"/><rect width="70" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="35" y="40" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="#FFD43B">Py</text></svg>
  </div>

  <!-- HTML5 -->
  <div class="logo-3d l4">
    <svg width="64" height="74" viewBox="0 0 64 74"><defs><linearGradient id="htg" x1="0" y1="0" x2="64" y2="74"><stop stop-color="#E44D26"/><stop offset="1" stop-color="#F16529"/></linearGradient></defs><rect width="64" height="74" rx="13" fill="url(#htg)"/><rect width="64" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">HTML</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.75)">5</text></svg>
  </div>

  <!-- Node.js -->
  <div class="logo-3d l5">
    <svg width="80" height="60" viewBox="0 0 80 60"><defs><linearGradient id="ndg" x1="0" y1="0" x2="80" y2="60"><stop stop-color="#3c873a"/><stop offset="1" stop-color="#68a85e"/></linearGradient></defs><rect width="80" height="60" rx="13" fill="url(#ndg)"/><rect width="80" height="5" rx="10" fill="rgba(255,255,255,.2)"/><text x="40" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">Node.js</text></svg>
  </div>

  <!-- MySQL -->
  <div class="logo-3d l6">
    <svg width="80" height="60" viewBox="0 0 80 60"><defs><linearGradient id="myg" x1="0" y1="0" x2="80" y2="60"><stop stop-color="#00618a"/><stop offset="1" stop-color="#004f74"/></linearGradient></defs><rect width="80" height="60" rx="13" fill="url(#myg)"/><rect width="80" height="5" rx="10" fill="rgba(255,255,255,.18)"/><ellipse cx="18" cy="28" rx="8" ry="3.5" fill="rgba(255,255,255,.55)"/><rect x="10" y="28" width="16" height="10" fill="rgba(255,255,255,.35)"/><ellipse cx="18" cy="38" rx="8" ry="3.5" fill="rgba(255,255,255,.45)"/><text x="52" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="15" font-weight="900" fill="#fff">MySQL</text></svg>
  </div>

  <!-- CSS3 -->
  <div class="logo-3d l7">
    <svg width="64" height="74" viewBox="0 0 64 74"><defs><linearGradient id="csg" x1="0" y1="0" x2="64" y2="74"><stop stop-color="#264de4"/><stop offset="1" stop-color="#2756d4"/></linearGradient></defs><rect width="64" height="74" rx="13" fill="url(#csg)"/><rect width="64" height="5" rx="10" fill="rgba(255,255,255,.2)"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="18" font-weight="900" fill="#fff">CSS</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.7)">3</text></svg>
  </div>

  <!-- React -->
  <div class="logo-3d l8">
    <svg width="76" height="76" viewBox="0 0 76 76"><rect width="76" height="76" rx="16" fill="#20232a"/><rect width="76" height="6" rx="12" fill="rgba(255,255,255,.08)"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(60 38 38)"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(120 38 38)"/><circle cx="38" cy="38" r="4" fill="#61DAFB"/></svg>
  </div>

  <!-- Vue.js -->
  <div class="logo-3d l9">
    <svg width="72" height="72" viewBox="0 0 72 72"><rect width="72" height="72" rx="14" fill="#1a1a2e"/><rect width="72" height="5" rx="10" fill="rgba(255,255,255,.09)"/><path d="M10 16 L36 60 L62 16 L51 16 L36 44 L21 16Z" fill="#42b883"/><path d="M21 16 L36 44 L51 16 L42 16 L36 30 L30 16Z" fill="#35495e"/></svg>
  </div>

  <!-- TypeScript -->
  <div class="logo-3d l10">
    <svg width="72" height="72" viewBox="0 0 72 72"><defs><linearGradient id="tsg" x1="0" y1="0" x2="72" y2="72"><stop stop-color="#3178c6"/><stop offset="1" stop-color="#1d5fa0"/></linearGradient></defs><rect width="72" height="72" rx="14" fill="url(#tsg)"/><rect width="72" height="5" rx="10" fill="rgba(255,255,255,.2)"/><text x="36" y="42" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="28" font-weight="900" fill="#fff">TS</text></svg>
  </div>

  <!-- Laravel -->
  <div class="logo-3d l11">
    <svg width="70" height="70" viewBox="0 0 70 70"><defs><linearGradient id="lag" x1="0" y1="0" x2="70" y2="70"><stop stop-color="#FF2D20"/><stop offset="1" stop-color="#c0180d"/></linearGradient></defs><rect width="70" height="70" rx="14" fill="url(#lag)"/><rect width="70" height="5" rx="10" fill="rgba(255,255,255,.2)"/><path d="M19 14 L30 14 L30 46 L52 46 L52 56 L19 56Z" fill="rgba(255,255,255,.92)"/></svg>
  </div>

  <!-- Docker -->
  <div class="logo-3d l12">
    <svg width="78" height="62" viewBox="0 0 78 62"><defs><linearGradient id="dkg" x1="0" y1="0" x2="78" y2="62"><stop stop-color="#0db7ed"/><stop offset="1" stop-color="#008fbe"/></linearGradient></defs><rect width="78" height="62" rx="13" fill="url(#dkg)"/><rect width="78" height="5" rx="10" fill="rgba(255,255,255,.2)"/><rect x="12" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="26" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="40" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="26" y="10" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="40" y="10" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><path d="M8 38 Q18 32 28 38 Q38 44 50 38 Q60 33 68 38" stroke="rgba(255,255,255,.6)" stroke-width="2.5" fill="none" stroke-linecap="round"/></svg>
  </div>

  <!-- Git -->
  <div class="logo-3d l13">
    <svg width="66" height="66" viewBox="0 0 66 66"><defs><linearGradient id="gtg" x1="0" y1="0" x2="66" y2="66"><stop stop-color="#F05032"/><stop offset="1" stop-color="#bc2c1a"/></linearGradient></defs><rect width="66" height="66" rx="13" fill="url(#gtg)"/><rect width="66" height="5" rx="10" fill="rgba(255,255,255,.2)"/><circle cx="20" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="46" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="20" cy="46" r="6" fill="rgba(255,255,255,.9)"/><line x1="20" y1="26" x2="20" y2="40" stroke="rgba(255,255,255,.85)" stroke-width="2.5"/><path d="M20 20 Q33 20 46 20" stroke="rgba(255,255,255,.85)" stroke-width="2.5" fill="none"/><path d="M46 20 Q46 33 20 46" stroke="rgba(255,255,255,.85)" stroke-width="2.5" fill="none"/></svg>
  </div>

  <!-- MongoDB -->
  <div class="logo-3d l14">
    <svg width="66" height="72" viewBox="0 0 66 72"><defs><linearGradient id="mgg" x1="0" y1="0" x2="66" y2="72"><stop stop-color="#13aa52"/><stop offset="1" stop-color="#0d7a3a"/></linearGradient></defs><rect width="66" height="72" rx="13" fill="url(#mgg)"/><rect width="66" height="5" rx="10" fill="rgba(255,255,255,.2)"/><path d="M33 14 C33 14 22 28 22 42 C22 52 27 58 33 60 C39 58 44 52 44 42 C44 28 33 14 33 14Z" fill="rgba(255,255,255,.9)"/><rect x="30" y="54" width="6" height="12" rx="3" fill="rgba(255,255,255,.7)"/></svg>
  </div>

</div>

<!-- Overlay blur -->
<div class="overlay"></div>

<!-- Formulaire centré -->
<div class="page">
  <div class="card">

    <div class="hd">
      <div class="icon-wrap">&lt;/&gt;</div>
      <h2>AHOUTOU</h2>
      <p>Connectez-vous à votre espace de gestion</p>
    </div>

    <div class="sep"></div>

    <form method="POST" action="{{ route('auth.SeConnecter') }}" id="loginForm" novalidate>
      @csrf

      {{-- Champ Email --}}
      <div class="field">
        <label for="email">Adresse e-mail <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          <input type="email"
                 id="email"
                 name="email"
                 placeholder="admin@portfolio.com"
                 value="{{ old('email') }}"
                 autocomplete="email"
                 required />
        </div>
      </div>

      {{-- Champ Mot de passe --}}
      <div class="field">
        <label for="password">Mot de passe <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
          </svg>
          <input type="password"
                 id="password"
                 name="password"
                 placeholder="••••••••••"
                 autocomplete="current-password"
                 required />
          <button type="button" class="eye" id="eyeBtn" aria-label="Afficher le mot de passe">
            <svg id="eyeIco" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          </button>
        </div>
      </div>

      {{-- Options --}}
      <div class="opts">
        <label class="ck">
          <input type="checkbox" id="rem" name="remember" {{ old('remember') ? 'checked' : '' }} />
          <span class="ck-box"></span>
          <span>Se souvenir de moi</span>
        </label>
        <a href="{{ route('password.request') }}" class="lnk">Mot de passe oublié ?</a>
      </div>

      {{-- Bouton --}}
      <button type="submit" class="btn" id="btn">
        <span class="lbl">Se connecter →</span>
        <span class="spinner"></span>
      </button>

    </form>

    <div class="ft">
      &copy; {{ now()->year }} <strong>AHOUTOU N'DA JOSUE</strong> · Tous droits réservés
    </div>

  </div>
</div>



<script>
  /* ── Config SweetAlert de base ─────────────────────────── */
  const SwalBase = Swal.mixin({
    background:    '#2c2850',
    color:         '#ffffff',
    confirmButtonColor: '#ff7c08',
    customClass: {
      popup:         'swal-popup',
      confirmButton: 'swal-btn',
    }
  });

  /* ── Toggle mot de passe ───────────────────────────────── */
  const eyeOpen = `<path stroke-linecap="round" stroke-linejoin="round" d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
  const eyeOff  = `<path stroke-linecap="round" d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19M1 1l22 22"/><circle cx="12" cy="12" r="3"/>`;
  const pwdInput = document.getElementById('password');
  const eyeIco   = document.getElementById('eyeIco');

  document.getElementById('eyeBtn').addEventListener('click', () => {
    const show = pwdInput.type === 'password';
    pwdInput.type    = show ? 'text' : 'password';
    eyeIco.innerHTML = show ? eyeOff : eyeOpen;
  });

  /* ── Validation côté client avant envoi ────────────────── */
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault(); // bloquer l'envoi natif le temps de valider

    const email    = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const emailRgx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Champ email vide
    if (!email) {
      SwalBase.fire({
        icon:              'warning',
        iconColor:         '#f59e0b',
        title:             'Champ requis',
        text:              'Veuillez saisir votre adresse e-mail.',
        confirmButtonText: 'OK',
      }).then(() => document.getElementById('email').focus());
      return;
    }

    // Format email invalide
    if (!emailRgx.test(email)) {
      SwalBase.fire({
        icon:              'error',
        iconColor:         '#ef4444',
        title:             'E-mail invalide',
        text:              'Le format de l\'adresse e-mail n\'est pas valide.',
        confirmButtonText: 'Corriger',
      }).then(() => document.getElementById('email').focus());
      return;
    }

    // Champ mot de passe vide
    if (!password) {
      SwalBase.fire({
        icon:              'warning',
        iconColor:         '#f59e0b',
        title:             'Champ requis',
        text:              'Veuillez saisir votre mot de passe.',
        confirmButtonText: 'OK',
      }).then(() => document.getElementById('password').focus());
      return;
    }

    // Mot de passe trop court
    if (password.length < 6) {
      SwalBase.fire({
        icon:              'error',
        iconColor:         '#ef4444',
        title:             'Mot de passe trop court',
        text:              'Le mot de passe doit contenir au moins 6 caractères.',
        confirmButtonText: 'Corriger',
      }).then(() => document.getElementById('password').focus());
      return;
    }

    // ✅ Tout est valide → spinner + envoi
    const btn = document.getElementById('btn');
    btn.classList.add('loading');
    this.submit();
  });

  /* ── Alertes serveur (session Laravel) ─────────────────── */
  @if (session('sweet_error'))
    SwalBase.fire({
      icon:              "{{ session('sweet_error.icon') }}",
      iconColor:         "{{ session('sweet_error.icon') === 'warning' ? '#f59e0b' : '#ef4444' }}",
      title:             "{{ session('sweet_error.title') }}",
      text:              "{{ session('sweet_error.message') }}",
      confirmButtonText: 'Réessayer',
    });
  @endif

  @if (session('sweet_success'))
    SwalBase.fire({
      icon:              'success',
      iconColor:         '#10b981',
      title:             "{{ session('sweet_success.title') }}",
      text:              "{{ session('sweet_success.message') }}",
      timer:             2800,
      timerProgressBar:  true,
      showConfirmButton: false,
    });
  @endif

  @if (session('success_reset'))
    SwalBase.fire({
      icon:      'success',
      iconColor: '#10b981',
      title:     'Mot de passe réinitialisé !',
      text:      "{{ session('success_reset') }}",
      timer:     3500,
      timerProgressBar: true,
      showConfirmButton: false,
    });
  @endif
</script>

{{-- ── Style SweetAlert cohérent avec le thème ──────────── --}}
<style>
  .swal2-popup.swal-popup {
    border-radius: 20px !important;
    border: 1px solid rgba(255,255,255,.08) !important;
    box-shadow: 0 24px 80px rgba(0,0,0,.55) !important;
  }
  .swal2-title {
    font-family: 'Outfit', sans-serif !important;
    font-size: 20px !important;
    font-weight: 700 !important;
  }
  .swal2-html-container {
    font-family: 'DM Sans', sans-serif !important;
    font-size: 14px !important;
    color: rgba(255,255,255,.6) !important;
  }
  .swal2-confirm.swal-btn {
    border-radius: 10px !important;
    font-family: 'Outfit', sans-serif !important;
    font-weight: 600 !important;
    padding: 10px 28px !important;
    box-shadow: 0 6px 20px rgba(255,124,8,.35) !important;
  }
  .swal2-timer-progress-bar { background: #ff7c08 !important; }

  /* Bordure rouge sur champ invalide après tentative */
  input.invalid {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 4px rgba(239,68,68,.15) !important;
  }
</style>

<script src="assets/js/script_auth.js"></script>

</body>
</html>
