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

  // ── Init all page-specific modules ──
  document.addEventListener('DOMContentLoaded', function () {
    initChatWidget();
    initPrensaTabs();
    initFaqScrollHint();
  });
})();
