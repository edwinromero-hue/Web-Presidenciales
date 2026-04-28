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

  document.addEventListener('DOMContentLoaded', function () {
    initSceneReveal();
    initSpineReveal();
    initFlowReveal();
    initAllyAccordion();
  });
})();
