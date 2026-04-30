# Barrido NO-ITALIC — Progreso

## Estado: Completado
Última actualización: 2026-04-29

## Inventario inicial

### CSS (`css/styles.css`) — 24 ocurrencias `font-style: italic`
24 reglas neutralizadas (cambio italic → normal). Listado de líneas
originales: 630, 1242, 1331, 1643, 1737, 1745, 1850, 2029, 2108, 2553,
2768, 2941, 2986, 3247, 3381, 3447, 3615, 3806, 3986, 4517, 5134, 5585,
5660, 5915.

### CSS (`ds/colors_and_type.css`)
0 ocurrencias. Archivo no se consume en el sitio (@import retirado en
fase previa de cleanup).

### HTML inline italic — 4 ocurrencias eliminadas
- `prensa.html:108` — `font-style:italic` en `<p>` quitado
- `prensa.html:113` — `font-style:italic` en `<p>` quitado
- `eventos.html:157` — `font-style:italic` en `<p>` quitado
- `plataforma.html:83` — `font-style:italic` en `<span>` quitado

### Tags semánticos
- `<em>` ~20 ocurrencias en titulares: mantenidos (semántica intacta).
- `<i></i><i></i><i></i>` (banderas decorativas, vacíos): mantenidos.
- No hay `<cite>`, `<dfn>`, `<var>`, `<address>`.

### Google Fonts
- Manrope wght@400-800 + Archivo wght@400-800 — sin variantes ital
  en ninguna de las 8 páginas. OK.

### SVG / atributos `font-style="italic"`
0 ocurrencias.

### JS
0 ocurrencias de `font-style`/`italic`/`oblique`/templates con `<em>`.

## Plan
1. [x] Fase 1 · CSS — 24 reglas neutralizadas + bloque global agregado
2. [x] Fase 2 · HTML — 4 inline limpiados
3. [x] Fase 3 · JS — confirmado limpio (no había nada que tocar)
4. [x] Fase 4 · Verificación — greps a 0; 8 páginas a 200

## Cambios aplicados (log)
### css/styles.css (25 cambios)
- L630 `.ae-banner-title em` italic→normal
- L1242 `.ae-logo-vanguardia` italic→normal (cumple regla maestra)
- L1331 `.ae-video-title em` italic→normal
- L1643 `.ae-scene-title em` italic→normal
- L1737 `.ae-pageinfo-statement-sub` italic→normal
- L1745 `.ae-pageinfo-statement-sub em` italic→normal
- L1850 `.ae-info-head .ae-h2 em` italic→normal
- L2029 `.ae-info-floatlink` italic→normal
- L2108 `.ae-info-block-title em` italic→normal
- L2553 `.ae-hub-title em` italic→normal
- L2768 `.ae-detail-title em` italic→normal
- L2941 `.ae-detail-purpose-tag` italic→normal
- L2986 `.ae-board-title em` italic→normal
- L3247 `.ae-board-h em` italic→normal
- L3381 `.ae-board-outro-text em` italic→normal
- L3447 `.ae-poster-hero-h em` italic→normal
- L3615 `.ae-poster-title em` italic→normal
- L3806 `.ae-diag-h em` italic→normal
- L3986 `.ae-diag-center-tag em` italic→normal
- L4517 `.ae-locator-head .ae-h2 em` italic→normal
- L5134 `.ae-diag-panel h2.ae-diag-h em` italic→normal
- L5585 `.ae-banner-compact-title em` italic→normal
- L5660 `.ae-contact-h em` italic→normal
- L5915 `.ae-faq-h em` italic→normal
- L5932+ bloque global comentado `NO-ITALIC` agregado al final

### prensa.html
- L108 quitado `font-style:italic` de `<p>` (cita SEMANA)
- L113 quitado `font-style:italic` de `<p>` (cita EL TIEMPO)

### eventos.html
- L157 quitado `font-style:italic` de `<p>` (descripción plataforma)

### plataforma.html
- L83 quitado `font-style:italic` de `<span>` (palabra "democracia" en H1)

## Verificación
- `grep "font-style:\s*italic\|font-style:\s*oblique" *.css *.html *.js`: **0**
- `grep 'font-style="italic"\|font-style="oblique"' *.html *.svg *.js`: **0**
- Páginas respondiendo 200 en :8080:
  - index.html · quienes-somos.html · plataforma.html · regiones.html
  - canales.html · entrenamiento.html · eventos.html · prensa.html
  Todas: **200 OK**.

## Notas
- @font-face de itálica no invocadas: ninguna. Solo hay 2 @font-face
  (ClashDisplay-Light y Outfit-Black), ambos con `font-style: normal`.
- Falsos positivos descartados:
  - "internacional" en plataforma.html:134 (substring "ital" — texto puro).
  - `<i></i><i></i><i></i>` en banderas decorativas (Font Awesome-like;
    elemento vacío sin texto).
- `.ae-logo-vanguardia` (L1242) replicaba el logo del periódico Vanguardia
  que es itálico de marca. Lo neutralizamos para cumplir la regla maestra
  ("ningún texto del sitio debe renderizar en cursiva"). Si surge feedback
  de marca, se puede revertir solo esa regla y dejar el resto.
- Total: **29 cambios** (24 CSS rules + 1 CSS block + 4 HTML inline).
