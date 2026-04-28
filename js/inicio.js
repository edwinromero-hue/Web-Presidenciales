/* inicio.js — Home: banners scroll-navegados + video lite embed */
(function () {
  'use strict';

  var stepAt = AEScrolly && AEScrolly.stepAt;
  var isDesktop = AEScrolly && AEScrolly.isDesktop;

  // ── Banners Scene — scrub crossfade en desktop (4 steps) ──
  window.scene_bannersScene = function (p) {
    if (!stepAt) return;
    var data = stepAt(p, 4);
    var active = data.step;

    var slides = document.querySelectorAll('#bannersScene .ae-banner-slide');
    slides.forEach(function (s, i) {
      s.classList.toggle('is-active', i === active);
    });

    var dots = document.querySelectorAll('#bannersScene .ae-banner-dot');
    dots.forEach(function (d, i) {
      d.classList.toggle('is-active', i === active);
    });

    var hint = document.querySelector('#bannersScene .ae-banner-hint');
    if (hint) hint.style.opacity = (1 - p * 1.8).toFixed(2);
  };

  // ── Dots clickables (desktop = scroll-to; mobile = scroll horizontal) ──
  function initBannerDots() {
    var scene = document.getElementById('bannersScene');
    if (!scene) return;
    var dots = scene.querySelectorAll('.ae-banner-dot');

    dots.forEach(function (dot) {
      dot.addEventListener('click', function () {
        var idx = parseInt(dot.getAttribute('data-goto'), 10) || 0;
        if (isDesktop) {
          var rect = scene.getBoundingClientRect();
          var abs = window.pageYOffset + rect.top;
          var total = scene.offsetHeight - window.innerHeight;
          var y = abs + (total * (idx / 3));
          window.scrollTo({ top: y, behavior: 'smooth' });
        } else {
          var slides = scene.querySelectorAll('.ae-banner-slide');
          var target = slides[idx];
          if (target) target.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
        }
      });
    });
  }

  // ── Mobile: IntersectionObserver para marcar banner activo + actualizar dots ──
  function initMobileBannerObserver() {
    if (isDesktop) return;
    var stage = document.querySelector('#bannersScene .ae-banners-stage');
    if (!stage) return;
    var slides = stage.querySelectorAll('.ae-banner-slide');
    var dots = stage.querySelectorAll('.ae-banner-dot');

    var obs = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        var idx = parseInt(e.target.getAttribute('data-banner'), 10) || 0;
        slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
        dots.forEach(function (d, i) { d.classList.toggle('is-active', i === idx); });
      });
    }, { root: stage, threshold: 0.6 });

    slides.forEach(function (s) { obs.observe(s); });
  }

  // ── Video lite-embed ──
  function initVideo() {
    var player = document.querySelector('.ae-video-player');
    if (!player) return;
    var btn = player.querySelector('.ae-video-play');
    if (!btn) return;

    var isEmbedded = false;

    btn.addEventListener('click', function () {
      if (isEmbedded) return;
      var videoId = player.getAttribute('data-video-id');
      if (!videoId) return;

      var iframe = document.createElement('iframe');
      iframe.className = 'ae-video-iframe';
      iframe.src = 'https://www.youtube.com/embed/' + encodeURIComponent(videoId) + '?autoplay=1&rel=0';
      iframe.title = 'Video institucional Actores Electorales 2026';
      iframe.loading = 'lazy';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
      iframe.setAttribute('allowfullscreen', '');
      iframe.setAttribute('frameborder', '0');

      player.appendChild(iframe);
      player.classList.add('is-playing');
      isEmbedded = true;
    });
  }

  // ── Press marquee: clona el track para loop continuo ──
  function initPressMarquee() {
    var marquee = document.querySelector('.ae-press-marquee');
    if (!marquee) return;
    var track = marquee.querySelector('.ae-press-track');
    if (!track || track.dataset.cloned === '1') return;

    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduced) return; // sin clonar, overflow-x: auto ya permite scroll manual

    var clone = track.cloneNode(true);
    clone.setAttribute('aria-hidden', 'true');
    // Quitamos role/aria y hacemos los links no-tabulables para evitar duplicados en el tab order
    clone.removeAttribute('role');
    clone.querySelectorAll('a').forEach(function (a) { a.setAttribute('tabindex', '-1'); });
    track.dataset.cloned = '1';
    marquee.appendChild(clone);
  }

  document.addEventListener('DOMContentLoaded', function () {
    initBannerDots();
    initMobileBannerObserver();
    initVideo();
    initPressMarquee();
  });
})();
