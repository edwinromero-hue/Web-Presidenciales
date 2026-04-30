/**
 * AE Locator — Buscador territorial (regiones.html)
 * ==================================================
 *
 * Diseñado para ser portable a WordPress sin tocar JS.
 *
 * ─── Cómo funciona ───────────────────────────────────────────────
 * Las plazas (departamentos / municipios / consulados) se leen del
 * DOM. Cada `.ae-locator-item` y cada `.ae-loc-pin` lleva su
 * `data-pin` (id), `data-lat`, `data-lng` y `data-zoom`. En WordPress
 * basta con renderizar la misma estructura desde un loop PHP (ACF /
 * CPT / custom field) — el JS ya lee los datos del HTML resultante.
 *
 * ─── Cómo conectar un mapa real (Leaflet / Google / Mapbox) ──────
 * En `.ae-locator-mapwrap`:
 *
 *   <div class="ae-locator-mapwrap"
 *        data-map-provider="leaflet"        // 'placeholder' | 'leaflet' | 'google' | 'mapbox'
 *        data-default-center="4.5709,-74.2973"
 *        data-default-zoom="6"
 *        data-map-tiles="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
 *        data-map-key="">
 *
 * Cada proveedor tiene un adaptador en `AELocator.providers.<name>`
 * con tres métodos:
 *
 *   - mount(mountEl, opts) → Promise        // inicializa el mapa
 *   - select(placeId, places)                // centra/destaca un lugar
 *   - destroy()                              // limpia listeners y el mapa
 *
 * Si el mount falla (ej. la lib externa no cargó), se cae al
 * proveedor `placeholder` (SVG decorativo) y la UI sigue funcional.
 *
 * ─── API pública ─────────────────────────────────────────────────
 *   window.AELocator = {
 *     setTab(tab),               // 'colombia' | 'municipios' | 'consulados'
 *     selectPlace(id),
 *     places,                    // { colombia:[…], municipios:[…], consulados:[…] }
 *     providers                  // adaptadores registrados
 *   }
 *
 * Si tu plugin de WP necesita registrar un proveedor adicional:
 *   AELocator.providers.miPlugin = { mount, select, destroy };
 *
 * Y luego en el HTML: data-map-provider="miPlugin".
 */

