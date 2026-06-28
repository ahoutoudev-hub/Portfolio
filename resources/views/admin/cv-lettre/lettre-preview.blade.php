@extends('layouts_admin.master_admin')
@section('title', 'Aperçu lettre · ' . $lettre->poste)

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Lettre de motivation</div>
    <h4 class="page-title mb-1">{{ $lettre->poste }} — {{ $lettre->entreprise }}</h4>
    <p class="text-muted small mb-0">
      {{ $lettre->type_contrat_label }} · {{ $lettre->date_lettre->translatedFormat('d F Y') }}
    </p>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.cv-lettre.index') }}" class="btn-hd-back">
      ← Retour
    </a>
    <a href="{{ route('admin.cv-lettre.lettre.download', $lettre) }}" class="btn-cv-download">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
      </svg>
      Télécharger PDF
    </a>
  </div>
</div>

<div class="lettre-preview-wrap">
  <div class="lettre-preview-shadow">
    <iframe src="{{ route('admin.cv-lettre.lettre.pdf-view', $lettre) }}"
      style="width:100%;height:1050px;border:none;background:#fff">
    </iframe>
  </div>
</div>

@endsection

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;cursor:pointer;transition:all var(--transition);text-decoration:none;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}
.btn-cv-download{display:inline-flex;align-items:center;gap:7px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.82rem;padding:9px 18px;border-radius:9px;text-decoration:none;transition:all var(--transition);box-shadow:0 3px 10px rgba(255,124,8,.3)}
.btn-cv-download:hover{background:var(--primary-dark);color:#fff}
.lettre-preview-wrap{max-width:860px;margin:0 auto}
.lettre-preview-shadow{box-shadow:0 8px 40px rgba(0,0,0,.18);border-radius:4px;overflow:hidden;border:1px solid #ddd}
</style>
@endpush
