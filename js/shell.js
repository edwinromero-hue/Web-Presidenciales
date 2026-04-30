/* Shell.js — Header, progress rail, reveals, smooth anchors, mobile drawer, countdown, back-to-top, footer accordion, sticky CTA */

(function() {
  'use strict';

  var REDUCED_MOTION = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ── Header floating + Progress rail ──
  function initShell() {
    var hdr = document.querySelector('.hdr-wrap');
    var fill = document.getElementById('pfill');
    var flagRule = document.querySelector('.flag-rule');
    var lastFloat = false;
    var ticking = false;

    function onScroll() {
      var y = window.scrollY;
      var shouldFloat = y > 80;
      if (shouldFloat !== lastFloat) {
        lastFloat = shouldFloat;
        if (hdr) hdr.classList.toggle('floating', shouldFloat);
        if (flagRule) flagRule.style.display = shouldFloat ? 'none' : 'flex';
      }
      if (fill) {
        var docH = document.documentElement.scrollHeight - window.innerHeight;
        fill.style.width = (docH > 0 ? Math.min(100, (y / docH) * 100) : 0) + '%';
      }
      ticking = false;
    }

    window.addEventListener('scroll', function() {
      if (!ticking) { requestAnimationFrame(onScroll); ticking = true; }
    }, { passive: true });
  }

  // ── Data-enter observer ──
  function initEnterObserver() {
    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(e) {
        if (e.isIntersecting) {
          e.target.classList.add('in');
          obs.unobserve(e.target);
        }
      });
    }, { threshold: 0.01, rootMargin: '0px 0px 0px 0px' });
    var targets = document.querySelectorAll('[data-enter]');
    targets.forEach(function(el) { obs.observe(el); });

    // Safety net: tras 800ms, cualquier [data-enter] que no tenga .in y esté
    // al menos parcialmente en el viewport se fuerza visible. Evita que una
    // sección quede vacía si el observer no llega a disparar por cualquier motivo.
    setTimeout(function() {
      document.querySelectorAll('[data-enter]:not(.in)').forEach(function(el) {
        var r = el.getBoundingClientRect();
        if (r.top < window.innerHeight && r.bottom > 0) {
          el.classList.add('in');
          obs.unobserve(el);
        }
      });
    }, 800);
  }

  // ── Smooth anchor scroll ──
  function initSmoothAnchors() {
    document.addEventListener('click', function(e) {
      var a = e.target.closest('a[href^="#"]');
      if (!a) return;
      var id = a.getAttribute('href').slice(1);
      if (!id) return;
      var el = document.getElementById(id);
      if (!el) return;
      e.preventDefault();
      el.scrollIntoView({ behavior: REDUCED_MOTION ? 'auto' : 'smooth', block: 'start' });
    });
  }

  // ── Mobile drawer — off-canvas con overlay, scroll-lock, focus trap, Esc ──
  function initMobileNav() {
    var toggle = document.querySelector('.hdr-mobile-toggle');
    var nav = document.querySelector('.hdr-mobile-nav');
    if (!toggle || !nav) return;

    // Overlay (se crea si no existe)
    var overlay = document.querySelector('.hdr-overlay');
    if (!overlay) {
      overlay = document.createElement('div');
      overlay.className = 'hdr-overlay';
      overlay.setAttribute('aria-hidden', 'true');
      document.body.appendChild(overlay);
    }

    // aria-controls + id
    if (!nav.id) nav.id = 'aeMobileNav';
    toggle.setAttribute('aria-controls', nav.id);
    toggle.setAttribute('aria-expanded', 'false');

    var scrollY = 0;
    var isOpen = false;
    var focusableSel = 'a, button, [tabindex]:not([tabindex="-1"])';
    var closeBtn = nav.querySelector('.mnav-close');

    function lockScroll() {
      scrollY = window.scrollY;
      document.body.style.top = '-' + scrollY + 'px';
      document.body.classList.add('no-scroll');
    }
    function unlockScroll() {
      document.body.classList.remove('no-scroll');
      document.body.style.top = '';
      window.scrollTo(0, scrollY);
    }

    function openNav() {
      if (isOpen) return;
      isOpen = true;
      nav.classList.add('open');
      overlay.classList.add('open');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', 'Cerrar menú');
      nav.setAttribute('aria-hidden', 'false');
      lockScroll();
      var first = nav.querySelector(focusableSel);
      if (first) setTimeout(function(){ first.focus(); }, 50);
    }
    function closeNav() {
      if (!isOpen) return;
      isOpen = false;
      nav.classList.remove('open');
      overlay.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Abrir menú');
      nav.setAttribute('aria-hidden', 'true');
      unlockScroll();
      toggle.focus();
    }

    toggle.addEventListener('click', function() { isOpen ? closeNav() : openNav(); });
    overlay.addEventListener('click', closeNav);
    if (closeBtn) closeBtn.addEventListener('click', closeNav);

    nav.addEventListener('click', function(e) {
      if (e.target.tagName === 'A') closeNav();
    });

    // Esc cierra + focus trap
    document.addEventListener('keydown', function(e) {
      if (!isOpen) return;
      if (e.key === 'Escape') { e.preventDefault(); closeNav(); return; }
      if (e.key === 'Tab') {
        var focusable = nav.querySelectorAll(focusableSel);
        if (!focusable.length) return;
        var first = focusable[0];
        var last = focusable[focusable.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      }
    });

    // Si la ventana se agranda a desktop, cierra el drawer
    var mql = window.matchMedia('(min-width: 1000px)');
    var mqlHandler = function(e) { if (e.matches && isOpen) closeNav(); };
    if (mql.addEventListener) mql.addEventListener('change', mqlHandler);
    else if (mql.addListener) mql.addListener(mqlHandler);
  }

  // ── Countdown ──
  function initCountdown() {
    var els = document.querySelectorAll('[data-countdown]');
    if (!els.length) return;
    var target = new Date('2026-05-31T08:00:00-05:00').getTime();
    function update() {
      var diff = Math.max(0, target - Date.now());
      var d = Math.floor(diff / 86400000);
      var h = Math.floor((diff % 86400000) / 3600000);
      var m = Math.floor((diff % 3600000) / 60000);
      var s = Math.floor((diff % 60000) / 1000);
      els.forEach(function(el) {
        var dEl = el.querySelector('[data-cd="d"]');
        var hEl = el.querySelector('[data-cd="h"]');
        var mEl = el.querySelector('[data-cd="m"]');
        var sEl = el.querySelector('[data-cd="s"]');
        if (dEl) dEl.textContent = String(d).padStart(2, '0');
        if (hEl) hEl.textContent = String(h).padStart(2, '0');
        if (mEl) mEl.textContent = String(m).padStart(2, '0');
        if (sEl) sEl.textContent = String(s).padStart(2, '0');
      });
    }
    update();
    // Interval intencional: actualiza el contador cada segundo durante
    // toda la vida de la página. No se limpia porque el timer solo termina
    // con el unload del documento (no hay SPA navigation en este sitio).
    setInterval(update, 1000);
  }

  // ── Back-to-top ──
  function initBackToTop() {
    var btn = document.querySelector('.back-top');
    if (!btn) return;
    var ticking = false;
    function check() {
      btn.classList.toggle('show', window.scrollY > 600);
      ticking = false;
    }
    window.addEventListener('scroll', function() {
      if (!ticking) { requestAnimationFrame(check); ticking = true; }
    }, { passive: true });
    btn.addEventListener('click', function() {
      window.scrollTo({ top: 0, behavior: REDUCED_MOTION ? 'auto' : 'smooth' });
    });
  }

  // ── Sticky CTA bottom (home móvil) ──
  function initStickyCTA() {
    var bar = document.querySelector('.sticky-cta');
    if (!bar) return;
    var ticking = false;
    function check() {
      bar.classList.toggle('show', window.scrollY > 400);
      ticking = false;
    }
    window.addEventListener('scroll', function() {
      if (!ticking) { requestAnimationFrame(check); ticking = true; }
    }, { passive: true });
  }

  // ── Footer acordeón (solo móvil vía CSS; JS controla data-open) ──
  function initFooterAccordion() {
    document.querySelectorAll('.footer-col').forEach(function(col) {
      var btn = col.querySelector('.footer-col-btn');
      if (!btn) return;
      btn.setAttribute('aria-expanded', 'false');
      btn.addEventListener('click', function() {
        var open = col.getAttribute('data-open') === 'true';
        col.setAttribute('data-open', open ? 'false' : 'true');
        btn.setAttribute('aria-expanded', open ? 'false' : 'true');
      });
    });
  }

  // Nota: el patrón FAQ (entrenamiento módulos, etc.) lo maneja scrolly.js:initFAQ
  // con semántica de "un solo abierto por .faq-group". Aquí no duplicamos listeners.
  // Canales usa variante `.ae-faq-btn` con onclick inline propio.

  // ── Header active state — marca .active + aria-current="page"
  // sobre los <a data-nav="X"> que coinciden con <body data-page="X">.
  // Mantiene la single-source-of-truth del partial sin que cada página
  // tenga que duplicar marcado por estado activo.
  function initHeaderActive() {
    var page = document.body && document.body.dataset && document.body.dataset.page;
    if (!page) return;
    var links = document.querySelectorAll('[data-nav="' + CSS.escape(page) + '"]');
    links.forEach(function(a) {
      a.classList.add('active');
      a.setAttribute('aria-current', 'page');
    });
  }

  // ── Init all ──
  document.addEventListener('DOMContentLoaded', function() {
    initHeaderActive();
    initShell();
    initEnterObserver();
    initSmoothAnchors();
    initMobileNav();
    initCountdown();
    initBackToTop();
    initStickyCTA();
    initFooterAccordion();
  });

  window.AEShell = { REDUCED_MOTION: REDUCED_MOTION };
})();
