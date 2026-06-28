@extends('layouts_admin.master_admin')
@section('title', 'Mon profil')

@section('content')

{{-- En-tête --}}
<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">Compte</div>
    <h4 class="page-title mb-1">Mon profil</h4>
    <p class="text-muted small mb-0">Gérez vos informations personnelles et votre sécurité.</p>
  </div>
  <a href="{{ route('TableauDeBord') }}" class="btn-hd-back">
    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
    </svg>
    Tableau de bord
  </a>
</div>

<div class="row g-4">

  {{-- ══ COLONNE GAUCHE ══ --}}
  <div class="col-lg-4">

    {{-- Card avatar --}}
    <div class="f-card mb-4">
      <div class="f-card-head">
        <span class="f-card-ico"><i class="bi bi-image-fill"></i></span>
        <span class="f-card-titre">Photo de profil</span>
      </div>
      <div class="f-card-body text-center">

        {{-- Aperçu avatar --}}
        <div class="avatar-wrap" id="avatarWrap">
          @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}"
              alt="{{ $user->prenom }}"
              class="avatar-img" id="avatarImg">
          @else
            <div class="avatar-initiales" id="avatarInitiales">
              {{ $user->initiales }}
            </div>
          @endif
          <div class="avatar-overlay" onclick="document.getElementById('avatarInput').click()">
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
        </div>

        <div class="avatar-name mt-3">{{ $user->prenom }} {{ $user->nom }}</div>
        <div class="avatar-role">{{ $user->poste_actuel ?: 'Administrateur' }}</div>

        {{-- Formulaire upload avatar --}}
        <form method="POST"
          action="{{ route('profil.avatar') }}"
          enctype="multipart/form-data"
          id="avatarForm">
          @csrf
          <input type="file" name="avatar" id="avatarInput"
            accept="image/jpeg,image/png,image/webp"
            class="d-none"
            onchange="previewAvatar(this); this.form.submit()">
        </form>

        @if($user->avatar)
          <form method="POST" action="{{ route('profil.avatar.delete') }}" style="margin-top:10px">
            @csrf @method('DELETE')
            <button type="submit" class="btn-del-avatar">
              <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
              </svg>
              Supprimer la photo
            </button>
          </form>
        @endif

        <p class="avatar-hint">JPG, PNG, WEBP · max 2 Mo<br>Cliquez sur la photo pour changer</p>

      </div>
    </div>

    {{-- CV --}}
    <div class="f-card mb-4">
      <div class="f-card-head">
        <span class="f-card-ico"><i class="bi bi-file-earmark-person-fill"></i></span>
        <span class="f-card-titre">Mon CV</span>
        @if($user->cv)
          <span class="cv-badge-ok">PDF importé</span>
        @endif
      </div>
      <div class="f-card-body">

        @if($user->cv)
          {{-- CV existant --}}
          <div class="cv-current">
            <div class="cv-current-ico"><i class="bi bi-file-earmark-person-fill"></i></div>
            <div class="cv-current-info">
              <div class="cv-current-nom">
                CV_{{ str_replace(' ', '_', $user->nom_complet) }}.pdf
              </div>
              <div class="cv-current-size">PDF · Disponible au téléchargement</div>
            </div>
          </div>
          <div class="cv-actions mt-3">
            <a href="{{ route('profil.cv.download') }}" class="cv-btn-download">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              Télécharger
            </a>
            <form method="POST"
              action="{{ route('profil.cv.upload') }}"
              enctype="multipart/form-data"
              id="cvUploadFormReplace"
              style="flex:1">
              @csrf
              <label class="cv-btn-replace">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Remplacer
                <input type="file" name="cv" accept=".pdf"
                  class="d-none" onchange="this.form.submit()">
              </label>
            </form>
            <form method="POST" action="{{ route('profil.cv.delete') }}" style="margin:0">
              @csrf @method('DELETE')
              <button type="submit" class="cv-btn-del" title="Supprimer le CV"
                onclick="return confirm('Supprimer le CV ?')">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
              </button>
            </form>
          </div>

        @else
          {{-- Zone upload --}}
          <form method="POST"
            action="{{ route('profil.cv.upload') }}"
            enctype="multipart/form-data"
            id="cvUploadForm">
            @csrf
            <div class="cv-upload-zone" id="cvUploadZone">
              <input type="file" name="cv" id="cvInput" accept=".pdf"
                class="cv-upload-input @error('cv') f-input--err @enderror"
                onchange="handleCvChange(this)">
              <div class="cv-upload-body">
                <div class="cv-upload-ico">
                  <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
                <p class="cv-upload-txt">
                  Glissez votre CV ou
                  <span class="cv-upload-browse">cliquez pour importer</span>
                </p>
                <p class="cv-upload-hint">PDF uniquement · max 5 Mo</p>
              </div>
            </div>
            @error('cv')
              <p class="f-err-msg mt-2">{{ $message }}</p>
            @enderror
            <div id="cvPreviewWrap" style="display:none" class="cv-preview-selected">
              <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="var(--danger)" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span id="cvFileName" class="cv-preview-name"></span>
              <button type="submit" class="cv-btn-import">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Importer
              </button>
            </div>
          </form>
        @endif

      </div>
    </div>

    {{-- Disponibilité --}}
    <div class="f-card">
      <div class="f-card-head">
        <span class="f-card-ico"><i class="bi bi-broadcast-pin"></i></span>
        <span class="f-card-titre">Statut</span>
      </div>
      <div class="f-card-body">
        <div class="dispo-badge {{ $user->disponible ? 'dispo-badge--on' : 'dispo-badge--off' }}">
          @if($user->disponible)
            <span class="dispo-dot"></span>
            Disponible pour de nouveaux projets
          @else
            <span class="dispo-dot dispo-dot--off"></span>
            Non disponible actuellement
          @endif
        </div>
        <p class="f-hint mt-2">Modifiable depuis les informations ci-contre.</p>
      </div>
    </div>

  </div>

  {{-- ══ COLONNE DROITE ══ --}}
  <div class="col-lg-8">

    {{-- Onglets --}}
    <div class="profil-tabs mb-4">
      <button class="profil-tab profil-tab--active" onclick="switchTab('infos', this)">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Informations
      </button>
      <button class="profil-tab" onclick="switchTab('password', this)">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <rect x="3" y="11" width="18" height="11" rx="2"/>
          <path stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
        Mot de passe
      </button>
    </div>

    {{-- ── TAB : Informations ── --}}
    <div id="tab-infos">
      <form method="POST" action="{{ route('profil.infos') }}" novalidate>
        @csrf @method('PUT')

        {{-- Identité --}}
        <div class="f-card mb-4">
          <div class="f-card-head">
            <span class="f-card-ico"><i class="bi bi-person-fill"></i></span>
            <span class="f-card-titre">Identité</span>
          </div>
          <div class="f-card-body">

            <div class="f-field-row">
              <div class="f-field">
                <label class="f-label">Prénom <span class="f-req">*</span></label>
                <input type="text" name="prenom"
                  class="f-input @error('prenom') f-input--err @enderror"
                  value="{{ old('prenom', $user->prenom) }}" required>
                @error('prenom')<p class="f-err-msg">{{ $message }}</p>@enderror
              </div>
              <div class="f-field">
                <label class="f-label">Nom <span class="f-req">*</span></label>
                <input type="text" name="nom"
                  class="f-input @error('nom') f-input--err @enderror"
                  value="{{ old('nom', $user->nom) }}" required>
                @error('nom')<p class="f-err-msg">{{ $message }}</p>@enderror
              </div>
            </div>

            <div class="f-field">
              <label class="f-label">Adresse e-mail <span class="f-req">*</span></label>
              <div class="f-input-ico-wrap">
                <svg class="f-input-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <input type="email" name="email"
                  class="f-input f-input-with-ico @error('email') f-input--err @enderror"
                  value="{{ old('email', $user->email) }}" required>
              </div>
              @error('email')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="f-field-row">
              <div class="f-field">
                <label class="f-label">Téléphone</label>
                <div class="f-input-ico-wrap">
                  <svg class="f-input-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                  </svg>
                  <input type="tel" name="telephone"
                    class="f-input f-input-with-ico"
                    placeholder="+225 07 00 00 00"
                    value="{{ old('telephone', $user->telephone) }}">
                </div>
              </div>
              <div class="f-field">
                <label class="f-label">Poste actuel</label>
                <input type="text" name="poste_actuel"
                  class="f-input"
                  placeholder="Ex : Développeur Full-Stack"
                  value="{{ old('poste_actuel', $user->poste_actuel) }}">
              </div>
            </div>

            <div class="f-field-row">
              <div class="f-field">
                <label class="f-label">Ville</label>
                <input type="text" name="ville"
                  class="f-input"
                  placeholder="Abidjan"
                  value="{{ old('ville', $user->ville) }}">
              </div>
              <div class="f-field mb-0">
                <label class="f-label">Pays</label>
                <input type="text" name="pays"
                  class="f-input"
                  placeholder="Côte d'Ivoire"
                  value="{{ old('pays', $user->pays) }}">
              </div>
            </div>

          </div>
        </div>

        {{-- Biographie --}}
        <div class="f-card mb-4">
          <div class="f-card-head">
            <span class="f-card-ico"><i class="bi bi-file-text-fill"></i></span>
            <span class="f-card-titre">Biographie</span>
            <span class="f-card-head-hint">affichée sur le portfolio</span>
          </div>
          <div class="f-card-body">
            <input type="hidden" name="biographie" id="profil_biographie"
              value="{{ old('biographie', $user->biographie) }}">
            <div data-quill-target="profil_biographie"
              data-placeholder="Parlez de vous, de votre parcours et de vos passions..."></div>
            <p class="f-hint mt-2">Ce texte sera affiché dans la section "À propos" de votre portfolio.</p>
          </div>
        </div>

        {{-- Disponibilité --}}
        <div class="f-card mb-4">
          <div class="f-card-head">
            <span class="f-card-ico"><i class="bi bi-broadcast-pin"></i></span>
            <span class="f-card-titre">Disponibilité</span>
          </div>
          <div class="f-card-body">
            <div class="f-toggle-row">
              <div>
                <div class="f-toggle-label">
                  <span class="dispo-mini-dot {{ $user->disponible ? '' : 'dispo-mini-dot--off' }}" id="dispoMiniDot"></span>
                  Disponible pour de nouveaux projets
                </div>
                <div class="f-toggle-hint">Affiche un badge "Disponible" sur votre portfolio</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="disponible" value="0">
                <input type="checkbox" name="disponible" value="1"
                  id="disponibleToggle"
                  {{ old('disponible', $user->disponible) ? 'checked' : '' }}
                  onchange="updateDispoBadge(this.checked)">
                <span class="f-toggle-track"><span class="f-toggle-thumb"></span></span>
              </label>
            </div>
          </div>
        </div>

        <button type="submit" class="f-btn-submit">
          <i class="bi bi-floppy-fill"></i> Enregistrer les modifications
        </button>

      </form>
    </div>

    {{-- ── TAB : Mot de passe ── --}}
    <div id="tab-password" style="display:none">
      <div class="f-card">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-shield-lock-fill"></i></span>
          <span class="f-card-titre">Changer le mot de passe</span>
        </div>
        <div class="f-card-body">
          <form method="POST" action="{{ route('profil.password') }}" novalidate>
            @csrf @method('PUT')

            <div class="f-field">
              <label class="f-label">Mot de passe actuel <span class="f-req">*</span></label>
              <div class="f-input-pwd-wrap">
                <input type="password" name="current_password" id="currentPwd"
                  class="f-input @error('current_password') f-input--err @enderror"
                  placeholder="••••••••" autocomplete="current-password">
                <button type="button" class="f-pwd-toggle" onclick="togglePwd('currentPwd', this)">
                  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
              @error('current_password')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="f-field">
              <label class="f-label">Nouveau mot de passe <span class="f-req">*</span></label>
              <div class="f-input-pwd-wrap">
                <input type="password" name="password" id="newPwd"
                  class="f-input @error('password') f-input--err @enderror"
                  placeholder="••••••••" autocomplete="new-password"
                  oninput="checkStrength(this.value)">
                <button type="button" class="f-pwd-toggle" onclick="togglePwd('newPwd', this)">
                  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
              {{-- Indicateur de force --}}
              <div class="pwd-strength-bar mt-2" id="pwdStrengthBar">
                <div class="pwd-strength-fill" id="pwdStrengthFill"></div>
              </div>
              <p class="pwd-strength-label" id="pwdStrengthLabel"></p>
              @error('password')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>

            <div class="f-field mb-0">
              <label class="f-label">Confirmer le nouveau mot de passe <span class="f-req">*</span></label>
              <div class="f-input-pwd-wrap">
                <input type="password" name="password_confirmation" id="confirmPwd"
                  class="f-input"
                  placeholder="••••••••" autocomplete="new-password">
                <button type="button" class="f-pwd-toggle" onclick="togglePwd('confirmPwd', this)">
                  <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </button>
              </div>
            </div>

            <div class="pwd-rules mt-3">
              <p class="pwd-rules-title">Le mot de passe doit contenir :</p>
              <ul class="pwd-rules-list">
                <li id="rule-len"  class="pwd-rule">Au moins 8 caractères</li>
                <li id="rule-upper" class="pwd-rule">Une lettre majuscule</li>
                <li id="rule-num"  class="pwd-rule">Un chiffre</li>
              </ul>
            </div>

            <button type="submit" class="f-btn-submit mt-4">
              <i class="bi bi-shield-lock-fill"></i> Changer le mot de passe
            </button>

          </form>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection

