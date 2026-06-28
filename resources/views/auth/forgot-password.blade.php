<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mot de passe oublié | AHOUTOU</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style_auth.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="bg"></div>
<div class="grid-floor"></div>

<!-- Logos 3D (même décoration que la page connexion) -->
<div class="logos">
  <div class="logo-3d l1"><svg width="74" height="74" viewBox="0 0 74 74"><rect width="74" height="74" rx="15" fill="#F0DB4F"/><rect width="74" height="6" rx="10" fill="rgba(255,255,255,.3)"/><text x="37" y="45" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="30" font-weight="900" fill="#231f40">JS</text></svg></div>
  <div class="logo-3d l2"><svg width="88" height="58" viewBox="0 0 88 58"><rect width="88" height="58" rx="13" fill="#4F5B93"/><rect width="88" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="44" y="33" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="26" font-weight="900" fill="#fff" letter-spacing="2">PHP</text></svg></div>
  <div class="logo-3d l3"><svg width="70" height="70" viewBox="0 0 70 70"><defs><linearGradient id="pyg" x1="0" y1="0" x2="70" y2="70"><stop stop-color="#4B8BBE"/><stop offset="1" stop-color="#306998"/></linearGradient></defs><rect width="70" height="70" rx="14" fill="url(#pyg)"/><rect width="70" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="35" y="40" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="#FFD43B">Py</text></svg></div>
  <div class="logo-3d l4"><svg width="64" height="74" viewBox="0 0 64 74"><defs><linearGradient id="htg" x1="0" y1="0" x2="64" y2="74"><stop stop-color="#E44D26"/><stop offset="1" stop-color="#F16529"/></linearGradient></defs><rect width="64" height="74" rx="13" fill="url(#htg)"/><rect width="64" height="5" rx="10" fill="rgba(255,255,255,.22)"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">HTML</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.75)">5</text></svg></div>
  <div class="logo-3d l5"><svg width="80" height="60" viewBox="0 0 80 60"><defs><linearGradient id="ndg" x1="0" y1="0" x2="80" y2="60"><stop stop-color="#3c873a"/><stop offset="1" stop-color="#68a85e"/></linearGradient></defs><rect width="80" height="60" rx="13" fill="url(#ndg)"/><rect width="80" height="5" rx="10" fill="rgba(255,255,255,.2)"/><text x="40" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">Node.js</text></svg></div>
  <div class="logo-3d l6"><svg width="80" height="60" viewBox="0 0 80 60"><defs><linearGradient id="myg" x1="0" y1="0" x2="80" y2="60"><stop stop-color="#00618a"/><stop offset="1" stop-color="#004f74"/></linearGradient></defs><rect width="80" height="60" rx="13" fill="url(#myg)"/><rect width="80" height="5" rx="10" fill="rgba(255,255,255,.18)"/><text x="52" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="15" font-weight="900" fill="#fff">MySQL</text></svg></div>
  <div class="logo-3d l7"><svg width="64" height="74" viewBox="0 0 64 74"><defs><linearGradient id="csg" x1="0" y1="0" x2="64" y2="74"><stop stop-color="#264de4"/><stop offset="1" stop-color="#2756d4"/></linearGradient></defs><rect width="64" height="74" rx="13" fill="url(#csg)"/><rect width="64" height="5" rx="10" fill="rgba(255,255,255,.2)"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="18" font-weight="900" fill="#fff">CSS</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.7)">3</text></svg></div>
  <div class="logo-3d l8"><svg width="76" height="76" viewBox="0 0 76 76"><rect width="76" height="76" rx="16" fill="#20232a"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(60 38 38)"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(120 38 38)"/><circle cx="38" cy="38" r="4" fill="#61DAFB"/></svg></div>
  <div class="logo-3d l9"><svg width="72" height="72" viewBox="0 0 72 72"><rect width="72" height="72" rx="14" fill="#1a1a2e"/><path d="M10 16 L36 60 L62 16 L51 16 L36 44 L21 16Z" fill="#42b883"/><path d="M21 16 L36 44 L51 16 L42 16 L36 30 L30 16Z" fill="#35495e"/></svg></div>
  <div class="logo-3d l10"><svg width="72" height="72" viewBox="0 0 72 72"><defs><linearGradient id="tsg" x1="0" y1="0" x2="72" y2="72"><stop stop-color="#3178c6"/><stop offset="1" stop-color="#1d5fa0"/></linearGradient></defs><rect width="72" height="72" rx="14" fill="url(#tsg)"/><text x="36" y="42" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="28" font-weight="900" fill="#fff">TS</text></svg></div>
  <div class="logo-3d l11"><svg width="70" height="70" viewBox="0 0 70 70"><defs><linearGradient id="lag" x1="0" y1="0" x2="70" y2="70"><stop stop-color="#FF2D20"/><stop offset="1" stop-color="#c0180d"/></linearGradient></defs><rect width="70" height="70" rx="14" fill="url(#lag)"/><path d="M19 14 L30 14 L30 46 L52 46 L52 56 L19 56Z" fill="rgba(255,255,255,.92)"/></svg></div>
  <div class="logo-3d l12"><svg width="78" height="62" viewBox="0 0 78 62"><defs><linearGradient id="dkg" x1="0" y1="0" x2="78" y2="62"><stop stop-color="#0db7ed"/><stop offset="1" stop-color="#008fbe"/></linearGradient></defs><rect width="78" height="62" rx="13" fill="url(#dkg)"/><rect x="12" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="26" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="40" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/></svg></div>
  <div class="logo-3d l13"><svg width="66" height="66" viewBox="0 0 66 66"><defs><linearGradient id="gtg" x1="0" y1="0" x2="66" y2="66"><stop stop-color="#F05032"/><stop offset="1" stop-color="#bc2c1a"/></linearGradient></defs><rect width="66" height="66" rx="13" fill="url(#gtg)"/><circle cx="20" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="46" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="20" cy="46" r="6" fill="rgba(255,255,255,.9)"/></svg></div>
  <div class="logo-3d l14"><svg width="66" height="72" viewBox="0 0 66 72"><defs><linearGradient id="mgg" x1="0" y1="0" x2="66" y2="72"><stop stop-color="#13aa52"/><stop offset="1" stop-color="#0d7a3a"/></linearGradient></defs><rect width="66" height="72" rx="13" fill="url(#mgg)"/><path d="M33 14 C33 14 22 28 22 42 C22 52 27 58 33 60 C39 58 44 52 44 42 C44 28 33 14 33 14Z" fill="rgba(255,255,255,.9)"/></svg></div>
