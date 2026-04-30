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

  // ── Eventos: Calendar grid generator ──
  function initCalendar() {
    var grid = document.getElementById('calGrid');
    if (!grid) return;
    var eventDays = [8, 15, 17, 22, 24];

    // Event delegation: 1 listener on the grid instead of 30.
    grid.addEventListener('click', function (e) {
      var btn = e.target.closest('.cal-day');
      if (!btn || !grid.contains(btn)) return;
      grid.querySelectorAll('.cal-day').forEach(function (b) {
        b.style.background = '#fff';
      });
      btn.style.background = '#ffc627';
    });

    for (var i = 1; i <= 30; i++) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'cal-day';
      btn.setAttribute('aria-label', 'Día ' + i);
      btn.style.cssText = 'aspect-ratio:1/1;border:0.5px solid #f1f5f9;background:' + (i === 15 ? '#ffc627' : '#fff') + ';cursor:pointer;padding:8px;display:flex;flex-direction:column;align-items:flex-start;font-family:inherit';
      var num = document.createElement('div');
      num.style.cssText = 'font-size:13px;font-weight:800;color:#0f172a';
      num.textContent = i;
      btn.appendChild(num);
      if (eventDays.indexOf(i) !== -1) {
        var lbl = document.createElement('div');
        lbl.style.cssText = 'font-size:9px;margin-top:4px;padding:2px 4px;background:' + (i === 15 ? '#1e3a8a' : '#eaf1ff') + ';color:' + (i === 15 ? '#fff' : '#1e3a8a') + ';border-radius:4px;font-weight:700;line-height:1.2;text-align:left';
        lbl.textContent = 'Campaña pres...';
        btn.appendChild(lbl);
      }
      grid.appendChild(btn);
    }
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
    initCalendar();
    initFaqScrollHint();
  });
})();