@push('styles')
<style>
/* ── Page header ── */
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border);text-decoration:none;transition:all var(--transition)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}

/* ── Avatar ── */
.avatar-wrap{position:relative;width:110px;height:110px;border-radius:50%;margin:0 auto;cursor:pointer}
.avatar-img{width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid var(--primary);box-shadow:0 4px 16px rgba(255,124,8,.25)}
.avatar-initiales{width:110px;height:110px;border-radius:50%;background:linear-gradient(135deg,var(--primary),#ffb347);display:flex;align-items:center;justify-content:center;font-family:var(--font-display);font-weight:800;font-size:2rem;color:#fff;box-shadow:0 4px 16px rgba(255,124,8,.25)}
.avatar-overlay{position:absolute;inset:0;border-radius:50%;background:rgba(0,0,0,.45);display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity var(--transition)}
.avatar-wrap:hover .avatar-overlay{opacity:1}
.avatar-name{font-family:var(--font-display);font-size:1rem;font-weight:800;color:var(--dark)}
.avatar-role{font-size:.78rem;color:var(--muted);margin-top:2px}
.avatar-hint{font-size:.72rem;color:var(--muted);margin-top:10px;line-height:1.6}
.btn-del-avatar{display:inline-flex;align-items:center;gap:5px;background:rgba(239,68,68,.08);color:var(--danger);font-family:var(--font-display);font-size:.74rem;font-weight:700;padding:6px 12px;border-radius:8px;border:1px solid rgba(239,68,68,.2);cursor:pointer;transition:all var(--transition)}
.btn-del-avatar:hover{background:rgba(239,68,68,.15)}

/* ── Disponibilité ── */
.dispo-badge{display:flex;align-items:center;gap:9px;padding:10px 14px;border-radius:9px;font-family:var(--font-display);font-size:.82rem;font-weight:600}
.dispo-badge--on{background:rgba(16,185,129,.1);color:var(--success);border:1px solid rgba(16,185,129,.2)}
.dispo-badge--off{background:rgba(156,163,175,.1);color:var(--muted);border:1px solid var(--border)}
.dispo-dot{width:8px;height:8px;border-radius:50%;background:var(--success);animation:dispoPulse 1.8s infinite;flex-shrink:0}
.dispo-dot--off{background:var(--muted);animation:none}
.dispo-mini-dot{display:inline-block;width:7px;height:7px;border-radius:50%;background:var(--success);margin-right:5px;animation:dispoPulse 1.8s infinite;vertical-align:middle}
.dispo-mini-dot--off{background:var(--muted);animation:none}
@keyframes dispoPulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.35)}}