</div>

<div class="overlay"></div>

<div class="page">
  <div class="card">

    <div class="hd">
      <div class="icon-wrap">
        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
        </svg>
      </div>
      <h2>Mot de passe oublié</h2>
      <p>Saisissez votre adresse e-mail, nous vous enverrons un lien de réinitialisation.</p>
    </div>

    <div class="sep"></div>

    <form method="POST" action="{{ route('password.email') }}" id="forgotForm" novalidate>
      @csrf

      <div class="field">
        <label for="email">Adresse e-mail <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          <input type="email"
                 id="email"
                 name="email"
                 placeholder="votre@email.com"
                 value="{{ old('email') }}"
                 autocomplete="email"
                 required />
        </div>
        @error('email')
          <div class="err-msg" style="color:#ef4444;font-size:.8rem;margin-top:6px">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn" id="submitBtn">
        <span id="btnText">Envoyer le lien</span>
        <span id="btnSpinner" style="display:none">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 1s linear infinite">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
          </svg>
          Envoi…
        </span>
      </button>

    </form>

    <div class="foot" style="text-align:center;margin-top:20px">
      <a href="{{ route('auth.connexion') }}" class="lnk" style="display:inline-flex;align-items:center;gap:6px;font-size:.83rem">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la connexion
      </a>
    </div>

  </div>
</div>

@if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'E-mail envoyé !',
    text: @json(session('success')),
    confirmButtonText: 'OK',
    confirmButtonColor: '#ff7c08',
    background: '#1e1b2e',
    color: '#fff',
    iconColor: '#10b981',
    customClass: { popup:'swal-dark' }
  });
</script>
@endif

@if($errors->any() && !$errors->has('email'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Erreur',
    text: @json($errors->first()),
    confirmButtonColor: '#ff7c08',
    background: '#1e1b2e',
    color: '#fff',
  });
</script>
@endif

<script>
document.getElementById('forgotForm').addEventListener('submit', function(e) {
  const email = document.getElementById('email').value.trim();
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    e.preventDefault();
    Swal.fire({
      icon: 'warning',
      title: 'Champ requis',
      text: 'Veuillez saisir une adresse e-mail valide.',
      confirmButtonColor: '#ff7c08',
      background: '#1e1b2e',
      color: '#fff',
    });
    return;
  }
  document.getElementById('btnText').style.display = 'none';
  document.getElementById('btnSpinner').style.display = 'inline-flex';
  document.getElementById('submitBtn').disabled = true;
});
</script>

<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>

</body>
</html>