(function () {
  'use strict';

  // ───────── Lectura de plazas desde el DOM ─────────
  function readPlaces() {
    var places = { colombia: [], municipios: [], consulados: [] };
    document.querySelectorAll('.ae-locator-pane').forEach(function (pane) {
      var tab = pane.dataset.pane;
      if (!places[tab]) return;
      pane.querySelectorAll('.ae-locator-item').forEach(function (it) {
        var lat = parseFloat(it.dataset.lat);
        var lng = parseFloat(it.dataset.lng);
        var zoom = parseInt(it.dataset.zoom || '8', 10);
        var h3 = it.querySelector('h3');
        var addr = it.querySelector('.ae-locator-addr');
        var status = it.querySelector('.ae-locator-status');
        places[tab].push({
          id: it.dataset.pin,
          name: h3 ? h3.textContent.trim() : it.dataset.pin,
          address: addr ? addr.textContent.trim() : '',
          status: status ? status.textContent.trim() : '',
          lat: isNaN(lat) ? null : lat,
          lng: isNaN(lng) ? null : lng,
          zoom: zoom,
          element: it
        });
      });
    });
    return places;
  }

  // ───────── Adaptadores de proveedor ─────────
  var providers = {

    /**
     * placeholder — proveedor por defecto.
     * Usa el SVG decorativo + pins absolutos. No requiere API.
     * Listo para producción si no se quiere depender de tile providers.
     */
    placeholder: {
      mount: function () {
        // El SVG y los pins ya están en el DOM. Nada que montar.
        return Promise.resolve();
      },
      select: function () {
        // El click visual lo maneja el flujo común (selectPlace).
      },
      destroy: function () { /* no-op */ }
    },

    /**
     * google-iframe — Google Maps embebido vía iframe (sin API key).
     *
     * Renderiza un <iframe> con la URL pública de Google Maps embed
     * (q=LAT,LNG&z=Z&output=embed). Cuando el usuario selecciona una
     * sede en la lista, se actualiza el src del iframe con su lat/lng.
     *
     * Trade-offs vs el adapter google (JS API):
     *   + Sin API key, sin facturación por loads
     *   + Markup simple (un iframe), funciona offline-from-CDN
     *   − Sin control de marcadores múltiples (solo una sede a la vez)
     *   − Sin eventos de click sobre el mapa
     *
     * Requiere CSP `frame-src https://www.google.com` (ver vercel.json).
     */
    'google-iframe': {
      _iframe: null,
      _places: {},
      _buildUrl: function (lat, lng, zoom) {
        // Sin pin (centro/zoom directo): si quisieras pin, usa q=lat,lng
        return 'https://www.google.com/maps?q=' + encodeURIComponent(lat + ',' + lng) +
               '&z=' + (zoom || 12) + '&hl=es&output=embed';
      },
      mount: function (mountEl, opts) {
        var iframe = document.createElement('iframe');
        iframe.className = 'ae-locator-mapiframe';
        iframe.title = 'Mapa de Colombia con sedes regionales';
        iframe.setAttribute('loading', 'lazy');
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        iframe.setAttribute('allowfullscreen', '');
        iframe.style.cssText = 'border:0;width:100%;height:100%;display:block;';
        iframe.src = this._buildUrl(opts.center[0], opts.center[1], opts.zoom);
        mountEl.appendChild(iframe);
        mountEl.removeAttribute('aria-hidden');
        this._iframe = iframe;
        // Cache de places por id para lookup rápido en select()
        var self = this;
        (opts.places || []).forEach(function (p) { self._places[p.id] = p; });
        return Promise.resolve();
      },
      select: function (placeId, allPlaces) {
        if (!this._iframe) return;
        var place = this._places[placeId];
        // Fallback: si select() trae el array (signatura del flujo principal),
        // buscarlo ahí en caso de que mount no hubiera cacheado este id.
        if (!place && Array.isArray(allPlaces)) {
          for (var i = 0; i < allPlaces.length; i++) {
            if (allPlaces[i].id === placeId) { place = allPlaces[i]; break; }
          }
        }
        if (!place || place.lat == null || place.lng == null) return;
        this._iframe.src = this._buildUrl(place.lat, place.lng, place.zoom || 12);
      },
      destroy: function () {
        if (this._iframe && this._iframe.parentNode) {
          this._iframe.parentNode.removeChild(this._iframe);
        }
        this._iframe = null;
        this._places = {};
      }
    },

    /**
     * leaflet — OpenStreetMap por defecto, free tier sin key.
     *
     * Para activar:
     *   1. <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
     *   2. <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
     *   3. data-map-provider="leaflet" en .ae-locator-mapwrap
     *
     * En WordPress: encolá los assets con wp_enqueue_script / style.
     */
    leaflet: {
      _map: null,
      _markers: {},
      mount: function (mountEl, opts) {
        if (typeof L === 'undefined') {
          return Promise.reject(new Error('Leaflet no está cargado.'));
        }
        var map = L.map(mountEl, { zoomControl: true, scrollWheelZoom: false }).setView(opts.center, opts.zoom);
        L.tileLayer(opts.tiles, {
          maxZoom: 18,
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var self = this;
        opts.places.forEach(function (p) {
          if (p.lat == null || p.lng == null) return;
          var marker = L.marker([p.lat, p.lng], { title: p.name }).addTo(map);
          marker.bindPopup('<strong>' + p.name + '</strong><br>' + (p.address || ''));
          marker.on('click', function () { if (opts.onSelect) opts.onSelect(p.id); });
          self._markers[p.id] = marker;
        });
        this._map = map;
        return Promise.resolve();
      },
      select: function (placeId) {
        var marker = this._markers[placeId];
        if (marker && this._map) {
          var ll = marker.getLatLng();
          this._map.flyTo([ll.lat, ll.lng], Math.max(this._map.getZoom(), 11), { duration: 0.7 });
          marker.openPopup();
        }
      },
      destroy: function () {
        if (this._map) { this._map.remove(); this._map = null; }
        this._markers = {};
      }
    },

    /**
     * google — Google Maps JavaScript API.
     *
     * Para activar:
     *   1. <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY"></script>
     *   2. data-map-provider="google" data-map-key="YOUR_KEY"
     *
     * En WordPress: leé la API key desde wp_options y echala al
     * atributo data-map-key con esc_attr( get_option('ae_gmaps_key') ).
     */
    google: {
      _map: null,
      _markers: {},
      mount: function (mountEl, opts) {
        if (typeof google === 'undefined' || !google.maps) {
          return Promise.reject(new Error('Google Maps API no está cargada.'));
        }
        var map = new google.maps.Map(mountEl, {
          center: { lat: opts.center[0], lng: opts.center[1] },
          zoom: opts.zoom,
          disableDefaultUI: false,
          gestureHandling: 'cooperative'
        });
        var self = this;
        opts.places.forEach(function (p) {
          if (p.lat == null || p.lng == null) return;
          var marker = new google.maps.Marker({
            position: { lat: p.lat, lng: p.lng },
            map: map,
            title: p.name
          });
          marker.addListener('click', function () { if (opts.onSelect) opts.onSelect(p.id); });
          self._markers[p.id] = marker;
        });
        this._map = map;
        return Promise.resolve();
      },
      select: function (placeId) {
        var marker = this._markers[placeId];
        if (marker && this._map) {
          this._map.panTo(marker.getPosition());
          this._map.setZoom(Math.max(this._map.getZoom(), 11));
        }
      },
      destroy: function () {
        Object.values(this._markers).forEach(function (m) { m.setMap(null); });
        this._markers = {};
        this._map = null;
      }
    },

    /**
     * mapbox — Mapbox GL JS.
     *
     * Para activar:
     *   1. <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet"/>
     *   2. <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>
     *   3. data-map-provider="mapbox" data-map-key="YOUR_TOKEN"
     */
    mapbox: {
      _map: null,
      _markers: {},
      mount: function (mountEl, opts) {
        if (typeof mapboxgl === 'undefined') {
          return Promise.reject(new Error('Mapbox GL JS no está cargado.'));
        }
        if (!opts.key) {
          return Promise.reject(new Error('Mapbox necesita data-map-key con tu access token.'));
        }
        mapboxgl.accessToken = opts.key;
        var map = new mapboxgl.Map({
          container: mountEl,
          style: 'mapbox://styles/mapbox/light-v11',
          center: [opts.center[1], opts.center[0]],
          zoom: opts.zoom
        });
        var self = this;
        map.on('load', function () {
          opts.places.forEach(function (p) {
            if (p.lat == null || p.lng == null) return;
            var marker = new mapboxgl.Marker().setLngLat([p.lng, p.lat]).addTo(map);
            marker.getElement().addEventListener('click', function () {
              if (opts.onSelect) opts.onSelect(p.id);
            });
            self._markers[p.id] = marker;
          });
        });
        this._map = map;
        return Promise.resolve();
      },
      select: function (placeId) {
        var marker = this._markers[placeId];
        if (marker && this._map) {
          this._map.flyTo({ center: marker.getLngLat(), zoom: 11 });
        }
      },
      destroy: function () {
        if (this._map) { this._map.remove(); this._map = null; }
        this._markers = {};
      }
    }
  };

  // ───────── Boot ─────────
  function init() {
    var wrap = document.querySelector('.ae-locator-mapwrap');
    if (!wrap) return;
    var mountEl = wrap.querySelector('[data-map-mount]');

    var providerName = wrap.dataset.mapProvider || 'placeholder';
    var providerCfg = {
      tiles: wrap.dataset.mapTiles || 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      key: wrap.dataset.mapKey || '',
      center: (wrap.dataset.defaultCenter || '4.5709,-74.2973').split(',').map(Number),
      zoom: parseInt(wrap.dataset.defaultZoom || '6', 10)
    };

    var places = readPlaces();
    var current = { tab: 'colombia', provider: providers[providerName] || providers.placeholder };

    var tabs = document.querySelectorAll('.ae-locator-tab');
    var panes = document.querySelectorAll('.ae-locator-pane');
    var pins = document.querySelectorAll('.ae-loc-pin');
    var items = document.querySelectorAll('.ae-locator-item');
    var search = document.getElementById('aeLocatorSearch');
    var tip = document.getElementById('aeMapTip');

    function setTab(tab) {
      current.tab = tab;
      tabs.forEach(function (t) {
        var on = t.dataset.tab === tab;
        t.classList.toggle('is-active', on);
        t.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      panes.forEach(function (p) {
        var on = p.dataset.pane === tab;
        p.classList.toggle('is-active', on);
        if (on) p.removeAttribute('hidden'); else p.setAttribute('hidden', '');
      });
      wrap.dataset.tab = tab;
      var canvas = document.getElementById('aeMap');
      if (canvas) canvas.dataset.tab = tab;
      if (search) search.value = '';
      filterItems('');
    }

    // ── Helpers de expansión (foto debajo de la dirección) ──
    function setExpanded(it, value) {
      var expanded = !!value;
      it.classList.toggle('is-expanded', expanded);
      var toggle = it.querySelector('.ae-locator-toggle');
      if (toggle) toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
      if (expanded) {
        // Carga lazy: pone src solo cuando se expande, si data-photo tiene URL.
        var photoUrl = it.getAttribute('data-photo') || '';
        var img = it.querySelector('.ae-locator-photo-img');
        if (img && photoUrl && img.getAttribute('src') !== photoUrl) {
          img.setAttribute('src', photoUrl);
          var sedeName = (it.querySelector('.ae-locator-sede') || {}).textContent || '';
          img.setAttribute('alt', sedeName ? 'Foto de ' + sedeName : '');
        }
      }
    }
    function expandOnly(it) {
      items.forEach(function (other) {
        if (other !== it) setExpanded(other, false);
      });
      setExpanded(it, true);
    }

    function selectPlace(id) {
      pins.forEach(function (p) { p.classList.toggle('is-active', p.dataset.pin === id); });
      items.forEach(function (it) {
        var on = it.dataset.pin === id && !it.closest('.ae-locator-pane').hasAttribute('hidden');
        it.classList.toggle('is-active', on);
        if (on) {
          it.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
          // Al seleccionar desde la card o el pin del mapa, autoexpandir esta
          // sola (las demás se colapsan).
          expandOnly(it);
        }
      });
      var label = '';
      pins.forEach(function (p) { if (p.dataset.pin === id) label = p.getAttribute('aria-label') || ''; });
      if (tip && label) {
        var strong = tip.querySelector('strong');
        if (strong) strong.textContent = label;
        tip.removeAttribute('hidden');
        clearTimeout(tip._t);
        tip._t = setTimeout(function () { tip.setAttribute('hidden', ''); }, 2400);
      }
      // Notificar al proveedor (centra el mapa real, abre popup, etc.)
      if (current.provider && current.provider.select) {
        var allPlaces = [].concat(places.colombia, places.municipios, places.consulados);
        try { current.provider.select(id, allPlaces); } catch (e) { /* swallow */ }
      }
    }

    function filterItems(q) {
      q = (q || '').trim().toLowerCase();
      var activePane = document.querySelector('.ae-locator-pane.is-active');
      if (!activePane) return;
      activePane.querySelectorAll('li').forEach(function (li) {
        if (!q) { li.style.display = ''; return; }
        var txt = li.textContent.toLowerCase();
        li.style.display = txt.indexOf(q) > -1 ? '' : 'none';
      });
    }

    tabs.forEach(function (t) { t.addEventListener('click', function () { setTab(t.dataset.tab); }); });
    pins.forEach(function (p) { p.addEventListener('click', function (e) { e.preventDefault(); selectPlace(p.dataset.pin); }); });
    items.forEach(function (it) {
      it.addEventListener('click', function (e) {
        e.preventDefault();
        // Click en la flecha → toggle de la foto (sin cambiar la selección del mapa)
        if (e.target.closest('.ae-locator-toggle')) {
          if (it.classList.contains('is-expanded')) setExpanded(it, false);
          else expandOnly(it);
          return;
        }
        // Click en cualquier otra parte de la card → seleccionar (auto-expande también)
        selectPlace(it.dataset.pin);
      });
      // Soporte de teclado para el toggle (es <span role="button">)
      var toggle = it.querySelector('.ae-locator-toggle');
      if (toggle) {
        toggle.addEventListener('keydown', function (e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            e.stopPropagation();
            if (it.classList.contains('is-expanded')) setExpanded(it, false);
            else expandOnly(it);
          }
        });
      }
    });
    if (search) search.addEventListener('input', function () { filterItems(search.value); });

    // Montar el proveedor (no bloqueante)
    if (mountEl && providerName !== 'placeholder') {
      var allPlaces = [].concat(places.colombia, places.municipios, places.consulados);
      try {
        current.provider.mount(mountEl, {
          center: providerCfg.center,
          zoom: providerCfg.zoom,
          tiles: providerCfg.tiles,
          key: providerCfg.key,
          places: allPlaces,
          onSelect: selectPlace
        }).then(function () {
          wrap.classList.add('has-real-map');
          mountEl.removeAttribute('aria-hidden');
        }).catch(function (err) {
          console.warn('[AELocator] Proveedor "' + providerName + '" falló:', err && err.message, '— usando placeholder.');
          current.provider = providers.placeholder;
        });
      } catch (e) {
        console.warn('[AELocator] Error al montar proveedor:', e && e.message);
        current.provider = providers.placeholder;
      }
    }

    setTab('colombia');

    // Exponer API para integraciones externas / debugging
    window.AELocator = {
      setTab: setTab,
      selectPlace: selectPlace,
      places: places,
      provider: current.provider,
      providers: providers,
      reload: function () {
        if (current.provider && current.provider.destroy) current.provider.destroy();
        init();
      }
    };
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
