@extends('layouts.master')

@section('title')

@section('page_css')
{{-- style_client.css chargé globalement dans master.blade.php --}}
@endsection

@section('content')
  <!-- ─── HERO ─── -->
  <section class="hero" id="home">
    <div class="hero-bg"></div>
    <div class="container">
      <div class="hero-grid">
        <div class="hero-content">
          @if($params['site_disponible'] ?? false)
            <div class="hero-badge">
               {{ $params['site_hero_badge'] ?? 'Disponible pour de nouveaux projets' }}
            </div>
          @endif
          <h1 class="hero-name">AHOUTOU<br><em>N'da Josué</em></h1>
          <p class="hero-title">{{ $params['site_titre'] ?? 'Développeur Full-Stack' }}</p>
          <p class="hero-desc">{!! $params['site_description'] ?? '' !!}</p>
          <br> <br>
          <div class="hero-btns">
            <a href="#projects" class="btn-primary">
              <i class="bi bi-rocket-takeoff-fill"></i> Voir mes projets
            </a>
            <a href="{{ $params['site_cv'] ?? '' }}" class="btn-outline" download>
              <i class="bi bi-file-earmark-person-fill"></i> Télécharger CV
            </a>
          </div>
          <div class="hero-stats">
            <div>
              <div class="h-stat-num"><span data-target="{{ $params['stats_projets'] ?? 0 }}" id="h1">0</span>+</div>
              <div class="h-stat-label">Projets réalisés</div>
            </div>
            <div>
              <div class="h-stat-num"><span data-target="{{ $params['stats_clients'] ?? 0 }}" id="h2">0</span>+</div>
              <div class="h-stat-label">Clients satisfaits</div>
            </div>
            <div>
              <div class="h-stat-num"><span data-target="{{ $params['stats_experience'] ?? 0 }}" id="h3">0</span>an(s)</div>
              <div class="h-stat-label">D'expérience</div>
            </div>
          </div>
        </div>
        <div class="hero-visual">
          <div class="avatar-wrap">
            <div class="avatar-inner"><i class="bi bi-person-workspace"></i></div>
          </div>
          <div class="float-card">
            <div class="float-dot" style="background:var(--success)"></div>
            <div>
              <div class="float-text">CodeIgniter & Laravel</div>
              <div class="float-sub">Stack principal</div>
            </div>
          </div>
          <div class="float-card">
            <div class="float-dot" style="background:var(--info)"></div>
            <div>
              <div class="float-text">Flutter Dev</div>
              <div class="float-sub">iOS & Android</div>
            </div>
          </div>
          <div class="float-card">
            <div class="float-dot" style="background:var(--primary)"></div>
            <div>
              <div class="float-text">5★ Satisfaction</div>
              <div class="float-sub">Clients</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ─── ABOUT ─── -->
  <section class="section about" id="about">
    <div class="container">
      <div class="about-grid">
        <div class="about-text reveal-left">
          <div class="section-label">À propos</div>
          <h2 class="section-title">Passionné par le code,<br>axé sur les résultats</h2>
          <p>Je suis <strong>AHOUTOU N'da Josué</strong>, {{ $params['site_titre'] ?? 'Développeur Full-Stack' }} avec plus de {{ $params['stats_experience'] ?? 0 }} ans d'expérience dans la création d'applications web et mobiles. Je combine expertise technique et sens du design pour livrer des produits numériques qui font la différence.</p>
          <p>Basé à {{ $params['site_adresse'] ?? '' }}, je travaille avec des startups et des entreprises établies pour transformer leurs idées en solutions concrètes. Mon approche est simple : <strong>comprendre vos besoins, livrer de la valeur, dépasser les attentes</strong>.</p>
          <p>En dehors du code, je contribue à des projets en équipe, je participe à des hackathons et à des séances de gaming.</p>
          <div class="stack-grid">
            @foreach($categoriesCompetences as $cat)
              @foreach($cat->competences->take(2) as $comp)
                @if($comp->icone)
                  <div class="stack-chip">
                    <img src="https://cdn.simpleicons.org/{{ $comp->icone }}/{{ ltrim($cat->couleur, '#') }}"
                        alt="{{ $comp->nom }}"
                        class="chip-icon"
                        width="16" height="16"
                        onerror="this.outerHTML='<i class=\'bi bi-lightning-charge-fill chip-icon\' style=\'color:{{ $cat->couleur }}\'></i>'">
                    {{ $comp->nom }}
                  </div>
                @else
                  <div class="stack-chip">
                    <i class="bi bi-lightning-charge-fill chip-icon" style="color:{{ $cat->couleur }}"></i>
                    {{ $comp->nom }}
                  </div>
                @endif
              @endforeach
            @endforeach
          </div>
        </div>
        <div class="about-cards reveal-right">
          <div class="about-card" style="--i:0">
            <div class="about-card-icon"><i class="bi bi-bullseye"></i></div>
            <h4>Orienté performance</h4>
            <p>Chaque ligne de code est optimisée pour offrir des applications rapides et fluides, avec un focus sur l'expérience utilisateur finale.</p>
          </div>
          <div class="about-card" style="--i:1">
            <div class="about-card-icon"><i class="bi bi-shield-lock-fill"></i></div>
            <h4>Sécurité </h4>
            <p>La sécurité n'est pas une option. J'intègre les meilleures pratiques dès la conception pour protéger vos données et utilisateurs.</p>
          </div>
          <div class="about-card" style="--i:2">
            <div class="about-card-icon"><i class="bi bi-box-seam-fill"></i></div>
            <h4>Livraison structurée</h4>
            <p>Méthodologie agile, communication régulière et documentation claire pour des projets livrés dans les délais et le budget.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ─── SERVICES ─── -->
  <section class="section" id="services">
    <div class="container">
      <div class="services-head reveal">
        <div class="section-label">Services</div>
        <h2 class="section-title">Ce que je propose</h2>
        <p class="section-sub">Des solutions web et mobiles sur-mesure, de la conception à la mise en production.</p>
      </div>

      <div class="services-grid">

        <div class="service-card reveal" style="--i:0">
          <div class="service-icon"><i class="bi bi-layout-text-window-reverse"></i></div>
          <h3 class="service-title">Développement Front-end</h3>
          <p class="service-desc">Création d'interfaces modernes, réactives et accessibles avec les derniers frameworks web.</p>
        </div>

        <div class="service-card reveal" style="--i:1">
          <div class="service-icon"><i class="bi bi-server"></i></div>
          <h3 class="service-title">Développement Back-end</h3>
          <p class="service-desc">Conception d'API robustes, optimisation des bases de données et logiques métier complexes.</p>
        </div>

        <div class="service-card reveal" style="--i:2">
          <div class="service-icon"><i class="bi bi-phone-fill"></i></div>
          <h3 class="service-title">Applications Mobiles</h3>
          <p class="service-desc">Développement d'applications cross-platform performantes et fluides pour iOS et Android.</p>
        </div>

        <div class="service-card reveal" style="--i:3">
          <div class="service-icon"><i class="bi bi-diagram-3-fill"></i></div>
          <h3 class="service-title">API & Intégrations</h3>
          <p class="service-desc">Connexion de services tiers, webhooks, paiement en ligne et automatisation de workflows.</p>
        </div>

        <div class="service-card reveal" style="--i:4">
          <div class="service-icon"><i class="bi bi-vector-pen"></i></div>
          <h3 class="service-title">UI/UX Design</h3>
          <p class="service-desc">Maquettage, prototypage et création d'interfaces intuitives axées sur l'expérience utilisateur.</p>
        </div>

        <div class="service-card reveal" style="--i:5">
          <div class="service-icon"><i class="bi bi-shield-check"></i></div>
          <h3 class="service-title">Maintenance & Conseil</h3>
          <p class="service-desc">Audit de code, correction de bugs, optimisation des performances et accompagnement technique.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ─── PROJECTS ─── -->
  <section class="section" id="projects">
    <div class="container">
      <div class="projects-head reveal">
        <div class="section-label">Projets</div>
        <h2 class="section-title">Réalisations récentes</h2>
        <p class="section-sub">Une sélection de projets qui illustrent mon savoir-faire technique et ma capacité à livrer des solutions complètes.</p>
      </div>
      <div class="projects-grid">

        @forelse($projets as $projet)
        <article class="project-card reveal">
          <div class="project-thumb">
            <div class="project-thumb-inner"
              style="{{ $projet->image ? '' : 'background:linear-gradient(135deg,#1a1a2e 0%,#16213e 50%,#0f3460 100%);display:flex;align-items:center;justify-content:center' }}">
              @if($projet->image)
                <img src="{{ asset('storage/' . $projet->image) }}" alt="{{ $projet->titre }}">
              @else
                <div class="project-ph-icon"><i class="bi bi-rocket-takeoff-fill"></i></div>
              @endif
            </div>
            <div class="project-overlay">
              @if($projet->url_demo)
                <a href="{{ $projet->url_demo }}" target="_blank" class="btn-icon" title="Voir le projet"><i class="bi bi-link-45deg"></i></a>
              @endif
              @if($projet->url_github)
                <a href="{{ $projet->url_github }}" target="_blank" class="btn-icon" title="Code source"><i class="bi bi-code-slash"></i></a>
              @endif
            </div>
          </div>
          <div class="project-body">
            <div class="project-tags">
              @foreach($projet->tags->take(3) as $tag)
                <span class="tag" style="color:{{ $tag->couleur }}">{{ $tag->nom }}</span>
              @endforeach
            </div>
            <h3 class="project-title">{{ $projet->titre }}</h3>
            <p class="project-desc">{{ Str::limit(strip_tags($projet->description), 120) }}</p>
            <div class="project-actions">
              @if($projet->url_demo)
                <a href="{{ $projet->url_demo }}" target="_blank" class="btn-sm btn-sm-primary"><i class="bi bi-link-45deg"></i> Voir</a>
              @endif
              @if($projet->url_github)
                <a href="{{ $projet->url_github }}" target="_blank" class="btn-sm btn-sm-ghost"><i class="bi bi-code-slash"></i> Code</a>
              @endif
              <a href="{{ route('projet.detail', $projet->slug) }}" class="btn-sm btn-sm-ghost">
                Détails →
              </a>
            </div>
          </div>
        </article>
        @empty
        <p style="text-align:center;color:var(--muted)">Aucun projet publié pour l'instant.</p>
        @endforelse

      </div>
    </div>
  </section>



  <!-- ─── TÉMOIGNAGES ─── -->
  @if($temoignages->isNotEmpty())
  <section class="section" id="temoignages">
    <div class="container">
      <div class="reveal" style="text-align:center;margin-bottom:48px">
        <div class="section-label" style="justify-content:center">Témoignages</div>
        <h2 class="section-title" style="text-align:center">Ce que disent mes clients</h2>
      </div>
      <div class="temo-grid">
        @foreach($temoignages as $temo)
        <div class="temo-card reveal">
          <div class="temo-stars">{{ $temo->etoiles }}</div>
          <blockquote class="temo-texte">"{{ $temo->contenu }}"</blockquote>
          <div class="temo-author">
            <div class="temo-avatar">{{ $temo->initiales }}</div>
            <div>
              <div class="temo-nom">{{ $temo->nom }}</div>
              @if($temo->poste || $temo->entreprise)
                <div class="temo-poste">
                  {{ $temo->poste }}@if($temo->poste && $temo->entreprise) · @endif{{ $temo->entreprise }}
                </div>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- ─── CONTACT ─── -->
  <section class="section" id="contact">
    <div class="container">
      <div class="contact-wrap">
        <div class="reveal-left">
          <div class="section-label">Contact</div>
          <h2 class="section-title">Travaillons ensemble</h2>
          <div class="contact-info">
            <p>Un projet en tête ? Je serais ravi d'en discuter. Remplissez le formulaire ou contactez-moi directement.</p>
            <div class="contact-items">
              @if($params['site_email'] ?? null)
              <div class="contact-item reveal">
                <div class="contact-icon"><i class="bi bi-envelope-fill"></i></div>
                <div>
                  <div class="contact-item-label">Email</div>
                  <div class="contact-item-value">
                    <a href="mailto:{{ $params['site_email'] }}">{{ $params['site_email'] }}</a>
                  </div>
                </div>
              </div>
              @endif
              @if($params['site_telephone'] ?? null)
              <div class="contact-item reveal">
                <div class="contact-icon"><i class="bi bi-telephone-fill"></i></div>
                <div>
                  <div class="contact-item-label">Téléphone</div>
                  <div class="contact-item-value">{{ $params['site_telephone'] }}</div>
                </div>
              </div>
              @endif
              @if($params['site_adresse'] ?? null)
              <div class="contact-item reveal">
                <div class="contact-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div>
                  <div class="contact-item-label">Localisation</div>
                  <div class="contact-item-value">{{ $params['site_adresse'] }}</div>
                </div>
              </div>
              @endif
              @if($params['site_disponibilite'] ?? null)
              <div class="contact-item reveal">
                <div class="contact-icon"><i class="bi bi-alarm"></i></div>
                <div>
                  <div class="contact-item-label">Disponibilité</div>
                  <div class="contact-item-value">{{ $params['site_disponibilite'] }}</div>
                </div>
              </div>
              @endif
            </div>
          </div>
        </div>
        <div class="reveal-right">
          <form class="contact-form" id="contactForm"
            action="{{ route('contact.store') }}"
            novalidate>
            @csrf

            {{-- ── Message succès ── --}}
            <div class="form-alert-success" id="formSuccess" style="display:none">
              <div class="form-alert-ico"><i class="bi bi-check-circle-fill"></i></div>
              <div class="form-alert-body">
                <div class="form-alert-title">Message envoyé !</div>
                <p class="form-alert-msg" id="formSuccessMsg">
                  Votre message a bien été envoyé. Je vous répondrai sous 24h !
                </p>
              </div>
              <button type="button" class="form-alert-close" onclick="this.closest('.form-alert-success').style.display='none'"><i class="bi bi-x"></i></button>
            </div>

            {{-- ── Message erreur ── --}}
            <div class="form-alert-error" id="formError" style="display:none">
              <div class="form-alert-ico"><i class="bi bi-x-circle-fill"></i></div>
              <div class="form-alert-body">
                <div class="form-alert-title">Erreur</div>
                <p class="form-alert-msg" id="formErrorMsg">Une erreur est survenue. Veuillez réessayer.</p>
              </div>
              <button type="button" class="form-alert-close" onclick="this.closest('.form-alert-error').style.display='none'"><i class="bi bi-x"></i></button>
            </div>

            {{-- Prénom + Nom --}}
            <div class="form-row">
              <div class="form-group">
                <label for="fname">Prénom *</label>
                <input type="text" id="fname" name="fname" class="form-control"
                  placeholder="Jean" autocomplete="given-name">
                <div class="field-error" id="fnameErr">Veuillez entrer votre prénom.</div>
              </div>
              <div class="form-group">
                <label for="lname">Nom *</label>
                <input type="text" id="lname" name="lname" class="form-control"
                  placeholder="Dupont" autocomplete="family-name">
                <div class="field-error" id="lnameErr">Veuillez entrer votre nom.</div>
              </div>
            </div>

            {{-- Email + Téléphone --}}
            <div class="form-row">
              <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" class="form-control"
                  placeholder="jean@exemple.com" autocomplete="email">
                <div class="field-error" id="emailErr">Veuillez entrer un email valide.</div>
              </div>
              <div class="form-group">
                <label for="telephone">Téléphone <span style="color:var(--muted);font-weight:400;font-size:.78rem">(optionnel)</span></label>
                <input type="tel" id="telephone" name="telephone" class="form-control"
                  placeholder="+225 07 00 00 00" autocomplete="tel">
              </div>
            </div>

            {{-- Sujet --}}
            <div class="form-group">
              <label for="subject">Sujet</label>
              <input type="text" id="subject" name="subject" class="form-control"
                placeholder="Développement d'une application web">
            </div>

            {{-- Message --}}
            <div class="form-group">
              <label for="message">Message *</label>
              <textarea id="message" name="message" class="form-control"
                placeholder="Décrivez votre projet..."></textarea>
              <div class="field-error" id="messageErr">Veuillez entrer un message (min. 20 caractères).</div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
              <span id="submitIco"><i class="bi bi-envelope-fill"></i></span>
              <span id="submitLabel">Envoyer le message</span>
            </button>

          </form>
          <style>
            /* ── Alertes formulaire ── */
            .form-alert-success,
            .form-alert-error {
              display: flex;
              align-items: flex-start;
              gap: 14px;
              padding: 16px 18px;
              border-radius: 14px;
              margin-bottom: 22px;
              animation: alertSlide .4s cubic-bezier(.4,0,.2,1);
              position: relative;
            }
            @keyframes alertSlide {
              from { opacity: 0; transform: translateY(-10px); }
              to   { opacity: 1; transform: translateY(0); }
            }

            .form-alert-success {
              background: rgba(16,185,129,.08);
              border: 1.5px solid rgba(16,185,129,.25);
            }
            .form-alert-error {
              background: rgba(239,68,68,.07);
              border: 1.5px solid rgba(239,68,68,.22);
            }

            .form-alert-ico {
              font-size: 1.5rem;
              line-height: 1;
              flex-shrink: 0;
              margin-top: 2px;
            }
            .form-alert-success .form-alert-ico { color: var(--success); }
            .form-alert-error   .form-alert-ico { color: var(--danger); }
            .form-alert-body { flex: 1 }

            .form-alert-title {
              font-family: var(--font-display, 'Plus Jakarta Sans', sans-serif);
              font-size: .92rem;
              font-weight: 800;
              margin-bottom: 3px;
            }
            .form-alert-success .form-alert-title { color: #065f46; }
            .form-alert-error   .form-alert-title { color: #991b1b; }
            [data-theme="dark"] .form-alert-success .form-alert-title { color: #6ee7b7; }
            [data-theme="dark"] .form-alert-error   .form-alert-title { color: #fca5a5; }

            .form-alert-msg {
              font-size: .86rem;
              margin: 0;
              line-height: 1.6;
            }
            .form-alert-success .form-alert-msg { color: #047857; }
            .form-alert-error   .form-alert-msg { color: #b91c1c; }
            [data-theme="dark"] .form-alert-success .form-alert-msg { color: #a7f3d0; }
            [data-theme="dark"] .form-alert-error   .form-alert-msg { color: #fecaca; }

            .form-alert-close {
              position: absolute;
              top: 10px; right: 12px;
              background: none;
              border: none;
              cursor: pointer;
              font-size: 1rem;
              opacity: .45;
              transition: opacity .2s;
              padding: 2px 5px;
              border-radius: 4px;
            }
            .form-alert-close:hover { opacity: 1; }
          </style>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('page_js')
<script>
document.getElementById('contactForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const fname   = document.getElementById('fname').value.trim();
  const lname   = document.getElementById('lname').value.trim();
  const email   = document.getElementById('email').value.trim();
  const tel     = document.getElementById('telephone')?.value.trim() || '';
  const message = document.getElementById('message').value.trim();

  // ── Réinitialiser ──
  document.querySelectorAll('.field-error').forEach(el => el.style.display = 'none');
  document.querySelectorAll('.form-control').forEach(el => el.classList.remove('invalid'));
  document.getElementById('formSuccess').style.display = 'none';
  document.getElementById('formError').style.display   = 'none';

  // ── Validation ──
  let hasError = false;
  const addErr = (fieldId, errId) => {
    document.getElementById(errId).style.display = 'block';
    document.getElementById(fieldId).classList.add('invalid');
    hasError = true;
  };
  if (!fname)                                          addErr('fname', 'fnameErr');
  if (!lname)                                          addErr('lname', 'lnameErr');
  if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) addErr('email', 'emailErr');
  if (message.length < 20)                             addErr('message', 'messageErr');
  if (hasError) return;

  // ── Spinner ──
  const btn = document.getElementById('submitBtn');
  const ico = document.getElementById('submitIco');
  const lbl = document.getElementById('submitLabel');
  if (ico) ico.innerHTML = '<i class="bi bi-hourglass-split"></i>';
  if (lbl) lbl.textContent = 'Envoi en cours...';
  btn.disabled = true;

  try {
    const res = await fetch('{{ route("contact.store") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
        'Accept':       'application/json',
      },
      body: JSON.stringify({
        fname:     fname,
        lname:     lname,
        email:     email,
        telephone: tel,
        subject:   document.getElementById('subject')?.value.trim() || '',
        message:   message,
      })
    });

    const data = await res.json();

    if (res.ok && data.success) {
      // ── Succès ──
      const okEl  = document.getElementById('formSuccess');
      const okMsg = document.getElementById('formSuccessMsg');
      if (okMsg) okMsg.textContent = data.message;
      if (okEl)  okEl.style.display = 'flex';
      this.reset();
      okEl?.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
      // ── Erreurs Laravel ──
      if (data.errors) {
        const map = { fname: 'fnameErr', lname: 'lnameErr', email: 'emailErr', message: 'messageErr' };
        Object.entries(data.errors).forEach(([field, msgs]) => {
          const errEl = document.getElementById(map[field]);
          if (errEl) { errEl.textContent = msgs[0]; errEl.style.display = 'block'; }
          document.getElementById(field)?.classList.add('invalid');
        });
      } else {
        const errMsg = document.getElementById('formErrorMsg');
        const errEl  = document.getElementById('formError');
        if (errMsg) errMsg.textContent = data.message || 'Une erreur est survenue.';
        if (errEl)  errEl.style.display = 'flex';
      }
    }

  } catch {
    const errEl = document.getElementById('formError');
    if (errEl) errEl.style.display = 'flex';

  } finally {
    if (ico) ico.innerHTML = '<i class="bi bi-envelope-fill"></i>';
    if (lbl) lbl.textContent = 'Envoyer le message';
    btn.disabled = false;
  }
});
</script>
@endsection
