<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Réinitialiser le mot de passe | AHOUTOU</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style_auth.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="bg"></div>
<div class="grid-floor"></div>

<div class="logos">
  <div class="logo-3d l1"><svg width="74" height="74" viewBox="0 0 74 74"><rect width="74" height="74" rx="15" fill="#F0DB4F"/><text x="37" y="45" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="30" font-weight="900" fill="#231f40">JS</text></svg></div>
  <div class="logo-3d l2"><svg width="88" height="58" viewBox="0 0 88 58"><rect width="88" height="58" rx="13" fill="#4F5B93"/><text x="44" y="33" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="26" font-weight="900" fill="#fff" letter-spacing="2">PHP</text></svg></div>
  <div class="logo-3d l3"><svg width="70" height="70" viewBox="0 0 70 70"><rect width="70" height="70" rx="14" fill="#4B8BBE"/><text x="35" y="40" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="#FFD43B">Py</text></svg></div>
  <div class="logo-3d l4"><svg width="64" height="74" viewBox="0 0 64 74"><rect width="64" height="74" rx="13" fill="#E44D26"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">HTML</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.75)">5</text></svg></div>
  <div class="logo-3d l5"><svg width="80" height="60" viewBox="0 0 80 60"><rect width="80" height="60" rx="13" fill="#3c873a"/><text x="40" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="17" font-weight="900" fill="#fff">Node.js</text></svg></div>
  <div class="logo-3d l6"><svg width="80" height="60" viewBox="0 0 80 60"><rect width="80" height="60" rx="13" fill="#00618a"/><text x="40" y="34" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="15" font-weight="900" fill="#fff">MySQL</text></svg></div>
  <div class="logo-3d l7"><svg width="64" height="74" viewBox="0 0 64 74"><rect width="64" height="74" rx="13" fill="#264de4"/><text x="32" y="35" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="18" font-weight="900" fill="#fff">CSS</text><text x="32" y="57" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="22" font-weight="900" fill="rgba(255,255,255,.7)">3</text></svg></div>
  <div class="logo-3d l8"><svg width="76" height="76" viewBox="0 0 76 76"><rect width="76" height="76" rx="16" fill="#20232a"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(60 38 38)"/><ellipse cx="38" cy="38" rx="26" ry="10" stroke="#61DAFB" stroke-width="2" fill="none" transform="rotate(120 38 38)"/><circle cx="38" cy="38" r="4" fill="#61DAFB"/></svg></div>
  <div class="logo-3d l9"><svg width="72" height="72" viewBox="0 0 72 72"><rect width="72" height="72" rx="14" fill="#1a1a2e"/><path d="M10 16 L36 60 L62 16 L51 16 L36 44 L21 16Z" fill="#42b883"/></svg></div>
  <div class="logo-3d l10"><svg width="72" height="72" viewBox="0 0 72 72"><rect width="72" height="72" rx="14" fill="#3178c6"/><text x="36" y="42" text-anchor="middle" dominant-baseline="middle" font-family="Arial Black,sans-serif" font-size="28" font-weight="900" fill="#fff">TS</text></svg></div>
  <div class="logo-3d l11"><svg width="70" height="70" viewBox="0 0 70 70"><rect width="70" height="70" rx="14" fill="#FF2D20"/><path d="M19 14 L30 14 L30 46 L52 46 L52 56 L19 56Z" fill="rgba(255,255,255,.92)"/></svg></div>
  <div class="logo-3d l12"><svg width="78" height="62" viewBox="0 0 78 62"><rect width="78" height="62" rx="13" fill="#0db7ed"/><rect x="12" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="26" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/><rect x="40" y="22" width="12" height="10" rx="2" fill="rgba(255,255,255,.85)"/></svg></div>
  <div class="logo-3d l13"><svg width="66" height="66" viewBox="0 0 66 66"><rect width="66" height="66" rx="13" fill="#F05032"/><circle cx="20" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="46" cy="20" r="6" fill="rgba(255,255,255,.9)"/><circle cx="20" cy="46" r="6" fill="rgba(255,255,255,.9)"/></svg></div>
  <div class="logo-3d l14"><svg width="66" height="72" viewBox="0 0 66 72"><rect width="66" height="72" rx="13" fill="#13aa52"/><path d="M33 14 C33 14 22 28 22 42 C22 52 27 58 33 60 C39 58 44 52 44 42 C44 28 33 14 33 14Z" fill="rgba(255,255,255,.9)"/></svg></div>
</div>

<div class="overlay"></div>

