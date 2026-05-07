/* cookie-consent.js — Componente independiente del banner de consentimiento de cookies.

   Auto-inicializa al cargar el DOM. Inyecta un banner pequeño en la parte
   inferior de la página la primera vez que el usuario visita el sitio.
   La decisión se persiste en localStorage para no volver a mostrar el aviso.

   Persistencia:
     localStorage['ae-cookie-consent'] = 'accepted' | 'rejected'

   API pública (window.AECookieConsent):
     .show()    → fuerza mostrar el banner (ignora la decisión almacenada)
     .accept()  → equivalente a click en "Aceptar"
     .reject()  → equivalente a click en "Rechazar"
     .reset()   → borra la decisión almacenada y muestra el banner de nuevo
     .status()  → 'accepted' | 'rejected' | null
     .destroy() → cierra y elimina el banner del DOM si está visible

   Configuración (window.AE_COOKIE_CONFIG, opcional):
     {
       policyHref: '#',                     // URL de la Política de Cookies
       title: 'Usamos cookies',
       description: '…',                    // Puede contener {link} como placeholder
       linkText: 'aquí',
       acceptLabel: 'Aceptar',
       rejectLabel: 'Rechazar',
       closeLabel: 'Cerrar aviso de cookies',
       storageKey: 'ae-cookie-consent'
     }
*/

(function () {
  'use strict';

  var defaults = {
    storageKey: 'ae-cookie-consent',
    policyHref: '#',
    title: 'Usamos cookies',
    description: 'Usamos cookies para mejorar tu experiencia de navegación, mostrarte contenido personalizado y analizar el tráfico de usuarios en nuestra web. Consulta nuestra Política de Cookies {link}.',
    linkText: 'aquí',
    acceptLabel: 'Aceptar',
    rejectLabel: 'Rechazar',
    closeLabel: 'Cerrar aviso de cookies'
  };

  var config = (function () {
    var user = (typeof window !== 'undefined' && window.AE_COOKIE_CONFIG) || {};
    var merged = {};
    for (var k in defaults) merged[k] = (k in user) ? user[k] : defaults[k];
    return merged;
  })();

  var STORAGE_KEY = config.storageKey;
  var bannerEl = null;
  var dismissing = false;

  function readStatus() {
    try { return localStorage.getItem(STORAGE_KEY); } catch (_) { return null; }
  }
  function writeStatus(value) {
    try { localStorage.setItem(STORAGE_KEY, value); } catch (_) { /* noop */ }
  }
  function clearStatus() {
    try { localStorage.removeItem(STORAGE_KEY); } catch (_) { /* noop */ }
  }

  function escapeHtml(str) {
    return String(str)
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  }

  function buildDescriptionHtml() {
    var linkHtml = '<a href="' + escapeHtml(config.policyHref) + '" rel="nofollow">' + escapeHtml(config.linkText) + '</a>';
    var raw = config.description.indexOf('{link}') !== -1
      ? config.description.replace('{link}', '__LINK__')
      : config.description + ' __LINK__';
    return escapeHtml(raw).replace('__LINK__', linkHtml);
  }

  function build() {
    var el = document.createElement('aside');
    el.className = 'ae-cookie';
    el.setAttribute('role', 'dialog');
    el.setAttribute('aria-live', 'polite');
    el.setAttribute('aria-labelledby', 'aeCookieTitle');
    el.setAttribute('aria-describedby', 'aeCookieDesc');
    el.setAttribute('data-component', 'cookie-consent');
    el.innerHTML =
      '<span class="ae-cookie-stripe" aria-hidden="true"><i></i><i></i><i></i></span>' +
      '<button type="button" class="ae-cookie-close" aria-label="' + escapeHtml(config.closeLabel) + '">✕</button>' +
      '<div class="ae-cookie-body">' +
      '  <p id="aeCookieTitle" class="ae-cookie-title">' + escapeHtml(config.title) + '</p>' +
      '  <p id="aeCookieDesc" class="ae-cookie-text">' + buildDescriptionHtml() + '</p>' +
      '</div>' +
      '<div class="ae-cookie-actions">' +
      '  <button type="button" class="ae-cookie-btn ae-cookie-btn-ghost" data-cookie-action="reject">' + escapeHtml(config.rejectLabel) + '</button>' +
      '  <button type="button" class="ae-cookie-btn ae-cookie-btn-primary" data-cookie-action="accept"><span>' + escapeHtml(config.acceptLabel) + '</span></button>' +
      '</div>';
    return el;
  }

  function attach(el) {
    document.body.appendChild(el);
    el.addEventListener('click', function (e) {
      var target = e.target.closest('[data-cookie-action], .ae-cookie-close');
      if (!target) return;
      if (target.classList.contains('ae-cookie-close')) return dismiss('rejected');
      var action = target.getAttribute('data-cookie-action');
      dismiss(action === 'accept' ? 'accepted' : 'rejected');
    });
    requestAnimationFrame(function () {
      requestAnimationFrame(function () { el.classList.add('is-visible'); });
    });
  }

  function dismiss(value, opts) {
    if (!bannerEl || dismissing) return;
    dismissing = true;
    if (opts !== undefined && opts && opts.skipPersist) {
      // no persistir
    } else {
      writeStatus(value);
    }
    bannerEl.classList.remove('is-visible');
    var handled = false;
    function remove() {
      if (handled) return;
      handled = true;
      if (bannerEl && bannerEl.parentNode) bannerEl.parentNode.removeChild(bannerEl);
      bannerEl = null;
      dismissing = false;
      window.dispatchEvent(new CustomEvent('ae:cookie-consent', { detail: { status: value } }));
    }
    bannerEl.addEventListener('transitionend', remove, { once: true });
    setTimeout(remove, 600);
  }

  function show(force) {
    if (bannerEl) return;
    if (!force) {
      var status = readStatus();
      if (status === 'accepted' || status === 'rejected') return;
    }
    if (!document.body) return;
    bannerEl = build();
    attach(bannerEl);
  }

  // API pública
  window.AECookieConsent = {
    show: function () { show(true); },
    accept: function () { dismiss('accepted'); },
    reject: function () { dismiss('rejected'); },
    reset: function () { clearStatus(); show(true); },
    status: readStatus,
    destroy: function () { if (bannerEl) dismiss(readStatus() || 'rejected', { skipPersist: true }); }
  };

  // Auto-init: solo si no hay decisión previa
  function autoInit() { show(false); }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', autoInit);
  } else {
    autoInit();
  }
})();
