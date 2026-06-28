@extends('errors.layout')

@section('title', '500 — Erreur serveur')

@section('content')
  <span class="err-icon">💥</span>
  <div class="err-code">500</div>
  <div class="err-divider"></div>
  <h1 class="err-title">Erreur interne du serveur</h1>
  <p class="err-desc">
    Quelque chose s'est mal passé de notre côté.<br>
    L'équipe est déjà sur le coup. Revenez dans un instant.
  </p>
  <div class="err-actions">
    <a href="/" class="err-btn err-btn--primary">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
      </svg>
      Retour à l'accueil
    </a>
    <a href="javascript:location.reload()" class="err-btn err-btn--ghost">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
      </svg>
      Réessayer
    </a>
  </div>
@endsection
