/* Scrolly.js — GSAP ScrollTrigger scrollytelling. Mobile-aware: pin solo en ≥1000px. */

(function () {
  'use strict';

  var REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var DESKTOP_MQ = '(min-width: 1000px)';
  var isDesktop = window.matchMedia(DESKTOP_MQ).matches;
  var hasGSAP = typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined';
  if (hasGSAP) {
    gsap.registerPlugin(ScrollTrigger);
    ScrollTrigger.config({ ignoreMobileResize: true }); // evita refresh por barra URL iOS
  }

  // ── Utility ──
  function clamp01(v) { return Math.max(0, Math.min(1, v)); }
  function range(p, a, b) { return clamp01((p - a) / (b - a)); }
  function stepAt(p, n) {
    var s = Math.min(n - 1, Math.floor(p * n));
    var local = Math.max(0, Math.min(1, (p - s / n) * n));
    return { step: s, local: local };
  }

  // ── Sticky Scene — solo desktop; móvil recibe progress=1 inmediato (estado final) ──
  function initStickyScenes() {
    document.querySelectorAll('.scene[data-steps]').forEach(function (scene) {
      var steps = parseInt(scene.getAttribute('data-steps')) || 3;
      var vhPerStep = parseFloat(scene.getAttribute('data-vh-per-step')) || 65;

      var callback = window['scene_' + scene.id];
      if (!callback) return;

      // Mobile: no aplicamos scrub. Dejamos los estados por defecto del HTML.
      // Reduced-motion: NO ejecutamos el scrub callback (que oculta slides y hace
      // transforms). El CSS @media (prefers-reduced-motion: reduce) apila todas las
      // slides (.pin-photo-slide / .quote-slide) y las muestra estáticamente.
      if (!isDesktop) {
        scene.style.minHeight = '';
        return;
      }
      if (REDUCED) {
        scene.style.minHeight = '';
        return;
      }

      scene.style.minHeight = (steps * vhPerStep) + 'vh';

      if (hasGSAP) {
        ScrollTrigger.create({
          trigger: scene,
          start: 'top top',
          end: 'bottom bottom',
          scrub: true,
          invalidateOnRefresh: true,
          onUpdate: function (self) { callback(self.progress, scene); }
        });
      } else {
        window.addEventListener('scroll', function () {
          var r = scene.getBoundingClientRect();
          var vh = window.innerHeight;
          var total = r.height - vh;
          var p = total <= 0 ? (r.top < 0 ? 1 : 0) : clamp01(-r.top / total);
          callback(p, scene);
        }, { passive: true });
      }
    });
  }

  // ── Count-up ──
  function initCountUp() {
    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        obs.unobserve(e.target);
        var target = parseFloat(e.target.getAttribute('data-countup')) || 0;
        var duration = parseFloat(e.target.getAttribute('data-duration')) || 2000;
        var suffix = e.target.getAttribute('data-suffix') || '';
        var locale = e.target.getAttribute('data-locale') !== 'false';

        if (REDUCED) {
          e.target.textContent = (locale ? target.toLocaleString('es-CO') : target) + suffix;
          return;
        }

        if (hasGSAP) {
          var obj = { v: 0 };
          gsap.to(obj, {
            v: target, duration: duration / 1000, ease: 'power2.out',
            onUpdate: function () {
              e.target.textContent = (locale ? Math.floor(obj.v).toLocaleString('es-CO') : Math.floor(obj.v)) + suffix;
            }
          });
        } else {
          var start = performance.now();
          (function animate(now) {
            var t = Math.min(1, (now - start) / duration);
            var eased = 1 - Math.pow(1 - t, 3);
            var val = Math.floor(target * eased);
            e.target.textContent = (locale ? val.toLocaleString('es-CO') : val) + suffix;
            if (t < 1) requestAnimationFrame(animate);
          })(performance.now());
        }
      });
    }, { threshold: 0.3 });

    document.querySelectorAll('[data-countup]').forEach(function (el) { obs.observe(el); });
  }

  // ── Word Reveal ──
  function initWordReveal() {
    function reveal(el) {
      var words = el.querySelectorAll('.word-reveal-word');
      var stagger = parseInt(el.getAttribute('data-word-stagger')) || 45;
      words.forEach(function (w, i) {
        setTimeout(function () { w.classList.add('revealed'); }, i * stagger);
      });
    }

    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        obs.unobserve(e.target);
        reveal(e.target);
      });
    }, { threshold: 0.01, rootMargin: '0px 0px 0px 0px' });

    var elements = [];
    document.querySelectorAll('[data-word-reveal]').forEach(function (el) {
      var text = el.textContent.trim();
      el.setAttribute('aria-label', text);
      el.innerHTML = '';
      text.split(' ').forEach(function (word) {
        var outer = document.createElement('span');
        outer.className = 'word-reveal-word';
        var inner = document.createElement('span');
        inner.className = 'word-reveal-inner';
        inner.textContent = word;
        inner.setAttribute('aria-hidden', 'true');
        outer.appendChild(inner);
        el.appendChild(outer);
      });
      if (REDUCED) {
        el.querySelectorAll('.word-reveal-word').forEach(function (w) { w.classList.add('revealed'); });
      } else {
        obs.observe(el);
        elements.push(el);
      }
    });

    // Safety net: si el observer no dispara en 800ms para un elemento ya visible,
    // revelamos las palabras para evitar que la sección quede vacía.
    setTimeout(function () {
      elements.forEach(function (el) {
        if (el.querySelector('.word-reveal-word.revealed')) return;
        var r = el.getBoundingClientRect();
        if (r.top < window.innerHeight && r.bottom > 0) {
          obs.unobserve(el);
          reveal(el);
        }
      });
    }, 800);
  }

  // ── Horizontal Section — SOLO desktop. Móvil usa scroll-snap nativo (CSS). ──
  function initHorizontalSections() {
    if (!hasGSAP || REDUCED || !isDesktop) return;
    document.querySelectorAll('.hz-section').forEach(function (section) {
      var track = section.querySelector('.hz-track');
      if (!track) return;
      var panels = track.children;
      var totalWidth = 0;
      for (var i = 0; i < panels.length; i++) totalWidth += panels[i].offsetWidth;
      var scrollDist = totalWidth - window.innerWidth;

      gsap.to(track, {
        x: function () { return -scrollDist; },
        ease: 'none',
        scrollTrigger: {
          trigger: section,
          start: 'top top',
          end: function () { return '+=' + scrollDist; },
          pin: true,
          scrub: 1,
          invalidateOnRefresh: true,
          anticipatePin: 1
        }
      });
    });
  }

  // ── Parallax — atenuado en móvil ──
  function initParallax() {
    if (!hasGSAP || REDUCED) return;
    var mult = isDesktop ? 1 : 0.6;
    document.querySelectorAll('[data-parallax]').forEach(function (el) {
      var speed = (parseFloat(el.getAttribute('data-parallax')) || 0.3) * mult;
      var xSpeed = (parseFloat(el.getAttribute('data-parallax-x')) || 0) * mult;
      var rotate = (parseFloat(el.getAttribute('data-parallax-rotate')) || 0) * mult;
      var scaleAmt = (parseFloat(el.getAttribute('data-parallax-scale')) || 0) * mult;
      var trigger = el.closest('[data-parallax-trigger]') || el;
      var tween = {
        y: function () { return speed * 100 + '%'; },
        ease: 'none',
        scrollTrigger: { trigger: trigger, start: 'top bottom', end: 'bottom top', scrub: true }
      };
      if (xSpeed) tween.x = function () { return xSpeed * 100 + '%'; };
      if (rotate) tween.rotation = rotate;
      if (scaleAmt) tween.scale = 1 + scaleAmt;
      gsap.to(el, tween);
    });
  }

  // ── FAQ accordion ──
  function initFAQ() {
    document.querySelectorAll('.faq-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var item = btn.closest('.faq-item');
        var answer = item.querySelector('.faq-answer');
        var wasOpen = answer.classList.contains('open');

        var group = btn.closest('.faq-group');
        if (group) {
          group.querySelectorAll('.faq-answer').forEach(function (a) { a.classList.remove('open'); });
          group.querySelectorAll('.faq-btn').forEach(function (b) { b.setAttribute('aria-expanded', 'false'); });
        }

        if (!wasOpen) {
          answer.classList.add('open');
          btn.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  // ── Init ──
  document.addEventListener('DOMContentLoaded', function () {
    initStickyScenes();
    initCountUp();
    initWordReveal();
    initHorizontalSections();
    initParallax();
    initFAQ();
  });

  window.AEScrolly = { clamp01: clamp01, range: range, stepAt: stepAt, hasGSAP: hasGSAP, isDesktop: isDesktop };
})();
