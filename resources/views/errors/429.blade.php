@extends('errors.layout')

@section('title', '429 — Trop de requêtes')

@section('content')
  <span class="err-icon">⚡</span>
  <div class="err-code">429</div>
  <div class="err-divider"></div>
  <h1 class="err-title">Trop de requêtes</h1>
  <p class="err-desc">
    Vous avez effectué trop d'actions en peu de temps.<br>
    Merci de patienter quelques instants avant de réessayer.
  </p>
  <div class="err-actions">
    <a href="javascript:location.reload()" class="err-btn err-btn--primary">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
      </svg>
      Réessayer
    </a>
    <a href="/" class="err-btn err-btn--ghost">Accueil</a>
  </div>
@endsection
