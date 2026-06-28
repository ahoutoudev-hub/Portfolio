<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maintenance — Portfolio</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #0f0f1a;
      color: #e2e8f0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      overflow: hidden;
    }
    .blob {
      position: fixed; border-radius: 50%;
      filter: blur(120px); pointer-events: none; z-index: 0;
    }
    .blob-1 { width:600px;height:600px;background:rgba(255,124,8,.1);top:-200px;right:-150px; }
    .blob-2 { width:500px;height:500px;background:rgba(99,102,241,.08);bottom:-150px;left:-100px; }

    .wrap {
      position: relative; z-index: 1;
      text-align: center; max-width: 600px; width: 100%;
    }

    .brand {
      font-size: 1.2rem; font-weight: 800; color: #fff;
      margin-bottom: 48px; display: inline-block;
    }
    .brand span { color: #ff7c08; }

    .gear-wrap {
      margin-bottom: 28px;
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .gear {
      color: #ff7c08;
      animation: spin-gear 4s linear infinite;
      font-size: 2.8rem;
    }
    .gear-sm {
      color: rgba(255,124,8,.5);
      animation: spin-gear 2.5s linear infinite reverse;
      font-size: 1.8rem;
    }

    .title {
      font-size: clamp(1.6rem, 5vw, 2.4rem);
      font-weight: 800; color: #fff;
      margin-bottom: 16px; line-height: 1.2;
    }
    .title span {
      background: linear-gradient(135deg, #ff7c08, #ffb347);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .desc {
      font-size: 1rem; color: rgba(255,255,255,.5);
      line-height: 1.8; margin-bottom: 40px;
    }

    .divider {
      width: 60px; height: 3px;
      background: #ff7c08; border-radius: 99px;
      margin: 24px auto 32px;
    }

    .progress-wrap {
      background: rgba(255,255,255,.06);
      border: 1px solid rgba(255,255,255,.08);
      border-radius: 16px; padding: 24px 28px;
      margin-bottom: 32px;
    }
    .progress-label {
      font-size: .8rem; color: rgba(255,255,255,.4);
      font-weight: 600; text-transform: uppercase;
      letter-spacing: .08em; margin-bottom: 12px;
    }
    .progress-bar {
      height: 6px; background: rgba(255,255,255,.1);
      border-radius: 99px; overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      background: linear-gradient(90deg, #ff7c08, #ffb347);
      border-radius: 99px;
      width: 75%;
      animation: progress-pulse 2s ease-in-out infinite;
    }

    .contact-line {
      font-size: .85rem; color: rgba(255,255,255,.35);
    }
    .contact-line a {
      color: #ff7c08; text-decoration: none; font-weight: 600;
    }

    @keyframes spin-gear { to { transform: rotate(360deg); } }
    @keyframes progress-pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: .6; }
    }
  </style>
</head>
<body>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <div class="wrap">
    <div class="brand">AHOUTOU<span>.</span></div>

    <div class="gear-wrap">
      <span class="gear">⚙️</span>
      <span class="gear-sm">⚙️</span>
    </div>

    <h1 class="title">Site en <span>maintenance</span></h1>
    <div class="divider"></div>
    <p class="desc">
      Nous effectuons des améliorations pour vous offrir<br>
      une meilleure expérience. De retour très bientôt !
    </p>

    <div class="progress-wrap">
      <div class="progress-label">Progression des travaux</div>
      <div class="progress-bar">
        <div class="progress-fill"></div>
      </div>
    </div>

    <p class="contact-line">
      Une urgence ? Contactez-moi sur
      <a href="mailto:ahoutou.dev@gmail.com">ahoutou.dev@gmail.com</a>
    </p>
  </div>
</body>
</html>
