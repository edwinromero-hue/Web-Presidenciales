/* inicio.js — Scene callbacks for the home page */
(function() {
  'use strict';

  var range = AEScrolly.range;
  var stepAt = AEScrolly.stepAt;

  // ── Hero Scene ──
  var ppData = [
    { tag:'01 · LEGITIMIDAD', title:'GARANTIZAR LA LEGITIMIDAD ELECTORAL', body:'Con más de 127.000 testigos acreditados, Actores Electorales verifica cada paso del proceso para que cada voto cuente.' },
    { tag:'02 · TRANSPARENCIA', title:'ASEGURAR LA TRANSPARENCIA DEL PROCESO', body:'Una plataforma única que permite vigilar, en tiempo real, la apertura de mesas, el escrutinio y el conteo.' },
    { tag:'03 · PARTICIPACIÓN', title:'MODERNIZAR LA DEMOCRACIA', body:'COMITIUM acerca el proceso electoral a cada ciudadano. Tecnología de punta al servicio de la democracia.' },
  ];

  window.scene_heroScene = function(p) {
    var photo = document.getElementById('heroPhoto');
    var bgLight = document.getElementById('heroBgLight');
    var chip = document.getElementById('heroChip');
    var titleWrap = document.getElementById('heroTitle');
    var sub = document.getElementById('heroSub');
    var cd = document.getElementById('heroCd');
    var scroll = document.getElementById('heroScroll');
    var hex1 = document.getElementById('heroHex1');
    var hex2 = document.getElementById('heroHex2');

    var photoOp = range(p, 0.15, 0.45);
    var scrimOp = range(p, 0.45, 0.85);

    if (photo) {
      photo.style.opacity = photoOp;
      photo.style.transform = 'scale(' + (1.15 - photoOp * 0.15) + ') translateY(' + (p * -40) + 'px)';
    }
    if (bgLight) bgLight.style.opacity = 1 - photoOp;

    var textColor = photoOp > 0.5 ? '#fff' : '#0f172a';
    if (titleWrap) {
      titleWrap.style.transform = 'translateY(' + (-p * 120) + 'px) scale(' + (1 - p * 0.15) + ')';
      titleWrap.style.opacity = 1 - range(p, 0.5, 0.8);
      titleWrap.style.color = textColor;
    }
    if (sub) {
      sub.style.transform = 'translateY(' + (-p * 240) + 'px)';
      sub.style.opacity = 1 - range(p, 0.2, 0.45);
    }
    if (chip) {
      chip.style.transform = 'translate(-50%, ' + (-p * 100) + 'px)';
      chip.style.opacity = 1 - range(p, 0.1, 0.3);
    }
    var cdOp = range(p, 0.05, 0.22);
    if (cd) {
      cd.style.opacity = cdOp;
      cd.style.transform = 'translate(-50%, ' + ((1 - cdOp) * 50) + 'px)';
      cd.style.color = textColor;
      var cdNums = cd.querySelectorAll('[data-cd]');
      cdNums.forEach(function(el) { el.style.color = photoOp > 0.5 ? '#ffc627' : '#1e3a8a'; });
      // a11y: label "Faltan para…" 11px bold: sobre foto (oscura) pasa de #475569 (fail ~2.59) a #e2e8f0 (>=7)
      var cdLabel = cd.querySelector('[data-cd-label]');
      if (!cdLabel) cdLabel = cd.firstElementChild; // primer div = label
      if (cdLabel) cdLabel.style.color = photoOp > 0.5 ? '#e2e8f0' : '#475569';
    }
    if (scroll) scroll.style.opacity = 1 - p * 3;
    // hex1/hex2 ahora se animan vía data-parallax (funciona en móvil y desktop)

    // Scrim intensity
    var scrim = document.getElementById('heroScrim');
    if (scrim) scrim.style.background = 'linear-gradient(180deg,rgba(15,23,42,' + (0.35 + scrimOp * 0.2) + '),rgba(15,23,42,' + (0.5 + scrimOp * 0.3) + '))';
  };

  // ── Statement Scene ──
  window.scene_statementScene = function(p) {
    var wrap = document.getElementById('statementWrap');
    if (!wrap) return;
    if (p < 0.33) wrap.style.background = 'var(--ae-blue-soft)';
    else if (p < 0.66) wrap.style.background = '#ffffff';
    else wrap.style.background = 'var(--ae-ink)';
    wrap.querySelector('h2').style.color = p >= 0.66 ? '#fff' : 'var(--ae-ink)';
  };

  // ── Pin Photo Scene ──
  window.scene_pinPhotoScene = function(p) {
    var data = stepAt(p, 3);
    var step = data.step;
    var slides = document.querySelectorAll('.pin-photo-slide');
    slides.forEach(function(s, i) { s.style.opacity = i === step ? 1 : 0; });

    var tag = document.getElementById('ppTag');
    var title = document.getElementById('ppTitle');
    var body = document.getElementById('ppBody');
    if (tag) tag.textContent = ppData[step].tag;
    if (title) title.textContent = ppData[step].title;
    if (body) body.textContent = ppData[step].body;

    var dots = document.querySelectorAll('.pp-dot');
    dots.forEach(function(d, i) { d.style.background = i === step ? '#ffc627' : 'rgba(255,255,255,0.25)'; });
  };

  // ── Card Stack Scene — desktop: scrub con stack; mobile: reveals escalonados ──
  var isDesktop = window.matchMedia('(min-width: 1000px)').matches;

  window.scene_cardStackScene = function(p) {
    // En móvil NO usamos scroll progress: las cards se revelan por IntersectionObserver
    // (clase .in agregada por shell.js initEnterObserver), así que no hacemos nada aquí.
    if (!isDesktop) return;

    for (var i = 0; i < 3; i++) {
      var card = document.getElementById('lcard' + i);
      if (!card) continue;
      var cardP = range(p, i * 0.22, i * 0.22 + 0.22);
      var pushBack = i < 2 ? range(p, (i + 1) * 0.22, (i + 1) * 0.22 + 0.18) : 0;
      var ty = (1 - cardP) * 120 - pushBack * 28;
      var scale = 1 - pushBack * 0.06;
      card.style.transform = 'translateY(' + ty + 'px) scale(' + scale + ')';
      var fadeIn = Math.min(1, cardP * 5);
      card.style.opacity = fadeIn * (1 - pushBack * 0.15);
    }
  };

  // En móvil: marcamos las layer-card con data-enter ANTES del DOMContentLoaded,
  // para que shell.js initEnterObserver las observe. En desktop las deja limpias para
  // que el callback de la escena las anime vía scrub.
  if (!isDesktop) {
    ['lcard0','lcard1','lcard2'].forEach(function(id, i) {
      var el = document.getElementById(id);
      if (!el) return;
      el.setAttribute('data-enter', '');
      el.setAttribute('data-delay', String(i + 1));
    });
  }

  // ── Quotes Scene ──
  window.scene_quotesScene = function(p) {
    var data = stepAt(p, 3);
    var step = data.step;
    var slides = document.querySelectorAll('.quote-slide');
    slides.forEach(function(s, i) {
      s.style.opacity = i === step ? 1 : 0;
      s.style.transform = 'translateY(' + (i === step ? 0 : 20) + 'px)';
    });
    var dots = document.getElementById('quoteDots');
    if (dots) {
      var children = dots.children;
      for (var i = 0; i < children.length; i++) {
        children[i].style.width = i === step ? '32px' : '12px';
        children[i].style.background = i === step ? '#ffc627' : 'rgba(255,255,255,0.2)';
      }
    }
  };
})();
