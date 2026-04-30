/* quienes-somos.js — interactividad de la infografía narrativa
   - Reveal escena por escena al entrar en viewport (.ae-scene.is-visible)
   - Dibuja la curva serpenteante (.ae-pageinfo.is-spine-drawn) al entrar la primera scene
   - Anima paths SVG del flow Glia (.ae-info-flow.in-view)
   - Coordina <details class="ae-ally-details"> en acordeón mutuamente exclusivo
   - Respeta prefers-reduced-motion */
(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ── Reveal scenes (IntersectionObserver — sin GSAP, suficiente para narrativa) ──
  function initSceneReveal() {
    var scenes = document.querySelectorAll('.ae-scene');
    if (!scenes.length) return;
    if (REDUCED) {
      scenes.forEach(function (s) { s.classList.add('is-visible'); });
      return;
    }
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-visible');
        obs.unobserve(e.target);
      });
    }, { threshold: 0.18, rootMargin: '0px 0px -8% 0px' });
    scenes.forEach(function (s) { obs.observe(s); });
  }

  // ── Spine drawing (al entrar la primera scene en viewport) ──
  function initSpineReveal() {
    var pageinfo = document.querySelector('.ae-pageinfo');
    if (!pageinfo) return;
    if (REDUCED) { pageinfo.classList.add('is-spine-drawn'); return; }

    var firstScene = pageinfo.querySelector('.ae-scene');
    if (!firstScene) return;

    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        pageinfo.classList.add('is-spine-drawn');
        obs.unobserve(firstScene);
      });
    }, { threshold: 0.1 });
    obs.observe(firstScene);
  }

  // ── Glia hero flow path-draw ──
  function initFlowReveal() {
    var flow = document.querySelector('.ae-info-flow');
    if (!flow) return;
    if (REDUCED) { flow.classList.add('in-view'); return; }

    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        flow.classList.add('in-view');
        obs.unobserve(flow);
      });
    }, { threshold: 0.3, rootMargin: '0px 0px -10% 0px' });
    obs.observe(flow);
  }

  // ── <details> aliados en acordeón ──
  function initAllyAccordion() {
    var allDetails = document.querySelectorAll('.ae-info-allies .ae-ally-details');
    if (!allDetails.length) return;
    allDetails.forEach(function (det) {
      det.addEventListener('toggle', function () {
        if (!det.open) return;
        allDetails.forEach(function (other) {
          if (other !== det && other.open) other.open = false;
        });
      });
    });
  }

  // ── Inline detail panels: desktop muestra info en panel izquierdo,
  //    mobile (≤ 699.98px) mueve el panel inline debajo de cada card ──
  function initDiagDetail() {
    var head = document.querySelector('.ae-diag-head');
    if (!head) return;
    var diag = document.querySelector('.ae-diag');
    var nodes = document.querySelectorAll('.ae-diag-node[data-detail]');
    if (!nodes.length) return;
    var panels = document.querySelectorAll('.ae-diag-panel[data-detail]');
    var backBtn = head.querySelector('.ae-diag-back');
    var detailContainer = head.querySelector('[data-state-content="detail"]');

    var MQ_MOBILE = window.matchMedia('(max-width: 699.98px)');

    // ── Layout switch: mueve los paneles entre el panel lateral (desktop)
    //    y un host inline inmediatamente después de su card (mobile). ──
    function relocatePanels() {
      var isMobile = MQ_MOBILE.matches;
      nodes.forEach(function (node) {
        var id = node.dataset.detail;
        var panel = document.querySelector('.ae-diag-panel[data-detail="' + id + '"]');
        if (!panel) return;

        if (isMobile) {
          // Asegurar host inline justo después del nodo
          var host = node.nextElementSibling;
          if (!host || !host.classList || !host.classList.contains('ae-diag-mobile-panel-host')) {
            host = document.createElement('div');
            host.className = 'ae-diag-mobile-panel-host';
            host.dataset.detailHost = id;
            if (node.parentNode) {
              node.parentNode.insertBefore(host, node.nextSibling);
            }
          }
          if (panel.parentNode !== host) {
            host.appendChild(panel);
          }
        } else {
          // Volver al panel lateral
          if (detailContainer && panel.parentNode !== detailContainer) {
            detailContainer.appendChild(panel);
          }
          var sib = node.nextElementSibling;
          if (sib && sib.classList && sib.classList.contains('ae-diag-mobile-panel-host')) {
            sib.remove();
          }
        }
      });

      // En mobile no usamos state-machine — siempre intro en .ae-diag-head
      if (isMobile) {
        head.dataset.state = 'intro';
        if (diag) diag.dataset.state = 'intro';
      }
    }

    function showDetail(id) {
      var isMobile = MQ_MOBILE.matches;

      panels.forEach(function (p) {
        if (p.dataset.detail === id) {
          p.removeAttribute('hidden');
          // Notifica a widgets internos (carrusel) que el panel quedó visible
          // para que recalculen medidas que no existían mientras estaba [hidden].
          requestAnimationFrame(function () {
            p.dispatchEvent(new CustomEvent('ae:panel-shown', { bubbles: true }));
          });
        } else {
          p.setAttribute('hidden', '');
        }
      });
      nodes.forEach(function (n) {
        n.classList.toggle('is-open', n.dataset.detail === id);
      });

      if (isMobile) {
        // Mobile: scroll suave para asegurar que el panel abierto sea visible
        var openedNode = document.querySelector('.ae-diag-node.is-open');
        if (openedNode) {
          requestAnimationFrame(function () {
            openedNode.scrollIntoView({
              behavior: REDUCED ? 'auto' : 'smooth',
              block: 'start',
            });
          });
        }
      } else {
        // Desktop: cambiar al estado detail del panel lateral + foco en Volver
        head.dataset.state = 'detail';
        if (diag) diag.dataset.state = 'detail';
        if (backBtn) backBtn.focus({ preventScroll: true });
      }

      // Sync URL hash sin scroll
      if (location.hash !== '#' + id) {
        history.replaceState(null, '', '#' + id);
      }
    }

    function showIntro() {
      panels.forEach(function (p) { p.setAttribute('hidden', ''); });
      nodes.forEach(function (n) { n.classList.remove('is-open'); });
      if (location.hash) history.replaceState(null, '', location.pathname + location.search);
      if (!MQ_MOBILE.matches) {
        head.dataset.state = 'intro';
        if (diag) diag.dataset.state = 'intro';
      }
    }

    nodes.forEach(function (n) {
      n.addEventListener('click', function (e) {
        e.preventDefault();
        var id = n.dataset.detail;
        if (n.classList.contains('is-open')) {
          showIntro();
        } else {
          showDetail(id);
        }
      });
    });

    if (backBtn) backBtn.addEventListener('click', showIntro);

    document.addEventListener('keydown', function (e) {
      if (e.key !== 'Escape') return;
      // Cerrar si hay algún nodo abierto (sirve en ambos modos)
      var anyOpen = document.querySelector('.ae-diag-node.is-open');
      if (anyOpen) showIntro();
    });

    // Click fuera del panel y fuera de los satélites → cerrar (solo desktop;
    // en mobile el panel es parte de la card, no tiene sentido cerrar al
    // tocar en cualquier lado de la página).
    document.addEventListener('click', function (e) {
      if (MQ_MOBILE.matches) return;
      if (head.dataset.state !== 'detail') return;
      if (e.target.closest('.ae-diag-head')) return;
      if (e.target.closest('.ae-diag-node')) return;
      showIntro();
    });

    // Reaccionar a cambios de viewport (girar tablet, redimensionar ventana)
    var onMQChange = function () {
      // Cerrar todo y reubicar paneles según el nuevo modo
      showIntro();
      relocatePanels();
    };
    if (MQ_MOBILE.addEventListener) {
      MQ_MOBILE.addEventListener('change', onMQChange);
    } else if (MQ_MOBILE.addListener) {
      // Safari < 14
      MQ_MOBILE.addListener(onMQChange);
    }

    // Init: ubicar paneles según viewport actual antes del deep-link
    relocatePanels();

    // Deep-link via hash al cargar.
    // Sanitización: allowlist [a-z0-9_-], 1..64 chars. Sin esto, un hash con
    // comillas puede romper el selector CSS o forzar match no deseado.
    if (location.hash) {
      var hashId = location.hash.slice(1);
      if (/^[a-zA-Z0-9_-]{1,64}$/.test(hashId)) {
        var found = document.querySelector('.ae-diag-panel[data-detail="' + hashId + '"]');
        if (found) showDetail(hashId);
      }
    }
  }

  // ── Carrusel horizontal de pasos (BLOQUE 3 · ¿Cómo lo hacemos?) ──
  function initStepCarousel() {
    var roots = document.querySelectorAll('.ae-diag-carousel');
    if (!roots.length) return;

    roots.forEach(function (root) {
      var track = root.querySelector('[data-carousel-track]');
      if (!track) return;
      var items = track.querySelectorAll('.ae-diag-step');
      if (!items.length) return;
      var prev = root.querySelector('[data-carousel-prev]');
      var next = root.querySelector('[data-carousel-next]');
      var dots = root.querySelectorAll('[data-carousel-go]');

      function step() {
        if (items.length < 2) return track.clientWidth;
        // Distancia real entre 2 items (incluye gap)
        return items[1].offsetLeft - items[0].offsetLeft;
      }
      function activeIndex() {
        var w = step();
        if (!w) return 0;
        return Math.round(track.scrollLeft / w);
      }
      function goTo(i) {
        var w = step();
        var clamped = Math.max(0, Math.min(items.length - 1, i));
        try {
          track.scrollTo({
            left: clamped * w,
            behavior: REDUCED ? 'auto' : 'smooth'
          });
        } catch (_) {
          track.scrollLeft = clamped * w;
        }
      }
      function sync() {
        var i = activeIndex();
        dots.forEach(function (d, idx) { d.classList.toggle('is-active', idx === i); });
        if (prev) prev.disabled = i <= 0;
        if (next) next.disabled = i >= items.length - 1;
      }

      if (prev) prev.addEventListener('click', function () { goTo(activeIndex() - 1); });
      if (next) next.addEventListener('click', function () { goTo(activeIndex() + 1); });
      dots.forEach(function (d) {
        d.addEventListener('click', function () {
          var i = parseInt(d.getAttribute('data-carousel-go'), 10);
          if (!isNaN(i)) goTo(i);
        });
      });

      var raf = null;
      track.addEventListener('scroll', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
      }, { passive: true });

      // El carrusel suele cargarse dentro de un panel [hidden]: re-sincroniza
      // cuando el panel pase a visible y al cambiar el tamaño de ventana.
      var panel = root.closest('.ae-diag-panel');
      if (panel) {
        panel.addEventListener('ae:panel-shown', function () {
          track.scrollLeft = 0;
          requestAnimationFrame(sync);
        });
      }
      window.addEventListener('resize', function () {
        if (raf) cancelAnimationFrame(raf);
        raf = requestAnimationFrame(sync);
      });

      // Init
      requestAnimationFrame(sync);
    });
  }

  // ── Counter animation para BLOQUE 4 (Impacto en cifras) ──
  // Se dispara cada vez que el panel se hace visible (ae:panel-shown).
  // Conserva sufijos (M+, k+, %) y separador de miles es-CO (2.798).
  function initStatsCounter() {
    var panels = document.querySelectorAll('.ae-diag-panel');
    if (!panels.length) return;

    function formatNum(n, fmt) {
      if (fmt === 'thousand-dot') {
        // 2798 → "2.798" (es-CO usa punto como separador de miles)
        return n.toLocaleString('es-CO');
      }
      return String(n);
    }

    function animateNumber(el) {
      var target = parseInt(el.dataset.countTo, 10);
      if (isNaN(target)) return;
      var suffix = el.dataset.suffix || '';
      var fmt = el.dataset.format || '';

      if (REDUCED) {
        el.textContent = formatNum(target, fmt) + suffix;
        return;
      }

      // Duración proporcional al valor: cifras grandes corren un pelín más
      var duration = target > 500 ? 1400 : 1000;
      var start = null;

      function tick(now) {
        if (start === null) start = now;
        var t = Math.min(1, (now - start) / duration);
        // ease-out cubic
        var eased = 1 - Math.pow(1 - t, 3);
        var current = Math.floor(target * eased);
        el.textContent = formatNum(current, fmt) + suffix;
        if (t < 1) requestAnimationFrame(tick);
        else el.textContent = formatNum(target, fmt) + suffix;
      }
      requestAnimationFrame(tick);
    }

    function runPanel(panel) {
      var stats = panel.querySelectorAll('.ae-diag-stat');
      // Re-disparar la animación de entrada CSS reseteando la clase
      stats.forEach(function (el, i) {
        el.classList.remove('is-animating');
        // Forzar reflow para que la animación se re-ejecute
        // (lectura de offsetWidth basta)
        void el.offsetWidth;
        el.style.setProperty('--ae-stat-delay', (i * 90) + 'ms');
        el.classList.add('is-animating');
      });

      var nums = panel.querySelectorAll('.ae-diag-stat-num[data-count-to]');
      nums.forEach(function (el, i) {
        // Empieza a contar 80ms después de que arranca el pop de la card
        setTimeout(function () { animateNumber(el); }, i * 90 + 80);
      });
    }

    panels.forEach(function (p) {
      p.addEventListener('ae:panel-shown', function () { runPanel(p); });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initSceneReveal();
    initSpineReveal();
    initFlowReveal();
    initAllyAccordion();
    initDiagDetail();
    initStepCarousel();
    initStatsCounter();
  });
})();
