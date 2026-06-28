@extends('layouts_admin.master_admin')
@section('title', isset($projet) ? 'Modifier · ' . $projet->titre : 'Nouveau projet')

@section('content')
@php $isEdit = isset($projet); @endphp

<div class="d-flex align-items-start justify-content-between mb-5 flex-wrap gap-3">
  <div>
    <div class="page-eyebrow">{{ $isEdit ? 'Modifier le projet' : 'Nouveau projet' }}</div>
    <h4 class="page-title mb-1">{{ $isEdit ? $projet->titre : 'Créer un projet' }}</h4>
    <p class="text-muted small mb-0">
      {{ $isEdit ? 'Mettez à jour les informations de ce projet.' : 'Remplissez les informations du nouveau projet.' }}
    </p>
  </div>
  <div class="d-flex gap-2 align-items-center">
    <button type="button" class="btn-hd-preview" onclick="openPreview()">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
      </svg>
      Aperçu
    </button>
    <a href="{{ route('projets.index') }}" class="btn-hd-back">
      <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7"/>
      </svg>
      Retour
    </a>
  </div>
</div>

<form method="POST"
  action="{{ $isEdit ? route('projets.update', $projet) : route('projets.store') }}"
  enctype="multipart/form-data"
  id="projetForm"
  novalidate>
  @csrf
  @if($isEdit) @method('PUT') @endif

  <div class="row g-4">

    {{-- ══════════ COLONNE GAUCHE ══════════ --}}
    <div class="col-lg-8">

      {{-- Infos générales --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-clipboard-fill"></i></span>
          <span class="f-card-titre">Informations générales</span>
        </div>
        <div class="f-card-body">
          <div class="f-field">
            <label class="f-label">Titre <span class="f-req">*</span></label>
            <input type="text" name="titre" id="titre"
              class="f-input @error('titre') f-input--err @enderror"
              placeholder="Ex : Application E-commerce"
              value="{{ old('titre', $projet->titre ?? '') }}"
              oninput="autoSlug(this.value)" required>
            @error('titre')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field">
            <label class="f-label">Slug (URL)</label>
            <div class="f-slug-wrap">
              <span class="f-slug-prefix">/projets/</span>
              <input type="text" name="slug" id="slug"
                class="f-input f-slug-input @error('slug') f-input--err @enderror"
                placeholder="application-e-commerce"
                value="{{ old('slug', $projet->slug ?? '') }}">
            </div>
            @error('slug')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>

          <div class="f-field mb-0">
            <label class="f-label">
              Description courte
              <span class="f-label-hint">(affichée dans la liste des projets)</span>
            </label>
            <input type="hidden" name="description" id="proj_description"
              value="{{ old('description', $projet->description ?? '') }}">
            <div data-quill-target="proj_description"
              data-placeholder="Résumé du projet en quelques lignes..."></div>
            @error('description')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Contenu riche --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-file-text-fill"></i></span>
          <span class="f-card-titre">Contenu détaillé</span>
          <span class="f-card-head-hint">affiché en page détail</span>
        </div>
        <div class="f-card-body">
          <textarea name="contenu" id="contenu"
            class="@error('contenu') f-input--err @enderror"
            style="visibility:hidden">{{ old('contenu', $projet->contenu ?? '') }}</textarea>
          @error('contenu')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

      {{-- ✨ NOUVEAU : Fonctionnalités --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-lightning-charge-fill"></i></span>
          <span class="f-card-titre">Fonctionnalités principales</span>
          <span class="f-card-head-hint">affichées en page détail</span>
        </div>
        <div class="f-card-body">
          <p class="f-hint mb-3">Ajoutez les fonctionnalités clés du projet (une par ligne).</p>
          <div id="fonctionnalitesList">
            @php
              $fonctionnalites = old('fonctionnalites', $projet->fonctionnalites ?? []);
              if (empty($fonctionnalites)) $fonctionnalites = [''];
            @endphp
            @foreach($fonctionnalites as $i => $feat)
              <div class="f-list-item" id="feat-{{ $i }}">
                <div class="f-list-item-ico"><i class="bi bi-check-lg"></i></div>
                <input type="text" name="fonctionnalites[]"
                  class="f-input f-list-input"
                  placeholder="Ex : Gestion des stocks en temps réel"
                  value="{{ $feat }}">
                <button type="button" class="f-list-remove"
                  onclick="removeItem(this.closest('.f-list-item'))">
                  <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                  </svg>
                </button>
              </div>
            @endforeach
          </div>
          <button type="button" class="f-list-add" onclick="addFonctionnalite()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter une fonctionnalité
          </button>
        </div>
      </div>

      {{-- ✨ NOUVEAU : Défis & Solutions --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-tools"></i></span>
          <span class="f-card-titre">Défis & Solutions</span>
          <span class="f-card-head-hint">optionnel</span>
        </div>
        <div class="f-card-body">
          <p class="f-hint mb-3">Décrivez les défis techniques rencontrés et les solutions apportées.</p>
          <div id="defisList">
            @php
              $defis = old('defis_challenge', []);
              if ($isEdit && empty($defis)) {
                $defis = collect($projet->defis ?? [])->pluck('challenge')->toArray();
                $solutions = collect($projet->defis ?? [])->pluck('solution')->toArray();
              }
              if (empty($defis)) { $defis = ['']; $solutions = ['']; }
            @endphp
            @foreach($defis as $i => $defi)
              <div class="f-defi-item" id="defi-{{ $i }}">
                <div class="f-defi-header">
                  <span class="f-defi-num">{{ $i + 1 }}</span>
                  <button type="button" class="f-list-remove ms-auto"
                    onclick="removeItem(this.closest('.f-defi-item'))">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                  </button>
                </div>
                <div class="f-defi-fields">
                  <div class="f-field mb-0">
                    <label class="f-label">
                      <span class="f-defi-badge f-defi-badge--challenge">Défi</span>
                    </label>
                    <input type="text" name="defis_challenge[]"
                      class="f-input"
                      placeholder="Ex : Gestion des stocks lors de commandes simultanées"
                      value="{{ $defi }}">
                  </div>
                  <div class="f-field mb-0 mt-2">
                    <label class="f-label">
                      <span class="f-defi-badge f-defi-badge--solution">Solution</span>
                    </label>
                    <input type="text" name="defis_solution[]"
                      class="f-input"
                      placeholder="Ex : Transactions Laravel avec mécanisme de verrouillage"
                      value="{{ $solutions[$i] ?? '' }}">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
          <button type="button" class="f-list-add" onclick="addDefi()">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Ajouter un défi
          </button>
        </div>
      </div>

      {{-- Image de couverture --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-image-fill"></i></span>
          <span class="f-card-titre">Image de couverture</span>
        </div>
        <div class="f-card-body">
          @if($isEdit && $projet->image)
            <div class="f-img-current" id="currentImgWrap">
              <img src="{{ asset('storage/' . $projet->image) }}"
                alt="{{ $projet->titre }}" id="imgPreview" class="f-img-preview">
              <label class="f-img-remove">
                <input type="checkbox" name="supprimer_image" value="1"
                  id="supprimerImage" onchange="toggleCurrentImg(this)">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <polyline points="3 6 5 6 21 6"/>
                  <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Supprimer l'image actuelle
              </label>
            </div>
          @endif
          <div id="newImgPreviewWrap" style="display:none" class="f-img-current">
            <img id="newImgPreview" src="" alt="Nouvelle image" class="f-img-preview">
            <button type="button" class="f-img-remove" onclick="clearImageInput()"
              style="border:none;background:none;cursor:pointer">
              <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
              </svg>
              Retirer
            </button>
          </div>
          <div class="f-upload" id="uploadZone">
            <input type="file" name="image" id="imageInput"
              accept="image/jpeg,image/png,image/webp"
              class="f-upload-input @error('image') f-input--err @enderror"
              onchange="handleImageChange(this)">
            <div class="f-upload-body">
              <div class="f-upload-ico">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
              <p class="f-upload-txt">Glissez une image ou <span class="f-upload-browse">parcourir</span></p>
              <p class="f-upload-hint">JPG, PNG, WEBP · max 2 Mo</p>
            </div>
          </div>
          @error('image')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
        </div>
      </div>
      

      {{-- ══ SECTION GALERIE ══ --}}
{{-- À insérer dans projets_form.blade.php, après la card "Image de couverture" --}}
 
<div class="f-card mb-4">
  <div class="f-card-head">
    <span class="f-card-ico"><i class="bi bi-camera-fill"></i></span>
    <span class="f-card-titre">Galerie d'images</span>
    <span class="f-card-head-hint">affichées en page détail</span>
  </div>
  <div class="f-card-body">
 
    {{-- Images existantes (mode édition) --}}
    @if($isEdit && $projet->images->isNotEmpty())
      <div class="galerie-existing" id="galerieExisting">
        <p class="f-hint mb-2">Images actuelles — cochez pour supprimer :</p>
        <div class="galerie-grid" id="galerieGrid">
          @foreach($projet->images as $img)
            <div class="galerie-item" id="galerie-img-{{ $img->id }}">
              <img src="{{ asset('storage/' . $img->image) }}"
                alt="{{ $img->legende ?? '' }}"
                class="galerie-thumb">
              <div class="galerie-item-body">
                <input type="text"
                  name="galerie_legendes[{{ $img->id }}]"
                  class="f-input galerie-legende-input"
                  placeholder="Légende (optionnel)"
                  value="{{ $img->legende ?? '' }}">
                <label class="galerie-delete-label">
                  <input type="checkbox"
                    name="galerie_supprimer[]"
                    value="{{ $img->id }}"
                    onchange="markForDeletion(this, 'galerie-img-{{ $img->id }}')">
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path stroke-linecap="round" d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                  </svg>
                  Supprimer
                </label>
              </div>
            </div>
          @endforeach
        </div>
        <div class="galerie-divider">
          <span>Ajouter de nouvelles images</span>
        </div>
      </div>
    @endif
 
    {{-- Aperçu nouvelles images (JS) --}}
    <div class="galerie-new-preview" id="galerieNewPreview" style="display:none">
      <div class="galerie-grid" id="galerieNewGrid"></div>
    </div>
 
    {{-- Zone upload multiple --}}
    <div class="f-upload f-upload--galerie" id="galerieUploadZone">
      <input type="file" name="galerie[]" id="galerieInput"
        accept="image/jpeg,image/png,image/webp"
        class="f-upload-input"
        multiple
        onchange="handleGalerieChange(this)">
      <div class="f-upload-body">
        <div class="f-upload-ico">
          <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
          </svg>
        </div>
        <p class="f-upload-txt">
          Glissez plusieurs images ou <span class="f-upload-browse">parcourir</span>
        </p>
        <p class="f-upload-hint">JPG, PNG, WEBP · max 2 Mo par image · sélection multiple</p>
      </div>
    </div>
 
    {{-- Légendes nouvelles images (générées en JS) --}}
    <div id="galerieNewLegendes" style="display:none">
      <p class="f-hint mt-3 mb-2">Légendes pour les nouvelles images :</p>
      <div id="galerieLegendesList"></div>
    </div>
 
  </div>
</div>



      {{-- Tags --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-tag-fill"></i></span>
          <span class="f-card-titre">Tags / Technologies</span>
        </div>
        <div class="f-card-body">
          @if($tags->isEmpty())
            <p class="text-muted small">
              Aucun tag disponible.
              <a href="{{ route('admin.tags.index') }}" style="color:var(--primary)">Créer des tags →</a>
            </p>
          @else
            <div class="f-tags-grid">
              @foreach($tags as $tag)
                @php $checked = in_array($tag->id, old('tags', $selectedTags ?? [])); @endphp
                <label class="f-tag-chip {{ $checked ? 'f-tag-chip--on' : '' }}"
                  style="--tc:{{ $tag->couleur }}">
                  <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                    {{ $checked ? 'checked' : '' }}>
                  <span class="f-tag-dot" style="background:{{ $tag->couleur }}"></span>
                  {{ $tag->nom }}
                </label>
              @endforeach
            </div>
          @endif
          @error('tags')<p class="f-err-msg mt-2">{{ $message }}</p>@enderror
        </div>
      </div>

    </div>

    {{-- ══════════ COLONNE DROITE ══════════ --}}
    <div class="col-lg-4">

      {{-- Publication --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-rocket-takeoff-fill"></i></span>
          <span class="f-card-titre">Publication</span>
        </div>
        <div class="f-card-body">
          <div class="f-field">
            <label class="f-label">Statut <span class="f-req">*</span></label>
            <div class="f-select-wrap">
              <select name="statut" class="f-input f-select @error('statut') f-input--err @enderror">
                <option value="brouillon" {{ old('statut', $projet->statut ?? 'brouillon') === 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                <option value="publié"    {{ old('statut', $projet->statut ?? '') === 'publié'    ? 'selected' : '' }}>Publié</option>
                <option value="archivé"   {{ old('statut', $projet->statut ?? '') === 'archivé'   ? 'selected' : '' }}>Archivé</option>
              </select>
              <svg class="f-select-arr" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
              </svg>
            </div>
            @error('statut')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>
          <div class="f-field">
            <div class="f-toggle-row">
              <div>
                <div class="f-toggle-label"><i class="bi bi-star-fill"></i> En vedette</div>
                <div class="f-toggle-hint">Affiché en priorité sur le portfolio</div>
              </div>
              <label class="f-toggle">
                <input type="hidden" name="en_vedette" value="0">
                <input type="checkbox" name="en_vedette" value="1"
                  {{ old('en_vedette', $projet->en_vedette ?? false) ? 'checked' : '' }}>
                <span class="f-toggle-track"><span class="f-toggle-thumb"></span></span>
              </label>
            </div>
          </div>
          <div class="f-field mb-0">
            <label class="f-label">Ordre d'affichage</label>
            <input type="number" name="ordre" class="f-input" min="0"
              value="{{ old('ordre', $projet->ordre ?? 0) }}">
            <p class="f-hint">Plus petit = affiché en premier.</p>
          </div>
        </div>
      </div>

      {{-- Détails du projet --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-pin-fill"></i></span>
          <span class="f-card-titre">Détails</span>
        </div>
        <div class="f-card-body">

          <div class="f-field">
            <label class="f-label">Type de projet</label>
            <input type="text" name="type_projet" class="f-input"
              placeholder="Application Web, Mobile, SaaS..."
              value="{{ old('type_projet', $projet->type_projet ?? '') }}">
          </div>

          {{-- ✨ NOUVEAU : Rôle --}}
          <div class="f-field">
            <label class="f-label">Mon rôle</label>
            <input type="text" name="role" class="f-input"
              placeholder="Développeur Full-Stack, UX Designer..."
              value="{{ old('role', $projet->role ?? '') }}">
          </div>

          <div class="f-field">
            <label class="f-label">Client</label>
            <input type="text" name="client" class="f-input"
              placeholder="Nom du client (optionnel)"
              value="{{ old('client', $projet->client ?? '') }}">
          </div>

          {{-- ✨ NOUVEAU : Durée --}}
          <div class="f-field">
            <label class="f-label">Durée du projet</label>
            <input type="text" name="duree" class="f-input"
              placeholder="Ex : 3 mois, 6 semaines..."
              value="{{ old('duree', $projet->duree ?? '') }}">
          </div>

          <div class="f-field-row">
            <div class="f-field">
              <label class="f-label">Date début</label>
              <input type="date" name="date_debut"
                class="f-input @error('date_debut') f-input--err @enderror"
                value="{{ old('date_debut', isset($projet->date_debut) ? $projet->date_debut->format('Y-m-d') : '') }}">
              @error('date_debut')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>
            <div class="f-field mb-0">
              <label class="f-label">Date fin</label>
              <input type="date" name="date_fin"
                class="f-input @error('date_fin') f-input--err @enderror"
                value="{{ old('date_fin', isset($projet->date_fin) ? $projet->date_fin->format('Y-m-d') : '') }}">
              @error('date_fin')<p class="f-err-msg">{{ $message }}</p>@enderror
            </div>
          </div>

        </div>
      </div>

      {{-- Liens --}}
      <div class="f-card mb-4">
        <div class="f-card-head">
          <span class="f-card-ico"><i class="bi bi-link-45deg"></i></span>
          <span class="f-card-titre">Liens</span>
        </div>
        <div class="f-card-body">
          <div class="f-field">
            <label class="f-label">URL démo</label>
            <div class="f-input-ico-wrap">
              <svg class="f-input-ico" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
              </svg>
              <input type="url" name="url_demo"
                class="f-input f-input-with-ico @error('url_demo') f-input--err @enderror"
                placeholder="https://demo.exemple.com"
                value="{{ old('url_demo', $projet->url_demo ?? '') }}">
            </div>
            @error('url_demo')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>
          <div class="f-field mb-0">
            <label class="f-label">URL GitHub</label>
            <div class="f-input-ico-wrap">
              <svg class="f-input-ico" width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
              </svg>
              <input type="url" name="url_github"
                class="f-input f-input-with-ico @error('url_github') f-input--err @enderror"
                placeholder="https://github.com/..."
                value="{{ old('url_github', $projet->url_github ?? '') }}">
            </div>
            @error('url_github')<p class="f-err-msg">{{ $message }}</p>@enderror
          </div>
        </div>
      </div>

      {{-- Actions --}}
      <div class="f-actions">
        <button type="submit" class="f-btn-submit" id="submitBtn">
          <span id="submitBtnText">
            {!! $isEdit ? '<i class="bi bi-floppy-fill"></i> Enregistrer les modifications' : '<i class="bi bi-rocket-takeoff-fill"></i> Créer le projet' !!}
          </span>
          <span id="submitBtnSpinner" style="display:none;align-items:center;gap:8px">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation:spin .9s linear infinite">
              <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            </svg>
            Enregistrement…
          </span>
        </button>
        <a href="{{ route('projets.index') }}" class="f-btn-cancel">Annuler</a>
      </div>

    </div>
  </div>
</form>

{{-- ══ MODAL APERÇU ══ --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen preview-modal-dialog">
    <div class="modal-content preview-modal-content">
      <div class="modal-header preview-modal-header">
        <span style="color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;opacity:.9">
          <i class="bi bi-eye-fill me-2"></i>Aperçu du projet
        </span>
        <div class="preview-devices ms-auto me-3">
          <button class="preview-device-btn active" onclick="switchDevice('desktop',this)">
            <i class="bi bi-display"></i> Bureau
          </button>
          <button class="preview-device-btn" onclick="switchDevice('mobile',this)">
            <i class="bi bi-phone"></i> Mobile
          </button>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body preview-modal-body p-0 overflow-auto">
        <div id="previewWrapper" class="preview-desktop">
          <div class="preview-card">
            <div class="preview-cover">
              <img id="previewCoverImg" src="" alt="" style="display:none">
              <span id="previewCoverEmoji">🚀</span>
            </div>
            <div class="preview-card-body">
              <div class="preview-tags" id="previewTags"></div>
              <h2 class="preview-titre" id="previewTitre">Titre du projet</h2>
              <p class="preview-desc" id="previewDescription"></p>
              <div class="preview-meta-row">
                <span class="preview-meta-item" id="previewType"></span>
                <span class="preview-meta-item" id="previewRole"></span>
                <span class="preview-meta-item" id="previewClient"></span>
                <span class="preview-meta-item" id="previewDuree"></span>
                <span class="preview-meta-item" id="previewDates"></span>
              </div>
              <div class="preview-links" style="margin-bottom:24px">
                <a href="#" id="previewDemo" class="preview-btn-demo" style="display:none">
                  <i class="bi bi-link-45deg"></i> Voir la démo
                </a>
                <a href="#" id="previewGithub" class="preview-btn-github" target="_blank" style="display:none">
                  <i class="bi bi-code-slash"></i> GitHub
                </a>
              </div>
              <div id="previewFeats" style="display:none;margin-bottom:20px">
                <div class="preview-block-title">
                  <i class="bi bi-lightning-charge-fill" style="color:var(--primary)"></i> Fonctionnalités
                </div>
                <div class="preview-feats-grid" id="previewFeatsList"></div>
              </div>
              <div id="previewDefis" style="display:none;margin-bottom:20px">
                <div class="preview-block-title">
                  <i class="bi bi-tools" style="color:var(--warning)"></i> Défis & Solutions
                </div>
                <div id="previewDefisList"></div>
              </div>
              <div class="preview-contenu" id="previewContenu"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
.page-eyebrow{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-display);font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:var(--primary);margin-bottom:5px}
.page-eyebrow::before{content:'';width:18px;height:2px;background:var(--primary);border-radius:2px}
.page-title{font-family:var(--font-display);font-size:1.5rem;font-weight:800;color:var(--dark)}
.btn-hd-preview,.btn-hd-back{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.82rem;cursor:pointer;transition:all var(--transition);text-decoration:none}
.btn-hd-preview{background:var(--primary-light);color:var(--primary);border:1.5px solid rgba(255,124,8,.25)}
.btn-hd-preview:hover{background:var(--primary);color:#fff}
.btn-hd-back{background:var(--gray-bg);color:var(--text);border:1.5px solid var(--border)}
.btn-hd-back:hover{background:var(--border);color:var(--dark)}
.f-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;box-shadow:var(--shadow)}
.f-card-head{display:flex;align-items:center;gap:9px;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--gray-bg)}
.f-card-ico{font-size:1rem;line-height:1}
.f-card-titre{font-family:var(--font-display);font-size:.88rem;font-weight:700;color:var(--dark)}
.f-card-head-hint{font-size:.74rem;color:var(--muted);margin-left:4px}
.f-card-body{padding:20px}
.f-field{margin-bottom:18px}
.f-field:last-child,.f-field.mb-0{margin-bottom:0}
.f-field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.f-label{display:block;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--dark);margin-bottom:7px}
.f-label-hint{font-size:.74rem;color:var(--muted);font-weight:400}
.f-req{color:var(--primary)}
.f-hint{font-size:.73rem;color:var(--muted);margin-top:5px;margin-bottom:0}
.f-err-msg{font-size:.76rem;color:var(--danger);margin-top:4px;margin-bottom:0}
.f-input{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:var(--gray-bg);color:var(--text);font-family:var(--font-body);font-size:.88rem;outline:none;transition:all var(--transition);-webkit-appearance:none;appearance:none}
.f-input:focus{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1);background:#fff}
.f-input--err{border-color:var(--danger)!important}
.f-textarea{resize:vertical;min-height:90px}
.f-slug-wrap{display:flex;align-items:center;border:1.5px solid var(--border);border-radius:9px;overflow:hidden;background:var(--gray-bg);transition:all var(--transition)}
.f-slug-wrap:focus-within{border-color:var(--primary);box-shadow:0 0 0 4px rgba(255,124,8,.1)}
.f-slug-prefix{padding:0 12px;font-size:.78rem;color:var(--muted);background:var(--border);border-right:1.5px solid var(--border);white-space:nowrap;height:42px;display:flex;align-items:center;flex-shrink:0}
.f-slug-input{border:none!important;border-radius:0!important;box-shadow:none!important;flex:1;padding-left:10px;background:transparent!important}
.f-select-wrap{position:relative}
.f-select{padding-right:36px;cursor:pointer}
.f-select-arr{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none}
.f-input-ico-wrap{position:relative}
.f-input-ico{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--muted);pointer-events:none}
.f-input-with-ico{padding-left:38px}
.f-toggle-row{display:flex;align-items:center;justify-content:space-between;gap:12px;background:var(--gray-bg);border:1px solid var(--border);border-radius:9px;padding:12px 14px}
.f-toggle-label{font-family:var(--font-body);font-size:.87rem;font-weight:600;color:var(--dark)}
.f-toggle-hint{font-size:.74rem;color:var(--muted);margin-top:1px}
.f-toggle{flex-shrink:0;cursor:pointer}
.f-toggle input{display:none}
.f-toggle-track{display:block;width:44px;height:25px;border-radius:99px;background:var(--border);position:relative;transition:background var(--transition)}
.f-toggle-thumb{position:absolute;width:19px;height:19px;border-radius:50%;background:#fff;top:3px;left:3px;transition:transform var(--transition);box-shadow:0 1px 4px rgba(0,0,0,.2)}
.f-toggle input:checked + .f-toggle-track{background:var(--primary)}
.f-toggle input:checked + .f-toggle-track .f-toggle-thumb{transform:translateX(19px)}
.f-img-current{margin-bottom:14px}
.f-img-preview{width:100%;max-height:200px;object-fit:cover;border-radius:10px;border:1px solid var(--border)}
.f-img-remove{display:inline-flex;align-items:center;gap:6px;margin-top:8px;font-size:.8rem;color:var(--danger);cursor:pointer;font-family:var(--font-body)}
.f-img-remove input{accent-color:var(--danger)}
.f-upload{border:2px dashed var(--border);border-radius:var(--radius);padding:32px 20px;text-align:center;cursor:pointer;position:relative;transition:all var(--transition)}
.f-upload:hover,.f-upload.drag-active{border-color:var(--primary);background:var(--primary-light)}
.f-upload-input{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.f-upload-body{pointer-events:none}
.f-upload-ico{width:52px;height:52px;border-radius:14px;background:var(--gray-bg);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--muted);margin:0 auto 12px}
.f-upload:hover .f-upload-ico,.f-upload.drag-active .f-upload-ico{background:rgba(255,124,8,.12);border-color:rgba(255,124,8,.3);color:var(--primary)}
.f-upload-txt{font-size:.88rem;color:var(--text);margin-bottom:4px}
.f-upload-browse{color:var(--primary);font-weight:700}
.f-upload-hint{font-size:.75rem;color:var(--muted);margin:0}
.f-tags-grid{display:flex;flex-wrap:wrap;gap:8px}
.f-tag-chip{display:inline-flex;align-items:center;gap:7px;padding:7px 14px;border-radius:99px;border:1.5px solid var(--border);cursor:pointer;font-family:var(--font-body);font-size:.8rem;font-weight:600;color:var(--text);background:#fff;user-select:none;transition:all var(--transition)}
.f-tag-chip:hover{border-color:var(--tc,var(--primary))}
.f-tag-chip input{display:none}
.f-tag-chip--on{background:var(--tc,var(--primary));border-color:var(--tc,var(--primary));color:#fff}
.f-tag-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.f-actions{display:flex;flex-direction:column;gap:10px}
.f-btn-submit{width:100%;padding:13px;background:var(--primary);color:#fff;font-family:var(--font-display);font-weight:700;font-size:.9rem;border:none;border-radius:var(--radius);cursor:pointer;box-shadow:0 4px 16px rgba(255,124,8,.35);transition:all var(--transition)}
.f-btn-submit:hover{background:var(--primary-dark);transform:translateY(-2px)}
.f-btn-preview{width:100%;padding:11px;background:var(--primary-light);color:var(--primary);font-family:var(--font-display);font-weight:700;font-size:.85rem;border:1.5px solid rgba(255,124,8,.25);border-radius:var(--radius);cursor:pointer;transition:all var(--transition)}
.f-btn-preview:hover{background:var(--primary);color:#fff}
.f-btn-cancel{display:block;text-align:center;padding:10px;background:var(--gray-bg);color:var(--muted);font-family:var(--font-display);font-weight:600;font-size:.85rem;border:1.5px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:all var(--transition)}
.f-btn-cancel:hover{background:var(--border);color:var(--text)}

/* ── Fonctionnalités & Défis ── */
.f-list-item{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.f-list-item-ico{width:24px;height:24px;border-radius:6px;background:rgba(16,185,129,.12);color:var(--success);display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;flex-shrink:0}
.f-list-input{flex:1}
.f-list-remove{width:28px;height:28px;border-radius:7px;background:rgba(239,68,68,.08);color:var(--danger);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all var(--transition)}
.f-list-remove:hover{background:rgba(239,68,68,.18)}
.f-list-add{display:inline-flex;align-items:center;gap:7px;margin-top:10px;padding:8px 16px;border-radius:9px;background:var(--gray-bg);color:var(--primary);font-family:var(--font-display);font-weight:700;font-size:.8rem;border:1.5px solid rgba(255,124,8,.2);cursor:pointer;transition:all var(--transition)}
.f-list-add:hover{background:var(--primary-light)}

.f-defi-item{background:var(--gray-bg);border:1px solid var(--border);border-radius:10px;padding:14px;margin-bottom:10px}
.f-defi-header{display:flex;align-items:center;margin-bottom:10px}
.f-defi-num{width:24px;height:24px;border-radius:50%;background:var(--primary);color:#fff;font-family:var(--font-display);font-size:.72rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.f-defi-fields{display:flex;flex-direction:column;gap:8px}
.f-defi-badge{display:inline-block;font-family:var(--font-display);font-size:.65rem;font-weight:800;padding:2px 8px;border-radius:99px;margin-right:6px}
.f-defi-badge--challenge{background:rgba(239,68,68,.1);color:var(--danger)}
.f-defi-badge--solution{background:rgba(16,185,129,.1);color:var(--success)}

.tox-tinymce{border-radius:9px!important;border:1.5px solid var(--border)!important}
.tox-tinymce:focus-within{border-color:var(--primary)!important;box-shadow:0 0 0 4px rgba(255,124,8,.1)!important}

/* Preview */
.preview-modal-content{border:none;border-radius:18px;overflow:hidden}
.preview-modal-header{background:var(--dark);border:none;padding:14px 20px}
.preview-modal-body{background:var(--gray-bg);min-height:70vh}
.preview-modal-footer{background:var(--gray-bg);border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.preview-devices{display:flex;background:rgba(255,255,255,.1);border-radius:8px;padding:3px;gap:2px}
.preview-device-btn{border:none;background:transparent;color:rgba(255,255,255,.55);padding:5px 14px;border-radius:6px;font-family:var(--font-display);font-size:.78rem;font-weight:700;cursor:pointer;transition:all var(--transition)}
.preview-device-btn.active{background:rgba(255,255,255,.15);color:#fff}
.preview-desktop{padding:30px;display:flex;justify-content:center}
.preview-mobile{padding:20px;display:flex;justify-content:center}
.preview-mobile .preview-card{max-width:390px}
.preview-card{background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 32px rgba(0,0,0,.1);width:100%;max-width:900px}
.preview-cover{width:100%;height:300px;background:linear-gradient(135deg,var(--dark-3),var(--dark));display:flex;align-items:center;justify-content:center;overflow:hidden;font-size:5rem}
.preview-cover img{width:100%;height:100%;object-fit:cover}
.preview-card-body{padding:24px 28px 32px}
.preview-tags{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:12px}
.preview-tag{padding:4px 12px;border-radius:99px;font-size:.72rem;font-weight:700}
.preview-titre{font-family:var(--font-display);font-size:1.9rem;font-weight:800;color:var(--dark);margin-bottom:8px}
.preview-desc{font-size:.95rem;color:var(--muted);line-height:1.7;margin-bottom:14px}
.preview-meta-row{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:16px}
.preview-meta-item{font-size:.82rem;color:var(--muted)}
.preview-links{display:flex;gap:10px}
.preview-btn-demo{display:inline-flex;align-items:center;gap:7px;background:var(--primary);color:#fff;padding:10px 22px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.85rem;text-decoration:none}
.preview-btn-github{display:inline-flex;align-items:center;gap:7px;background:var(--dark);color:#fff;padding:10px 22px;border-radius:var(--radius);font-family:var(--font-display);font-weight:700;font-size:.85rem;text-decoration:none}
.preview-contenu{line-height:1.85;color:var(--text)}
.preview-contenu h2{font-family:var(--font-display);font-size:1.35rem;font-weight:700;color:var(--dark);margin:22px 0 10px}
.preview-contenu h3{font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--dark);margin:16px 0 8px}
.preview-contenu ul{padding-left:20px;margin-bottom:14px}
.preview-contenu li{margin-bottom:5px}
.preview-contenu strong{color:var(--primary)}
.preview-block-title{font-family:var(--font-display);font-size:.95rem;font-weight:800;color:var(--dark);margin-bottom:12px;display:flex;align-items:center;gap:8px}
.preview-feats-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:8px}
.preview-feat-item{display:flex;align-items:flex-start;gap:8px;background:var(--gray-bg);border-radius:8px;padding:10px;font-size:.84rem;color:var(--text)}
.preview-feat-check{width:18px;height:18px;border-radius:50%;background:rgba(16,185,129,.15);color:var(--success);display:flex;align-items:center;justify-content:center;font-size:.65rem;font-weight:800;flex-shrink:0;margin-top:1px}
.preview-defi-item{background:var(--gray-bg);border-radius:10px;padding:14px;margin-bottom:8px;font-size:.86rem}
.preview-defi-challenge{margin-bottom:8px;color:var(--text)}
.preview-defi-solution{color:var(--text)}
.preview-defi-lbl{display:inline-block;font-size:.64rem;font-weight:800;padding:2px 7px;border-radius:99px;margin-right:6px}
.preview-defi-lbl--c{background:rgba(239,68,68,.1);color:var(--danger)}
.preview-defi-lbl--s{background:rgba(16,185,129,.1);color:var(--success)}

@media(max-width:768px){.f-field-row{grid-template-columns:1fr}}
@keyframes spin{to{transform:rotate(360deg)}}
.preview-modal-dialog{max-width:100%}




/* ── Galerie admin ── */
.galerie-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px;margin-bottom:16px}
.galerie-item{background:var(--gray-bg);border:1px solid var(--border);border-radius:10px;overflow:hidden;transition:all var(--transition)}
.galerie-item--deleted{opacity:.3;border-color:var(--danger);pointer-events:none}
.galerie-thumb{width:100%;height:110px;object-fit:cover;display:block}
.galerie-item-body{padding:8px}
.galerie-legende-input{font-size:.76rem;padding:6px 10px;margin-bottom:6px}
.galerie-delete-label{display:inline-flex;align-items:center;gap:5px;font-size:.72rem;color:var(--danger);cursor:pointer;font-family:var(--font-body)}
.galerie-delete-label input{accent-color:var(--danger)}
.galerie-divider{display:flex;align-items:center;gap:12px;margin:18px 0;font-size:.76rem;color:var(--muted);font-weight:600}
.galerie-divider::before,.galerie-divider::after{content:'';flex:1;height:1px;background:var(--border)}
.f-upload--galerie{border-style:dashed;border-color:rgba(59,130,246,.3);background:rgba(59,130,246,.02)}
.f-upload--galerie:hover,.f-upload--galerie.drag-active{border-color:var(--info);background:rgba(59,130,246,.06)}
.f-upload--galerie:hover .f-upload-ico,.f-upload--galerie.drag-active .f-upload-ico{background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.3);color:var(--info)}
.galerie-new-item{background:var(--gray-bg);border:1px solid var(--border);border-radius:10px;overflow:hidden;position:relative}
.galerie-new-thumb{width:100%;height:110px;object-fit:cover;display:block}
.galerie-new-remove{position:absolute;top:5px;right:5px;width:22px;height:22px;border-radius:50%;background:rgba(0,0,0,.6);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.65rem;transition:background var(--transition)}
.galerie-new-remove:hover{background:var(--danger)}
.galerie-legende-row{display:flex;align-items:center;gap:10px;margin-bottom:8px}
.galerie-legende-num{width:24px;height:24px;border-radius:6px;background:rgba(59,130,246,.1);color:var(--info);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:800;flex-shrink:0}
</style>
@endpush

{{-- ============================================================
     Remplacez TOUT le bloc @push('scripts') par celui-ci
     ============================================================ --}}

@push('styles')
{{-- Quill CSS & JS chargés globalement dans master_admin --}}
<style>
/* ── Quill : intégration visuelle au design ─────────────── */
#quill-editor {
  min-height: 320px;
  border: none;
  font-family: var(--font-body);
  font-size: .9rem;
  color: var(--text);
}
.ql-toolbar.ql-snow {
  border: none !important;
  border-bottom: 1px solid var(--border) !important;
  background: var(--gray-bg);
  border-radius: 9px 9px 0 0 !important;
  padding: 8px 12px !important;
}
.ql-container.ql-snow {
  border: none !important;
  border-radius: 0 0 9px 9px !important;
}
.quill-wrap {
  border: 1.5px solid var(--border);
  border-radius: 9px;
  overflow: hidden;
  transition: border-color var(--transition), box-shadow var(--transition);
  background: #fff;
}
.quill-wrap:focus-within {
  border-color: var(--primary);
  box-shadow: 0 0 0 4px rgba(255,124,8,.1);
}
.quill-wrap.has-error {
  border-color: var(--danger) !important;
}
.ql-toolbar .ql-stroke     { stroke: var(--muted) !important; }
.ql-toolbar .ql-fill       { fill:   var(--muted) !important; }
.ql-toolbar button:hover .ql-stroke,
.ql-toolbar .ql-active .ql-stroke { stroke: var(--primary) !important; }
.ql-toolbar button:hover .ql-fill,
.ql-toolbar .ql-active .ql-fill   { fill:   var(--primary) !important; }
.ql-editor.ql-blank::before { color: var(--muted); font-style: normal !important; }

/* Compteur de mots */
.ql-word-count {
  text-align: right;
  font-size: .72rem;
  color: var(--muted);
  padding: 4px 12px 6px;
  border-top: 1px solid var(--border);
  background: var(--gray-bg);
}
</style>
@endpush

@push('scripts')
{{-- Quill JS chargé globalement dans master_admin --}}
<script>
/* ══════════════════════════════════════════════════════
   QUILL — Initialisation
══════════════════════════════════════════════════════ */
const contenuField = document.getElementById('contenu');

// Créer le wrapper + éditeur
const quillWrap = document.createElement('div');
quillWrap.className = 'quill-wrap' + (contenuField.classList.contains('f-input--err') ? ' has-error' : '');

const quillEl = document.createElement('div');
quillEl.id = 'quill-editor';

const wordCountEl = document.createElement('div');
wordCountEl.className = 'ql-word-count';
wordCountEl.textContent = '0 mot';

quillWrap.appendChild(quillEl);
quillWrap.appendChild(wordCountEl);

// Insérer avant le textarea (qui reste caché)
contenuField.style.display = 'none';
contenuField.parentNode.insertBefore(quillWrap, contenuField);

// Config Quill
const quill = new Quill('#quill-editor', {
  theme: 'snow',
  modules: {
    toolbar: [
      [{ header: [2, 3, 4, false] }],
      ['bold', 'italic', 'underline', 'strike'],
      [{ color: [] }, { background: [] }],
      [{ list: 'ordered' }, { list: 'bullet' }],
      [{ indent: '-1' }, { indent: '+1' }],
      ['link', 'image', 'blockquote', 'code-block'],
      ['clean'],
    ]
  },
  placeholder: 'Rédigez le contenu détaillé du projet...',
});

// Charger le contenu existant
if (contenuField.value.trim()) {
  quill.root.innerHTML = contenuField.value;
}

// Synchroniser Quill → textarea + compteur de mots
quill.on('text-change', () => {
  const html = quill.root.innerHTML;
  contenuField.value = html === '<p><br></p>' ? '' : html;

  // Compteur de mots
  const text  = quill.getText().trim();
  const words = text ? text.split(/\s+/).length : 0;
  wordCountEl.textContent = words + ' mot' + (words > 1 ? 's' : '');
});

/* ══════════════════════════════════════════════════════
   SLUG automatique
══════════════════════════════════════════════════════ */
let slugManual = {{ ($isEdit && ($projet->slug ?? false)) ? 'true' : 'false' }};

function autoSlug(v) {
  if (slugManual) return;
  document.getElementById('slug').value = v
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .replace(/[^a-z0-9\s-]/g, '')
    .trim()
    .replace(/\s+/g, '-')
    .replace(/-+/g, '-');
}

document.getElementById('slug').addEventListener('input', () => { slugManual = true; });

/* ══════════════════════════════════════════════════════
   IMAGE — upload + drag & drop + preview
══════════════════════════════════════════════════════ */
function handleImageChange(input) {
  if (!input.files?.[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('newImgPreview').src = e.target.result;
    document.getElementById('newImgPreviewWrap').style.display = 'block';
  };
  reader.readAsDataURL(input.files[0]);
}

function clearImageInput() {
  document.getElementById('imageInput').value = '';
  document.getElementById('newImgPreviewWrap').style.display = 'none';
}

function toggleCurrentImg(cb) {
  const img = document.querySelector('#currentImgWrap img');
  if (img) img.style.opacity = cb.checked ? '.25' : '1';
}

// Drag & drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('drag-active'); });
zone.addEventListener('dragleave', () => zone.classList.remove('drag-active'));
zone.addEventListener('drop', e => {
  e.preventDefault();
  zone.classList.remove('drag-active');
  const file = e.dataTransfer.files[0];
  if (file?.type.startsWith('image/')) {
    const dt = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById('imageInput');
    input.files = dt.files;
    handleImageChange(input);
  }
});

/* ══════════════════════════════════════════════════════
   TAGS
══════════════════════════════════════════════════════ */
document.querySelectorAll('.f-tag-chip input').forEach(cb => {
  cb.addEventListener('change', function () {
    this.closest('.f-tag-chip').classList.toggle('f-tag-chip--on', this.checked);
  });
});

/* ══════════════════════════════════════════════════════
   FONCTIONNALITÉS — ajout dynamique
══════════════════════════════════════════════════════ */
function addFonctionnalite() {
  const list = document.getElementById('fonctionnalitesList');
  const div  = document.createElement('div');
  div.className = 'f-list-item';
  div.innerHTML = `
    <div class="f-list-item-ico"><i class="bi bi-check-lg"></i></div>
    <input type="text" name="fonctionnalites[]"
      class="f-input f-list-input"
      placeholder="Ex : Nouvelle fonctionnalité">
    <button type="button" class="f-list-remove"
      onclick="removeItem(this.closest('.f-list-item'))">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>`;
  list.appendChild(div);
  div.querySelector('input').focus();
}

/* ══════════════════════════════════════════════════════
   DÉFIS — ajout dynamique
══════════════════════════════════════════════════════ */
let defiCount = {{ count($projet->defis ?? []) ?: 1 }};

function addDefi() {
  defiCount++;
  const list = document.getElementById('defisList');
  const div  = document.createElement('div');
  div.className = 'f-defi-item';
  div.id = 'defi-' + defiCount;
  div.innerHTML = `
    <div class="f-defi-header">
      <span class="f-defi-num">${defiCount}</span>
      <button type="button" class="f-list-remove ms-auto"
        onclick="removeItem(this.closest('.f-defi-item'))">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
        </svg>
      </button>
    </div>
    <div class="f-defi-fields">
      <div class="f-field mb-0">
        <label class="f-label">
          <span class="f-defi-badge f-defi-badge--challenge">Défi</span>
        </label>
        <input type="text" name="defis_challenge[]" class="f-input"
          placeholder="Décrivez le défi technique">
      </div>
      <div class="f-field mb-0 mt-2">
        <label class="f-label">
          <span class="f-defi-badge f-defi-badge--solution">Solution</span>
        </label>
        <input type="text" name="defis_solution[]" class="f-input"
          placeholder="Décrivez la solution apportée">
      </div>
    </div>`;
  list.appendChild(div);
  div.querySelector('input').focus();
}

function removeItem(el) {
  if (el) el.remove();
}

/* ══════════════════════════════════════════════════════
   SOUMISSION — synchroniser Quill + spinner
══════════════════════════════════════════════════════ */
let formDirty = false;
document.getElementById('projetForm').addEventListener('change', () => { formDirty = true; });
quill.on('text-change', () => { formDirty = true; });

window.addEventListener('beforeunload', e => {
  if (formDirty) { e.preventDefault(); e.returnValue = ''; }
});

document.getElementById('projetForm').addEventListener('submit', () => {
  const html = quill.root.innerHTML;
  contenuField.value = html === '<p><br></p>' ? '' : html;
  formDirty = false;
  document.getElementById('submitBtnText').style.display    = 'none';
  document.getElementById('submitBtnSpinner').style.display = 'inline-flex';
  document.getElementById('submitBtn').disabled             = true;
});

/* ══════════════════════════════════════════════════════
   APERÇU
══════════════════════════════════════════════════════ */
function openPreview() {
  // Synchroniser Quill → textarea avant lecture
  const html = quill.root.innerHTML;
  contenuField.value = html === '<p><br></p>' ? '' : html;

  const get = id => document.getElementById(id)?.value || '';

  // Tags sélectionnés
  const tags = [...document.querySelectorAll('.f-tag-chip input:checked')].map(cb => ({
    nom:   cb.closest('.f-tag-chip').textContent.trim(),
    color: cb.closest('.f-tag-chip').style.getPropertyValue('--tc') || '#ff7c08',
  }));

  // Fonctionnalités
  const feats = [...document.querySelectorAll('[name="fonctionnalites[]"]')]
    .map(i => i.value.trim()).filter(Boolean);

  // Défis & Solutions
  const challenges = [...document.querySelectorAll('[name="defis_challenge[]"]')].map(i => i.value.trim());
  const solutions  = [...document.querySelectorAll('[name="defis_solution[]"]')].map(i => i.value.trim());

  // Image
  const newImg  = document.getElementById('newImgPreview');
  const currImg = document.querySelector('#currentImgWrap img');
  const suppImg = document.getElementById('supprimerImage');
  const imgSrc  = (newImg?.src && newImg.src !== window.location.href)
    ? newImg.src
    : (currImg && !(suppImg?.checked) ? currImg.src : null);

  // Remplir l'aperçu
  document.getElementById('previewTitre').textContent       = get('titre') || 'Titre du projet';
  document.getElementById('previewDescription').textContent = get('description');
  document.getElementById('previewContenu').innerHTML       = contenuField.value;

  const coverImg   = document.getElementById('previewCoverImg');
  const coverEmoji = document.getElementById('previewCoverEmoji');
  if (imgSrc) {
    coverImg.src = imgSrc; coverImg.style.display = 'block';
    coverEmoji.style.display = 'none';
  } else {
    coverImg.style.display = 'none'; coverEmoji.style.display = 'block';
  }

  document.getElementById('previewTags').innerHTML = tags.map(t =>
    `<span class="preview-tag" style="background:${t.color}20;color:${t.color}">${t.nom}</span>`
  ).join('');

  const q = s => document.querySelector(s)?.value || '';
  const type   = q('[name=type_projet]');
  const role   = q('[name=role]');
  const client = q('[name=client]');
  const duree  = q('[name=duree]');
  const dS     = q('[name=date_debut]');
  const dE     = q('[name=date_fin]');

  document.getElementById('previewType').innerHTML   = type   ? '<i class="bi bi-tag-fill"></i> '           + type   : '';
  document.getElementById('previewRole').innerHTML   = role   ? '<i class="bi bi-person-workspace"></i> ' + role   : '';
  document.getElementById('previewClient').innerHTML = client ? '<i class="bi bi-handshake"></i> '         + client : '';
  document.getElementById('previewDuree').innerHTML  = duree  ? '<i class="bi bi-stopwatch-fill"></i> '   + duree  : '';

  const dates = [dS && fmtDate(dS), dE && fmtDate(dE)].filter(Boolean).join(' — ');
  document.getElementById('previewDates').innerHTML = dates ? '<i class="bi bi-calendar3"></i> ' + dates : '';

  const demoEl  = document.getElementById('previewDemo');
  const ghEl    = document.getElementById('previewGithub');
  const urlDemo = q('[name=url_demo]');
  const urlGH   = q('[name=url_github]');
  demoEl.style.display = urlDemo ? 'inline-flex' : 'none';
  ghEl.style.display   = urlGH   ? 'inline-flex' : 'none';
  if (urlDemo) demoEl.href = urlDemo;
  if (urlGH)   ghEl.href   = urlGH;

  // Fonctionnalités aperçu
  const featsWrap = document.getElementById('previewFeats');
  const featsList = document.getElementById('previewFeatsList');
  if (feats.length > 0) {
    featsList.innerHTML = feats.map(f =>
      `<div class="preview-feat-item">
        <span class="preview-feat-check"><i class="bi bi-check-lg"></i></span>
        <span>${f}</span>
      </div>`
    ).join('');
    featsWrap.style.display = 'block';
  } else {
    featsWrap.style.display = 'none';
  }

  // Défis aperçu
  const defisWrap = document.getElementById('previewDefis');
  const defisList = document.getElementById('previewDefisList');
  const hasDefis  = challenges.some(c => c.trim());
  if (hasDefis) {
    defisList.innerHTML = challenges.map((c, i) => c ? `
      <div class="preview-defi-item">
        <div class="preview-defi-challenge">
          <span class="preview-defi-lbl preview-defi-lbl--c">Défi</span>${c}
        </div>
        ${solutions[i] ? `<div class="preview-defi-solution">
          <span class="preview-defi-lbl preview-defi-lbl--s">Solution</span>${solutions[i]}
        </div>` : ''}
      </div>` : ''
    ).join('');
    defisWrap.style.display = 'block';
  } else {
    defisWrap.style.display = 'none';
  }

  new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function fmtDate(s) {
  return new Date(s).toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
}

function switchDevice(d, btn) {
  document.querySelectorAll('.preview-device-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('previewWrapper').className =
    d === 'mobile' ? 'preview-mobile' : 'preview-desktop';
}

/* ═══════════════════════════════════════
   GALERIE
═══════════════════════════════════════ */
let galerieFiles = []; // stockage local des fichiers sélectionnés
 
function handleGalerieChange(input) {
  const files = Array.from(input.files);
  if (!files.length) return;
 
  // Ajouter les nouveaux fichiers
  files.forEach(file => {
    if (!file.type.startsWith('image/')) return;
    if (file.size > 2 * 1024 * 1024) {
      if (window.showToast) window.showToast(`"${file.name}" dépasse 2 Mo.`, 'error');
      return;
    }
    galerieFiles.push(file);
  });
 
  renderGaleriePreview();
  syncGalerieInput();
}
 
function renderGaleriePreview() {
  const grid     = document.getElementById('galerieNewGrid');
  const wrap     = document.getElementById('galerieNewPreview');
  const legendes = document.getElementById('galerieLegendesList');
  const legendWrap = document.getElementById('galerieNewLegendes');
 
  grid.innerHTML     = '';
  legendes.innerHTML = '';
 
  if (galerieFiles.length === 0) {
    wrap.style.display      = 'none';
    legendWrap.style.display = 'none';
    return;
  }
 
  wrap.style.display      = 'block';
  legendWrap.style.display = 'block';
 
  galerieFiles.forEach((file, i) => {
    const reader = new FileReader();
    reader.onload = e => {
      // Vignette
      const item = document.createElement('div');
      item.className = 'galerie-new-item';
      item.id = 'new-galerie-' + i;
      item.innerHTML = `
        <img src="${e.target.result}" class="galerie-new-thumb" alt="">
        <button type="button" class="galerie-new-remove"
          onclick="removeGalerieFile(${i})" title="Retirer"><i class="bi bi-x"></i></button>
      `;
      grid.appendChild(item);
 
      // Champ légende
      const row = document.createElement('div');
      row.className = 'galerie-legende-row';
      row.id = 'legende-row-' + i;
      row.innerHTML = `
        <div class="galerie-legende-num">${i + 1}</div>
        <input type="text" name="galerie_nouvelles_legendes[]"
          class="f-input galerie-legende-input"
          placeholder="Légende pour cette image (optionnel)">
      `;
      legendes.appendChild(row);
    };
    reader.readAsDataURL(file);
  });
}
 
function removeGalerieFile(index) {
  galerieFiles.splice(index, 1);
  renderGaleriePreview();
  syncGalerieInput();
}
 
function syncGalerieInput() {
  // Recréer le FileList dans l'input
  const dt = new DataTransfer();
  galerieFiles.forEach(f => dt.items.add(f));
  document.getElementById('galerieInput').files = dt.files;
}
 
function markForDeletion(cb, itemId) {
  const item = document.getElementById(itemId);
  if (item) item.classList.toggle('galerie-item--deleted', cb.checked);
}
 
// Drag & drop galerie
const galerieZone = document.getElementById('galerieUploadZone');
if (galerieZone) {
  galerieZone.addEventListener('dragover', e => { e.preventDefault(); galerieZone.classList.add('drag-active'); });
  galerieZone.addEventListener('dragleave', () => galerieZone.classList.remove('drag-active'));
  galerieZone.addEventListener('drop', e => {
    e.preventDefault(); galerieZone.classList.remove('drag-active');
    const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
    if (!files.length) return;
    galerieFiles.push(...files);
    renderGaleriePreview();
    syncGalerieInput();
  });
}

</script>
@endpush