/* ── Onglets profil ── */
.profil-tabs{display:flex;gap:4px;background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:5px;box-shadow:var(--shadow)}
.profil-tab{display:inline-flex;align-items:center;gap:7px;flex:1;justify-content:center;padding:9px 16px;border-radius:9px;font-family:var(--font-display);font-weight:700;font-size:.83rem;color:var(--muted);border:none;background:transparent;cursor:pointer;transition:all var(--transition)}
.profil-tab:hover{background:var(--gray-bg);color:var(--text)}
.profil-tab--active{background:var(--dark);color:#fff}

/* ── Cards ── */
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:13px 18px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:.95rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.87rem;font-weight:700;color:var(--dark)}
.f-card-head-hint{font-size:.72rem;color:var(--muted);margin-left:3px}
.f-card-body{padding:18px}
.f-field{margin-bottom:16px}
.f-field.mb-0{margin-bottom:0}
.f-field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-req{color:var(--primary)}
.f-hint{font-size:.73rem;color:var(--muted);margin-bottom:0}
.f-err-msg{font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition)}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.f-input--err{border-color:var(--danger)!important}
.f-textarea{resize:vertical;min-height:100px}
.f-input-ico-wrap{position:relative}
.f-input-ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none}
.f-input-with-ico{padding-left:38px}

