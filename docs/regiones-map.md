# Mapa de Regiones — Google Maps embed sin API key

Documentación de cómo se implementó el mapa interactivo en
[regiones.html](../regiones.html).

## TL;DR

Iframe embebido de Google Maps (`https://www.google.com/maps?...&output=embed`)
que se actualiza por JS cuando el usuario selecciona una sede. Sin API key,
sin facturación, sin librerías externas — el mapa se monta como un adapter
más dentro del sistema de proveedores existente del locator.

```
┌────────────────────┐    click sede    ┌──────────────────────────┐
│ <a class=          │  ──────────────► │  google-iframe adapter   │
│   "ae-locator-item"│                  │  · _places[id] lookup    │
│   data-lat data-lng│                  │  · iframe.src = newUrl   │
│   data-zoom>       │                  └──────────────────────────┘
└────────────────────┘                              │
                                                    ▼
                                  iframe → google.com/maps?q=LAT,LNG
```

## Por qué este enfoque

| Necesidad                             | Decisión                                          |
|---------------------------------------|---------------------------------------------------|
| Mapa real (no SVG fallback)           | iframe embed de Google Maps                       |
| Sin facturación (Google JS API cobra) | embed público — gratis, sin token                 |
| Centrado dinámico al seleccionar sede | JS actualiza `iframe.src` en cada `select()`      |
| Migrable a WordPress                  | Mismo patrón adapter + atributos `data-*` planos  |
| CSP estricta del sitio                | Whitelist puntual en `frame-src`                  |

Los adapters previos (`leaflet`, `google` JS API, `mapbox`) seguían sin
funcionar fuera de la caja porque exigen `<script src=...>` extra y, en
los dos últimos, una API key. Esta variante elimina esa fricción.

## Archivos involucrados

| Archivo                                    | Cambio                                                            |
|--------------------------------------------|-------------------------------------------------------------------|
| [regiones.html](../regiones.html)          | Banner compacto + `data-map-provider="google-iframe"`             |
| [js/regiones.js](../js/regiones.js)        | Nuevo adapter `google-iframe` (mount/select/destroy)              |
| [vercel.json](../vercel.json)              | CSP `frame-src` ahora incluye `https://www.google.com`            |
| [css/styles.css](../css/styles.css)        | (sin cambios — las reglas `.has-real-map` ya cubrían el caso)     |

## Anatomía del adapter

```js
'google-iframe': {
  _iframe: null,
  _places: {},

  _buildUrl: function (lat, lng, zoom) {
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
    var self = this;
    (opts.places || []).forEach(function (p) { self._places[p.id] = p; });
    return Promise.resolve();
  },

  select: function (placeId, allPlaces) {
    var place = this._places[placeId] || /* fallback al array */ ...;
    if (!place || place.lat == null) return;
    this._iframe.src = this._buildUrl(place.lat, place.lng, place.zoom || 12);
  },

  destroy: function () { /* remove iframe + clear cache */ }
}
```

Las tres funciones son el contrato que comparten todos los adapters
(`leaflet`, `google`, `mapbox`, `placeholder`):

- **`mount(mountEl, opts)`** — recibe el `<div data-map-mount>` del DOM
  y un objeto `opts` con `center`, `zoom`, `tiles`, `key`, `places` y un
  callback `onSelect`. Devuelve `Promise` (la cadena `.then` añade la
  clase `.has-real-map` al wrap, lo que oculta el SVG fallback vía CSS).
- **`select(placeId, allPlaces)`** — llamado cuando el usuario hace click
  en un item de la lista. Cambia el `src` del iframe.
- **`destroy()`** — cleanup si se reconfigura el proveedor.

## Atributos en el HTML

```html
<div class="ae-locator-mapwrap"
     data-map-provider="google-iframe"
     data-default-center="4.5709,-74.2973"
     data-default-zoom="6">
  ...
  <div class="ae-locator-mapmount" data-map-mount aria-hidden="true"></div>
  ...
</div>
```

Y cada sede:

```html
<a href="#" class="ae-locator-item"
   data-pin="amazonas"
   data-lat="-4.2150"
   data-lng="-69.9406"
   data-zoom="11">
  ...
</a>
```

Solo `data-lat` y `data-lng` son obligatorios para el adapter. El resto
queda a disposición del UI (foto, email, link directo a Google Maps,
etc.).

## Flujo runtime

1. **`DOMContentLoaded`** → [js/regiones.js](../js/regiones.js) lee
   `data-map-provider`, escoge `providers['google-iframe']` y llama a
   `mount(mountEl, opts)`.
2. **`mount` resuelve** → el flujo añade `.has-real-map` al wrap; el SVG
   fallback queda oculto por CSS, el iframe queda visible.
3. **Click en sede** → `selectPlace(id)` actualiza la lista activa y
   llama `current.provider.select(id, allPlaces)`.
4. **Adapter** → busca el sede por `id` en `this._places`, construye la
   URL del nuevo `q=lat,lng&z=zoom` y la asigna al `iframe.src`. Google
   re-carga el frame; el viewer ve el pin centrado en la nueva ubicación.