<div class="page">
  <div class="card">

    <div class="hd">
      <div class="icon-wrap">
        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
      </div>
      <h2>Nouveau mot de passe</h2>
      <p>Choisissez un mot de passe sécurisé d'au moins 8 caractères.</p>
    </div>

    <div class="sep"></div>

    <form method="POST" action="{{ route('password.update') }}" id="resetForm" novalidate>
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      {{-- Email --}}
      <div class="field">
        <label for="email">Adresse e-mail <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          <input type="email" id="email" name="email"
                 value="{{ old('email', request('email')) }}"
                 placeholder="votre@email.com"
                 autocomplete="email" required/>
        </div>
        @error('email')
          <div class="err-msg" style="color:#ef4444;font-size:.8rem;margin-top:6px">{{ $message }}</div>
        @enderror
      </div>

      {{-- Nouveau mot de passe --}}
      <div class="field">
        <label for="password">Nouveau mot de passe <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
          </svg>
          <input type="password" id="password" name="password"
                 placeholder="Minimum 8 caractères"
                 autocomplete="new-password" required/>
          <button type="button" class="eye" id="eye1" onclick="togglePwd('password','eye1')" tabindex="-1">
            <svg id="eye1-off" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            <svg id="eye1-on" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
        </div>
        @error('password')
          <div class="err-msg" style="color:#ef4444;font-size:.8rem;margin-top:6px">{{ $message }}</div>
        @enderror
      </div>

      {{-- Confirmation --}}
      <div class="field">
        <label for="password_confirmation">Confirmer le mot de passe <span style="color:#ff7c08">*</span></label>
        <div class="iw">
          <svg class="ic" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <input type="password" id="password_confirmation" name="password_confirmation"
                 placeholder="Répétez le mot de passe"
                 autocomplete="new-password" required/>
          <button type="button" class="eye" id="eye2" onclick="togglePwd('password_confirmation','eye2')" tabindex="-1">
            <svg id="eye2-off" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            <svg id="eye2-on" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
        </div>
      </div>

      {{-- Indicateur de force --}}
      <div class="strength-bar" style="margin:-8px 0 20px">
        <div id="strengthFill" style="height:4px;border-radius:4px;width:0;transition:width .35s,background .35s;background:#ef4444"></div>
      </div>
      <div id="strengthLabel" style="font-size:.75rem;color:var(--muted,#888);margin-bottom:16px;min-height:16px"></div>

      <button type="submit" class="btn" id="submitBtn">
        <span id="btnText">Réinitialiser le mot de passe</span>
        <span id="btnSpinner" style="display:none;align-items:center;gap:8px">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin 1s linear infinite">
            <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
          </svg>
          Enregistrement…
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

@if($errors->any())
<script>
  Swal.fire({
    icon:'error', title:'Erreur',
    text: @json($errors->first()),
    confirmButtonColor:'#ff7c08',
    background:'#1e1b2e', color:'#fff',
  });
</script>
@endif

<script>
function togglePwd(inputId, btnId) {
  const input = document.getElementById(inputId);
  const isText = input.type === 'text';
  input.type = isText ? 'password' : 'text';
  document.getElementById(btnId + '-off').style.display = isText ? '' : 'none';
  document.getElementById(btnId + '-on').style.display  = isText ? 'none' : '';
}

/* Indicateur de force */
document.getElementById('password').addEventListener('input', function() {
  const v = this.value;
  let score = 0;
  if (v.length >= 8)  score++;
  if (/[A-Z]/.test(v)) score++;
  if (/[0-9]/.test(v)) score++;
  if (/[^A-Za-z0-9]/.test(v)) score++;

  const fill  = document.getElementById('strengthFill');
  const label = document.getElementById('strengthLabel');
  const map   = [
    { w:'0%',   bg:'#ef4444', txt:'' },
    { w:'25%',  bg:'#ef4444', txt:'Très faible' },
    { w:'50%',  bg:'#f59e0b', txt:'Moyen' },
    { w:'75%',  bg:'#3b82f6', txt:'Bon' },
    { w:'100%', bg:'#10b981', txt:'Excellent' },
  ];
  fill.style.width      = map[score].w;
  fill.style.background = map[score].bg;
  label.textContent     = map[score].txt;
  label.style.color     = map[score].bg;
});

document.getElementById('resetForm').addEventListener('submit', function(e) {
  const pwd  = document.getElementById('password').value;
  const conf = document.getElementById('password_confirmation').value;
  if (pwd.length < 8) {
    e.preventDefault();
    Swal.fire({ icon:'warning', title:'Mot de passe trop court', text:'8 caractères minimum.', confirmButtonColor:'#ff7c08', background:'#1e1b2e', color:'#fff' });
    return;
  }
  if (pwd !== conf) {
    e.preventDefault();
    Swal.fire({ icon:'warning', title:'Mots de passe différents', text:'La confirmation ne correspond pas.', confirmButtonColor:'#ff7c08', background:'#1e1b2e', color:'#fff' });
    return;
  }
  document.getElementById('btnText').style.display = 'none';
  document.getElementById('btnSpinner').style.display = 'inline-flex';
  document.getElementById('submitBtn').disabled = true;
});
</script>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

</body>
</html>