/* Toggle */
.f-toggle-row{display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 14px}
.f-toggle-label{font-family:var(--font-body);font-size:.87rem;font-weight:600;color:var(--dark);display:flex;align-items:center}
.f-toggle-hint{font-size:.74rem;color:var(--muted);margin-top:1px}
.f-toggle{flex-shrink:0;cursor:pointer}
.f-toggle input{display:none}
.f-toggle-track{display:block;width:44px;height:25px;border-radius:99px;background:var(--border);position:relative;transition:background var(--transition)}
.f-toggle-thumb{position:absolute;width:19px;height:19px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform var(--transition);box-shadow:0 1px 4px rgba(0,0,0,.2)}
.f-toggle input:checked + .f-toggle-track{background:var(--success)}
.f-toggle input:checked + .f-toggle-track .f-toggle-thumb{transform:translateX(19px)}

/* Bouton submit */
.f-btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px);box-shadow:0 8px 22px rgba(255,124,8,.45)}

/* ── Mot de passe ── */
.f-input-pwd-wrap{position:relative}
.f-input-pwd-wrap .f-input{padding-right:44px}
.f-pwd-toggle{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;padding:4px;display:flex;align-items:center;transition:color var(--transition)}
.f-pwd-toggle:hover{color:var(--primary)}