## CSP

El embed de Google Maps requiere whitelist en `frame-src`:

```jsonc
// vercel.json
"Content-Security-Policy": "...; frame-src https://www.youtube.com https://www.google.com https://maps.google.com; ..."
```

Sin esa entrada, el iframe se bloquea silenciosamente en producción
(en local con `python -m http.server` no aplica la CSP, así que el
síntoma solo aparece tras desplegar).

## Trade-offs

| Capacidad                          | google-iframe | google (JS API) | leaflet (OSM) |
|------------------------------------|:-------------:|:---------------:|:-------------:|
| Sin API key                        | ✅            | ❌              | ✅            |
| Múltiples markers visibles a la vez| ❌            | ✅              | ✅            |
| Eventos sobre markers              | ❌            | ✅              | ✅            |
| Personalizar estilo del mapa       | limitado      | ✅              | ✅            |
| Streetview / 45° aerial            | ✅            | ✅              | ❌            |
| Peso (KB)                          | ~0 (iframe)   | ~200 KB JS      | ~150 KB JS    |
| Fricción de despliegue             | mínima        | alta (key)      | media         |

Si en el futuro el cliente pide ver **todos** los pins simultáneamente o
abrir popups custom, hay que migrar a `leaflet` o `google` JS API. El
contrato adapter ya está listo — solo es cambiar `data-map-provider`
y, en el caso de Google JSAPI, cargar `https://maps.googleapis.com/...`
con `data-map-key`.

## Cómo cambiar de proveedor

Un solo atributo en el HTML:

```html
<!-- Hoy -->
<div data-map-provider="google-iframe">

<!-- Switch a OpenStreetMap (Leaflet) -->
<div data-map-provider="leaflet" data-map-tiles="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png">

<!-- Switch a Google JS API -->
<div data-map-provider="google" data-map-key="YOUR_KEY">
```

Los adapters viven todos en [js/regiones.js](../js/regiones.js); el
flujo principal (lectura del DOM, `selectPlace`, sync UI) no cambia.

## Migración a WordPress

1. **Markup** — `regiones.html` se convierte en `page-regiones.php` (o
   un template part). El `<div class="ae-locator-mapwrap">` queda
   idéntico; los `<li>` con `data-lat`/`data-lng` se generan con un
   loop sobre un CPT `sede` o sobre opciones de tema:

   ```php
   <?php foreach ( ae_get_sedes() as $sede ): ?>
     <li>
       <a href="#" class="ae-locator-item"
          data-pin="<?php echo esc_attr( $sede['slug'] ); ?>"
          data-lat="<?php echo esc_attr( $sede['lat'] ); ?>"
          data-lng="<?php echo esc_attr( $sede['lng'] ); ?>"
          data-zoom="11">
         <h3><?php echo esc_html( $sede['nombre'] ); ?></h3>
         ...
       </a>
     </li>
   <?php endforeach; ?>
   ```

2. **CSP** — replicar la whitelist `frame-src https://www.google.com
   https://maps.google.com` en el header del WordPress (vía `wp_headers`
   filter o el plugin de seguridad que use el cliente).

3. **JS** — encolar `js/regiones.js` igual que en estático:

   ```php
   wp_enqueue_script(
     'ae-regiones',
     get_template_directory_uri() . '/js/regiones.js',
     [], '1.0.0', true
   );
   ```

4. **Sin API key**: nada más que hacer. Si después se quiere migrar a
   Google JSAPI, leer la key de un setting:

   ```php
   $key = esc_attr( get_option('ae_gmaps_key') );
   echo '<div class="ae-locator-mapwrap" data-map-provider="google" data-map-key="' . $key . '">';
   ```

## Troubleshooting

| Síntoma                                     | Causa probable                                                  |
|---------------------------------------------|-----------------------------------------------------------------|
| Iframe vacío en producción, ok en local     | CSP no incluye `https://www.google.com` en `frame-src`          |
| Selección no centra el mapa                 | `data-lat` o `data-lng` faltantes o no numéricos                |
| El pin va al centro de Colombia siempre     | El `id` del item (`data-pin`) no matchea el cache `_places`     |
| El iframe carga gris (Google rate-limit)    | Demasiados page loads desde una IP — problema solo en testing   |
| El SVG fallback sigue visible               | El adapter falló en `mount()`; revisar consola, vuelve a `placeholder` automáticamente |

## Por qué no escribir `q=` solo con el nombre del lugar

URL `https://www.google.com/maps?q=Leticia,+Amazonas&output=embed` también
funciona, pero Google geocodea el string en su lado, lo que produce
resultados ambiguos (varias ciudades con el mismo nombre). Con `q=lat,lng`
el centrado es exacto y reproducible.

## Referencias

- [Google Maps Embed (parámetros públicos)](https://developers.google.com/maps/documentation/urls/get-started)
- [CSP frame-src en MDN](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy/frame-src)
- Adapters del locator: [js/regiones.js](../js/regiones.js) (sección `providers`)
