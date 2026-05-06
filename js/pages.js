/* pages.js — Page-specific initializers (canales, prensa, eventos)
   Extracted from inline <script> blocks to keep HTML clean and cacheable.
   Each init function is guarded by DOM presence checks, so loading this
   file on any page is safe (no-op if elements are absent). */

(function () {
  'use strict';

  // ── Canales: Chat widget open/close ──
  function initChatWidget() {
    var widget = document.getElementById('chatWidget');
    var toggle = document.getElementById('chatToggle');
    var closeBtn = document.getElementById('chatClose');
    if (!widget || !toggle) return;
    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        widget.style.display = 'none';
        toggle.style.display = 'block';
      });
    }
    toggle.addEventListener('click', function () {
      widget.style.display = 'flex';
      toggle.style.display = 'none';
    });
  }

  // ── Prensa: Tab bar + filter buttons ──
  function initPrensaTabs() {
    var tabs = document.querySelectorAll('.prensa-tab');
    if (!tabs.length) return;
    var pressContact = document.querySelector('[data-press-contact]');
    var pressKit = document.querySelector('[data-press-kit]');
    var newsList = document.querySelector('[data-news-list]');
    tabs.forEach(function (btn) {
      btn.addEventListener('click', function () {
        tabs.forEach(function (b) {
          b.style.color = '#475569';
          b.style.borderBottom = '3px solid transparent';
          b.setAttribute('aria-pressed', 'false');
        });
        btn.style.color = '#1e3a8a';
        btn.style.borderBottom = '3px solid #1e3a8a';
        btn.setAttribute('aria-pressed', 'true');
        var current = btn.dataset.tab;
        if (pressContact) pressContact.hidden = current !== 'comunicados';
        if (pressKit) pressKit.hidden = current !== 'kit';
        if (newsList) newsList.hidden = current === 'kit';
      });
    });

    var filters = document.querySelectorAll('.filter-btn');
    if (!filters.length) return;
    filters.forEach(function (btn) {
      btn.addEventListener('click', function () {
        filters.forEach(function (b) {
          b.style.background = 'transparent';
          b.style.color = '#475569';
          b.style.borderColor = '#e2e8f0';
          b.setAttribute('aria-pressed', 'false');
        });
        btn.style.background = '#1e3a8a';
        btn.style.color = '#fff';
        btn.style.borderColor = '#1e3a8a';
        btn.setAttribute('aria-pressed', 'true');
      });
    });
  }

  // ── Canales: FAQ scroll-end detector ──
  // Cuando el usuario llega al final del .faq-group, marcamos el
  // contenedor padre .ae-contact-faq con .is-faq-bottom — el CSS oculta
  // el badge "↓ Hay más preguntas". Si vuelve a subir, el badge regresa.
  function initFaqScrollHint() {
    var faqs = document.querySelectorAll('.ae-contact-faq');
    if (!faqs.length) return;
    faqs.forEach(function (faq) {
      var group = faq.querySelector('.faq-group');
      if (!group) return;
      function check() {
        var atBottom = group.scrollTop + group.clientHeight >= group.scrollHeight - 4;
        var fits = group.scrollHeight <= group.clientHeight + 1;
        // Si todo cabe → no hay scroll → ocultar badge.
        // Si llegó al final → ocultar badge.
        faq.classList.toggle('is-faq-bottom', atBottom || fits);
      }
      var raf = null;
      group.addEventListener('scroll', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(check);
      }, { passive: true });
      // Re-evaluar cuando se abren/cierran acordeones (cambian la altura)
      faq.querySelectorAll('.ae-faq-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          // Esperar a que termine la transición max-height (300ms)
          setTimeout(check, 320);
        });
      });
      // Re-evaluar al redimensionar la ventana
      window.addEventListener('resize', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(check);
      });
      // Init
      requestAnimationFrame(check);
    });
  }

  // ── Detalle (evento / comunicado): carrusel hero ──
  // Estructura mínima esperada:
  //   .ae-event-hero[data-hero-carousel]
  //     .ae-event-hero-track (scroll-snap-x)
  //       .ae-event-hero-slide × N (img + opcional data-caption)
  //     .ae-event-hero-caption (texto del slide activo)
  //     .ae-event-hero-counter (1 / N)
  //     .ae-event-hero-nav.prev / .next
  //     .ae-event-hero-dots > button[data-hero-go]
  function initHeroCarousels() {
    var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var roots = document.querySelectorAll('[data-hero-carousel]');
    if (!roots.length) return;

    roots.forEach(function (root) {
      var track = root.querySelector('.ae-event-hero-track');
      if (!track) return;
      var slides = track.querySelectorAll('.ae-event-hero-slide');
      var total = slides.length;
      root.setAttribute('data-slides', String(total));
      if (total <= 1) return;

      var prev = root.querySelector('.ae-event-hero-nav.prev');
      var next = root.querySelector('.ae-event-hero-nav.next');
      var dots = root.querySelectorAll('.ae-event-hero-dots [data-hero-go]');
      var caption = root.querySelector('.ae-event-hero-caption');
      var counter = root.querySelector('.ae-event-hero-counter');

      function step() {
        if (total < 2) return track.clientWidth;
        return slides[1].offsetLeft - slides[0].offsetLeft;
      }
      function activeIndex() {
        var w = step();
        if (!w) return 0;
        return Math.max(0, Math.min(total - 1, Math.round(track.scrollLeft / w)));
      }
      function goTo(i) {
        var w = step();
        var clamped = Math.max(0, Math.min(total - 1, i));
        try {
          track.scrollTo({ left: clamped * w, behavior: REDUCED ? 'auto' : 'smooth' });
        } catch (_) {
          track.scrollLeft = clamped * w;
        }
      }
      function sync() {
        var i = activeIndex();
        dots.forEach(function (d, idx) {
          d.setAttribute('aria-selected', idx === i ? 'true' : 'false');
        });
        if (prev) prev.disabled = i <= 0;
        if (next) next.disabled = i >= total - 1;
        if (counter) counter.textContent = (i + 1) + ' / ' + total;
        if (caption) {
          var cap = slides[i].getAttribute('data-caption') || '';
          caption.textContent = cap;
          caption.style.display = cap ? '' : 'none';
        }
      }

      if (prev) prev.addEventListener('click', function () { goTo(activeIndex() - 1); });
      if (next) next.addEventListener('click', function () { goTo(activeIndex() + 1); });
      dots.forEach(function (d) {
        d.addEventListener('click', function () {
          var i = parseInt(d.getAttribute('data-hero-go'), 10);
          if (!isNaN(i)) goTo(i);
        });
      });

      // Teclado (←/→/Home/End) cuando el carrusel tiene foco
      root.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') { e.preventDefault(); goTo(activeIndex() - 1); }
        else if (e.key === 'ArrowRight') { e.preventDefault(); goTo(activeIndex() + 1); }
        else if (e.key === 'Home') { e.preventDefault(); goTo(0); }
        else if (e.key === 'End') { e.preventDefault(); goTo(total - 1); }
      });

      var raf = null;
      track.addEventListener('scroll', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
      }, { passive: true });

      window.addEventListener('resize', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
      });

      // Init
      requestAnimationFrame(sync);
    });
  }

  // ── Init all page-specific modules ──
  document.addEventListener('DOMContentLoaded', function () {
    initChatWidget();
    initPrensaTabs();
    initFaqScrollHint();
    initHeroCarousels();
  });
})();
