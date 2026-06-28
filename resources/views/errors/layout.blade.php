<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Erreur') — Portfolio</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --primary: #ff7c08;
      --dark: #0f0f1a;
      --text: #e2e8f0;
      --muted: rgba(255,255,255,.4);
      --border: rgba(255,255,255,.08);
      --font: 'Plus Jakarta Sans', sans-serif;
    }
    body {
      font-family: var(--font);
      background: var(--dark);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px;
      overflow: hidden;
      position: relative;
    }

    /* Blobs décoratifs */
    .err-blob {
      position: fixed;
      border-radius: 50%;
      filter: blur(100px);
      pointer-events: none;
      z-index: 0;
    }
    .err-blob--1 {
      width: 500px; height: 500px;
      background: rgba(255,124,8,.12);
      top: -150px; right: -100px;
    }
    .err-blob--2 {
      width: 400px; height: 400px;
      background: rgba(99,102,241,.08);
      bottom: -100px; left: -80px;
    }

    .err-wrap {
      position: relative; z-index: 1;
      text-align: center;
      max-width: 560px;
      width: 100%;
    }

    .err-code {
      font-size: clamp(6rem, 18vw, 10rem);
      font-weight: 800;
      line-height: 1;
      background: linear-gradient(135deg, var(--primary) 0%, #ffb347 60%, #fff 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 12px;
      letter-spacing: -.04em;
    }

    .err-icon {
      font-size: 3.5rem;
      margin-bottom: 20px;
      display: block;
      animation: float 3s ease-in-out infinite;
    }

    .err-title {
      font-size: clamp(1.3rem, 4vw, 1.8rem);
      font-weight: 800;
      color: #fff;
      margin-bottom: 12px;
    }

    .err-desc {
      font-size: .95rem;
      color: var(--muted);
      line-height: 1.7;
      margin-bottom: 36px;
    }

    .err-actions {
      display: flex;
      gap: 12px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .err-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 12px 28px;
      border-radius: 12px;
      font-family: var(--font);
      font-weight: 700;
      font-size: .9rem;
      text-decoration: none;
      transition: all .2s;
      cursor: pointer;
      border: none;
    }
    .err-btn--primary {
      background: var(--primary);
      color: #fff;
      box-shadow: 0 4px 20px rgba(255,124,8,.4);
    }
    .err-btn--primary:hover {
      background: #e56e00;
      transform: translateY(-2px);
      box-shadow: 0 8px 28px rgba(255,124,8,.5);
    }
    .err-btn--ghost {
      background: rgba(255,255,255,.06);
      color: var(--text);
      border: 1px solid var(--border);
    }
    .err-btn--ghost:hover {
      background: rgba(255,255,255,.12);
      transform: translateY(-2px);
    }

    .err-divider {
      width: 60px; height: 3px;
      background: var(--primary);
      border-radius: 99px;
      margin: 20px auto;
    }

    .err-brand {
      position: fixed;
      top: 28px; left: 32px;
      font-family: var(--font);
      font-weight: 800;
      font-size: 1.1rem;
      color: #fff;
      text-decoration: none;
    }
    .err-brand span { color: var(--primary); }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-12px); }
    }

    @media (max-width: 480px) {
      .err-actions { flex-direction: column; align-items: center; }
      .err-btn { width: 100%; justify-content: center; }
    }
  </style>
  @stack('styles')
</head>
<body>
  <div class="err-blob err-blob--1"></div>
  <div class="err-blob err-blob--2"></div>

  <a href="/" class="err-brand">AHOUTOU<span>.</span></a>

  <div class="err-wrap">
    @yield('content')
  </div>
</body>
</html>
