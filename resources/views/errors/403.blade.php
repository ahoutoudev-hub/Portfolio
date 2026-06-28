@extends('errors.layout')

@section('title', '403 — Accès interdit')

@section('content')
  <span class="err-icon">🚫</span>
  <div class="err-code">403</div>
  <div class="err-divider"></div>
  <h1 class="err-title">Accès interdit</h1>
  <p class="err-desc">
    Vous n'avez pas les permissions nécessaires<br>
    pour accéder à cette ressource.
  </p>
  <div class="err-actions">
    <a href="/" class="err-btn err-btn--primary">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
      </svg>
      Retour à l'accueil
    </a>
    <a href="javascript:history.back()" class="err-btn err-btn--ghost">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
      </svg>
      Page précédente
    </a>
  </div>
@endsection