/* Force du mot de passe */
.pwd-strength-bar{height:5px;background:var(--border);border-radius:99px;overflow:hidden}
.pwd-strength-fill{height:100%;border-radius:99px;width:0;transition:width .4s ease, background .4s ease}
.pwd-strength-label{font-size:.74rem;font-weight:600;margin-top:4px;margin-bottom:0}

/* Règles */
.pwd-rules{background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 16px}
.pwd-rules-title{font-size:.78rem;font-weight:600;color:var(--text);margin-bottom:6px}
.pwd-rules-list{margin:0;padding-left:16px;list-style:none}
.pwd-rule{font-size:.78rem;color:var(--muted);padding:2px 0;transition:color var(--transition)}
.pwd-rule::before{content:'○ ';opacity:.5}
.pwd-rule.ok{color:var(--success)}
.pwd-rule.ok::before{content:'✓ ';opacity:1}


/* ── CV ── */
.cv-badge-ok{background:rgba(16,185,129,.12);color:var(--success);font-family:var(--font-display);font-size:.66rem;font-weight:700;padding:2px 8px;border-radius:99px;margin-left:auto}
.cv-current{display:flex;align-items:center;gap:12px;background:rgba(239,68,68,.05);border:1px solid rgba(239,68,68,.15);border-radius:10px;padding:14px}
.cv-current-ico{font-size:2rem;line-height:1;flex-shrink:0}
.cv-current-nom{font-family:var(--font-display);font-size:.85rem;font-weight:700;color:var(--dark);margin-bottom:2px}
.cv-current-size{font-size:.74rem;color:var(--muted)}
.cv-actions{display:flex;align-items:center;gap:8px}
.cv-btn-download{display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.8rem;padding:9px 16px;border-radius:9px;text-decoration:none;box-shadow:0 3px 10px rgba(255,124,8,.3);transition:all var(--transition)}
.cv-btn-download:hover{background:var(--primary-dark);color:#fff;transform:translateY(-1px)}
.cv-btn-replace{display:flex;align-items:center;justify-content:center;gap:6px;width:100%;background:var(--gray-bg);color:var(--text);font-family:var(--font-display);font-weight:700;font-size:.8rem;padding:9px 14px;border-radius:9px;border:1.5px solid var(--border);cursor:pointer;transition:all var(--transition)}
.cv-btn-replace:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-light)}
.cv-btn-del{width:36px;height:36px;border-radius:9px;background:rgba(239,68,68,.08);color:var(--danger);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all var(--transition);flex-shrink:0}
.cv-btn-del:hover{background:rgba(239,68,68,.18)}
.cv-upload-zone{border:2px dashed var(--border);border-radius:var(--radius);padding:28px 20px;text-align:center;cursor:pointer;position:relative;transition:all var(--transition)}
.cv-upload-zone:hover,.cv-upload-zone.cv-drag-active{border-color:var(--primary);background:var(--primary-light)}
.cv-upload-input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.cv-upload-body{pointer-events:none}
.cv-upload-ico{width:52px;height:52px;border-radius:14px;background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.15);color:var(--danger);display:flex;align-items:center;justify-content:center;margin:0 auto 12px}
.cv-upload-zone:hover .cv-upload-ico,.cv-upload-zone.cv-drag-active .cv-upload-ico{background:rgba(255,124,8,.1);border-color:rgba(255,124,8,.3);color:var(--primary)}
.cv-upload-txt{font-size:.88rem;color:var(--text);margin-bottom:4px}
.cv-upload-browse{color:var(--primary);font-weight:700}
.cv-upload-hint{font-size:.74rem;color:var(--muted);margin:0}
.cv-preview-selected{display:flex;align-items:center;gap:10px;margin-top:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:10px 14px}
.cv-preview-name{flex:1;font-family:'Courier New',monospace;font-size:.78rem;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.cv-btn-import{display:inline-flex;align-items:center;gap:5px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.78rem;padding:7px 14px;border-radius:8px;border:none;cursor:pointer;transition:all var(--transition);flex-shrink:0}
.cv-btn-import:hover{background:var(--primary-dark)}
@media(max-width:576px){.f-field-row{grid-template-columns:1fr}}
</style>
@endpush

@push('scripts')
<script>
/* ── Switcher onglets ── */
function switchTab(tab, btn) {
  ['infos','password'].forEach(t => {
    document.getElementById('tab-' + t).style.display = t === tab ? 'block' : 'none';
  });
  document.querySelectorAll('.profil-tab').forEach(b => b.classList.remove('profil-tab--active'));
  btn.classList.add('profil-tab--active');
}

// Afficher onglet password si erreur dans ce tab
@if($errors->has('current_password') || $errors->has('password'))
  switchTab('password', document.querySelectorAll('.profil-tab')[1]);
@endif

/* ── Toggle visibilité mot de passe ── */
function togglePwd(id, btn) {
  const input = document.getElementById(id);
  const show  = input.type === 'password';
  input.type = show ? 'text' : 'password';
  btn.style.color = show ? 'var(--primary)' : 'var(--muted)';
}

/* ── Force du mot de passe ── */
function checkStrength(val) {
  const bar   = document.getElementById('pwdStrengthFill');
  const label = document.getElementById('pwdStrengthLabel');
  const rLen   = document.getElementById('rule-len');
  const rUpper = document.getElementById('rule-upper');
  const rNum   = document.getElementById('rule-num');

  const hasLen   = val.length >= 8;
  const hasUpper = /[A-Z]/.test(val);
  const hasNum   = /\d/.test(val);
  const hasSpec  = /[^A-Za-z0-9]/.test(val);

  rLen.classList.toggle('ok',   hasLen);
  rUpper.classList.toggle('ok', hasUpper);
  rNum.classList.toggle('ok',   hasNum);

  const score = [hasLen, hasUpper, hasNum, hasSpec, val.length >= 12].filter(Boolean).length;

  const levels = [
    { w: '0%',   bg: 'transparent', txt: '',              clr: '' },
    { w: '25%',  bg: 'var(--danger)',  txt: 'Très faible', clr: 'var(--danger)' },
    { w: '50%',  bg: 'var(--warning)', txt: 'Faible',      clr: 'var(--warning)' },
    { w: '75%',  bg: '#f97316',        txt: 'Moyen',       clr: '#f97316' },
    { w: '90%',  bg: 'var(--success)', txt: 'Fort',        clr: 'var(--success)' },
    { w: '100%', bg: 'var(--success)', txt: 'Très fort',   clr: 'var(--success)' },
  ];

  const l = levels[Math.min(score, 5)];
  bar.style.width      = val ? l.w : '0%';
  bar.style.background = l.bg;
  label.textContent    = val ? l.txt : '';
  label.style.color    = l.clr;
}

/* ── Disponibilité ── */
function updateDispoBadge(checked) {
  const dot = document.getElementById('dispoMiniDot');
  if (dot) dot.classList.toggle('dispo-mini-dot--off', !checked);
}

/* ── Prévisualiser avatar avant upload ── */
function previewAvatar(input) {
  if (!input.files?.[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const wrap = document.getElementById('avatarWrap');
    let img = document.getElementById('avatarImg');
    if (!img) {
      wrap.innerHTML = '';
      img = document.createElement('img');
      img.id        = 'avatarImg';
      img.className = 'avatar-img';
      const overlay = document.createElement('div');
      overlay.className = 'avatar-overlay';
      overlay.onclick   = () => document.getElementById('avatarInput').click();
      overlay.innerHTML = `<svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`;
      wrap.appendChild(img);
      wrap.appendChild(overlay);
    }
    img.src = e.target.result;
  };
  reader.readAsDataURL(input.files[0]);
}

/* ── CV drag & drop + prévisualisation ── */
function handleCvChange(input) {
  if (!input.files?.[0]) return;
  const file = input.files[0];
  if (file.type !== 'application/pdf') {
    if (window.showToast) window.showToast('Seuls les fichiers PDF sont acceptés.', 'error');
    input.value = ''; return;
  }
  if (file.size > 5 * 1024 * 1024) {
    if (window.showToast) window.showToast('Le fichier ne doit pas dépasser 5 Mo.', 'error');
    input.value = ''; return;
  }
  document.getElementById('cvFileName').textContent      = file.name;
  document.getElementById('cvPreviewWrap').style.display = 'flex';
  const z = document.getElementById('cvUploadZone');
  if (z) { z.style.borderColor = 'var(--primary)'; z.style.background = 'var(--primary-light)'; }
}
const cvZone = document.getElementById('cvUploadZone');
if (cvZone) {
  cvZone.addEventListener('dragover',  e => { e.preventDefault(); cvZone.classList.add('cv-drag-active'); });
  cvZone.addEventListener('dragleave', ()  => cvZone.classList.remove('cv-drag-active'));
  cvZone.addEventListener('drop',      e  => {
    e.preventDefault(); cvZone.classList.remove('cv-drag-active');
    const file = e.dataTransfer.files[0];
    if (file?.type === 'application/pdf') {
      const dt = new DataTransfer(); dt.items.add(file);
      const inp = document.getElementById('cvInput');
      inp.files = dt.files; handleCvChange(inp);
    } else {
      if (window.showToast) window.showToast('Seuls les fichiers PDF sont acceptés.', 'error');
    }
  });
}
</script>
@endpush